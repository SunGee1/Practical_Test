<?php 
header("Content-Type: application/json");
require("settings.php");
session_start();
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}
$user = $_SESSION["user"];
$item_id = $_POST["itemRef"];
$sell_amount = $_POST["amount"];

$query = "SELECT item_quantity, u.money AS money, p.cost AS price FROM user_inventory LEFT JOIN user u ON u.id = {$user->id} LEFT JOIN product p ON p.id = {$item_id} WHERE item_ref = {$item_id} AND inv_user_ref = {$user->id}";
$result = $db_con->query($query);
$return_row = array();
while ($row = mysqli_fetch_assoc($result)) {
	$return_row[] = $row;
}
// var_dump($return_row[0]["money"]);
// var_dump($return_row[0]["price"] * $sell_amount);
$user_money = ($return_row[0]["money"] + (($return_row[0]["price"] / 2) * $sell_amount));
// var_dump($user_money);

if ($return_row[0]["item_quantity"] - $sell_amount < 0)
{
	$return_row = ["success" => false];
	die(json_encode($return_row));
}
else
{
	$statement = $db_con->prepare("UPDATE user_inventory SET item_quantity = item_quantity - ? WHERE item_ref = ? AND inv_user_ref = ?");
	$statement->bind_param("iii", $sell_amount, $item_id, $user->id);
	$statement->execute();

	$statement = $db_con->prepare("UPDATE user SET money = ? WHERE id = ?");
	$statement->bind_param("ii", $user_money, $user->id);
	$statement->execute();

	$return_row = ["new_amount" => $return_row[0]["item_quantity"] - $sell_amount];
	$return_row += ["current_money" => $user_money];
	die(json_encode($return_row));
}
?>