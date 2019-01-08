<?php
	require("settings.php");
	
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	$user = $_SESSION["user"];
	$products = $_POST['products'];

	$query = sprintf("INSERT INTO user_order(user_ref, status_ref) VALUES(%s, 1)",
			$user->id
			);

	$result = $db_con->query($query);
	
	if($result)
	{
		//"insert_id" = get last inserted row's primary key
		$order_id = $db_con->insert_id;
	}

	// need to find out how to get timezone according to user's localization settings
	date_default_timezone_set('Africa/Harare');
	$date = date('Y-m-d H:i:s', time());

	$response = (object)array("firstname" => $user->firstname, 
								"order_id" => $order_id,
								"value" => 0,
								"order_date" => $date,
								"order_update" => "0000-00-00 00:00:00",
								"status" => "Placed");
	
	if($statement = $db_con->prepare("INSERT INTO order_product VALUES(?, ?, ?)"))
	{
		$statement->bind_param("iii", $order_id, $product_id, $product_quantity);
		foreach ($products as $product)
		{
			$product = (object)$product;
			$product_id = $product->product_id;
			$product_quantity = $product->product_quantity;
			$statement->execute();
			$response->value += $product->product_quantity * $product->product_cost;
		}
	}
	die(json_encode($response));

?>