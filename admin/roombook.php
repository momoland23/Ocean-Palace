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

function getRoomBookingDetails($con, $id) {
    $sql = "SELECT * FROM roombook WHERE id = '$id'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_array($result);
}

function getRoomCounts($con) {
    $sql = "SELECT * FROM room";
    $result = mysqli_query($con, $sql);
    $room_count = [
        "Superior Room" => 0,
        "Guest House" => 0,
        "Single Room" => 0,
        "Deluxe Room" => 0
    ];
    while ($row = mysqli_fetch_array($result)) {
        $room_count[$row['type']] += 1;
    }
    return $room_count;
}

function getBookedCounts($con) {
    $sql = "SELECT * FROM payment";
    $result = mysqli_query($con, $sql);
    $booked_count = [
        "Superior Room" => 0,
        "Guest House" => 0,
        "Single Room" => 0,
        "Deluxe Room" => 0
    ];
    while ($row = mysqli_fetch_array($result)) {
        $booked_count[$row['troom']] += 1;
    }
    return $booked_count;
}

function getAvailableCounts($room_count, $booked_count) {
    $available_count = [];
    foreach ($room_count as $type => $count) {
        $available_count[$type] = $count - $booked_count[$type];
    }
    return $available_count;
}

function calculateCosts($troom, $bed, $meal, $days, $nroom) {
    $room_rates = [
        "Superior Room" => 3200,
        "Deluxe Room" => 2200,
        "Guest House" => 1800,
        "Single Room" => 1500
    ];

    $bed_multiplier = [
        "Single" => 1,
        "Double" => 2,
        "Triple" => 3,
        "Quad" => 4
    ];

    $meal_multiplier = [
        "Room only" => 0,
        "Breakfast" => 2,
        "Half Board" => 3,
        "Full Board" => 4
    ];

    $type_of_room = $room_rates[$troom];
    $type_of_bed = $type_of_room * $bed_multiplier[$bed] / 100;
    $type_of_meal = $type_of_bed * $meal_multiplier[$meal];

    $ttot = $type_of_room * $days * $nroom;
    $mepr = $type_of_meal * $days;
    $btot = $type_of_bed * $days;
    $fintot = $ttot + $mepr + $btot;

    return [$ttot, $mepr, $btot, $fintot];
}

function confirmBooking($con, $id, $available_count, $troom, $fname, $lname, $bed, $nroom, $cin, $cout, $meal, $days) {
    if ($available_count[$troom] <= 0) {
        echo "<script type='text/javascript'> alert('Sorry! $troom Not Available')</script>";
        return;
    }

    $updateRoomBookSql = "UPDATE roombook SET stat='Confirm' WHERE id = '$id'";
    if (!mysqli_query($con, $updateRoomBookSql)) {
        return;
    }

    list($ttot, $mepr, $btot, $fintot) = calculateCosts($troom, $bed, $meal, $days, $nroom);

    $insertPaymentSql = "INSERT INTO payment(id, fname, lname, troom, tbed, nroom, cin, cout, ttot, meal, mepr, btot, fintot, noofdays) 
                         VALUES ('$id','$fname','$lname','$troom','$bed','$nroom','$cin','$cout','$ttot','$meal','$mepr','$btot','$fintot','$days')";
    if (!mysqli_query($con, $insertPaymentSql)) {
        return;
    }

    $updateRoomSql = "UPDATE room SET cusid='$id' WHERE bedding='$bed' AND type='$troom' LIMIT 1";
    if (mysqli_query($con, $updateRoomSql)) {
        echo "<script type='text/javascript'> alert('Booking Confirm')</script>";
        echo "<script type='text/javascript'> window.location='home.php'</script>";
    }
}

$row = getRoomBookingDetails($con, $id);
$room_count = getRoomCounts($con);
$booked_count = getBookedCounts($con);
$available_count = getAvailableCounts($room_count, $booked_count);

if (isset($_POST['co'])) {
    confirmBooking($con, $id, $available_count, $row['TRoom'], $row['FName'], $row['LName'], $row['Bed'], $row['NRoom'], $row['cin'], $row['cout'], $row['Meal'], $row['nodays']);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php"> <?php echo $_SESSION["user"]; ?> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li><a href="home.php"><i class="fa fa-dashboard"></i> Room Booking</a></li>
                    <li><a href="messages.php"><i class="fa fa-desktop"></i> Queries</a></li>
                    <li><a href="payment.php"><i class="fa fa-qrcode"></i> Payment</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Room Booking <small><?php echo $curdate; ?></small></h1>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="panel panel-info">
                            <div class="panel-heading">Booking Confirmation</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr><th>DESCRIPTION</th><th>INFORMATION</th></tr>
                                        <tr><th>Name</th><th><?php echo $row['FName'] . ' ' . $row['LName']; ?></th></tr>
                                        <tr><th>Email</th><th><?php echo $row['Email']; ?></th></tr>
                                        <tr><th>Nationality</th><th><?php echo $row['National']; ?></th></tr>
                                        <tr><th>Country</th><th><?php echo $row['Country']; ?></th></tr>
                                        <tr><th>Phone No</th><th><?php echo $row['Phone']; ?></th></tr>
                                        <tr><th>Type Of the Room</th><th><?php echo $row['TRoom']; ?></th></tr>
                                        <tr><th>No Of the Room</th><th><?php echo $row['NRoom']; ?></th></tr>
                                        <tr><th>Meal Plan</th><th><?php echo $row['Meal']; ?></th></tr>
                                        <tr><th>Bedding</th><th><?php echo $row['Bed']; ?></th></tr>
                                        <tr><th>Check-in Date</th><th><?php echo $row['cin']; ?></th></tr>
                                        <tr><th>Check-out Date</th><th><?php echo $row['cout']; ?></th></tr>
                                        <tr><th>No of days</th><th><?php echo $row['nodays']; ?></th></tr>
                                        <tr><th>Status Level</th><th><?php echo $row['stat']; ?></th></tr>
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
                            <div class="panel-heading">Available Room Details</div>
                            <div class="panel-body">
                                <table width="200px">
                                    <?php foreach ($available_count as $room_type => $count): ?>
                                        <tr><td><b><?php echo $room_type; ?></b></td><td><?php echo $count; ?></td></tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('footer.php'); ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>
