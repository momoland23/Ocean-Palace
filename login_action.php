<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "hotel") or die(mysqli_error($con));

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        header("Location: admin/reservation.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
    mysqli_close($con);
}
?>
