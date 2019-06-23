<?php include 'ido.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/ido/ido-home.php");
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

    <!-- Form Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.9.1/docxtemplater.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.6.1/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.0.2/jszip-utils.js"></script>

    <!-- GDRIVE -->

    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/ido-upload2.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

</head>

<body>

  <?php
    $query='SELECT 		  C.CASE_ID AS CASE_ID,
                        C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                        C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                        CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                        C.OFFENSE_ID AS OFFENSE_ID,
                        RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                        RO.TYPE AS TYPE,
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
                        C.COMMENT AS COMMENT,
                        C.LAST_UPDATE AS LAST_UPDATE,
                        C.PENALTY_ID AS PENALTY_ID,
                        RP.PENALTY_DESC AS PENALTY_DESC,
                        C.VERDICT AS VERDICT,
                        C.PROCEEDING_DATE AS PROCEEDING_DATE,
                        C.PROCEEDING_DECISION AS PROCEEDING_DECISION,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW,
                        IR.IF_UPLOADED AS IF_UPLOADED,
                        C.WITH_PARENT_LETTER AS WITH_PARENT_LETTER,
                        C.IF_APPEAL AS IF_APPEAL
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
            LEFT JOIN   INCIDENT_REPORTS IR ON IR.INCIDENT_REPORT_ID = C.INCIDENT_REPORT_ID

            WHERE   	  C.CASE_ID = "'.$_GET['cn'].'"
            ORDER BY	  C.LAST_UPDATE';
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else{
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    }

    // ADMISSIONS
    $queryadmi = 'SELECT *
                FROM CASES C
                JOIN REF_ADMISSION_TYPE RAT ON RAT.ADMISSION_TYPE_ID = C.ADMISSION_TYPE_ID
               WHERE C.CASE_ID = "'.$_GET['cn'].'"';

     $resultadmi=mysqli_query($dbc,$queryadmi);
     if(!$resultadmi){
       echo mysqli_error($dbc);
     }
     else{
       $rowadmi=mysqli_fetch_array($resultadmi,MYSQLI_ASSOC);
     }

     // FOR CLOSURE LETTER

     $qClosure = 'SELECT *
                    FROM CASES C
                    JOIN STUDENT_RESPONSE_FORMS S ON S.CASE_ID = C.CASE_ID
                    JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                    JOIN REF_STUDENTS R ON R.STUDENT_ID = U.USER_ID
                    JOIN REF_USER_OFFICE RO ON RO.OFFICE_ID = U.OFFICE_ID
                    LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID

                   WHERE C.CASE_ID = "'.$_GET['cn'].'"';

      $qClosureRes=mysqli_query($dbc,$qClosure);
      if(!$qClosureRes){
        echo mysqli_error($dbc);
      }
      else{
        $rowClosure=mysqli_fetch_array($qClosureRes,MYSQLI_ASSOC);
      }

      $qComplainant = 'SELECT *
                     FROM CASES C
                     JOIN USERS U ON C.COMPLAINANT_ID = U.USER_ID
                    WHERE C.CASE_ID = "'.$_GET['cn'].'"';

       $qComplainantRes=mysqli_query($dbc,$qComplainant);
       if(!$qComplainantRes){
         echo mysqli_error($dbc);
       }
       else{
         $qComplainantRow=mysqli_fetch_array($qComplainantRes,MYSQLI_ASSOC);
       }

       // calculating left/lost idea

       $fiveplus = 'SELECT COUNT(C.OFFENSE_ID) AS TOTAL
                      FROM CASES C
                      JOIN REF_OFFENSES R ON C.OFFENSE_ID = R.OFFENSE_ID
                     WHERE C.OFFENSE_ID = 57 AND C.REPORTED_STUDENT_ID = "'.$rowClosure['user_id'].'"';

        $fiveplusRes=mysqli_query($dbc,$fiveplus);
        $fiveplusRow = mysqli_fetch_assoc($fiveplusRes);

        $qleft = 'SELECT COUNT(C.OFFENSE_ID)
                       FROM CASES C
                       JOIN REF_OFFENSES R ON C.OFFENSE_ID = R.OFFENSE_ID
                      WHERE C.REPORTED_STUDENT_ID = "'.$rowClosure['user_id'].'" AND C.OFFENSE_ID = 62';

         $qleftRes=mysqli_query($dbc,$qleft);
         if(!$qleftRes){
           echo mysqli_error($dbc);
         }
         else{
           $qleftRow=mysqli_fetch_array($qleftRes,MYSQLI_ASSOC);
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

         $passData = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $rowStud['level'] . "/" . $rowStud['reported_student_id'] . "/" . "IDO-VIEW-CASE" . "/" . $_GET['cn'];
         $passCase = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $rowStud['level'] . "/" . $rowStud['reported_student_id'] . "/" . "VIEW-FOLDER" . "/" . $_GET['cn'];

          $uploadsq = 'SELECT   I.INCIDENT_REPORT_ID, I.IF_UPLOADED AS INCIDENT_UPLOADED,
  	                            S.STUDENT_RESPONSE_FORM_ID, S.IF_UPLOADED AS STUDENT_UPLOADED,
                                C.IF_APPEAL   AS IF_APPEAL,
                                C.WITH_PARENT_LETTER AS WITH_PARENT_LETTER,
                                F.PL_UPLOADED AS PL_UPLOADED
                      FROM      CASES C
                      LEFT JOIN STUDENT_RESPONSE_FORMS S ON S.CASE_ID = C.CASE_ID
                      LEFT JOIN INCIDENT_REPORTS I ON I.INCIDENT_REPORT_ID = C.INCIDENT_REPORT_ID
                      LEFT JOIN FORM_UPLOADING F ON F.CASE_ID = C.CASE_ID
                      WHERE C.CASE_ID = "'.$_GET['cn'].'"';
          $uploadsres=mysqli_query($dbc,$uploadsq);
          if(!$uploadsres){
            echo mysqli_error($dbc);
          }
          else{
            $uploadsrow = mysqli_fetch_array($uploadsres,MYSQLI_ASSOC);
          }

          $queryResp = 'SELECT *
                          FROM CASES C
                          JOIN STUDENT_RESPONSE_FORMS S ON C.CASE_ID = S.CASE_ID
                         WHERE C.CASE_ID = "'.$_GET['cn'].'"';

          $resultResp = mysqli_query($dbc,$queryResp);

          if(!$resultResp){
            echo mysqli_error($dbc);
          }
          else{
            $rowResp = mysqli_fetch_array($resultResp,MYSQLI_ASSOC);
          }

          $qSelect = 'SELECT 	U.FIRST_NAME, U.LAST_NAME, U.USER_ID
                        FROM	USERS U
                   LEFT JOIN	CASES C ON U.USER_ID = C.REPORTED_STUDENT_ID OR U.USER_ID = C.COMPLAINANT_ID
                       WHERE	C.CASE_ID = "'.$_GET['cn'].'"';
          $qSelectRes = mysqli_query($dbc,$qSelect);

          $qEvidenceSelect = 'SELECT * 
                                FROM REF_EVIDENCE_TYPE
                               WHERE OFFENSE_ID = "'.$row['OFFENSE_ID'].'"';
          $qEvidenceRes = mysqli_query($dbc,$qEvidenceSelect);
  ?>

    <div id="wrapper">

    <?php include 'ido-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-8">
                  <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-6">
        					<b>Offense:</b> <?php echo $row['OFFENSE_DESCRIPTION']; ?><br>
        					<b>Type:</b> <?php echo $row['TYPE']; ?><br>
                  <b>Location of the Incident:</b> <?php echo $row['LOCATION']; ?><br>
        					<b>Date Filed:</b> <?php echo $row['DATE_FILED']; ?><br>
                  <b>Last Update:</b> <?php echo $row['LAST_UPDATE']; ?><br>
        					<b>Status:</b> <?php echo $row['STATUS_DESCRIPTION']; ?><br>
                  <br>
        					<b>Student ID No.:</b> <?php echo $row['REPORTED_STUDENT_ID']; ?><br>
        					<b>Student Name:</b> <?php echo $row['STUDENT']; ?><br>
                  <br>
        					<b>Complainant:</b> <?php echo $row['COMPLAINANT']; ?><br>
        					<b>Investigated by:</b> <?php echo $row['HANDLED_BY']; ?><br>
                  <!--<b>Investigating Officer:</b> Debbie Simon <br>-->

                  <br><br>

                  <div class="form-group">
                    <label>Summary of the Incident</label>
                    <textarea id="details" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
                  </div>

                  <div class="form-group" id="proceedingarea" hidden>
                    <label>Nature of Proceedings</label>
                    <textarea id="proceeding" name="proceeding" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING']; ?></textarea>
                  </div>

                  <?php
                  if($row['PENALTY_DESC'] != null || $row['PROCEEDING_DECISION'] != null) { ?>
                    <div class="form-group" id="penaltyarea">
                      <label>Penalty</label>
                      <?php
                        if($row['PENALTY_DESC'] != null and $row['PENALTY_DESC'] != "Will be processed as a major discipline offense") { ?>
                          <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
                      <?php }
                        else if($row['PROCEEDING_DECISION'] != null) { ?>
                          <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                      <?php }
                      ?>
                    </div>
                  <?php }
                  ?>

                  <br>

                  <button type="submit" id="btnViewEvidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
                  <input type="file" id="fUpload" class="hide"/>

                  <br><br><br><br>

                  <div class="row">
                    <div class="col-sm-6">
                      <button type="submit" id="return" name="return" class="btn btn-warning">Return to Student</button>
                      <?php
                        if ($row['TYPE'] == 'Major') { ?>
                          <button type="button" class="btn btn-success" id="schedule"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule an interview</button>
                      <?php }
                      ?>
                      <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                      <button type="submit" id="sendcl" name="sendcl" class="btn btn-success">Send Closure Letter</button>
                      <button type="submit" id = "uploading" name="submit" class="btn btn-success" onclick="handle('<?php echo $passData;?>')" style = "display: none">Upload Form</button>
                      <!--<button type="submit" id="endorsement" name="submit" class="btn btn-success">Send Academic Service Endorsement Form</button>-->
                    </div>
                  </div>
              </div>

              <?php include "../ajax/user-case-audit.php" ?>

              <div class="col-lg-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <b style = "font-size: 17px;">
                      <a data-toggle="collapse" data-parent="#accordion" href="#caseHistory" style="color: black;">Case History</a>
                    </b>
                  </div>
                  <!-- /.panel-heading -->
                  <div id="caseHistory" class="panel-collapse collapse">
                    <div class="panel-body" style="overflow-y: scroll; max-height: 300px;">
                      <?php
                        if ($caseAuditRes->num_rows > 0) { ?>
                          <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action Done</th>
                                    <th>By Whom</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  while($caseAuditRow = mysqli_fetch_array($caseAuditRes,MYSQLI_ASSOC)) {
                                    echo "<tr>
                                            <td>{$caseAuditRow['date']}</td>
                                            <td>{$caseAuditRow['action_done']}</td>
                                            <td>{$caseAuditRow['action_done_by']}</td>
                                          </tr>";
                                  }
                                ?>
                              </tbody>
                            </table>
                          </div>
                          <!-- /.table-responsive -->
                      <?php }
                        else {
                          echo "No case history";
                        }
                      ?>
                      <br>
                    </div>
                    <!-- /.panel-body -->
                  </div>
                  <!-- </div> -->
                </div>
                <!-- /.panel -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Documents/Evidence</b>
                        <button Ftype="submit" id = "first" name="evidence" class="btn btn-primary btn-sm" style = "margin-left: 20px;" onclick="handle('<?php echo $passData;?>')">Authenticate Google Drive</button>
                    </div>

                    <!-- // NEW - DRIVE -->
                    <div id = "uploadPanel" class="panel-body" style = "display: none">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>File Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <?php
                                        if ($uploadsrow['INCIDENT_UPLOADED']) { ?>
                                          <td><button type="submit" id = "one" name="evidence" class="btn btn-outline btn-primary btn-xs" disabled>Submitted</button></td>
                                  <?php  }

                                        elseif ($uploadsrow['INCIDENT_UPLOADED'] == null) { ?>
                                          <td><label id = "one" style="font-weight:normal; font-style:italic; font-size:12px;">Not Applicable</label></td>
                                  <?php  }

                                        else { ?>
                                          <td><button type="submit" id = "one" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>
                                  <?php  }
                                      ?>

                                      <td>Incident Report Form</td>

                                    <tr>

                                      <?php
                                        if ($uploadsrow['STUDENT_UPLOADED']) { ?>
                                          <td><button type="submit" id = "two" name="evidence" class="btn btn-outline btn-primary btn-xs" disabled>Submitted</button></td>
                                  <?php  }

                                        else { ?>
                                          <td><button type="submit" id = "two" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>
                                  <?php  }
                                      ?>

                                      <td>Student Response Form</td>

                                    </tr>

                                  <?php

                                    if ($row['IF_APPEAL']) { ?>
                                      <tr>

                                        <?php
                                          if ($uploadsrow['STUDENT_UPLOADED'] == 2) { ?>
                                            <td><button type="submit" id = "five" name="evidence" class="btn btn-outline btn-primary btn-xs" disabled>Submitted</button></td>
                                    <?php  }

                                          else { ?>
                                            <td><button type="submit" id = "five" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>
                                    <?php  }
                                        ?>

                                        <td>Student Response Form for Appeal</td>

                                      </tr>
                              <?php }

                                  ?>
<<<<<<< HEAD

                                    <tr>

                                      <?php
                                        if ($uploadsrow['PL_UPLOADED']) { ?>
                                          <td><button type="submit" id = "three" name="evidence" class="btn btn-outline btn-primary btn-xs" disabled>Submitted</button></td>
                                  <?php  }
                                        elseif ($row['WITH_PARENT_LETTER'] == 0) { ?>
                                          <td><label id = "three" style="font-weight:normal; font-style:italic; font-size:12px;">Not Applicable</label></td>
                                  <?php  }

                                        else { ?>
                                          <td><button type="submit" id = "three" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>
                                  <?php  }
                                      ?>

                                      <td>Parent Letter</td>

=======

                                    <tr>

                                      <?php
                                        if ($uploadsrow['PL_UPLOADED']) { ?>
                                          <td><button type="submit" id = "three" name="evidence" class="btn btn-outline btn-primary btn-xs" disabled>Submitted</button></td>
                                  <?php  }
                                        elseif ($row['WITH_PARENT_LETTER'] == 0) { ?>
                                          <td><label id = "three" style="font-weight:normal; font-style:italic; font-size:12px;">Not Applicable</label></td>
                                  <?php  }

                                        else { ?>
                                          <td><button type="submit" id = "three" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>
                                  <?php  }
                                      ?>

                                      <td>Parent Letter</td>

>>>>>>> origin/ico-dev
                                    </tr>

                                    <tr>
                                      <td><button type="submit" id = "four" name="evidence" class="btn btn-outline btn-primary btn-xs">Upload</button></td>

                                      <td>Evidence</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                      <!-- //END NEW - DRIVE -->
                  </div>
                </div>
              </div>
      <br><br><br><br><br>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		IC.CASE_ID AS CASE_ID,
                          IC.IF_NEW AS IF_NEW
              FROM 		    IDO_CASES IC
              WHERE   	  IC.USER_ID = "'.$_SESSION['user_id'].'" AND IC.CASE_ID = "'.$_GET['cn'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if($row2['IF_NEW']){
          $query2='UPDATE IDO_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }
      ?>
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
          url: '../ajax/ido-notif-cases.php',
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

    $('#checkingForms').click();

    var totalID;

    <?php include "ido-form-queries.php" ?>

    var myVar = setInterval(myTimer2, 1000);
    function myTimer2() {
      <?php
        if($rowResp['student_response_form_id'] != null) { ?>
          if($('#two').text() == 'Submitted') {
              $.ajax({
                  url: 'ido-response-upload.php',
                  type: 'POST',
                  data: {
                      srf: <?php echo $rowResp['student_response_form_id']; ?>,
                      appeal: <?php echo $row['IF_APPEAL']; ?>
                  },
                  success: function(msg) {
                    clearInterval(myVar);
                  }
              });

            }
      <?php }
       ?>
    }

    var myVar2 = setInterval(myTimer1, 1000);
    function myTimer1() {
      <?php
        if($rowResp['student_response_form_id'] != null) { ?>
          if($('#five').text() == 'Submitted') {
            $.ajax({
                url: 'ido-response-upload.php',
                type: 'POST',
                data: {
                    srf: <?php echo $rowResp['student_response_form_id']; ?>,
                    appeal: <?php echo $row['IF_APPEAL']; ?>
                },
                success: function(msg) {
                  clearInterval(myVar2);
                }
            });
          }
    <?php }
     ?>
    }

    var myVar3 = setInterval(myTimer3, 1000);
    function myTimer3() {
      <?php
        if($row['INCIDENT_REPORT_ID'] != null) { ?>
          if($('#one').text() == 'Submitted') {
            $.ajax({
                url: 'ido-incident-upload.php',
                type: 'POST',
                data: {
                    irn: <?php echo $row['INCIDENT_REPORT_ID']; ?>
                },
                success: function(msg) {
                  clearInterval(myVar3);
                }
            });
          }
    <?php }
     ?>
    }

    var myVar4 = setInterval(myTimer4, 1000);
    function myTimer4() {
      if($('#three').text() == 'Submitted') {
        $.ajax({
            url: 'ido-pl-upload.php',
            type: 'POST',
            data: {
                caseid: <?php echo $_GET['cn']; ?>
            },
            success: function(msg) {
              clearInterval(myVar4);
            }
        });
      }
    }

    document.getElementById("submit").disabled = true;

    var submitTime = setInterval(mySubmitTimer, 100);
    function mySubmitTimer() {

      if(($('#one').text() == "Submitted" || $('#one').text() == "Not Applicable") && ($('#two').text() == "Submitted") && ($('#three').text() == "Submitted" || $('#three').text() == "Not Applicable")) {
        document.getElementById("submit").disabled = false;
        $('#successOK').on('click', function() {
          $("#submitModal").modal('show');
          clearInterval(submitTime);
        });
      }
    }


      // if ($uploadsrow['STUDENT_UPLOADED'] == 1 && $uploadsrow['INCIDENT_UPLOADED'] == 1) { // incident & student response uploaded
      //   // student response - appeal
      //   if ($row['IF_APPEAL']) {  // there is an appeal (meaning theres another student  response form)
      //
      //       if ($row['WITH_PARENT_LETTER']) { // theres parent letter and its uploaded
      //
      //         if ($uploadsrow['PL_UPLOADED']) {
      //           ?>
      //           // $("#submit").removeAttr('disabled');
      //           //$("#submit").style.display = "block";
      //           document.getElementById("submit").disabled = false;
      //           <?php
      //         }
      //       }
      //
      //       else {
      //         ?>
      //         //$("#submit").removeAttr('disabled');
      //         //$("#submit").style.display = "block";
      //         document.getElementById("submit").disabled = false;
      //         <?php
      //       }
      //
      //   }
      //
      //   else {
      //     if ($row['WITH_PARENT_LETTER']) { // theres parent letter and its uploaded
      //
      //       if ($uploadsrow['PL_UPLOADED']) {
      //         ?>
      //         //$("#submit").removeAttr('disabled')
      //         //$("#submit").style.display = "block";
      //         document.getElementById("submit").disabled = false;
      //         <?php
      //       }
      //     }
      //
      //     else { ?>
      //       //$("#submit").removeAttr('disabled');
      //       document.getElementById("submit").disabled = false;
      //       <?php
      //     }
      //   }
      // }
      //
      // else { ?>
      //   document.getElementById("submit").disabled = true; <?php
      // }
      //
      // ?>


    $('#uploading').on('click',function() {
      $("#waitModal").modal("show");
    });

    $('#submit').on('click',function() {
      $.ajax({
          url: '../ajax/ido-forward-case.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
              $('#message').text('Case is forwarded to SDFO Director successfully!');
              $("#submit").attr('disabled', true).text("Submitted");
              $("#return").attr('disabled', true);
              $("#penalty").attr('readonly', true);
              $("#schedule").attr('disabled', true);

              $("#alertModal").modal("show");
          }
      });
    });

    $('#mamamo').on('click', function() {
      location.reload();
      // if(('#message').text() == "Case is forwarded to SDFO Director successfully!") {
      //   location.reload();
      // }
    });

    $('#first').on('click',function() {
      $("#waitModal").modal("show");

    });

    $('#one').on('click',function(data) {
      $("#waitModal").modal("show");

      var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
      btnSubmit(data);
    });

    $('#two').on('click',function(data) {
      $("#waitModal").modal("show");

      var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
      btnSubmit(data);
    });

    $('#three').on('click',function(data) {
      $("#waitModal").modal("show");

      var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
      btnSubmit(data);
    });

    //new
    $('#four').on('click',function(data) {
      $("#uploadModal").modal("show");

      // var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
      // btnSubmit(data);
    });

    $('#five').on('click',function(data) {
      $("#waitModal").modal("show");

      var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
      btnSubmit(data);
    });

    $('#six').on('click',function(data) {
      $("#uploadModal").modal("hide");
      var e = document.getElementById("uploadSelect");

      if(e.options[e.selectedIndex].value == 0 && document.getElementById("witnessName").value.length == 0) {
        $("#emptyUploadModal").modal("show");
      }

      else {

        var selectedUser = e.options[e.selectedIndex].value;
        var witness = document.getElementById("witnessName").value;
        var x = document.getElementById("evidenceSelect");
        var evidenceSel  = x.options[x.selectedIndex].value;
        var check = 1; 

        // var e = document.getElementById("uploadSelect");
        // var selectedUser = e.options[e.selectedIndex].value;
        // var com = document.getElementById("desc_input").value;

        $.ajax({
            url: '../ajax/ido-insert-evi.php',
            type: 'POST',
            data: {
                submittedBy: selectedUser,
                evidence: evidenceSel,
                idoID: <?php echo $row['HANDLED_BY_ID']; ?>,
                sName: witness
            },
            success: function(msg) {
              document.getElementById("witnessName").value = "";
            },
            error: function(msg) {
              check = NULL;
            }
        });

        if(check != null) {
          var data = data.target.id + "|" + "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|" + "IDO-VIEW";
          btnSubmit(data);
        }

      }
    });


    $('#btnViewEvidence').on('click',function() {
      <?php $_SESSION['pass'] = $passCase; ?>
      location.href='ido-gdrive-case.php';
    });

    $('#submitComment').on('click',function() {
      $.ajax({
          url: '../ajax/ido-return-forms.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              comment: $('#comment').val()
          },
          success: function(msg) {
            $('#message').text('Returned to student successfully!');
            $("#submit").attr('disabled', true);
            $("#return").attr('disabled', true);
            $("#schedule").attr('disabled', true);
            $("#penalty").attr('readonly', true);

            $("#alertModal").modal("show");
          }
      });
    });

    $('#return').on('click',function() {
      $("#commentModal").modal("show");
    });

    function calculateID() {
      totalID = <?php echo intval($fiveplusRow)?> * 5;
    }

    $('#endorsement').on('click',function() {
      calculateID();
      $('#hourz').text('Student entered campus with lost or left ID for ' + totalID + ' times.');
      $("#acadService").modal("show");
    });

    $('#submitHours').on('click',function() { // create referral form

      loadFile("../templates/template-academic-service-endorsement-form.docx",function(error,content){

          if (error) { throw error };
          var zip = new JSZip(content);
          var doc=new window.docxtemplater().loadZip(zip);
          // date
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!
          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          }
          if (mm < 10) {
            mm = '0' + mm;
          }
          var today = dd + '/' + mm + '/' + yyyy;

          doc.setData({

            date: today,
            idoFirst: "<?php echo $qComplainantRow['first_name'] ?>",
            idoLast: "<?php echo $qComplainantRow['last_name'] ?>",
            idn: "<?php echo $rowClosure['user_id'] ?>",
            firstName: "<?php echo $rowClosure['first_name'] ?>",
            lastName: "<?php echo $rowClosure['last_name'] ?>",
            degree: "<?php echo $rowClosure['degree'] ?>",
            numHrs: document.getElementById("hours").value,
            typeofidlost: totalID

          });

          try {
              // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
              doc.render();
          }

          catch (error) {
              var e = {
                  message: error.message,
                  name: error.name,
                  stack: error.stack,
                  properties: error.properties,
              }
              console.log(JSON.stringify({error: e}));
              // The error thrown here contains additional information when logged with JSON.stringify (it contains a property object).
              throw error;
          }

          var out=doc.getZip().generate({
              type:"blob",
              mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          }); //Output the document using Data-URI
          saveAs(out,"output.docx");

      });

      // loadFile("../templates/template-academic-service-printable.docx",function(error,content){
      //
      //     if (error) { throw error };
      //     var zip = new JSZip(content);
      //     var doc=new window.docxtemplater().loadZip(zip);
      //     // date
      //     var today = new Date();
      //     var dd = today.getDate();
      //     var mm = today.getMonth() + 1; //January is 0!
      //     var yyyy = today.getFullYear();
      //     if (dd < 10) {
      //       dd = '0' + dd;
      //     }
      //     if (mm < 10) {
      //       mm = '0' + mm;
      //     }
      //     var today = dd + '/' + mm + '/' + yyyy;
      //
      //     doc.setData({
      //
      //       date: today,
      //       idoFirst: "<?php echo $qComplainantRow['first_name'] ?>",
      //       idoLast: "<?php echo $qComplainantRow['last_name'] ?>",
      //       idn: "<?php echo $rowClosure['user_id'] ?>",
      //       firstName: "<?php echo $rowClosure['first_name'] ?>",
      //       lastName: "<?php echo $rowClosure['last_name'] ?>",
      //       degree: "<?php echo $rowClosure['degree'] ?>",
      //       numHrs: document.getElementById("hours").value,
      //       typeofidlost: totalID
      //
      //     });
      //
      //     try {
      //         // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
      //         doc.render();
      //     }
      //
      //     catch (error) {
      //         var e = {
      //             message: error.message,
      //             name: error.name,
      //             stack: error.stack,
      //             properties: error.properties,
      //         }
      //         console.log(JSON.stringify({error: e}));
      //         // The error thrown here contains additional information when logged with JSON.stringify (it contains a property object).
      //         throw error;
      //     }
      //
      //     var out=doc.getZip().generate({
      //         type:"blob",
      //         mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      //     }); //Output the document using Data-URI
      //     saveAs(out,"output.docx");
      //
      // });

      $("#endorsement").attr('disabled', true).text("Sent");

		//NOT DONE
		//HELLOSIGN API

		//HELLOSIGN API
    });

    /*$('#dismiss').on('click',function() {
      $.ajax({
          url: '../ajax/ido-dismiss-case.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              penalty: $('#penalty').val()
          },
          success: function(msg) {
              $('#message').text('Case dismissed.');
              $("#submit").attr('disabled', true);
              $("#return").attr('disabled', true);
              $("#dismiss").attr('disabled', true).text("Dismissed");
              $("#schedule").attr('disabled', true);
              $("#penalty").attr('readonly', true);

              $("#alertModal").modal("show");
          }
      });
    });*/

    // GENERATING FORMS
    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#uploadSelect').on('change',function() {
        var submitter_id = $(this).val();

        if (submitter_id == 0) {
          $('#witness').show();
        }

        else {
          $('#witness').hide();
        }

        // $.ajax({
        //   url: 'hdo-get-details.php',
        //   type: 'POST',
        //   data: {
        //     offense: offense_id
        //   },
        //   success: function(response) {

            
        //   }
        // });
    });

    $('#sendcl').on('click',function() {
      $('#closureModal').modal('show');

      loadFile("../templates/template-closure-letter.docx",function(error,content){

          if (error) { throw error };
          var zip = new JSZip(content);
          var doc=new window.docxtemplater().loadZip(zip);
          // date
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth() + 1; //January is 0!
          var yyyy = today.getFullYear();
          if (dd < 10) {
            dd = '0' + dd;
          }
          if (mm < 10) {
            mm = '0' + mm;
          }
          var today = dd + '/' + mm + '/' + yyyy;

          doc.setData({

            date: today,
            firstName: "<?php echo $rowClosure['first_name'] ?>",
            lastName: "<?php echo $rowClosure['last_name'] ?>",
            year: "<?php echo $rowClosure['year_level'] ?>",
            idn: "<?php echo $rowClosure['user_id'] ?>",
            College: "<?php echo $nameres["description"] ?>",
            Degree: "<?php echo $studentres["degree"] ?>",
            offense: "<?php echo $row["OFFENSE_DESCRIPTION"] ?>",
            dateApp: "<?php echo $row["DATE_FILED"] ?>",
            comName: "<?php echo $row["COMPLAINANT"] ?>",
            idoName: "<?php echo $row["HANDLED_BY"] ?>",
            term: "<?php echo $formres2["term"] ?>",
            schoolYr: "<?php echo $formres2["school_year"] ?>"

          });

          try {
              // render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
              doc.render();
          }

          catch (error) {
              var e = {
                  message: error.message,
                  name: error.name,
                  stack: error.stack,
                  properties: error.properties,
              }
              console.log(JSON.stringify({error: e}));
              // The error thrown here contains additional information when logged with JSON.stringify (it contains a property object).
              throw error;
          }

          var out=doc.getZip().generate({
              type:"blob",
              mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          }); //Output the document using Data-URI
          saveAs(out,"Closure Letter.docx");

      });
    });

    $('#submitClosure').on('click',function() {
      $.ajax({
          url: '../ajax/ido-send-closure-letter.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
              $.ajax({
                    url: '../ajax/users-hellosign.php',
                    type: 'POST',
                    data: {
                        formT: "Closure Letter.docx",
              					title : "Closure Letter",
              					subject : "Incident Report Document Signature",
              					message : "Please do sign this document.",
                        fname : "Dennis",
              					lname : "Trillo",
              					email : "ido.cms1@gmail.com",
              					filename : $('#inputfile').val()
                    },
                    success: function(response) {
                        $("#message").text('Case dismissed. Check your email to sign the Closure Letter and forward it to the student.');
                        $("#sendcl").attr('disabled', true);
                        $("#alertModal").modal("show");
          				}
          		});
          }
      });
    });

    $('#schedule').on('click', function() {
      <?php $_SESSION['caseID']=$_GET['cn']; ?>
      location.href='ido-calendar.php';
    });

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

  });

  <?php
    $isformq='SELECT * FROM STUDENT_RESPONSE_FORMS WHERE CASE_ID = "'.$_GET['cn'].'"';
    $isformres=mysqli_query($dbc,$isformq);
    if(!$isformres){
      echo mysqli_error($dbc);
    }
    else{
      $isformrow=mysqli_fetch_array($isformres,MYSQLI_ASSOC);
    }
  ?>

  <?php
    if($row['TYPE'] == "Major"){ ?>
      $("#admitarea").show();
  <?php }
    if($row['PROCEEDING'] != null ){ ?>
      $("#proceedingarea").show();
  <?php }
    if($row['REMARKS_ID'] != 2){ ?>
      $("#schedule").hide();
      $("#return").hide();
      $("#submit").hide();
  <?php }
    if(!isset($isformrow)){ ?>
      $("#return").hide();
      $("#submit").hide();
  <?php }
    if($row['REMARKS_ID'] == 2 && isset($isformrow)){ ?>
      $("#schedule").hide();
      $("#return").show();
      $("#submit").show();
  <?php }
    if($row['REMARKS_ID'] != 2){ ?>
      $("#submit").attr('disabled', true);
      $("#return").attr('disabled', true);
      $("#schedule").attr('disabled', true);

      <?php {
          /*if($row['REMARKS_ID'] > 4) { ?>
            $("#schedule").hide();
            $("#return").hide();
            $("#submit").hide();
        <?php if($row['PENALTY_DESC'] == null){ ?>
                $("#penaltyarea").hide();*/
            }
      }
  if($row['REMARKS_ID'] != 7) { ?>
    $("#sendcl").hide();
  <?php }
  if($row['TYPE'] != "Major" or $row['REMARKS_ID'] != 11) { ?>
      $("#endorsement").hide();
  <?php
  } ?>

  </script>

  <!-- Add Comment Modal -->
  <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Add Comment</b></h4>
        </div>
        <div class="modal-body">
          <span style="font-weight:normal; font-style:italic; font-size:12px;">Please be specific.</span>
          <textarea id="comment" style="width:570px;" name="comment" class="form-control" rows="3"><?php echo $row['COMMENT']; ?></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitComment" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Acad Service Modal -->
  <div class="modal fade" id="acadService" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Academic Service Endorsement Form</b></h4>
        </div>
        <div class="modal-body">

          <div id="hourz"></div> <br>

          <b>Number of Service Hours <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 10)</span>:</b>
          <input id="hours" class="schoolyear form-control"/><br>
        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitHours" class="btn btn-primary" data-dismiss="modal">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Closure Letter Modal -->
  <div class="modal fade" id="closureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Closure Letter</b></h4>
        </div>
        <div class="modal-body">

          <p>Date: <b><?php echo date("d-m-Y"); ?></b></p>
          <br>
          <p><b>STUDENT DETAILS</b></p>
          <p>Student: <b><?php echo $row["STUDENT"]; ?></b></p>
          <p>ID Number: <b><?php echo $row["REPORTED_STUDENT_ID"]; ?></b></p>
          <p>Year Level: <b><?php echo $studentres["year_level"]; ?></b></p>
          <p>College: <b><?php echo $nameres["description"]; ?></b></p>
          <p>Degree: <b><?php echo $studentres["degree"]; ?></b></p>
          <p>Academic Year / Term: <b>AY <?php echo $formres2["school_year"]; ?> / Term <?php echo $formres2["term"]; ?></b></p>
          <br>
          <p><b>CASE DETAILS</b></p>
          <p>Violation/Offense: <b><?php echo $row["OFFENSE_DESCRIPTION"]; ?></b></p>
          <p>Date of Apprehension: <b><?php echo $row["DATE_FILED"]; ?></b></p>
          <p>Complainant: <b><?php echo $row["COMPLAINANT"]; ?></b></p>
          <p>Investigating Discipline Officer: <b><?php echo $row["HANDLED_BY"]; ?></b></p>
          <p>Case Decision: <b>Case Dismissed</b></p>

        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitClosure" class="btn btn-primary" data-dismiss="modal">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message"></p>
        </div>
        <div class="modal-footer">
          <button type="button" id="mamamo" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- DRIVE Modal -->
  <div class="modal fade" id="driveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Google Authentication</b></h4>
        </div>
        <div class="modal-body">
          <p> You have authenticated the use of Google Drive. You can now upload your evidences.</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
          <!-- <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "btnSubmit()">Upload</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- // NEW - DRIVE -->

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Form Upload</b></h4>
        </div>
        <div class="modal-body">
          <p> File was uploaded successfully!</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="successOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Wait Modal -->
  <div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
          <h4 class="modal-title" id="myModalLabel"><b>Google Drive</b></h4>
        </div>
        <div class="modal-body">
          <p> Please wait. </p>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button> -->
        </div>
      </div>
    </div>
  </div>


  <!-- NEW Upload Modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Upload Evidence</b></h4>
        </div>
        <div class="modal-body">

          <p> <b>Submitted By</b>

            <select id = "uploadSelect" class = "form-control">

            <?php

              while($qSelectRow = mysqli_fetch_array($qSelectRes,MYSQLI_ASSOC)) {

                $first = $qSelectRow['FIRST_NAME'];
                $last = $qSelectRow['LAST_NAME'];
                $id = $qSelectRow['USER_ID'];

                echo "<option value ='".$id."'> ".$first." ".$last."</option>";

              }
              
              echo "<option value = 0> Witness </option>";

            ?> </select>

          </p><br>

          <div id="witness" class="form-group" hidden>
            <label>Witness Name</label>
            <input id="witnessName" class="form-control">
          </div>

          <p> <b>Evidence Description</b>

            <select id = "evidenceSelect" class = "form-control">

            <?php

              while($qEvidenceResRow = mysqli_fetch_array($qEvidenceRes,MYSQLI_ASSOC)) {

                $id = $qEvidenceResRow['evidence_type_id'];
                $desc = $qEvidenceResRow['evidence_type_desc'];

                echo "<option value ='".$id."'> ".$desc." </option>";

              }

            ?> </select>

          </p><br>

          <!-- make this select, gets suggested desc of evidence from new table in db -->

          <!-- <p> Description: <textarea class="form-control" rows="3" id = "desc_input"></textarea></p><br> -->

          <button type="submit" id = "six" name="evidence" class="btn btn-primary ">Upload</button>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button> -->
        </div>
      </div>
    </div>
  </div>

  <!-- Can Submit Modal -->
  <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p> Case can now be submitted to SDFO Director. </p>
        </div>
        <div class="modal-footer">
          <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="emptyUploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><b>Evidence Upload</b></h4>
					</div>
					<div class="modal-body">
						<p id="message">Please fill in all the fields!</p>
					</div>
					<div class="modal-footer">
            <button type="submit" id = "modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
    </div>

</body>

</html>

<style>

p{ margin: 0; }

</style>
