<?php include 'ulc.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Inobx</title>

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

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    
    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
    </script>

    <style>
      iframe {
        width: 100%;
        border: 0;
        min-height: 80%;
        height: 600px;
        display: flex;
      }
    </style>

</head>

<body>

    <div id="wrapper">

        <?php include 'ulc-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-8">
                  <h3 class="page-header">Inbox</h3>
              </div>
              <!-- /.col-lg-12 -->
          </div>

          <div class="row">
            <div class="col-lg-12">
              <?php include  '../gmail/inbox.php' ?>
            </div>
          </div>

          <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
  //all functinos have to be inside this functions
  //function that runs once the page is loaded

  $(document).ready(function() {
    loadNotif();

    function loadNotif () {
        $.ajax({
          url: '../ajax/ulc-notif-cases.php',
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
    
    $("#login").hide();
    $("#create").hide();

    var count = 0;
    var prevCount = 0;
    loadCount();

    function loadCount() {
      $.ajax({
        url: '../ajax/user-notifications-count.php',
        type: 'POST',
        data: {
        },
        success: function(response) {
          count = response;
          if(count > 0) {
            $('#notif-badge').text(count);
          }
          else {
            $('#notif-badge').text('');
          }
          if (prevCount != count) {
            loadReminders();
            prevCount = count;
          }
        }
      });

      setTimeout(loadCount, 5000);
    };

    var notifTable;

    function loadReminders() {
      if (count > 0) {
        var notif = " new notification";
        if (count > 1) notif = " new notifications";
        $('#alert-message').text('You have '+count+notif);
        setTimeout(function() { showSnackbar(); }, 1500);
      }
    }

    notifData();

    function notifData() {
      $.ajax({
        url: '../ajax/user-notifications.php',
        type: 'POST',
        data: {
        },
        success: function(response) {
          $('#notifTable').html(response);
        }
      });

      notifTable = setTimeout(notifData, 5000);
    }
    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'ULC Inbox - Viewed Cases'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });
      $('#sidebar_files').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'ULC Inbox - Viewed Files'
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
                actiondone: 'ULC Inbox - Viewed Calendar'
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
                actiondone: 'ULC Inbox - Viewed Inbox'
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

<style>
.badge-notify{
   background: red;
   position: relative;
   top: -8px;
   left: -3px;
   margin: -10px;
}

#snackbar {
  visibility: hidden;
  min-width: 300px;
  background-color: #337ab7;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 15px;
  position: fixed;
  z-index: 1;
  right: 40px;
  bottom: 40px;
  font-size: 18px;
  border-radius: 5px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 40px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 40px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 40px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 40px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>