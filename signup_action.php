<?php
include('db.php'); // Include database connection

session_start(); // Start the session

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($firstname) || empty($lastname) || empty($email) || empty($contact) || empty($password)) {
    die("Please fill in all required fields.");
}

try {
    $con = new mysqli("localhost", "root", "", "hotel");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO users (firstname, lastname, email, contact, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $contact, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['user'] = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'contact' => $contact
        ];

        header("Location: admin/reservation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} catch (mysqli_sql_exception $e) {
    die("Error: " . $e->getMessage());
}
?>