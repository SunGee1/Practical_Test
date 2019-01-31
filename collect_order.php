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


	$product_rows =[];
	$query = "SELECT product_ref, quantity FROM order_product WHERE order_ref = {$order_id}";
	$product_result = $db_con->query($query);
	while ($product_row = mysqli_fetch_array($product_result)) {
		$query = "SELECT item_ref FROM user_inventory WHERE item_ref = {$product_row['product_ref']}";
		$item_result = $db_con->query($query);
		if (!($item_result->num_rows)) {
			insertIntoTable($db_con, $user->id, $product_row['product_ref'], $product_row['quantity']);
		}
		else
		{
			updateTable($db_con, $user->id, $product_row['product_ref'], $product_row['quantity']);
		}
	}

	function insertIntoTable($db_con, $user_id, $item_ref, $quantity)
	{
		$statement = $db_con->prepare("INSERT INTO user_inventory (inv_user_ref, item_ref, item_quantity) VALUES (?, ?, ?)");
		$statement->bind_param("iii", $user_id, $item_ref, $quantity);
		$statement->execute();
		$statement->close();
		die("inserted into table");
	}

	function updateTable($db_con, $user_id, $item_ref, $quantity)
	{
		$statement = $db_con->prepare("UPDATE user_inventory SET item_quantity = item_quantity + ? WHERE item_ref = ?");
		$statement->bind_param("ii", $quantity, $item_ref);
		$statement->execute();
		$statement->close();
		die("updated table");
	}
?>