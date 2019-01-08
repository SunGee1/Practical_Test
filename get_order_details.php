<?php
	
	session_start();

	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	require("settings.php");

	$order_id = $_POST["orderNum"];

	// var_dump($order_id);

	$rows = [];

	$query = "SELECT product_ref, quantity
				FROM order_product
				WHERE order_ref = {$order_id}
				GROUP BY product_ref";

	$result = $db_con->query($query);
	
	while ($row = mysqli_fetch_array($result)) {
		array_push($rows, $row);
	}

	die(json_encode($rows));
?>