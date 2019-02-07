<?php 
session_start();
header("Content-Type: application/json");
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");
// $user = $_SESSION["user"];




// $query = "SELECT item_ref, p.description, item_quantity FROM user_inventory LEFT JOIN product p ON item_ref = p.id WHERE inv_user_ref = {$user->id}";


$query = "SELECT order_num, u.firstname AS Name, date_order_placed, date_order_archived FROM archive LEFT JOIN user u ON user_ref = u.id ORDER BY order_num";
$result = $db_con->query($query);
mysqli_error($db_con);
$orders = array();
while ($order = mysqli_fetch_array($result)) {
	$orders[] = $order;
}

// var_dump($orders);
// die("wwwwwddsdasdasd");
die(json_encode($orders));
?>