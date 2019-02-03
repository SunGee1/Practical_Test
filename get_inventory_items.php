<?php 
	session_start();
	header("Content-Type: application/json");
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	
	require("settings.php");
	$user = $_SESSION["user"];

	$query = "SELECT item_ref, p.description, item_quantity FROM user_inventory LEFT JOIN product p ON item_ref = p.id WHERE inv_user_ref = {$user->id}";
	$result = $db_con->query($query);
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$row = (object)$row;
		$rows[] = $row;
	}
	die(json_encode($rows));
?>