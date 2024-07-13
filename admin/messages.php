<?php  
session_start();  
if (!isset($_SESSION["user"])) {
    header("location:index.php");
}

include('db.php');
include('Handlers.php');

$queryHandler = new QueryHandler($con);
$replyHandler = new ReplyHandler($con);

// Handle form submission
if (isset($_POST['log'])) {
    $replyHandler->sendReply($_POST['email'], $_POST['subject'], $_POST['news']);
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
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <!-- Navigation and other content -->

        <!--/. NAV TOP LEFT -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="home.php"><i class="fa fa-dashboard"></i> Room Booking</a>
                    </li>
                    <li>
                        <a href="messages.php"><i class="fa fa-desktop"></i> Queries</a>
                    </li>
                    <li>
                        <a class="active-menu" href="payment.php"><i class="fa fa-qrcode"></i> Payment</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Queries <small>panel</small></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="jumbotron">
                            <h3>Send The Queries to Users</h3>
                            <div class="panel-body">
                                <button class="btn btn-primary btn" data-toggle="modal" data-target="#myModal">
                                    Send Reply
                                </button>
                                <!-- Modal for sending reply -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Compose Reply</h4>
                                            </div>
                                            <form method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input name="email" class="form-control" placeholder="Enter Email">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <input name="subject" class="form-control" placeholder="Enter Subject">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment">Message</label>
                                                        <textarea name="news" class="form-control" rows="5" id="comment"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <input type="submit" name="log" value="Send" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Email</th>
                                                    <th>Message</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Approval</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $queryHandler->displayQueries(); ?>
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

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <script src="assets/js/custom-scripts.js"></script>
</body>
</html>