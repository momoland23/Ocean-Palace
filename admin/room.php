<?php
include('db.php');
session_start();
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OCEAN PALACE</title>
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
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">MAIN MENU </a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
			
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="usersetting.php"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
				
                </li>
               
            </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a  href="settings.php"><i class="fa fa-dashboard"></i>Rooms Status</a>
                    </li>
					<li>
                        <a  class="active-menu" href="room.php"><i class="fa fa-plus-circle"></i>Add Room</a>
                    </li>
                    <li>
                        <a  href="roomdel.php"><i class="fa fa-desktop"></i> Delete Room</a>
                    </li>
					

                    
            </div>

        </nav>
        <!-- /. NAV SIDE  -->
       
        
       
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           NEW ROOM <small></small>
                        </h1>
                    </div>
                </div> 
                 
                                 
            <div class="row">
                
                <div class="col-md-5 col-sm-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            ADD NEW ROOM
                        </div>
                        <div class="panel-body">
						<form name="form" method="post">
                            <div class="form-group">
                                <label>Type Of Room</label>
                                <select name="troom" class="form-control" required>
                                    <option value selected></option>
                                    <option value="Superior Room">SUPERIOR ROOM</option>
                                    <option value="Deluxe Room">DELUXE ROOM</option>
                                    <option value="Guest House">GUEST HOUSE</option>
                                    <option value="Single Room">SINGLE ROOM</option>
                                   
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Bedding Type</label>
                                <select name="bed" class="form-control" required>
                                    <option value selected></option>
                                    <option value="Single">Single</option>
                                    <option value="Double">Double</option>
                                    <option value="Triple">Triple</option>
                                    <option value="Quad">Quad</option>
                                </select>
                            </div>

                            <input type="submit" name="add" value="Add New" class="btn btn-primary">
                        </form>

                        <?php
                        if (isset($_POST['add'])) {
                            $room = $_POST['troom'];
                            $bed = $_POST['bed'];
                            $place = 'Free';

                            $sql = "INSERT INTO `room`( `type`, `bedding`) VALUES ('$room','$bed')";
                            if (mysqli_query($con, $sql)) {
                                echo '<script>alert("New Room Added") </script>';
                            } else {
                                echo '<script>alert("Sorry ! Check The System") </script>';
                            }
                        }
                        ?>
                        </div>
                        
                    </div>
                </div>
                
                  
                <div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                ROOMS INFORMATION
            </div>
            <div class="panel-body">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <?php
                    $limit = 15; // Number of records to display per page
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                    $sql = "SELECT * FROM room LIMIT $start, $limit";
                    $re = mysqli_query($con, $sql);
                    ?>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Room ID</th>
                                        <th>Room Type</th>
                                        <th>Bedding</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    while ($row = mysqli_fetch_array($re)) {
                                        $id = $row['id'];
                                        if ($id % 2 == 0) {
                                            echo "<tr class=odd gradeX>
                                                <td>" . $row['id'] . "</td>
                                                <td>" . $row['type'] . "</td>
                                                <th>" . $row['bedding'] . "</th>
                                            </tr>";
                                        } else {
                                            echo "<tr class=even gradeC>
                                                <td>" . $row['id'] . "</td>
                                                <td>" . $row['type'] . "</td>
                                                <th>" . $row['bedding'] . "</th>
                                            </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        $sql = "SELECT COUNT(id) AS total FROM room";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_pages = ceil($row['total'] / $limit);
                        ?>

                        <div class="text-center">
                            <?php if ($page > 1) : ?>
                                <a href="?page=<?php echo $page - 1; ?>" class="btn btn-primary">Previous</a>
                            <?php endif; ?>
                            <?php if ($page < $total_pages) : ?>
                                <a href="?page=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a>
                            <?php endif; ?>
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
