<?php

$db_hostname = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "ordering";
$db_con = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//Check connection
if (!$db_con) {
 die("Connection failed: " . mysqli_connect_error());
}