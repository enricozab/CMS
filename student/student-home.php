<?php include 'student.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Home</title>

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

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script> 
      function viewCaseAudit(x) {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: ('Student Cases - Viewed Case #' + x)
            },
            success: function(response) {
              console.log('Success');
            }
        });
      }
    </script>

</head>

<body>

    <div id="wrapper">

        <?php include 'student-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="page-header">Notifications</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			      <!-- case notification table -->
			      <div class="row">
                <div class="col-lg-12">
                  <br>
                  <div class="btn-group">
                    <button type="button" class="tableButton btn btn-default" id="all">All Cases</button>
                    <button type="button" class="tableButton btn btn-default" id="open">Open</button>
                    <button type="button" class="tableButton btn btn-default" id="closed">Closed</button>
                  </div>
                  <style>
                      .tableButton {
                        width: 100px;
                      }
                      #all {border-radius: 3px 0px 0px 3px;}
                      #closed {border-radius: 0px 3px 3px 0px;}
                  </style>
                  <br><br>
                  <table width="100%" class="table table-striped table-bordered table-hover" id="case-notif-table">
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
            url: '../ajax/student-notif-cases.php',
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
      var temCurPage = null;
      normalTable();

      function normalTable() {
        $.ajax({
          url: '../ajax/student-get-cases.php',
          type: 'POST',
          data: {
          },
          success: function(response) {
            $('#case-notif-table').html(response);
            var curPage = $('#case-notif-table').DataTable().page();
            var curSearch = $('#case-notif-table').DataTable().search();
            if($('div.dataTables_filter input').is(':focus')) {
              var focus = true;
            }
            $('#case-notif-table').DataTable({
              'destroy': true,
              'aaSorting': []
            });
            $('#case-notif-table').DataTable().page(curPage).draw('page');
            $('#case-notif-table').DataTable().search(curSearch).draw('page');
            if(focus) {
              $('div.dataTables_filter input').focus();
            }
          }
        });

        timeTable = setTimeout(normalTable, 5000);
      }

      $('#all').css("background-color", "#e6e6e6");

      $('#all').on('click', function () {
        $('#all').focus();
        $('#all').css("background-color", "#e6e6e6");
        $('#open').css("background-color", "white");
        $('#closed').css("background-color", "white");

        clearTimeout(timeTable);
        temCurPage = $('#case-notif-table').DataTable().page();
        allTable();

        function allTable() {
          $.ajax({
            url: '../ajax/student-get-cases.php',
            type: 'POST',
            data: {
            },
            success: function(response) {
              $('#case-notif-table').html(response);
              if(temCurPage != null) {
                $('#case-notif-table').DataTable().page(0).draw('page');
                temCurPage = null;
              }
              var curPage = $('#case-notif-table').DataTable().page();
              var curSearch = $('#case-notif-table').DataTable().search();
              if($('div.dataTables_filter input').is(':focus')) {
                var focus = true;
              }
              $('#case-notif-table').DataTable({
                'destroy': true,
                'aaSorting': []
              });
              $('#case-notif-table').DataTable().page(curPage).draw('page');
              $('#case-notif-table').DataTable().search(curSearch).draw('page');
              if(focus) {
                $('div.dataTables_filter input').focus();
              }
            }
          });

          timeTable = setTimeout(allTable, 5000);
        }
      });

      $('#open').on('click', function () {
        $('#open').focus();
        $('#open').css("background-color", "#e6e6e6");
        $('#all').css("background-color", "white");
        $('#closed').css("background-color", "white");

        clearTimeout(timeTable);
        temCurPage = $('#case-notif-table').DataTable().page();
        activeTable();

        function activeTable() {
          $.ajax({
            url: '../ajax/student-get-cases-active.php',
            type: 'POST',
            data: {
            },
            success: function(response) {
              $('#case-notif-table').html(response);
              if(temCurPage != null) {
                $('#case-notif-table').DataTable().page(0).draw('page');
                temCurPage = null;
              }
              var curPage = $('#case-notif-table').DataTable().page();
              var curSearch = $('#case-notif-table').DataTable().search();
              if($('div.dataTables_filter input').is(':focus')) {
                var focus = true;
              }
              $('#case-notif-table').DataTable({
                'destroy': true,
                'aaSorting': []
              });
              $('#case-notif-table').DataTable().page(curPage).draw('page');
              $('#case-notif-table').DataTable().search(curSearch).draw('page');
              if(focus) {
                $('div.dataTables_filter input').focus();
              }
            }
          });

          timeTable = setTimeout(activeTable, 5000);
        }
      });

      $('#closed').on('click', function () {
        $('#closed').focus();
        $('#closed').css("background-color", "#e6e6e6");
        $('#open').css("background-color", "white");
        $('#all').css("background-color", "white");

        clearTimeout(timeTable);
        temCurPage = $('#case-notif-table').DataTable().page();
        closedTable();

        function closedTable() {
          $.ajax({
            url: '../ajax/student-get-cases-closed.php',
            type: 'POST',
            data: {
            },
            success: function(response) {
              $('#case-notif-table').html(response);
              if(temCurPage != null) {
                $('#case-notif-table').DataTable().page(0).draw('page');
                temCurPage = null;
              }
              var curPage = $('#case-notif-table').DataTable().page();
              var curSearch = $('#case-notif-table').DataTable().search();
              if($('div.dataTables_filter input').is(':focus')) {
                var focus = true;
              }
              $('#case-notif-table').DataTable({
                'destroy': true,
                'aaSorting': []
              });
              $('#case-notif-table').DataTable().page(curPage).draw('page');
              $('#case-notif-table').DataTable().search(curSearch).draw('page');
              if(focus) {
                $('div.dataTables_filter input').focus();
              }
            }
          });

          timeTable = setTimeout(closedTable, 5000);
        }
      });

      // sidebar system audit trail
     $('#sidebar_cases').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'Student Cases - Viewed Cases'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });
      $('#sidebar_inbox').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'Student Cases - Viewed Inbox'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });
      $('#sidebar_calendar').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'Student Cases - Viewed Calendar'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });

    });
    </script>

</body>

</html>
