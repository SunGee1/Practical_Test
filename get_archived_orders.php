<?php 
session_start();
header("Content-Type: application/json");
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");
// $user = $_SESSION["user"];

$query = "SELECT order_num, u.firstname AS Name, date_order_placed, date_order_archived FROM archive LEFT JOIN user u ON user_ref = u.id ORDER BY order_num";
$result = $db_con->query($query);
$orders = array();
while ($order = mysqli_fetch_array($result)) {
	$orders[] = $order;
}

die(json_encode($orders));
?>