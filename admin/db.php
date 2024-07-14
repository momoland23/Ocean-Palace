<?php
$con = mysqli_connect("localhost", "root", "", "hotel");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>