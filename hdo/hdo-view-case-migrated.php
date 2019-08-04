<?php include 'hdo.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/hdo/hdo-home.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Case</title>

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

    <!-- FOR SEARCHABLE DROP -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

</head>

<body>

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
                        C.LOCATION AS LOCATION,
                        C.DETAILS AS DETAILS,
                        C.ADMISSION_TYPE_ID AS ADMISSION_TYPE_ID,
                        C.HANDLED_BY_ID AS HANDLED_BY_ID,
                        CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS HANDLED_BY,
                        C.DATE_FILED AS DATE_FILED,
                        C.STATUS_ID AS STATUS_ID,
                        S.DESCRIPTION AS STATUS_DESCRIPTION,
                        C.REMARKS_ID AS REMARKS_ID,
                        C.LAST_UPDATE AS LAST_UPDATE,
                        C.PENALTY_ID AS PENALTY_ID,
                        RP.PENALTY_DESC AS PENALTY_DESC,
                        C.VERDICT AS VERDICT,
                        C.PROCEEDING_DATE AS PROCEEDING_DATE,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.PROCEEDING_DECISION AS PROCEEDING_DECISION,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW
            FROM 		    CASES C
            LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
            LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
            LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
            LEFT JOIN   CASE_REFERRAL_FORMS CRF ON C.CASE_ID = CRF.CASE_ID
            LEFT JOIN   REF_CASE_PROCEEDINGS RCP ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
            LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
            LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
            LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
            LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID

            WHERE   	  C.CASE_ID = "'.$_GET['cn'].'"
            ORDER BY	  C.LAST_UPDATE';
    $result2=mysqli_query($dbc,$query2);
    if(!$result2){
      echo mysqli_error($dbc);
    }
    else{
      $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
    }

    $queryStud = 'SELECT *
                         FROM CASES C
                         JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                         JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                         JOIN REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
                        WHERE C.CASE_ID = "'.$_GET['cn'].'"';

    $resultStud = mysqli_query($dbc,$queryStud);

    if(!$queryStud){
      echo mysqli_error($dbc);
    }
    else{
      $rowStud = mysqli_fetch_array($resultStud,MYSQLI_ASSOC);
    }

    $passCase = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $rowStud['level'] . "/" . $rowStud['reported_student_id'] . "/" . "VIEW-FOLDER" . "/" . $_GET['cn'];
  ?>
  
    <div id="wrapper">

    <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
            <div class="col-lg-8">
              <h3 class="page-header"><b>Migrated Case No.: <?php echo $_GET['cn']; ?></b></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <b>Offense:</b> <?php echo $row2['OFFENSE_DESCRIPTION']; ?><br>
                <b>Type:</b> <?php echo $row2['TYPE'];; ?><br>
                <b>Location of the Incident:</b> <?php echo $row2['LOCATION']; ?><br>
                <b>Date Filed:</b> <?php echo $row2['DATE_FILED']; ?><br>
                <b>Last Update:</b> <?php echo $row2['LAST_UPDATE']; ?><br>
                <b>Status:</b> <?php echo $row2['STATUS_DESCRIPTION']; ?><br>
                <br>
                <b>Student ID No.:</b> <?php echo $row2['REPORTED_STUDENT_ID']; ?><br>
                <b>Student Name:</b> <?php echo $row2['STUDENT']; ?><br>
                <br>
                <b>Complainant:</b> <?php echo $row2['COMPLAINANT']; ?><br>
                <b>Investigated by:</b> <?php echo $row2['HANDLED_BY']; ?><br>
                <b>Summary of the Incident: </b><?php echo $row2['DETAILS']; ?>

                <br><br>
            </div>

            <div class="col-lg-6">

              <div class="form-group" style = "width: 400px;">
                <label>Admission Type <span style="font-weight:normal; color:red;">*</span> </label>
                  <?php
                    $query='SELECT ADMISSION_TYPE_ID, DESCRIPTION FROM ref_admission_type';
                    $result=mysqli_query($dbc,$query);
                    if(!$result){
                      echo mysqli_error($dbc);
                    }
                  ?>
                <select id="admission_type" class="chosen-select">
                  <option value="" disabled selected>Select Admission Type</option>
                  <?php
                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                    {
                      echo "<option value=\"{$row['ADMISSION_TYPE_ID']}\">{$row['DESCRIPTION']}</option>";
                    }
                  ?>
                </select>
              </div>

              <div id="NOP" class="form-group" style = "width: 400px;" hidden>
                <label>Nature of Proceeding <span style="font-weight:normal; color:red;">*</span></label>
                <input id="NOPinput" type='text' class="form-control" readonly>
              </div>

              <div id="verdict_div" class="form-group" style = "width: 400px;" hidden>
                <div class="form-group" style = "width: 400px;">
                  <label>Verdict <span style="font-weight:normal; color:red;">*</span> </label>
                  <select id="verdict" class="chosen-select">
                    <option value="null" disabled selected>Select Verdict</option>
                    <option value="Guilty">Guilty</option>
                    <option value="Not Guilty">Not Guilty</option>
                  </select>
                </div>
              </div>

              <div id="penalty" class="form-group" style = "width: 400px;" hidden>
                <label>Penalty <span style="font-weight:normal; color:red;">*</span> </label>
                  <?php
                    $query='SELECT PENALTY_ID, PENALTY_DESC FROM ref_penalties';
                    $result=mysqli_query($dbc,$query);
                    if(!$result){
                      echo mysqli_error($dbc);
                    }
                  ?>
                <select id="penalty_type" class="chosen-select">
                  <option value="" disabled selected>Select Penalty Type</option>
                  <?php
                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))
                    {
                      echo "<option value=\"{$row['PENALTY_DESC']}\">{$row['PENALTY_DESC']}</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="form-group" style = "padding-left: 330px;">
                <br>
                <button id="update_case" type="submit" class="btn btn-primary">Update</button>
              </div>

            </div>
          </div>
        </div>
        <br><br><br><br><br>
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <!-- <script src="../vendor/jquery/jquery.min.js"></script> -->

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
      $('.chosen-select').chosen({width: '100%'});

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

      $('#admission_type').on('change',function() {
        var pd=$('#admission_type').val();
        if(pd == 1){
          $('#NOP').show();
          $('#penalty').show();
          $('#NOPinput').val('UPCC');
        }
        if(pd == 2){
          $('#NOP').show();
          $('#penalty').show();
          $('#NOPinput').val('Summary Proceedings');
        }
        if(pd == 3) {
          $('#NOP').show();
          $('#penalty').show();
          $('#NOPinput').val('Formal Hearing');
          $('#verdict_div').show();
        }
        else {
          $('#verdict_div').hide();
        }
        console.log(pd);
          // console.log($('NOP').val());
      });

      $('#update_case').click(function() {
        var ids = ['#admission_type','#penalty_type'];
        var isEmpty = true;

        if($('#verdict_div').is(":visible")){
          ids.push('#verdict');
        }
        else{
          if($.inArray('#verdict', ids) !== -1){
            ids.splice(ids.indexOf('#verdict'),1);
          }
        }
        
        for(var i = 0; i < ids.length; ++i ){
          if($.trim($(ids[i]).val()).length == 0){
            isEmpty = false;
          }
        }

        if(isEmpty) {
          $.ajax({
              url: '../ajax/hdo-update-migrated-case.php',
              type: 'POST',
              data: {
                  caseid: <?php echo $_GET['cn'] ?>,
                  admission: $('#admission_type').val(),
                  penalty: $('#penalty_type').val(),
                  verdict: $('#verdict').val()
              },
              success: function(response) {

                // audit trail
                $.ajax({
                    url: '../ajax/insert_system_audit_trail.php',
                    type: 'POST',
                    data: {
                        userid: <?php echo $_SESSION['user_id'] ?>,
                        actiondone: 'HDO Migrated Case - Updated Data for Migrated Case #<?php echo $_GET['cn']; ?>'
                    },
                    success: function(response) {
                      console.log('Success');
                    }
                })

                $("#message1").hide();
                $("#message2").show();
                $('#alertModal').modal('show');
              }
          });
        }
        else {
          $("#message1").show();
          $("#message2").hide();
          $('#alertModal').modal('show');
        }
      });

      $('#modalOK').click(function() {
        if ($('#message2').is(':visible')) {
          window.location.replace("http://localhost/CMS/hdo/hdo-home.php");
        }
      });

      $('.modal').attr('data-backdrop', "static");
      $('.modal').attr('data-keyboard', false);

      // sidebar system audit trail
      $('#sidebar_cases').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Apprehension - Viewed Cases'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_apprehend').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Apprehension - Viewed Apprehend'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_reports').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Apprehension - Viewed Incidet Reports'
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
                    actiondone: 'HDO Apprehension - Viewed Files'
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
                    actiondone: 'HDO Apprehension - Viewed Calendar'
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
                    actiondone: 'HDO Apprehension - Viewed Inbox'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_migration').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Apprehension - Viewed Data Migration'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
    });
  </script>

  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel1"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message1">Please fill in all the required ( <span style='color:red;'>*</span> ) fields!</p>
          <p id="message2">Case details have been updated successfully!</p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
