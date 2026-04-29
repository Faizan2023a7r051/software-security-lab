<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "faizan", "1234", "testdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
