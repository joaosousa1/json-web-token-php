<?php

$servername = "localhost";
$dbusername = "festas_user";
$dbpassword = "passworD1_";
$dbname = "minhofestas";

// Create connection
$mysqli = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}
?>