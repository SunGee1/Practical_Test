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

$query = "SELECT item_quantity FROM user_inventory WHERE item_ref = {$item_id} AND inv_user_ref = {$user->id}";
$result = $db_con->query($query);
$return_row = array();
while ($row = mysqli_fetch_assoc($result)) {
	$return_row[] = $row;
}
// var_dump("0------------------");
// var_dump($return_row[0]["item_quantity"]);
// var_dump($sell_amount);
// var_dump($return_row[0]["item_quantity"] . " - " . $sell_amount . " = " . ($return_row[0]["item_quantity"] - $sell_amount));
// var_dump("New amount: " . ($return_row[0]["item_quantity"] - $sell_amount));
// var_dump("is new amount less then 0: " . (($return_row[0]["item_quantity"] - $sell_amount) < 0));
// var_dump("1------------------");

// $answer =  "beginning ";
// $answer .= parseInt($return_row[0]["item_quantity"], 10);
// $answer .= " - ";
// $answer .= parseInt($sell_amount, 10);
// $answer .= " = ";
// $answer .= parseInt($return_row[0]["item_quantity"] - $sell_amount, 10);
// var_dump($answer);
// $numone = 1;
// $numtwo = 2;
// $wol = "number one = " . $numone . ". number two = " . $numtwo . ".";
// var_dump($wol);
// die("the END");
// var_dump($answer);
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

	$return_row = ["new_amount" => $return_row[0]["item_quantity"] - $sell_amount];
	// var_dump($return_row);
	die(json_encode($return_row));
}
?>