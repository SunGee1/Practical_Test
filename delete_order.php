<?php 

	require("settings.php");
	session_start();
	// header("Content-Type: application/json");
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	// $user = $_SESSION["user"];
	$order_id = $_POST["orderNum"];

// die("her i am");

	$query = "DELETE FROM user_order WHERE id = {$order_id}";
	$result = $db_con->query($query);

	$query = "DELETE FROM order_product WHERE order_ref = {$order_id}";
	$result = $db_con->query($query);
?>