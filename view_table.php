<?php
	require("settings.php");
	
	session_start();
	
	header("Content-Type: application/json");

	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}

	$user = $_SESSION["user"];
// die("ssss");
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
			WHERE u.id = {$user->id} AND s.id != 4 AND s.id != 5
			GROUP BY uo.id";
	}

	$result = $db_con->query($query);

	$rows = array();

	while($row = mysqli_fetch_object($result))
	{
		$row->order_html = GetHTML($row->id);
		$row->buttons = GetButtons($row);
		$rows[] = $row;
	}

	function GetButtons($order)
	{
		global $user;
		$button = "";
		if ($order->Status == "Placed")
		{
			if ($user->admin)
			{
				$button = "<input id='row_button_deliver_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget'
				onclick='StatusUpdate(". $order->id .",\"". $order->Status ."\",". $user->admin .")' value='Deliver order'>";
			} else
			{
				$button = "<input id='row_button_update_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog(". $order->id .")' value='Update order'><input id='row_button_cancel_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='StatusUpdate(". $order->id .",\"". $order->Status ."\",false)' value='Cancel order'>";
			}
		} else if ($order->Status == "Delivered")
		{
			if ($user->admin)
			{	
				$button = "";
			} else
			{
				$button = "<input id='row_button_collect_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='CollectOrder(". $order->id .")' value='Collect order'>";
			}
		} else if ($order->Status == "Canceled")
		{
			if ($user->admin)
			{
				$button = "<input id='row_button_delete_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='DeleteOrder(". $order->id .")' value='Delete order'>";
			} else
			{
				$button = "";
			}
		} else if ($order->Status == "Collected")
		{
			// if ($user->admin)
			// {
				$button = "<input id='row_button_archive_order_". $order->id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='ArchiveOrder(". $order->id .")' value='Archive order'>";
			// } else
			// {
			// 	$button = "";
			// }
		}else
		{
			$button = "";
		}
		
		return $button;
	}

	function GetHTML($order_id)
	{
		global $db_con;
		$query = "SELECT p.description AS Name, p.cost AS Price, op.quantity AS Amount
					FROM order_product op
					LEFT JOIN product p ON id = op.product_ref
					WHERE order_ref = {$order_id}";
		$result = $db_con->query($query);
		$rows = array();
		while ($row = mysqli_fetch_array($result)) {
			$rows[] = $row;
		}

		$div = array();
		foreach ($rows as $value) {
		$div[] = $value['Name']." @ R".$value['Price']." x ".$value['Amount'];
		}
		$div = implode("\n", $div);
		return $div;
	}
	
	die(json_encode($rows));
?>