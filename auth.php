<?php
session_start();
	//use this to see all variables in the session to find out if they are set or not.
	//var_dump($_SESSION);

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
	echo "You need to be admin to proceed.";
}

?>