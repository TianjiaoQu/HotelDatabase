<?php
$servername = "localhost";
$username ="tqu2";
$password = "pZh2iQfV";
$database = "tqu2_1";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Connection_failed: " .$conn->connect_error);
}
?>
