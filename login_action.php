<?php
include('db.php'); // Include database connection

session_start(); // Start the session

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    die("Please fill in all required fields.");
}

try {
    $con = new mysqli("localhost", "root", "", "hotel");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $stmt = $con->prepare("SELECT id, firstname, lastname, email, contact, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $firstname, $lastname, $email, $contact, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user'] = [
                'id' => $id,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'contact' => $contact
            ];

            header("Location: admin/reservation.php");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
    $con->close();
} catch (mysqli_sql_exception $e) {
    die("Error: " . $e->getMessage());
}
?>