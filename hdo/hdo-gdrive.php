<?php include 'hdo.php' ?>
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
    <script src="../gdrive/ido-gdrive.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js"
          onload="this.onload=function(){};handleClientLoad()"
          onreadystatechange="if (thigoogle-s.readyState === 'complete') this.onload()">
    </script>
    <script src="../gdrive/upload.js"></script>

</head>

<body>

  <?php
    include 'hdo-notif-queries.php';
  ?>

    <div id="wrapper">

    <?php include 'hdo-sidebar.php'; ?>

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
      $('#case-notif-table').DataTable({
          "order": [[ 4, "desc" ]]
      });

      <?php include 'hdo-notif-scripts.php'?>

      <?php
      $query2='SELECT 		C.CASE_ID AS CASE_ID,
                          C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                          C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                          CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                          C.OFFENSE_ID AS OFFENSE_ID,
                          RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                          C.CHEATING_TYPE_ID AS CHEATING_TYPE_ID,
                          RO.TYPE AS TYPE,
                          C.COMPLAINANT_ID AS COMPLAINANT_ID,
                          CONCAT(U1.FIRST_NAME," ",U1.LAST_NAME) AS COMPLAINANT,
                          C.DETAILS AS DETAILS,
                          C.ADMISSION_TYPE_ID AS ADMISSION_TYPE_ID,
                          C.HANDLED_BY_ID AS HANDLED_BY_ID,
                          CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS HANDLED_BY,
                          C.DATE_FILED AS DATE_FILED,
                          C.STATUS_ID AS STATUS_ID,
                          S.DESCRIPTION AS STATUS_DESCRIPTION,
                          C.REMARKS_ID AS REMARKS_ID,
                          R.DESCRIPTION AS REMARKS_DESCRIPTION,
                          C.LAST_UPDATE AS LAST_UPDATE,
                          C.VERDICT AS VERDICT,
                          C.HEARING_DATE AS HEARING_DATE,
                          C.DATE_CLOSED AS DATE_CLOSED,
                          C.IF_NEW AS IF_NEW
              FROM 		    CASES C
              LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
              LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
              LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
              LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
              LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
              LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
              LEFT JOIN   REF_REMARKS R ON C.REMARKS_ID = R.REMARKS_ID
              ORDER BY	  C.LAST_UPDATE';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
          if($row2['IF_NEW']){ ?>
            $('<?php echo "#".$row2['CASE_ID'] ?>').text('NEW');
          <?php }
          else{ ?>
            $('<?php echo "#".$row2['CASE_ID'] ?>').text('');
          <?php }
        }
      } ?>
  });
  </script>

</body>

</html>
