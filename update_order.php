<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");
$product_quantities = $_POST["products"];
$orderNum = $_POST['order_number'];
$user = $_SESSION['user'];

$query = "SELECT money FROM user WHERE id = '{$user->id}'";
$result = $db_con->query($query);
$user_money = mysqli_fetch_object($result);

$query = "SELECT SUM(p.cost * op.quantity) AS cost
			FROM order_product op
			LEFT JOIN product p ON op.product_ref = p.id
			WHERE order_ref = '{$orderNum}'";
$result = $db_con->query($query);
$current_amount = mysqli_fetch_object($result);
// var_dump($current_amount->cost);
$new_price = 0;
for ($i=0; $i < count($product_quantities); $i++) { 
	$new_price += $product_quantities[$i]['product_cost'] * $product_quantities[$i]['product_quantity'];
}
$new = ($current_amount->cost - $new_price);

$positive = 0;
if ($new < 0) // increasing quantities = deduct money
{
	$positive = $new / -1;
	$new_money = $user_money->money - $positive;
	
}
else // decreasing quantities = refund money
{
	$new_money = $user_money->money + $new;
}

if ($new_money < 0)
{
	die("You do not have enough money for the update.");
}
else
{
	$statement = $db_con->prepare("UPDATE user SET money = ? WHERE id = ?");
	$statement->bind_param("ii", $new_money , $user->id);
	$statement->execute();

	$query = "DELETE FROM order_product WHERE order_ref = '{$orderNum}'";
	$result = $db_con->query($query);

	$query = "UPDATE user_order SET order_update = NOW() WHERE id = '{$orderNum}'";
	$result = $db_con->query($query);

	if($statement = $db_con->prepare("INSERT INTO order_product VALUES(?, ?, ?)"))
	{
		$statement->bind_param("iii", $orderNum, $product_id, $product_quantity);
		foreach ($product_quantities as $product)
		{
			$product = (object)$product;
			$product_id = $product->product_id;
			$product_quantity = $product->product_quantity;
			$statement->execute();
		}
	}
}

	// $query = "SELECT u.firstname, uo.id, SUM(p.cost * op.quantity) AS value, uo.order_date, uo.order_update, s.label AS status
	// 	FROM user_order uo
	// 	LEFT JOIN status s ON uo.status_ref = s.id
	// 	LEFT JOIN user u ON u.id = uo.user_ref
	// 	LEFT JOIN order_product op ON op.order_ref = uo.id
	// 	LEFT JOIN product p ON p.id = op.product_ref
	// 	WHERE uo.id = ?";

	// if($statement = $db_con->prepare($query))
	// {
	// 	$statement->bind_param("i", $orderNum);
		
	// 	if($statement->execute())
	// 	{
	// 		$order = $statement->get_result();
	// 		$order = $order->fetch_object();
	// 	}
		
	// }
die($new_money);
