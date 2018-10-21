<!DOCTYPE>
<form method="post" action="">
	User name: <input type="text" name="name" value="<?php
		echo htmlspecialchars($name);
	?>"><br>
	Password: <input type="password" name="password"><br>
	Gender:
		<input type="radio" name="gender" value="f" <?php
			if ($gender === 'f') {
				echo ' checked';
			}
		?>>female
		<input type="radio" name="gender" value="m"<?php
			if ($gender === 'm') {
				echo ' checked';
			}
		?>>male<br>
		Favorite color:
			<select name="color">
				<option value="">Please select</option>
				<option value="#f00"<?php
					if ($color === '#f00') {
						echo ' selected';
					}
				?>>red</option>
				<option value="#0f0"<?php
					if ($color === '#0f0') {
						echo ' selected';
					}
				?>>green</option>
				<option value="#00f"<?php
					if ($color === '#00f') {
						echo ' selected';
					}
				?>>blue</option>
			</select><br>
		Languages spoken:
			<select name="languages[]" multiple size="3">
				<option value="en"<?php
					if (in_array('en', $languages)) {
						echo ' selected';
					}
				?>>English</option>
				<option value="fr"<?php
					if (in_array('fr', $languages)) {
						echo ' selected';
					}
				?>>French</option>
				<option value="it"<?php
					if (in_array('it', $languages)) {
						echo ' selected';
					}
				?>>Italian</option>
			</select><br>
		Comments: <textarea name="comments"><?php
			echo htmlspecialchars($comments)
		?></textarea><br>
		<input type="checkbox" name="tc" value="ok"<?php
			if ($tc === 'ok') {
				echo ' checked';
			}
		?>>I accept the T&C<br>
		<input type="submit" name="submit" value="Create">
</form>
</body>
</html>