<?php
// Include database connection
include('db.php');

// Session Management Class
class SessionManager {
    public static function startSession() {
        session_start();
    }

    public static function checkUserSession() {
        if (!isset($_SESSION['user'])) {
            die("User session not set. Please log in.");
        }
    }

    public static function getUserDetails() {
        return [
            'firstname' => $_SESSION['user']['firstname'] ?? 'N/A',
            'lastname' => $_SESSION['user']['lastname'] ?? 'N/A',
            'email' => $_SESSION['user']['email'] ?? 'N/A',
            'contact' => $_SESSION['user']['contact'] ?? 'N/A',
        ];
    }
}

// Human Verification Class
class HumanVerification {
    public static function generateCode() {
        return rand();
    }

    public static function validate($inputCode, $sessionCode) {
        if (empty($inputCode)) {
            throw new Exception('Human verification is required.');
        }

        if ($inputCode !== $sessionCode) {
            throw new Exception('Human verification code does not match. Please try again.');
        }
    }
}

// Date Validation Class
class DateValidator {
    public static function validateCheckInOutDates($checkIn, $checkOut) {
        $checkInDate = strtotime($checkIn);
        $checkOutDate = strtotime($checkOut);
        $currentDate = strtotime(date('Y-m-d'));

        if ($checkInDate < $currentDate || $checkOutDate < $currentDate || $checkOutDate <= $checkInDate) {
            throw new Exception('Invalid check-in or check-out dates.');
        }

        return [$checkInDate, $checkOutDate];
    }
}

// Room Availability Class
class RoomAvailability {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function checkRoomAvailability($roomType, $bedType, $checkIn, $checkOut) {
        $query = "SELECT * FROM roombook WHERE TRoom = '$roomType' AND Bed = '$bedType' 
                  AND NRoom > 0 AND ((STR_TO_DATE('$checkIn', '%Y-%m-%d') BETWEEN cin AND cout) 
                  OR (STR_TO_DATE('$checkOut', '%Y-%m-%d') BETWEEN cin AND cout))";

        $result = mysqli_query($this->con, $query);
        $data = mysqli_fetch_array($result, MYSQLI_NUM);

        if ($data !== null && $data[0] > 0) {
            throw new Exception('Selected room with the same bed type is not available for the specified dates.');
        }
    }
}

// Room Booking Class
class RoomBooking {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function bookRoom($userDetails, $roomDetails, $checkIn, $checkOut) {
        $days = floor((strtotime($checkOut) - strtotime($checkIn)) / (60 * 60 * 24));
        $status = "Not Confirm";

        $query = "INSERT INTO roombook (FName, LName, Email, Phone, TRoom, Bed, NRoom, Meal, cin, cout, stat, nodays) 
                  VALUES ('{$userDetails['firstname']}', '{$userDetails['lastname']}', '{$userDetails['email']}', 
                          '{$userDetails['contact']}', '{$roomDetails['troom']}', '{$roomDetails['bed']}', 
                          '{$roomDetails['nroom']}', '{$roomDetails['meal']}', '$checkIn', '$checkOut', '$status', '$days')";

        if (!mysqli_query($this->con, $query)) {
            throw new Exception('Error adding user to the database.');
        }
    }
}

// Main Logic
SessionManager::startSession();
SessionManager::checkUserSession();
$userDetails = SessionManager::getUserDetails();

$con = mysqli_connect("localhost", "root", "", "hotel");

if (isset($_POST['submit'])) {
    try {
        // Human verification
        HumanVerification::validate($_POST['code1'], $_POST['code']);
        
        // Date validation
        list($checkInDate, $checkOutDate) = DateValidator::validateCheckInOutDates($_POST['cin'], $_POST['cout']);

        // Room availability check
        $roomAvailability = new RoomAvailability($con);
        $roomAvailability->checkRoomAvailability($_POST['troom'], $_POST['bed'], $_POST['cin'], $_POST['cout']);

        // Room booking
        $roomDetails = [
            'troom' => $_POST['troom'],
            'bed' => $_POST['bed'],
            'nroom' => $_POST['nroom'],
            'meal' => $_POST['meal']
        ];

        $roomBooking = new RoomBooking($con);
        $roomBooking->bookRoom($userDetails, $roomDetails, $_POST['cin'], $_POST['cout']);

        echo "<script>alert('Your Booking application has been sent');</script>";
        header("Location: transaction.php");
        exit();
    } catch (Exception $e) {
        echo "<script>alert('{$e->getMessage()}');</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RESERVATION OCEAN PALACE</title>
    <!-- Styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-side">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="../index.php"><i class="fa fa-home"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">RESERVATION</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10 col-sm-10">
                        <div class="panel panel-primary">
                            <div class="panel-heading">RESERVATION INFORMATION</div>
                            <div class="panel-body">
                                <form method="post" action="reservation.php">
                                    <!-- Personal Info -->
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input name="fname" class="form-control" value="<?php echo htmlspecialchars($userDetails['firstname']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input name="lname" class="form-control" value="<?php echo htmlspecialchars($userDetails['lastname']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input name="phone" type="text" class="form-control" value="<?php echo htmlspecialchars($userDetails['contact']); ?>" required>
                                    </div>

                                    <!-- Reservation Info -->
                                    <div class="form-group">
                                        <label>Type Of Rooms</label>
                                        <select name="troom" class="form-control" required>
                                            <option value=""></option>
                                            <option value="Single Room">SINGLE ROOM</option>
                                            <option value="Superior Room">SUPERIOR ROOM</option>
                                            <option value="Deluxe Room">DELUXE ROOM</option>
                                            <option value="Guest House">GUEST HOUSE</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Bedding Type</label>
                                        <select name="bed" class="form-control" required>
                                            <option value=""></option>
                                            <option value="Single">Single</option>
                                            <option value="Double">Double</option>
                                            <option value="Triple">Triple</option>
                                            <option value="Quad">Quad</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No. of Rooms</label>
                                        <select name="nroom" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Meal Plan</label>
                                        <select name="meal" class="form-control" required>
                                            <option value=""></option>
                                            <option value="Room only">Room only</option>
                                            <option value="Breakfast">Breakfast</option>
                                            <option value="Half Board">Half Board</option>
                                            <option value="Full Board">Full Board</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Check-In</label>
                                        <input name="cin" type="date" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Check-Out</label>
                                        <input name="cout" type="date" class="form-control" required>
                                    </div>

                                    <!-- Human Verification -->
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">HUMAN VERIFICATION</div>
                                        <div class="panel-body">
                                            <p>Type Below this code: <strong><?php $Random_code = HumanVerification::generateCode(); echo $Random_code; ?></strong></p>
                                            <p>Enter the random code</p>
                                            <input type="text" name="code1" class="form-control" required />
                                            <input type="hidden" name="code" value="<?php echo $Random_code; ?>" />
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- jQuery Js -->
                <script src="assets/js/jquery-1.10.2.js"></script>
                <!-- Bootstrap Js -->
                <script src="assets/js/bootstrap.min.js"></script>
                <!-- Custom Js -->
                <script src="assets/js/custom-scripts.js"></script>
            </div>
        </div>
    </div>
</body>
</html>
