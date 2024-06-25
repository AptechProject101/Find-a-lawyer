<?php
$conn = mysqli_connect("localhost", "root", "", "lawyers");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
