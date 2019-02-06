<?php 

require("settings.php");
session_start();
// header("Content-Type: application/json");
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}
$user = $_SESSION["user"];
$order_id = $_POST["orderNum"];


$query = "DELETE FROM order_product WHERE order_ref = {$order_id}";
$result = $db_con->query($query);

$query = "SELECT (order_date) FROM user_order WHERE id = {$order_id}";
$result = $db_con->query($query);

mysqli_error($db_con);
$row = mysqli_fetch_assoc($result);
// var_dump($row["order_date"]);
$date = $row['order_date'];
$statement = $db_con->prepare("INSERT INTO archive (order_num, user_ref, date_order_placed) VALUES (?, ?, ?)");
$statement->bind_param("iis", $order_id, $user->id, $date);
$statement->execute();
// die();
$query = "DELETE FROM user_order WHERE id = {$order_id}";
$result = $db_con->query($query);

$statement->close();
$db_con->close();

?>