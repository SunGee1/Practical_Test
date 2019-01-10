<?php
	require("settings.php");
	
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	// $user = $_SESSION["user"];
	$orderNum = $_POST['orderNum'];

	$query = "UPDATE user_order SET status_ref = 2 WHERE id = '{$orderNum}'";
	$result = $db_con->query($query);

