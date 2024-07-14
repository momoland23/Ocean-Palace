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
    <title>Mobile Banking Payment</title>
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
                        <a href="transaction.php"><i class="fa fa-mobile"></i> Payment</a>
                    </li>
                    <li>
                        <a href="mobile_banking.php"><i class="fa fa-mobile"></i> Mobile Banking</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Mobile Banking Payment 
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
                                <form name="mobile_banking_form" method="post" action="process_mobile_payment.php">
                                    <div class="form-group">
                                        <label for="payment_method">Select Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control" required>
                                            <option value="bKash">bKash</option>
                                            <option value="Rocket">Rocket</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="MYCash">MYCash</option>
                                            <option value="FSIBL">FSIBL</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="transaction_id">Transaction ID</label>
                                        <input type="text" name="transaction_id" id="transaction_id" class="form-control" required>
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
                                <p>Please follow the instructions for your selected payment method to complete the payment. Once the transaction is done, enter the transaction ID in the provided field and submit the form.</p>
                                <ul>
                                    <li><strong>bKash:</strong> Dial *247#, choose Send Money, and follow the instructions.</li>
                                    <li><strong>Rocket:</strong> Dial *322#, select Payment, and follow the instructions.</li>
                                    <li><strong>Nagad:</strong> Dial *167#, select Send Money, and follow the instructions.</li>
                                    <li><strong>MYCash:</strong> Dial *225#, select Payment, and follow the instructions.</li>
                                    <li><strong>FSIBL:</strong> Use the FSIBL Mobile App or dial the respective USSD code.</li>
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
