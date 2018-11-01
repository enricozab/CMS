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

        <?php include 'student-sidebar.php';?>

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
          					<b>Complainant:</b> --- <br>
          					<b>Apprehended by:</b> --- <br>
                </div>

                <div class="col-lg-6">
                    <h4><b>List of Forms to Fill Out</b></h4>
                    <ul>
                      <li>Investigation Report</li>
                      <li>Readmission to Class Slip (If Applicable)</li>
                      <li>Academic Service Edorsement Form</li>
                      <li>Referral Form (for OCCS, FORMS, etc.)</li>
                    </ul>
                </div>
            </div>
			<br><br><br>
			<div class="panel panel-default">
				<div class="panel-heading">
					<b>Details</b>
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>
