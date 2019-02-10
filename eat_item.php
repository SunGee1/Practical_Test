<?php 
require("settings.php");
session_start();
// header("Content-Type: application/json");
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}
$user = $_SESSION["user"];
$item_id = $_POST["itemRef"];

$query = "SELECT item_quantity FROM user_inventory WHERE item_ref = {$item_id} AND inv_user_ref = {$user->id}";
$result = $db_con->query($query);
// mysqli_error($db_con);
// var_dump($result);
// $rows = {};
while ($amount = mysqli_fetch_assoc($result))
{
	$rows[] = (object)$amount;
	if($amount["item_quantity"] <= 1)
	{
		$query = "DELETE FROM user_inventory WHERE item_ref = {$item_id} AND inv_user_ref = {$user->id}";
		$db_con->query($query);
		// var_dump("1 or less");
	}
	else
	{
		// var_dump("more then 1");
		$query = "UPDATE user_inventory SET item_quantity = item_quantity - 1 WHERE item_ref = {$item_id} AND inv_user_ref = {$user->id}";
		$db_con->query($query);
	}
}
// $object = (object) ['property' => 'Here we go'];
// die("ssssssssssss");
// var_dump(gettype($object));
// var_dump($rows[0]->item_quantity);
die($rows[0]->item_quantity);
?>