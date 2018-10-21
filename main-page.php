<?php
session_start();
require("settings.php");
echo 'Welcome '.$_SESSION['user']->firstname.'. What would you like to do?';

readfile('navigation.tmpl.html');

//$db = new mysqli($db_hostname, $db_username, $db_password, $db_database);
//$query = 'SELECT username FROM user';
//$query = 'SELECT surname FROM user WHERE id = $id';
//$statement = $db->prepare($query);
//$result = mysqli_query($db, $query);
//$row = mysqli_fetch_assoc($result);

//$keys = array_keys($_SESSION['user']);
//echo $_SESSION[1]['user'];
//echo $row;
//echo $_SESSION['user']['username'];
//var_dump($_SESSION['user']);
//echo $row;
//$id = $_SESSION['user']->firstname;
//var_dump($row);
//$name = $_SESSION['username']['user'];
//var_dump($_SESSION);
//echo $id;
//if (isset($_SESSION['user'])) {
//	echo "not empty";
//}

//$row = $_SESSION['user'];
//echo $row["username"];
//session_destroy();

?>