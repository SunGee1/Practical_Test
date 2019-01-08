<?php
session_start();

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

require("settings.php");
$product_quantities = $_POST["products"];
$orderNum = $_POST['order_number'];

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

	$query = "SELECT u.firstname, uo.id, SUM(p.cost * op.quantity) AS value, uo.order_date, uo.order_update, s.label AS status
		FROM user_order uo
		LEFT JOIN status s ON uo.status_ref = s.id
		LEFT JOIN user u ON u.id = uo.user_ref
		LEFT JOIN order_product op ON op.order_ref = uo.id
		LEFT JOIN product p ON p.id = op.product_ref
		WHERE uo.id = ?";

	if($statement = $db_con->prepare($query))
	{
		$statement->bind_param("i", $orderNum);
		
		if($statement->execute())
		{
			$order = $statement->get_result();
			$order = $order->fetch_object();
		}
		
	}
die(json_encode($order));