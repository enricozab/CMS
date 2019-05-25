<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Incident Reports</title>

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

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="page-header">Incident Reports</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
      			<!-- case notification table -->
      			<div class="row">
                <div class="col-lg-12">
                  <table width="100%" class="table table-striped table-bordered table-hover" id="incident-reports-table">
                  </table>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <br><br><br><br><br>
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
        loadNotif();

        function loadNotif () {
            $.ajax({
              url: '../ajax/hdo-notif-incident-reports.php',
              type: 'POST',
              data: {
              },
              success: function(response) {
                if(response > 0) {
                  $('#ir').text(response);
                }
                else {
                  $('#ir').text('');
                }
              }
            });

            $.ajax({
              url: '../ajax/hdo-notif-cases.php',
              type: 'POST',
              data: {
              },
              success: function(response) {
                if(response > 0) {
                  $('#cn').text(response);
                }
                else {
                  $('#cn').text('');
                }
              }
            });

            setTimeout(loadNotif, 5000);
        };

        var timeTable;
        normalTable();

        function normalTable() {
          $.ajax({
            url: '../ajax/hdo-get-incident-reports.php',
            type: 'POST',
            data: {
            },
            success: function(response) {
              $('#incident-reports-table').html(response);
              var curPage = $('#incident-reports-table').DataTable().page();
              var curSearch = $('#incident-reports-table').DataTable().search();
              if($('div.dataTables_filter input').is(':focus')) {
                var focus = true;
              }
              $('#incident-reports-table').DataTable({
                'destroy': true,
                'aaSorting': []
              });
              $('#incident-reports-table').DataTable().page(curPage).draw('page');
              $('#incident-reports-table').DataTable().search(curSearch).draw('page');
              if(focus) {
                $('div.dataTables_filter input').focus();
              }
            }
          });

          timeTable = setTimeout(normalTable, 5000);
        }
    });
    </script>

</body>

</html>
