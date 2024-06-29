<?php  
session_start();  
if(!isset($_SESSION["user"]))
{
 header("location:index.php");
}
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OCEAN PALACE</title>
	
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
   
    <link href="assets/css/custom-styles.css" rel="stylesheet" />

   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="home.php"><?php echo $_SESSION["user"]; ?> </a>
            </div>
          <!--/. NAV TOP RIGHT -->
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
               
        </nav>

        <!--/. NAV TOP LEFT -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i> Room Booking</a>
                    </li>
                    <li>
                        <a  href="messages.php"><i class="fa fa-desktop"></i> Queries</a>
                    </li>
                    <li>
                        <a class="active-menu" href="payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                   
                    <li>
                        <a href="logout.php" ><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>            
            </div>
        </nav>
        
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                           Payment Details<small> </small>
                        </h1>
                    </div>
                </div> 

                 <!-- /. ROW  -->
				 
            <div class="row">
                <div class="col-md-12">
                    <!-- Bootstrap Tables https://datatables.net/examples/styling/bootstrap5.html -->

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
											<th>Room type</th>
                                            <th>Bed Type</th>
                                            <th>Check in</th>
											<th>Check out</th>
											<th>No of Room</th>
											<th>Meal Type</th>
                                            <th>Room Rent</th>
											<th>Bed Rent</th>
											<th>Meals </th>
											<th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
									<?php
										include ('db.php');
										$sql="select * from payment";
										$re = mysqli_query($con,$sql);
										while($row = mysqli_fetch_array($re))
										{
										
											$id = $row['id'];
											
											if($id % 2 ==1 )
											{
												echo"<tr class='gradeC'>
													<td>".$row['fname']." ".$row['lname']."</td>
													<td>".$row['troom']."</td>
													<td>".$row['tbed']."</td>
													<td>".$row['cin']."</td>
													<td>".$row['cout']."</td>
													<td>".$row['nroom']."</td>
													<td>".$row['meal']."</td>
													<td>".$row['ttot']."</td>
													<td>".$row['mepr']."</td>
													<td>".$row['btot']."</td>
													<td>".$row['fintot']."</td>
													</tr>";
											}
											else
											{
												echo"<tr class='gradeU'>
													<td>".$row['fname']." ".$row['lname']."</td>
													<td>".$row['troom']."</td>
													<td>".$row['tbed']."</td>
													<td>".$row['cin']."</td>
													<td>".$row['cout']."</td>
													<td>".$row['nroom']."</td>
													<td>".$row['meal']."</td>
													<td>".$row['ttot']."</td>
													<td>".$row['mepr']."</td>
													<td>".$row['btot']."</td>
													<td>".$row['fintot']."</td>
													</tr>";
											}
										
										}
										
									?>
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
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
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    
    <!-- It ensures that the JavaScript code inside will only run when the HTML document is ready.-->
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>
