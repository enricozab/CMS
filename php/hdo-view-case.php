<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Case</title>

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

  <?php
    require_once('./mysql_connect.php');

    include 'hdo-notif-queries.php'
  ?>

    <div id="wrapper">

    <?php include 'hdo-sidebar.php';?>
        <div id="page-wrapper">
            <div class="row">
               <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
                <div class="col-lg-6">

          					<b>Offense:</b> <?php echo $off; ?><br>
          					<b>Type:</b> <?php echo $type; ?><br>
          					<b>Date Filed:</b> <?php echo $date; ?><br>
          					<b>Status:</b> <?php echo $stat; ?><br><br>
          					<b>Student ID No.:</b> 11530022<br>
          					<b>Student Name:</b> Enrico Miguel. M. Zabayle<br><br>
          					<b>Complainant:</b> --- <br>
          					<b>Apprehended by:</b> --- <br>
                    <b>Investigating Officer:</b> Debbie Simon <br>

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
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style = "font-size: 15px;">History</a>
                                      </h4>
                                  </div>
                                  <div id="collapseOne" class="panel-collapse collapse in">
                                      <div class="panel-body">
                    										<div class="table-responsive">
                    											<table class="table">
                    												<tbody>
                    													<tr>
                    														<td>Reviewing Forms</td>
                    														<td>Carlos Garcia</td>
                    														<td><i>10/14/18</i></td>
                    													</tr>
                    													<tr>
                    														<td>Submitting Forms</td>
                    														<td>Enrico Miguel M. Zabayle</td>
                    														<td><i>10/13/18</i></td>
                    													</tr>
                    													<tr>
                    														<td>Passed Alleged Case</td>
                    														<td>Debbie Simon</td>
                    														<td><i>10/10/18</i></td>
                    													</tr>
                    												</tbody>
                    											</table>
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
                                        <div class="table-responsive">
                                          <table class="table">
                                            <tbody>
                                              <tr>
                                                <td>Form 1</td>
                                                <td><i>10/14/18</i></td>
                                              </tr>
                                              <tr>
                                                <td>Form 2</td>
                                                <td><i>10/10/18</i></td>
                                              </tr>
                                              <tr>
                                                <td>Form 3</td>
                                                <td><i>10/10/18</i></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- .panel-body -->
                  </div>
                </div>
              </div>
            </div>
          </div>
			<br><br>
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

      <h4><b>Evidence</b></h4><br>
		  <div class="row">
			   <div class="col-lg-3">
				    <b>Document/Photo:</b><input type="file">
			   </div>
			   <div class="col-lg-3">
				    <b>Write Up:</b> &nbsp;<button type="button" class="btn btn-outline btn-info btn-xs">Google Docs</button><br>
			   </div>
			   <!--<br>
			   <button type="button" class="btn btn-info btn-default">Upload Evidences</button>-->
			   <br><br><br><br>
		  </div>
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
    <?php include 'hdo-notif-scripts.php' ?>
  });
  </script>

</body>

</html>
