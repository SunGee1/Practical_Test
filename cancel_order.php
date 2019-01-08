<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");

$orderNum = $_POST['order_number'];

$query = "UPDATE user_order SET status_ref = 4 WHERE id = '{$orderNum}'";
$result = $db_con->query($query);

// die(text("success"));