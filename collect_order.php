<?php
	require("settings.php");
	
	session_start();
	
	// header("Content-Type: application/json");

	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}


	$user = $_SESSION["user"];
	$order_id = $_POST["orderNum"];
	$rows =[];


	$query = "SELECT product_ref, quantity FROM order_product WHERE order_ref = {$order_id}";
	$result = $db_con->query($query);
	
	while ($row = mysqli_fetch_array($result)) {
		array_push($rows, $row);
	}





// $result = $mysqli->query("SELECT item_ref FROM mytable WHERE city = 'c7' LIMIT 1");
// if($result->num_rows == 0) {
//      // row not found, do stuff...
// } else {
//     // do other stuff...
// }
// $mysqli->close();




				// die("item ref is not the same");
	if($statement = $db_con->prepare("INSERT INTO user_inventory (inv_user_ref, item_ref, item_quantity) VALUES (?, ?, ?)"))
	{
		$statement->bind_param("iii", $user->id, $item_ref, $quantity);
		foreach ($rows as $row) {
			$row = (object)$row;
			$item_ref = $row->product_ref;
			$quantity = $row->quantity;
			// $statement->execute();
			$query = "SELECT item_ref FROM user_inventory WHERE item_ref = {$item_ref}";
			$result = $db_con->query($query);
			die(fetch($result));
			$result = (object)$result;
			if (!($result->item_ref == $item_ref || $result->item_ref == null || $result->item_ref == "")) {
				die($result->item_ref);
			}
			else
			{
				die("item ref is not the same");
			}
		}
	}
	else
	{
		// die("");
		echo mysqli_error($db_con);
	}


	// die("ssssss");

	// die(json_encode($rows))
	?>