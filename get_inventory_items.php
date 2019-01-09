<<?php 
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	
	require("settings.php");
	$user = $_SESSION["user"];
	

	// '<li><a href="/user/messages"><span class="tab">Message Center</span></a></li>'

	$query = "";
	$result = $db_con->query($query);

?>