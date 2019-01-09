<?php
	session_start();
	
	if(!isset($_SESSION["user"]))
	{
		header("Location: login.php");
	}
	
	require("settings.php");
	$user = $_SESSION["user"];

	// echo $user->firstname;

	
	$db_con = new mysqli($db_hostname, $db_username, $db_password, $db_database);
	$query = "SELECT * FROM product";
	$result = $db_con->query($query);
?>

<!DOCTYPE html>
<html>
<head>
	</script>
		<script src="jquery-3.3.1.min.js"></script>
		<script src="order.js"></script>

		<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
		<script type="text/javascript" src="DataTables/datatables.min.js"></script>
		
		<!-- <link rel="stylesheet" href="jquery.css"> -->
 		<link type="text/css" href="jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="button_styles.css">
	</script>
</head>
<body>

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
				echo "<td style='text-align:right' width='33.33%'>" . 'R' . $row['cost']. '.00' . "</td>";		
				echo "<td style='text-align:right' width='33.33%'>" . "<input type='text' class='order_product' cost='{$row['cost']}' id='{$row['id']}' name='inputAdd' style='width: 65px;' maxlength='2'></input>" . "</td>";
				echo "</tr>";
			}
		?>
		</body>
	 	<footer>
			<tr>
				<td id='place_order_button'><input class="ui-button ui-corner-all ui-widget" type='button' onclick='PlaceOrder()' value='Place order' ></td>
			 	<td id='update_order_button'><input class="ui-button ui-corner-all ui-widget" type='button' value='Update order' ></td>
			</tr>
	 	</footer>
	 </table>
	<input style='margin-top: 3px;' type='button' class="ui-button ui-corner-all ui-widget" id="place_new_order" onclick='OrderDialog()' value='Place new order'>
	<input style='margin-top: 3px;' type='button' class="ui-button ui-corner-all ui-widget" id="inventory_button" onclick='' value='Show Inventory'>

	<div id="inventory" style="display: none">
		<ul>
		</ul>
		<input type="button" name="eat" value="Eat">
		<input type="button" name="chuck" value="Chuck">
	</div>

	<!-- ----- temp code that needs to be moved to its own file ----- -->
	<div id="error_dialog">

	</div>
	<!-- ----- temp code that needs to be moved to its own file ----- -->

</body>
</html>