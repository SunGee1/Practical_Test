<?php
	session_start();

	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	
	require("settings.php");
	$user = $_SESSION["user"];
	$name = $user->firstname;
	$isAdmin = $user->admin ? " - Admin user" : " - Basic user" ;
	
	$query = "SELECT money FROM user WHERE id = {$user->id}";
	$result = $db_con->query($query);
	$result = $result->fetch_object();
	$user->money = $result->money;

	$db_con = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	$query = "SELECT * FROM product";
	$result = $db_con->query($query);
?>

<!DOCTYPE html>
<html>
<head>
	</script>
		<script src="scripts/jquery-3.3.1.min.js"></script>
		<script src="scripts/order.js"></script>
		<link rel="stylesheet" href="scripts/styles.css">

		<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		
		<link rel="stylesheet" href="scripts/jquery.css">
 		<link type="text/css" href="jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="scripts/button_styles.css">
	</script>
</head>
<body>
	<?php
		$show_money =  "<div id='user_money' class='form_style'>Money: R" . $user->money . "</div><br>";
	?>
<div class="">You are logging in as <?php echo $name.$isAdmin; echo $user->admin ? "" : $show_money ?>
<form method="get" action="logout.php">
    <button type="submit">Logout</button>
</form>
<table id="view_order_table" class="display" style="width:100%;" style='display:none'>
	<thead>
		<tr>
			<th style='text-align:left'>Name</th>
			<th style='text-align:left'>Order</th>
			<th style='text-align:left'>Value</th>
			<th style='text-align:left'>Date</th>
			<th style='text-align:left'>Last Updated</th>
			<th style='text-align:left'>Status</th>
			<th style='text-align:left'>Action</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

	<table id="place_order_table" class="display" style="display: none">
		<thead>
			<tr>
				<th style='text-align:left'>Product</th>
				<th style='text-align:right'>Value</th>
				<th style='text-align:right'>Quantity</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($row = mysqli_fetch_array($result))	
			{	
				echo "<tr>";		
				echo "<td style='text-align:left' width='33.33%'>" . $row['description'] . "</td>";

				echo "<td style='text-align:right' width='33.33%'>" . 'R' . $row['cost'] . "</td>";

				echo "<td style='text-align:right' width='33.33%'>" . "<input type='text' id='{$row['id']}' class='order_product' cost='" . $row['cost'] . "' name='inputAdd' style='width: 65px;' maxlength='2'></input>" . "</td>";

				echo "</tr>";
			}
		?>
		</tbody>
	 	<footer>
	 		<tr><td colspan="3" style='text-align:center'>----------------------------------</td></tr>
				<td><label>Total Price:</label></td>
				<td colspan="2"><label id="total_order_price_label">R0.00</label></td>
			<tr>
				<td id='place_order_button'><input class="ui-button ui-corner-all ui-widget" type='button' onclick='PlaceOrder()' value='Place order' ></td>
			 	<td id='update_order_button'><input class="ui-button ui-corner-all ui-widget" type='button' value='Update order' ></td>
			</tr>
	 	</footer>
	 </table>
	 <?php

	 if (!$user->admin) {
	 	echo "<input style='margin-top: 3px;' type='button' class='ui-button ui-corner-all ui-widget' id='place_new_order' onclick='OrderDialog()' value='Place new order'>";
		echo "<input style='margin-top: 3px;' type='button' class='ui-button ui-corner-all ui-widget' id='inventory_button' onclick='ShowInventory()' value='Show Inventory'>";
		echo "<br>";
		echo "<input style='margin-top: 3px;' type='button' class='ui-button ui-corner-all ui-widget' id='gamble_button' onclick='GambleDialog()' value='Gamble'>";
	 } else
	 {
	 	echo "<input style='margin-top: 3px;' type='button' class='ui-button ui-corner-all ui-widget fixed_header' id='inventory_button' onclick='GetArchivedOrders()' value='Show archived orders'>";
	 }
		
	 ?>
	

	<div id="inventory" style="display: none">
		<table>
			<thead>
				<tr>
					<th style='text-align:left; width:150px'>Item</th>
					<th style='text-align:right'>Quantity</th>
					<th style='text-align:right'>Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<div id="gamble" class="wol"></div>

	<div id="archive" style="display: none">
		<table>
			<thead>
				<tr>
					<th style='text-align:center; width:80px'>Order #</th>
					<th style='text-align:center; width:80px'>User</th>
					<th style='text-align:center; width:250px'>Date Order Placed</th>
					<th style='text-align:center; width:250px'>Date Order Archived</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>

	<!-- ----- temp code that needs to be moved to its own file ----- -->
	<div id="error_dialog">

	</div>
	<!-- ----- temp code that needs to be moved to its own file ----- -->

</body>
</html>