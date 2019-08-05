<?php include 'cdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CMS - Reports</title>

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

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
    </script>

    <style>
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #3498db;
      width: 80px;
      height: 80px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
      position: relative;
      top: 50%;
      left: 43%;
    }

    /* Safari */
    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    </style>

</head>

<body>

    <div id="wrapper">

        <?php include 'cdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Generate Summary Report For Cases</h3>

                <div class="col-lg-12">
				        <!--------------------------->
                <!--<form id="form">-->
                  <div id="academicyear_div">
                    <div class="form-group" style = "width: 300px;">
                      <label>Academic Year: <span style="font-weight:normal; font-style:italic; font-size:12px;"></span> <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="academicyear" name="academicyear" class="academicyear form-control">
          							<!--<option value="2014-2015"> 2014-2015 </option>
          							<option value="2015-2016"> 2015-2016 </option>
          							<option value="2016-2017"> 2016-2017 </option>
          							<option value="2017-2018"> 2017-2018 </option>
          							<option value="2018-2019"> 2018-2019 </option>-->
          							<?php
          								require_once('../mysql_connect.php');
          								$sqlQuery = "SELECT DISTINCT(SRF.SCHOOL_YEAR)
          												FROM CMS.STUDENT_RESPONSE_FORMS SRF
          												ORDER BY SRF.SCHOOL_YEAR DESC";
          								$sqlRes = mysqli_query($dbc, $sqlQuery);
          								while ($row = $sqlRes->fetch_assoc()){
          									echo '<option value="' .$row['SCHOOL_YEAR'] .'">' . $row['SCHOOL_YEAR'] . '</option>';
          								}
          							?>
          						</select>
                    </div>
                  </div>

                  <div class="form-group" style = "width: 300px;">
                    <label>Term <span style="font-weight:normal; color:red;">*</span></label>
                    <select id="term" name="term" class="term form-control">
        							<option value=1> 1 </option>
        							<option value=2> 2 </option>
        							<option value=3> 3 </option>
        						</select>
                  </div>

        					<div class="form-group" style = "width: 300px;">
                        <label>Case Type <span style="font-weight:normal; color:red;">*</span></label>
                        <select id="casetype" name="casetype" class="casetype form-control">
            							<option value="Minor"> Minor </option>
            							<option value="Major"> Major </option>
        						</select>
                  </div>

                  <br>
                  <button type="button" id="submit" name="submit" class="btn btn-primary" onClick="submitForm()">Generate</button>
                <!--</form>-->
                <br><br><br>
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
          url: '../ajax/cdo-notif-cases.php',
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

    function submitForm(){
      var ay = document.getElementById('academicyear').value;
      var term = document.getElementById('term').value;
      var caseType = document.getElementById('casetype').value;
      console.log("AY: " + ay);
      console.log("Term: " + term);
      console.log("CaseType: " + caseType);
      $('#loadingModal').modal('show');
        $.ajax({
            url: 'insert-generated-report.php',
            type: 'POST',
            data: {
                ay: ay,
                term: term,
                caseType: caseType
            },
            success: function(msg) {
              console.log(msg.toString());
              console.log("SUCCESS!");

              document.getElementById('modalMessage').innerHTML = msg.toString();
              $('#loadingModal').modal('hide');
              // var x = document.getElementById('para').textContent;
              // console.log("X: " + x);
              // document.getElementById('modalMessage').innerHTML = x;
              var msg1 = "Summary Report for " + caseType + " Cases AY " + ay + " Term " + term;
              document.getElementById('myModalLabel').innerHTML = msg1;
              $('#successModal').modal('show');
            }
        });

    }

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

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
  </script>

  <!-- Notification Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel" align="center"><b>Report Generation</b></h4>
        </div>
        <div class="modal-body">
          <p id="modalMessage">Report has been generated and sent to your email and the SDFO Director! Check your email to view the spreadsheet.</p><br>
        </div>
        <div class="modal-footer">
          <button type="submit" id = "modalOK" onclick="location.reload()" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!--Loading Modal-->
  <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel" align="center"><b>Generating Report</b></h4>
        </div>
        <div class="modal-body">
          <div class="loader" align="center"></div>
          <h5 align="center">Please wait</h5>
        </div>
      </div>
    </div>
  </div>

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

@-webkit-keyframes fadeout {
  from {bottom: 40px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 40px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>