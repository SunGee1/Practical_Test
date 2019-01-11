<?php
	require("settings.php");
	
	session_start();
	
	header("Content-Type: application/json");

	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	$rows =[];

	$user = $_SESSION["user"];
	$order_id = $_POST["orderNum"];

	$query = "SELECT product_ref, quantity FROM order_product WHERE order_ref = {$order_id}";
	$result = $db_con->query($query);
	
	while ($row = mysqli_fetch_array($result)) {
		array_push($rows, $row);
	}
	
	$query = sprintf("INSERT INTO user_inventory(inv_user_ref, item_name, item_quentity) VALUES(%s, %s, %s, %s)",
		$user->id,
		
	);
	
	

	die(json_encode($rows))
?>