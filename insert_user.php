<?php
$con = mysqli_connect("localhost", "root", "", "hotel") or die(mysqli_error($con));

$email = "user@example.com";
$password = password_hash("password123", PASSWORD_BCRYPT);

$sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";

if (mysqli_query($con, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
?>
