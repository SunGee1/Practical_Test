<!DOCTYPE>
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
		echo "</tr>";
		}
		echo "</table><input type='submit' value='Submit'></form>";
		echo '<br>';
	?>