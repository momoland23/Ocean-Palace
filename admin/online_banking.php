<?php
session_start();

// Check if the user session is set
if (!isset($_SESSION['user'])) {
    die("User session not set. Please log in.");
}

// Retrieve user details from session
$firstname = $_SESSION['user']['firstname'] ?? 'N/A';
$lastname = $_SESSION['user']['lastname'] ?? 'N/A';
$email = $_SESSION['user']['email'] ?? 'N/A';
$contact = $_SESSION['user']['contact'] ?? 'N/A';

// Include database connection
include('db.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Online Banking Payment</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="transaction.php"><i class="fa fa-credit-card"></i> Payment</a>
                    </li>
                    <li>
                        <a href="online_banking.php"><i class="fa fa-credit-card"></i> Online Banking System</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Online Banking Payment 
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Choose Payment Method
                            </div>
                            <div class="panel-body">
                                <form name="online_banking_form" method="post" action="process_online_payment.php">
                                    <div class="form-group">
                                        <label for="payment_method">Select Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control" required>
                                            <option value="Credit Card">Credit Card</option>
                                            <option value="Debit Card">Debit Card</option>
                                            <option value="Master Card">Master Card</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="card_number">Card Number</label>
                                        <input type="text" name="card_number" id="card_number" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" class="form-control" required placeholder="MM/YY">
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" name="cvv" id="cvv" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="panel panel-primary">
                            <div class="panel-heading">
                                Instructions
                            </div>
                            <div class="panel-body">
                                <p>Please enter your card details to complete the payment. Make sure to double-check the information before submitting.</p>
                                <ul>
                                    <li><strong>Credit Card:</strong> Enter your credit card number, expiry date, and CVV.</li>
                                    <li><strong>Debit Card:</strong> Enter your debit card number, expiry date, and CVV.</li>
                                    <li><strong>Master Card:</strong> Enter your Master Card number, expiry date, and CVV.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <h4>Need Help?</h4>
                            <p>If you encounter any issues, please contact our support team at <a href="mailto:support@oceanpalace.com">support@oceanpalace.com</a> or call us at +123456789.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>
