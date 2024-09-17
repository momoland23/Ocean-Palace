<?php  
session_start();  
if (!isset($_SESSION["user"])) {
    header("location:index.php");
    exit();
}

if (!isset($_GET["rid"])) {
    header("location:index.php");
    exit();
}

$curdate = date("Y/m/d");
include('db.php');
$id = $_GET['rid'];

$sql = "SELECT * FROM roombook WHERE id = '$id'";
$re = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($re)) {
    $fname = $row['FName'];
    $lname = $row['LName'];
    $email = $row['Email'];
    $Phone = $row['Phone'];
    $troom = $row['TRoom'];
    $nroom = $row['NRoom'];
    $bed = $row['Bed'];
    $meal = $row['Meal'];
    $cin = $row['cin'];
    $cout = $row['cout'];
    $sta = $row['stat'];
    $days = $row['nodays'];
}

// Count the available rooms based on room type
$rsql = "SELECT type, COUNT(*) as total_rooms FROM room GROUP BY type";
$rre = mysqli_query($con, $rsql);
$room_count = [
    "Superior Room" => 0,
    "Guest House" => 0,
    "Single Room" => 0,
    "Deluxe Room" => 0
];
while ($rrow = mysqli_fetch_array($rre)) {
    $room_count[$rrow['type']] = $rrow['total_rooms'];
}

// Count the booked rooms based on payment records
$csql = "SELECT troom, COUNT(*) as booked_rooms FROM payment GROUP BY troom";
$cre = mysqli_query($con, $csql);
$booked_count = [
    "Superior Room" => 0,
    "Guest House" => 0,
    "Single Room" => 0,
    "Deluxe Room" => 0
];
while ($crow = mysqli_fetch_array($cre)) {
    $booked_count[$crow['troom']] = $crow['booked_rooms'];
}

// Calculate available rooms by subtracting booked rooms from total rooms
$available_count = [];
foreach ($room_count as $type => $count) {
    $available_count[$type] = $count - $booked_count[$type];
}

// Handle the confirmation process
if (isset($_POST['co'])) {
    $st = $_POST['conf'];

    if ($st == "Confirm") {
        if ($available_count[$troom] <= 0) {
            echo "<script type='text/javascript'> alert('Sorry! $troom Not Available')</script>";
        } else {
            // Update room booking status to Confirm
            $urb = "UPDATE `roombook` SET `stat`='$st' WHERE id = '$id'";
            if (mysqli_query($con, $urb)) {
                
                // Pricing logic for different room types
                $type_of_room = 0;
                switch ($troom) {
                    case "Superior Room":
                        $type_of_room = 3200;
                        break;
                    case "Deluxe Room":
                        $type_of_room = 2200;
                        break;
                    case "Guest House":
                        $type_of_room = 1800;
                        break;
                    case "Single Room":
                        $type_of_room = 1500;
                        break;
                }

                // Pricing logic for different bed types
                $type_of_bed = 0;
                switch ($bed) {
                    case "Single":
                        $type_of_bed = $type_of_room * 1/100;
                        break;
                    case "Double":
                        $type_of_bed = $type_of_room * 2/100;
                        break;
                    case "Triple":
                        $type_of_bed = $type_of_room * 3/100;
                        break;
                    case "Quad":
                        $type_of_bed = $type_of_room * 4/100;
                        break;
                }

                // Pricing logic for different meal plans
                $type_of_meal = 0;
                switch ($meal) {
                    case "Room only":
                        $type_of_meal = $type_of_bed * 0;
                        break;
                    case "Breakfast":
                        $type_of_meal = $type_of_bed * 2;
                        break;
                    case "Half Board":
                        $type_of_meal = $type_of_bed * 3;
                        break;
                    case "Full Board":
                        $type_of_meal = $type_of_bed * 4;
                        break;
                }

                // Total price calculations
                $ttot = $type_of_room * $days * $nroom;
                $mepr = $type_of_meal * $days;
                $btot = $type_of_bed * $days;
                $fintot = $ttot + $mepr + $btot;

                // Insert payment details into the payment table
                $psql = "INSERT INTO `payment`(`id`, `fname`, `lname`, `troom`, `tbed`, `nroom`, `cin`, `cout`, `ttot`, `meal`, `mepr`, `btot`, `fintot`, `noofdays`) 
                        VALUES ('$id','$fname','$lname','$troom','$bed','$nroom','$cin','$cout','$ttot','$meal','$mepr','$btot','$fintot','$days')";
                if (mysqli_query($con, $psql)) {
                    // Assign room to the customer
                    $rpsql = "UPDATE `room` SET `cusid`='$id' WHERE bedding='$bed' AND type='$troom' LIMIT 1";
                    if (mysqli_query($con, $rpsql)) {
                        echo "<script type='text/javascript'> alert('Booking Confirmed')</script>";
                        echo "<script type='text/javascript'> window.location='home.php'</script>";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <!-- Navbar and Sidebar Code ... -->
        <!-- Main Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Room Booking <small><?php echo $curdate; ?></small>
                        </h1>
                    </div>

                    <div class="col-md-8 col-sm-8">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                Booking Confirmation
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr><th>DESCRIPTION</th><th>INFORMATION</th></tr>
                                        <tr><th>Name</th><th><?php echo $fname . " " . $lname; ?></th></tr>
                                        <tr><th>Email</th><th><?php echo $email; ?></th></tr>
                                        <tr><th>Phone No</th><th><?php echo $Phone; ?></th></tr>
                                        <tr><th>Type Of Room</th><th><?php echo $troom; ?></th></tr>
                                        <tr><th>No Of Room</th><th><?php echo $nroom; ?></th></tr>
                                        <tr><th>Meal Plan</th><th><?php echo $meal; ?></th></tr>
                                        <tr><th>Bedding</th><th><?php echo $bed; ?></th></tr>
                                        <tr><th>Check-in Date</th><th><?php echo $cin; ?></th></tr>
                                        <tr><th>Check-out Date</th><th><?php echo $cout; ?></th></tr>
                                        <tr><th>No of Days</th><th><?php echo $days; ?></th></tr>
                                        <tr><th>Status Level</th><th><?php echo $sta; ?></th></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <form method="post">
                                    <div class="form-group">
                                        <label>Select the Confirmation</label>
                                        <select name="conf" class="form-control">
                                            <option value selected></option>
                                            <option value="Confirm">Confirm</option>
                                        </select>
                                    </div>
                                    <input type="submit" name="co" value="Confirm" class="btn btn-success">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Available Room Details
                            </div>
                            <div class="panel-body">
                                <table width="200px">
                                    <tr><td><b>Superior Room</b></td><td><button class="btn btn-primary btn-circle"><?php echo $available_count['Superior Room']; ?></button></td></tr>
                                    <tr><td><b>Deluxe Room</b></td><td><button class="btn btn-primary btn-circle"><?php echo $available_count['Deluxe Room']; ?></button></td></tr>
                                    <tr><td><b>Guest House</b></td><td><button class="btn btn-primary btn-circle"><?php echo $available_count['Guest House']; ?></button></td></tr>
                                    <tr><td><b>Single Room</b></td><td><button class="btn btn-primary btn-circle"><?php echo $available_count['Single Room']; ?></button></td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Inner -->
        </div>
        <!-- End Page Wrapper -->
    </div>
    <!-- End Wrapper -->

    <!-- Scripts -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script>

</body>

</html>
