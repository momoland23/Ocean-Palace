<?php
include('db.php');
session_start(); // Start the session

// Ensure the array keys match the form input names
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$contact = $_POST['contact'] ?? '';
$password = $_POST['password'] ?? '';

// Check if any required fields are empty
if (empty($firstname) || empty($lastname) || empty($email) || empty($contact) || empty($password)) {
    die("Please fill in all required fields.");
}

try {
    $con = new mysqli("localhost", "root", "", "hotel");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $con->prepare("INSERT INTO users (firstname, lastname, email, contact, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $contact, $password);

    // Execute the statement
    if ($stmt->execute()) {
        // Save the user's information in the session
        $_SESSION['user'] = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'contact' => $contact
        ];

        // Redirect to reservation.php after successful registration
        header("Location: admin/reservation.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $con->close();
} catch (mysqli_sql_exception $e) {
    die("Error: " . $e->getMessage());
}
?>
