<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");

$order_id = $_POST['order'];
$order_status = $_POST['status'];

// die(json_encode($order_status));
// canceling order
if (!$order_status == "Placed")
{
	$query = "UPDATE user_order SET status_ref = 3 WHERE id = '{$order_id}'";
	$result = $db_con->query($query);
}
// delivering order
else /*if status =*delivered*/
{
	$query = "UPDATE user_order SET status_ref = 2 WHERE id = '{$order_id}'";
	$result = $db_con->query($query);
}


