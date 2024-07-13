<?php
session_start(); // Start the session

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
    <title>RESERVATION OCEAN PALACE</title>
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
                            RESERVATION <small></small>
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 col-sm-5">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                PERSONAL INFORMATION
                            </div>
                            <div class="panel-body">
                               <form name="form" method="post" action="reservation.php">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="fname" class="form-control" value="<?php echo htmlspecialchars($firstname); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lname" class="form-control" value="<?php echo htmlspecialchars($lastname); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" type="text" class="form-control" value="<?php echo htmlspecialchars($contact); ?>" required>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-5">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                RESERVATION INFORMATION
                            </div>
                            <div class="panel-body">
                                <form name="form" method="post" action="reservation.php">
                                    <div class="form-group">
                                        <label>Type Of Rooms</label>
                                        <select name="troom" class="form-control" required>
                                            <option value="" selected></option>
                                            <option value="Single Room">SINGLE ROOM</option>
                                            <option value="Superior Room">SUPERIOR ROOM</option>
                                            <option value="Deluxe Room">DELUXE ROOM</option>
                                            <option value="Guest House">GUEST HOUSE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bedding Type</label>
                                        <select name="bed" class="form-control" required>
                                            <option value="" selected></option>
                                            <option value="Single">Single</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Quad">Quad</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No. of Rooms</label>
                                        <select name="nroom" class="form-control" required>
                                            <option value="" selected></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Meal Plan</label>
                                        <select name="meal" class="form-control" required>
                                            <option value="" selected></option>
                                            <option value="Room only">Room only</option>
                                            <option value="Breakfast">Breakfast</option>
                                            <option value="Half Board">Half Board</option>
                                            <option value="Full Board">Full Board</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Check-In</label>
                                        <input name="cin" type="date" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Check-Out</label>
                                        <input name="cout" type="date" class="form-control">
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="well">
                            <h4>HUMAN VERIFICATION</h4>
                            <p>Type Below this code <?php $Random_code = rand(); echo $Random_code; ?> </p>
                            <br />
                            <p>Enter the random code<br /></p>
                            <form name="form" method="post" action="reservation.php">
                                <input type="text" name="code1" title="random code" required />
                                <input type="hidden" name="code" value="<?php echo $Random_code; ?>" />
                                <input type="submit" name="submit" class="btn btn-primary">
                            </form>
                            <?php
                            
                            include('db.php');

                            if (isset($_POST['submit'])) {
                                $con = mysqli_connect("localhost", "root", "", "hotel");

                                // Validate check-in and check-out dates
                                $checkInDate = strtotime($_POST['cin']);
                                $checkOutDate = strtotime($_POST['cout']);
                                $currentDate = strtotime(date('Y-m-d'));

                                if ($checkInDate < $currentDate || $checkOutDate < $currentDate || $checkOutDate <= $checkInDate) {
                                    echo "<script type='text/javascript'> alert('Invalid check-in or check-out dates'); </script>";
                                } else {
                                    // Check if the room is available
                                    $roomAvailabilityCheck = "SELECT * FROM roombook WHERE TRoom = '$_POST[troom]' AND Bed = '$_POST[bed]' AND NRoom > 0 AND ((STR_TO_DATE('$_POST[cin]', '%Y-%m-%d') BETWEEN cin AND cout) OR (STR_TO_DATE('$_POST[cout]', '%Y-%m-%d') BETWEEN cin AND cout))";
                                    $roomAvailabilityResult = mysqli_query($con, $roomAvailabilityCheck);
                                    $roomAvailabilityData = mysqli_fetch_array($roomAvailabilityResult, MYSQLI_NUM);

                                    if ($roomAvailabilityData !== null && $roomAvailabilityData[0] > 0) {
                                        echo "<script type='text/javascript'> alert('Selected room with the same bed type is not available for the specified dates'); </script>";
                                    } else {
                                        $new = "Not Confirm";
                                        $nodays = floor(($checkOutDate - $checkInDate) / (60 * 60 * 24));

                                        $newUser = "INSERT INTO roombook`(FName`, LName, Email, Phone, TRoom, Bed, NRoom, Meal, cin, cout, stat, nodays) VALUES ('$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[phone]','$_POST[troom]','$_POST[bed]','$_POST[nroom]','$_POST[meal]','$_POST[cin]','$_POST[cout]','$new','$nodays')";

                                        if (mysqli_query($con, $newUser)) {
                                            echo "<script type='text/javascript'> alert('Your Booking application has been sent'); </script>";
                                        } else {
                                            echo "<script type='text/javascript'> alert('Error adding user to the database'); </script>";
                                        }
                                    }
                                }
                            }
                            ?>


    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>