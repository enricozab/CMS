<?php include 'aulc.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <link href="../gdrive/gdrive.css" rel="stylesheet" type="text/css">

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

    <!-- GDRIVE -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/lightbox.min.js" type="text/javascript"></script>
    <script src="../gdrive/ido-gdrive4.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
    </script>

</head>

<body>

    <div id="wrapper">

    <?php include 'aulc-sidebar.php'; ?>

        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-8">
                  <h3 class="page-header">Google Drive</h3>
              </div>
          </div>

          <div id="login-box">

            <p> You need to authorize this integration in order to use it. Please sign in to your Google Account to do so.</p><br>
            <button type="submit" id="drive" name="evidence" class="btn btn-primary" onclick="handleAuthClick()">Log In</button>

          </div>

          <div id="drive-box">
          	<div id="drive-breadcrumb">
                  <span class='breadcrumb-arrow'></span> <a data-level='0'>CMS</a>
                  <span id="span-navigation"></span>
            </div>

            <div id="drive-info" class="hide">
              <div class="user-item">Welcome <span id="span-name"></span></div>
          		<div class="user-item">Used Storage: <span id="span-usedQuota"></span></div>
              <div class="user-item">Total Storage: <span id="span-totalQuota"></span></div>
              <div class="user-item"><a id="link-logout" class="logout-link" onclick="handleSignoutClick()">Logout</a></div>
            </div>

          	<div id="drive-menu">
          		<!-- <div id="button-reload" title="View"></div> -->
              <div id="button-reload" title="Refresh"></div>
          		<div id="button-upload" title="Upload to Google Drive" class="button-opt"></div>
          		<div id="button-addfolder" title="Add Folder" class="button-opt"></div>
            </div>

          	<div id="drive-content"></div>
          	<div id="error-message" class="flash hidden"></div>
          	<div id="status-message" class="flash hidden"></div>
          </div>

          <input type="file" id="fUpload" class="hide"/>
          <div class="float-box" id="deleteForm" class ="hide">
              <div class="folder-form">
                  <h3 class="clear">Are you sure you want to delete this?</h3>
          				<button id="btnDelete" value="Delete" class="button">Yes</button>
          				<button id="btnCancelDelete" value="Cancel" class="button btnClose">Cancel</button>
              </div>
          </div>

          <input type="file" id="fUpload" class="hide"/>
          <div class="float-box" id="float-box">
              <div class="folder-form">
                  <div class="close-x"><img id="imgClose" class="imgClose" src="../gdrive/images/button_close.png" alt="close" /></div>
                  <h4>Add New Folder</h4><hr>
                  <div><input type="text" style="width: 350px" id="txtFolder" /></div><br>
          				<button id="btnAddFolder" value="Save"  class="btn btn-primary">Add</button>
              </div>
          </div>

          <div class="float-box" id="upload-box" >
              <div class="folder-form">
                  <h3 class="clear">Upload File</h3>
                  File: <input type = "text" id = "fileName" class ="fileName" readonly>
          				<br><br><button id="btnSubmit" value="Save" class="button btnChoose">Choose File</button>
                  <button id="btnClose" value="Close" class="button btnClose">Close</button>
          				<!-- <button id="btnCancel" value="Close" class="button btnChooseCancel">Cancel</button> -->
                  <div id='upload-percentage' class='flash'></div>
              </div>
          </div>

          <div class="float-box" id="view-box">
              <div class="folder-form">
                <div class="close-x"><img id="imgShowClose" class="imgClose" src="../gdrive/images/button_close.png" alt="close" /></div>
                Name: <input type = "text" id = "imageName" class ="fileName" readonly>
                <div><img class = "viewingTheImage" id="viewingTheImage"></div>
              </div>
          </div>

          <div id="float-box-info" class="float-box">
              <div class="info-form">
                  <div class="close-x"><img id="imgCloseInfo" class="imgClose" src="../gdrive/images/button_close.png" alt="close" /></div>
                  <h3 class="clear">File information</h3>
                  <table cellpadding="0" cellspacing="0" class="tbl-info">
          						<tr>
          								<td class="label">Type</td>
          								<td><span id="spanExtension"></span></td>
          						</tr>
          						<tr>
                          <td class="label">Size</td>
                          <td><span id="spanSize"></span></td>
                      </tr>
                      <tr>
                          <td class="label">Created Date</td>
                          <td><span id="spanCreatedDate"></span></td>
                      </tr>
                      <tr>
                          <td class="label">Modified Date</td>
                          <td><span id="spanModifiedDate"></span></td>
                      </tr>
                      <tr>
                          <td class="label">Owner</td>
                          <td><span id="spanOwner"></span></td>
                      </tr>
                  </table>
              </div>
          </div>

          <div id="float-box-text" class="float-box">
              <div class="info-form">
                  <div class="close-x"><img id="imgCloseText" class="imgClose" src="../gdrive/images/button_close.png" alt="close" /></div>
                  <h3 class="clear">Text Content</h3>
                  <div id="text-content"></div>
          				<button id="btnCloseText" value="Close" class="button btnClose">Close</button>
              </div>
          </div>

        </div>
      </div>

      <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

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
          url: '../ajax/aulc-notif-cases.php',
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

    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'AULC Files - Viewed Cases'
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
                actiondone: 'AULC Files - Viewed Files'
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
                actiondone: 'AULC Files - Viewed Calendar'
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
                actiondone: 'AULC Files - Viewed Inbox'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });

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
  });
  </script>

</body>

</html>

<style>
#snackbar {
  visibility: hidden;
  min-width: 300px;
  background-color: #337ab7;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 15px;
  position: fixed;
  z-index: 10;
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