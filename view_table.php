<?php
	require("settings.php");
	
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	$user = $_SESSION["user"];

	if ($user->admin)
	{	
		$query = "SELECT u.firstname, uo.id, SUM(p.cost * op.quantity) AS Value, uo.order_date, uo.order_update, s.label AS Status
			FROM user_order uo
			LEFT JOIN status s ON uo.status_ref = s.id
			LEFT JOIN user u ON u.id = uo.user_ref
			LEFT JOIN order_product op ON op.order_ref = uo.id
			LEFT JOIN product p ON p.id = op.product_ref
			GROUP BY uo.id";
	}else
	{
		$query = "SELECT u.firstname, uo.id, SUM(p.cost * op.quantity) AS Value, uo.order_date, uo.order_update, s.label AS Status
			FROM user_order uo
			LEFT JOIN status s ON uo.status_ref = s.id
			LEFT JOIN user u ON u.id = uo.user_ref
			LEFT JOIN order_product op ON op.order_ref = uo.id
			LEFT JOIN product p ON p.id = op.product_ref
			WHERE u.id = {$user->id}
			GROUP BY uo.id";
	}

	$result = $db_con->query($query);

	$rows = [];

	while($row = mysqli_fetch_array($result))
	{
		array_push($rows, $row);
	}

	die(json_encode($rows));
?>