<?php 
require("settings.php");
session_start();
// header("Content-Type: application/json");
if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

$order = $_POST['order'];
// $user = $_SESSION["user"];


$query = "SELECT p.description AS Name, p.cost AS Price, op.quantity AS Amount
FROM order_product op
LEFT JOIN product p ON id = op.product_ref
WHERE order_ref = '{$order['order_id']}'";
$result = $db_con->query($query);
$rows = array();
while ($row = mysqli_fetch_array($result)) {
	$rows[] = $row;
}

foreach ($rows as $value) {
	// $name = var_export($value['Name'], true);
	// $price = var_export($value['Price'], true);
	// $amount = var_export($value['Amount'], true);
	// var_dump($name);
	// var_dump($price);
	// var_dump($amount);
$div .= "<div>Name: ".$value['Name']." Price: ".$value['Price']."Amount: ".$value['Amount']."</div>";
}

$formatted = "<div>".$div."</div>";
var_dump($formatted);
die($formatted);

?>