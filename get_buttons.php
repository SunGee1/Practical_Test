<!-- <?php
	// session_start();
	
	// if(!isset($_SESSION["user"]))
	// {
	// 	header("Location: login.php");
	// }
	
	// require("settings.php");
	// $user = $_SESSION["user"];

	// $order = $_POST["order_number"];


	// if ($order->status == "Placed")
	// {
	// 	if ($user->admin)
	// 	{
	// 		$buttons->button = "<input id='row_button_deliver_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='DeliverDialog(". $order->order_id .")' value='Deliver order'>");
	// 	} else
	// 	{
	// 		$buttons->button = "<input id='row_button_update_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog(". $order->order_id .")' value='Update order'><input id='row_button_cancel_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='CancelOrder(". $order->order_id .")' value='Cancel order'>";
	// 	}
	// } else if ($order->status == "Delivered")
	// {
	// 	if ($user->admin)
	// 	{	
	// 		$buttons->button = "";
	// 	} else
	// 	{
	// 		$buttons->button = "<input id='row_button_collect_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='CollectOrder(". $order->order_id .")' value='Collect order'>";
	// 	}
	// } else if ($order->status == "Canceled")
	// {
	// 	if ($user->admin)
	// 	{
	// 		$buttons->button = "<input id='row_button_delete_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='DeleteOrder(". $order->order_id .")' value='Delete order'>";
	// 	} else
	// 	{
	// 		$buttons->button = "";
	// 	}
	// } else if ($order->status == "Collected")
	// {
	// 	if ($user->admin)
	// 	{
	// 		$buttons->button = "<input id='row_button_archive_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='ArchiveOrder(". $order->order_id .")' value='Archive order'>";
	// 	} else
	// 	{
	// 		$buttons->button = "";
	// 	}
	// } else /*if $order->status == Archived*/
	// {
	// 	$buttons->button = "";
	// }

	// $buttons = (object)["button" => "<input id='row_button_deliver_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog(". $order->order_id .")' value='Deliver order'>"];

	// $buttons = (object)["button" => ""];

	// $buttons->button = "<input id='row_button_deliver_order_". $order->order_id ."' type='button' class='ui-button ui-corner-all ui-widget' onclick='OrderDialog(". $order->order_id .")' value='Deliver order'>";
	// $buttons = (object)["button" => "<input type='button' value='button'>"];

	// die(json_encode($buttons));
?> -->