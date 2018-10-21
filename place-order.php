<!DOCTYPE>
<?php
session_start();
require("settings.php");
readfile('navigation.tmpl.html');

$firstname = $_SESSION['user']->firstname;

$db = new mysqli($db_hostname, $db_username, $db_password, $db_database);
$query = 'SELECT description FROM product';
$statement = $db->prepare($query);
$result = mysqli_query($db, $query);
$description = mysqli_fetch_assoc($result);


$table_contents = mysqli_query($db, "SELECT * FROM product");

/*require("settings.php");
session_start();*/

if(!isset($_SESSION["user"]))
{
	header("Location: login.php");
}

if (isset($_POST['submit'])) {
	
}

$user = $_SESSION["user"];
?>

<form method="post" action="">
	<p>Hello <?php echo $firstname?></p>
	<p>Choose below from a selection of great game titles and order now!</p>
	<p>Select multiple items by pressing and holding "Ctrl".</p><br>
	<?php
		echo "<form method='POST' action='ordering.php'><table border='1'>
		<tr>
		<th>ID</th>
		<th>Game Title</th>
		<th>Price</th>
		<th>Order</th>
		</tr>";

		while($row = mysqli_fetch_array($table_contents))
		{
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['description'] . "</td>";
		echo "<td>R" . $row['value'] . "</td>";
		//echo "<td>" . "<button onclick=order(($row['id'])) class='btn' >Select</button>" . "</td>";
		//<td><input type='radio' name='candidate_id[]' value='".$row['ID']."'></td>
		//echo "<td>" . "<button class='btn' >Select</button>" . "</td>";
		echo "<td>" . "<input type='text' name='{$row['id']}_quantity'>" . "</td>";
		//echo "<td>" . "<input type='text' name='inputText'>" . "</td>";
		echo "</tr>";
		}
		echo "</table><input type='submit' name='submit' value='Order'></form>";
		echo '<br>';
		echo $_POST[$row['3']];
		
	?>
<!-- <script src="order.js"></script>
		Order List:
			<select name="description[]" multiple size="7">
				
			</select><br>
		<input type="submit" name="submit" value="Order"> -->
</form>
</body>
</html>



<!-- <!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/ju/dt-1.10.18/b-1.5.4/b-flash-1.5.4/b-html5-1.5.4/datatables.min.css"/>
		<script src="jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/v/ju/dt-1.10.18/b-1.5.4/b-flash-1.5.4/b-html5-1.5.4/datatables.min.js"></script>
		<script src="order.js"></script>
		
		<link rel="stylesheet" href="jquery.css">
		<script
			  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
			  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
			  crossorigin="anonymous"></script>
	</head>
	<body>
	<?php echo $table; ?>
	<div id='order_dialog' title='Order Details' style='display:none;'>
		<div>
			<select id='order_dialog_product'>
				<?php echo $product_options; ?>
			</select>
		</div>
		<form id='order_list_form'><select id='order_list' name='order_list[]' multiple='true' style="width:300px;"></select></form><br>
		<input type='button' onclick='addProduct();' value='Add'>
		<input type='button' onclick='removeProduct();' value='Remove'>
	</div>
	<input type='button' onclick='order("new_order");' value='Place Order'> -->