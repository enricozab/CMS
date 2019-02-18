<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Active Cases</title>

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

  <?php include 'hdo-notif-queries.php' ?>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
			<br><br>
            <div class="panel panel-default">
				<div class="panel-heading">
					<b>Active Cases</b>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="active-cases-table">
						<thead>
							<tr>
								<th>Case No.</th>
								<th>Offense</th>
								<th>Type</th>
								<th>Date Filed</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr class="odd" onmouseover="this.style.cursor='pointer'" onclick="location.href='do-view-case.php?cn=00000002&off=Left ID&type=Minor&date=10/13/2018&stat=Pending';">
								<td>00000002</td>
								<td>Left ID</td>
								<td>Minor</td>
								<td>10/13/2018</td>
								<td>Pending</td>
							</tr>
							<tr class="even" onmouseover="this.style.cursor='pointer'" onclick="location.href='do-view-case.php?cn=00000003&off=Cheating&type=Major&date=10/13/2018&stat=For Review';">
								<td>00000003</td>
								<td>Cheating</td>
								<td>Major</td>
								<td>10/13/2018</td>
								<td>For Review</td>
							</tr>
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
        </div>
        <!-- /#page-wrapper -->

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
        $('#active-cases-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
        <?php include 'hdo-notif-scripts.php' ?>
    });
    </script>

</body>

</html>
