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
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Confirmation</title>
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
                        <a href="../index.php"><i class="fa fa-home"></i> Homepage</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Payment Confirmation
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Thank You!
                            </div>
                            <div class="panel-body">
                                <p>Your payment has been successfully processed. Thank you for choosing our service.</p>
                                <p>If you have any questions, please contact our support team at <a href="mailto:support@oceanpalace.com">support@oceanpalace.com</a> or call us at +123456789.</p>
                            </div>
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
