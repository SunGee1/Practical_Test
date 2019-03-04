<?php
	require("settings.php");
	
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	$user = $_SESSION["user"];
	$products = $_POST['products'];
	$total_price = $_POST['total_price'];

	$query = "SELECT money FROM user WHERE id = {$user->id}";
	$result = $db_con->query($query);
	$total_user_money = $result->fetch_object();

	$response = new stdClass();
	
	

	if ($total_user_money->money >= $total_price)
	{
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
		$placed = "Placed";

		$button = "<input id='row_button_update_order_". $order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog(". $order_id .")' value='Update order'><input id='row_button_cancel_order_". $order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='StatusUpdate(". $order_id . ",\"". $placed ."\",false)' value='Cancel order'>";
		
		$response->firstname = $user->firstname;
		$response->order_id = $order_id;
		$response->value = 0;
		$response->order_date = $date;
		$response->order_update = "0000-00-00 00:00:00";
		$response->status = "Placed";
		$response->buttons = $button;


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
			$response->value = number_format($response->value, 2, '.', '');
		}
		$total_order_price = $total_price;
		$new_user_money = ($total_user_money->money - $total_order_price);

		$format_money = number_format($new_user_money, 2, '.', '');
		$statement = $db_con->prepare("UPDATE user SET money = ? WHERE id = ?");
		$statement ->bind_param("di", $format_money, $user->id);
		
		$statement->execute();
		$response->enough_money = number_format($new_user_money, 2, '.', '');
	}
	else
	{
		$response->not_enough_money = "You do not have enough money.";
	}
	die(json_encode($response));

?>