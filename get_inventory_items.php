<?php 
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	
	require("settings.php");
	$user = $_SESSION["user"];
	


	$query = "SELECT";
	// $result = $db_con->query($query);

	die(json_encode($user));
?>