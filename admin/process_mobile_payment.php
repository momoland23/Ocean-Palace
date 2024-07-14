<?php
session_start();

// Include database connection
include('db.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $payment_method = $_POST['payment_method'] ?? '';
    $transaction_id = $_POST['transaction_id'] ?? '';

    // Validate the form data
    if (empty($payment_method) || empty($transaction_id)) {
        echo "<script type='text/javascript'> alert('Please fill in all fields'); window.location.href='mobile_banking.php'; </script>";
    } else {
        // Process the payment (this is a placeholder, you should implement actual payment processing)
        // ...

        // Redirect to a confirmation page
        echo "<script type='text/javascript'> alert('Payment successful'); window.location.href='confirmation.php'; </script>";
    }
} else {
    echo "<script type='text/javascript'> alert('Invalid request'); window.location.href='mobile_banking.php'; </script>";
}
?>
