<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - View Case</title>

	<!-- Webpage Icon -->
	<link rel="icon" href="../images/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

	<!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Case Management System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="apprehension.php"><i class="fa fa-plus fa-fw"></i> New Case</a>
                        </li>
						<li>
                            <a href="#"><i class="fa fa-bullseye fa-fw"></i> Case Tracker<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="activecases.php">Active</a>
                                </li>
                                <li>
                                    <a href="closedcases.php">Closed</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Files<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">File 1</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="#"><i class="fa fa-clipboard fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Report 1</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="calendar.php"><i class="fa fa-calendar fa-fw"></i> Calendar</a>
                        </li>
						<li>
                            <a href="usermanagement.php"><i class="fa fa-users fa-fw"></i> User Management</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<?php
			$cn=$_GET['cn'];
			$off=$_GET['off'];
			$type=$_GET['type'];
			$date=$_GET['date'];
			$stat=$_GET['stat'];
		?>
        <div id="page-wrapper">
            <div class="row">
               <h3 class="page-header"><b>Alleged Case No. <?php echo $cn; ?></b></h3>
                <div class="col-lg-6">

          					<b>Offense:</b> <?php echo $off; ?><br>
          					<b>Type:</b> <?php echo $type; ?><br>
          					<b>Date Filed:</b> <?php echo $date; ?><br>
          					<b>Status:</b> <?php echo $stat; ?><br><br>
          					<b>Student ID No.:</b> 11530022<br>
          					<b>Student Name:</b> Enrico Miguel. M. Zabayle<br><br>
          					<b>Reported by:</b> --- <br>
          					<b>Apprehended by:</b> --- <br>

                </div>

                <div class="col-lg-6">

                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">Updates</b>
                      </div>
                      <!-- .panel-heading -->
                      <div class="panel-body">
                          <div class="panel-group" id="accordion">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style = "font-size: 15px;">Lifecycle</a>
                                      </h4>
                                  </div>
                                  <div id="collapseOne" class="panel-collapse collapse in">
                                      <div class="panel-body">
                                          <div class = "col-xs-5">
                                            Reviewing Forms<br>
                                            Submitting Forms<br>
                                            Passed Alleged Case
                                          </div>
                                          <div class = "col-xs-5">
                                            Carlos Garcia<br>
                                            Enrico Miguel. M. Zabayle<br>
                                            Debbie Simon
                                          </div>
                                          <div class = "col-xs-2">
                                            <i>10/14/18</i><br>
                                            <i>10/13/18</i><br>
                                            <i>10/10/18</i>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style = "font-size: 15px;">Submitted Forms</a>
                                      </h4>
                                  </div>
                                  <div id="collapseTwo" class="panel-collapse collapse">
                                      <div class="panel-body">
                                          Form 1<br>
                                          Form 2<br>
                                          Form 3<br>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- .panel-body -->
                  </div>

                </div>
          </div>

			<br><br><br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<b>Details</b> &nbsp;<a href="#"><i class="fa fa-edit fa-fw"></i></a>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<p>Caught cheating by the professor during finals</p>
				</div>
        </div>
        <!-- /#page-wrapper -->

        <br>

        <h4><b>Evidences</b></h4><br>
        <b style = "padding-right: 5px;">Photo: </b><button type="button" class="btn btn-outline btn-info btn-xs">Add</button>
        <b style = "padding-left: 100px; padding-right: 5px;">Text: </b> <button type="button" class="btn btn-outline btn-info btn-xs">Google Docs</button><br>
        <!--<br>
        <button type="button" class="btn btn-info btn-default">Upload Evidences</button>-->

        <br><br><br>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
