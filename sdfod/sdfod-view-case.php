<?php include 'sdfod.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/sdfod/sdfod-home.php");
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

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Form Generation -->
    <script src="../form-generation/docxtemplater.js"></script>
    <script src="../form-generation/jszip.js"></script>
    <script src="../form-generation/FileSaver.js"></script>
    <script src="../form-generation/jszip-utils.js"></script>

    <!-- GDRIVE -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/ah2.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

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
                        C.PROCEEDING_DECISION AS PROCEEDING_DECISION,
                        CRF.CASE_DECISION AS CASE_DECISION,
                        RCP.CASE_PROCEEDINGS_ID AS CASE_PROCEEDINGS_ID,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW,
                        C.NEED_ACAD_SERVICE AS NEED_ACAD_SERVICE
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
      $row=mysqli_fetch_array($result2,MYSQLI_ASSOC);
    }

    $CollegeQ = 'SELECT *
                          FROM CASES C
                 JOIN     USERS U ON U.USER_ID = C.REPORTED_STUDENT_ID
                 JOIN     REF_USER_OFFICE R ON R.OFFICE_ID = U.OFFICE_ID
                 JOIN     REF_STUDENTS RS ON RS.STUDENT_ID = C.REPORTED_STUDENT_ID
                 WHERE    C.CASE_ID = "'.$_GET['cn'].'"';
    $CollegeQRes=mysqli_query($dbc,$CollegeQ);
    if(!$CollegeQRes){
      echo mysqli_error($dbc);
    }
    else{
      $CollegeQRow=mysqli_fetch_array($CollegeQRes,MYSQLI_ASSOC);
    }

    $queryStud2 = 'SELECT *
                    FROM CASES C
                    JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                    JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                    JOIN REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
                   WHERE C.CASE_ID = "'.$_GET['cn'].'"';

    $resultStud2 = mysqli_query($dbc,$queryStud2);

    if(!$resultStud2){
      echo mysqli_error($dbc);
    }
    else{
      $rowStud2 = mysqli_fetch_array($resultStud2,MYSQLI_ASSOC);
    }

    $passData = $rowStud2['description'] . "/" . $rowStud2['degree'] . "/" . $rowStud2['level'] . "/" . $rowStud2['reported_student_id'] . "/" . "SDFOD-VIEW-CASE" . "/" . $_GET['cn'];
    $passCase = $rowStud2['description'] . "/" . $rowStud2['degree'] . "/" . $rowStud2['level'] . "/" . $rowStud2['reported_student_id'] . "/" . "VIEW-FOLDER" . "/" . $_GET['cn'];

    $queryForm = 'SELECT *
                    FROM CASE_REFERRAL_FORMS
                   WHERE CASE_ID = "'.$_GET['cn'].'"';
    $resForm = mysqli_query($dbc,$queryForm);

     if(!$resForm){
       echo mysqli_error($dbc);
     }
     else{
       $rowForm = mysqli_fetch_array($resForm,MYSQLI_ASSOC);
     }

     // FOR CLOSURE LETTER

     $qClosure = 'SELECT *
                    FROM CASES C
                    LEFT JOIN STUDENT_RESPONSE_FORMS S ON S.CASE_ID = C.CASE_ID
                    LEFT JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                    LEFT JOIN REF_STUDENTS R ON R.STUDENT_ID = U.USER_ID
                    LEFT JOIN REF_USER_OFFICE RO ON RO.OFFICE_ID = U.OFFICE_ID
                    LEFT JOIN REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID
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

      $form = 'SELECT MAX(STUDENT_RESPONSE_FORM_ID)+1 AS MAX
                FROM STUDENT_RESPONSE_FORMS';
      $formq = mysqli_query($dbc,$form);

      if(!$formq){
        echo mysqli_error($dbc);
      }
      else{
        $formres = mysqli_fetch_array($formq);
      }

      $neewQry = 'SELECT REMARKS_ID AS REMARKS_ID
                   FROM CASES
                   WHERE CASE_ID = "'.$_GET['cn'].'"';
       $neewQryq = mysqli_query($dbc,$neewQry);

       if(!$neewQryq){
         echo mysqli_error($dbc);
       }
       else{
         $neewQryRes = mysqli_fetch_array($neewQryq);
       }

       $uploadsq = 'SELECT   I.INCIDENT_REPORT_ID, I.IF_UPLOADED AS INCIDENT_UPLOADED,
                             S.STUDENT_RESPONSE_FORM_ID, S.IF_UPLOADED AS STUDENT_UPLOADED,
                             C.IF_APPEAL   AS IF_APPEAL,
                             C.WITH_PARENT_LETTER AS WITH_PARENT_LETTER,
                             F.PL_UPLOADED AS PL_UPLOADED,
                             F.FEEDBACK_UPLOADED AS FEEDBACK_UPLOADED
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
  ?>

    <div id="wrapper">

    <?php include 'sdfod-sidebar.php';?>

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
                  <!--<div class="form-group" id="penaltyarea" hidden>
                    <label>Penalty</label>
                    <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
                  </div>-->
                  <?php
                    if($row['PROCEEDING'] != null) {
                      echo "<div class='form-group' id='proceedingarea'>
                              <label>Nature of Proceedings</label>
                              <textarea id='proceeding' name='proceeding' class='form-control' rows='3' readonly>{$row['PROCEEDING']}</textarea>
                            </div>";
                    }
                  ?>

                  <?php include 'sdfod-count-minor.php' ?>

                  <?php
                    $query2='SELECT DIRECTOR_REMARKS_ID, DIRECTOR_REMARKS FROM REF_DIRECTOR_REMARKS';
                    $result2=mysqli_query($dbc,$query2);
                    if(!$result2){
                      echo mysqli_error($dbc);
                    }
                  ?>

                  <br>

                  <div class="form-group">
                    <label>Remarks</label>
                    <?php
                    while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                      if ($row2['DIRECTOR_REMARKS_ID'] == 1 && $currentMinorOffense == 62 && $numSameMinor < 3 && $row['TYPE'] == "Minor") {
                        echo "<div class='checkbox'>
                                  <label>
                                      <input type='checkbox' name='remarks' value='{$row2['DIRECTOR_REMARKS_ID']}' checked disabled>&nbsp;&nbsp;&nbsp;{$row2['DIRECTOR_REMARKS']}
                                  </label>
                              </div>";
                      }
                      if ($row2['DIRECTOR_REMARKS_ID'] == 2 && $numSameMinor == 1 && $currentMinorOffense != 62 && $row['TYPE'] == "Minor") {
                        echo "<div class='checkbox'>
                                  <label>
                                      <input type='checkbox' name='remarks' value='{$row2['DIRECTOR_REMARKS_ID']}' checked disabled>&nbsp;&nbsp;&nbsp;{$row2['DIRECTOR_REMARKS']}
                                  </label>
                              </div>";
                      }
                      if ($row2['DIRECTOR_REMARKS_ID'] == 3 && ((($numSameMinorOffense > 2 || $numSameMinor > 4) && $currentMinorOffense != 62) || $row['TYPE'] == "Major")) {
                        echo "<div class='checkbox'>
                                  <label>
                                      <input type='checkbox' name='remarks' value='{$row2['DIRECTOR_REMARKS_ID']}' checked disabled>&nbsp;&nbsp;&nbsp;{$row2['DIRECTOR_REMARKS']}
                                  </label>
                              </div>";
                      }
                      if ($row2['DIRECTOR_REMARKS_ID'] == 4 && $numSameMinorOffense > 1 && $currentMinorOffense != 62  && $row['TYPE'] == "Minor") {
                        echo "<div class='checkbox'>
                                  <label>
                                      <input type='checkbox' name='remarks' value='{$row2['DIRECTOR_REMARKS_ID']}' checked disabled>&nbsp;&nbsp;&nbsp;{$row2['DIRECTOR_REMARKS']} <b><i>$numSameMinorOffense time(s)</i></b>
                                  </label>
                              </div>";
                      }
                        if ($row2['DIRECTOR_REMARKS_ID'] == 5 && $numSameMinor > 1 && $currentMinorOffense != 62  && $row['TYPE'] == "Minor") {
                          echo "<div class='checkbox'>
                                    <label>
                                        <input type='checkbox' name='remarks' value='{$row2['DIRECTOR_REMARKS_ID']}' checked disabled>&nbsp;&nbsp;&nbsp;{$row2['DIRECTOR_REMARKS']} <b><i>$numSameMinor time(s)</i></b>
                                    </label>
                                </div>";
                        }
                      }
                      ?>
                  </div>

                  <?php
                    if($row['TYPE'] == "Minor") {?>
                    <?php
                      if($row['REMARKS_ID'] < 6) { ?>
                        <?php
                          $query2='SELECT DIRECTOR_REMARKS_ID, DIRECTOR_REMARKS FROM REF_DIRECTOR_REMARKS';
                          $result2=mysqli_query($dbc,$query2);
                          if(!$result2){
                            echo mysqli_error($dbc);
                          }
                        ?>

                        <?php
                          while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                            if ($row2['DIRECTOR_REMARKS_ID'] == 1 && $currentMinorOffense == 62 && $numSameMinor < 3) {
                              echo "<br>
                                    <div class='form-group'>
                                      <label>Penalty</label>
                                      <textarea id='finpenalty' name='finpenalty' class='form-control' rows='3' readonly>No penalty will be given</textarea>
                                    </div>";
                            }
                            elseif ($row2['DIRECTOR_REMARKS_ID'] == 2 && $numSameMinor == 1 && $currentMinorOffense != 62) {
                              echo "<br>
                                    <div class='form-group'>
                                      <label>Penalty</label>
                                      <textarea id='finpenalty' name='finpenalty' class='form-control' rows='3' readonly>Warning will be given</textarea>
                                    </div>";
                            }
                            elseif ($row2['DIRECTOR_REMARKS_ID'] == 4 && $numSameMinor == 2 && $currentMinorOffense != 62) {
                              echo "<br>
                                    <div class='form-group'>
                                      <label>Penalty</label>
                                      <textarea id='finpenalty' name='finpenalty' class='form-control' rows='3' readonly>Reprimand will be given</textarea>
                                    </div>";
                            }
                            elseif ($row2['DIRECTOR_REMARKS_ID'] == 5 && $numSameMinor > 2 && $numSameMinor < 5 && $currentMinorOffense != 62) {
                              echo "<br>
                                    <div class='form-group'>
                                      <label>Penalty</label>
                                      <textarea id='finpenalty' name='finpenalty' class='form-control' rows='3' readonly>Student will be referred to University Councelor</textarea>
                                    </div>";
                            }
                          }
                        ?>
                    <?php }
                    ?>
                  <?php }
                  ?>

                  <?php
                  if($row['PENALTY_DESC'] != null) { ?>
                    <br>
                    <div class="form-group" id="penaltyarea">
                      <label>Penalty</label>
                      <textarea id="finpenalty" name="finpenalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
                    </div>
                  <?php }
                  ?>

                  <?php
                  if($row['PROCEEDING_DECISION'] != null) { ?>
                    <br>
                    <div class="form-group" id="penaltyarea">
                      <label>Penalty</label>
                      <textarea id="finpenalty" name="finpenalty" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                    </div>
                  <?php }
                  ?>

                  <?php
                    if(($row['PROCEEDING_DATE'] != null && date('Y-m-d H:i:s') > $row['PROCEEDING_DATE']) && $row['REMARKS_ID'] == 16 && $row['PROCEEDING_DECISION'] == null) { ?>
                      <br>
                      <div class="form-group" id="penpenaltyarea">
                        <label>Penalty <span style="color:red;">*</span></label>
                        <textarea id="finfinpenalty" name="finfinpenalty" class="form-control" rows="3" placeholder="Enter Penalty"><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                      </div>
                  <?php }
                  ?>

                  <!--<div id="proceedingsList" class="form-group" hidden>
                    <label>Nature of Proceedings</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="proceedings" id="1" value="1" checked>Formal Hearing
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="proceedings" id="2" value="2">Summary Proceeding
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="proceedings" id="3" value="3">University Panel for Case Conference
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="proceedings" id="4" value="4">Case Conference with DO Director
                        </label>
                    </div>
                </div>-->
                  <br>
                  <button type="submit" id="btnViewEvidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
                  
                  <br><br><br><br>
        
                  <?php
                    if($row['TYPE'] == "Major" || ($row['REMARKS_ID'] == 5 && ($numSameMinorOffense > 2 || $numSameMinor > 4))) { ?>
                      <button type="submit" id="endorse" name="endorse" class="btn btn-primary">Endorse</button>
                  <?php }
                    elseif ($row['REMARKS_ID'] == 5) { ?>
                      <button type="submit" id="endorse" name="endorse" class="btn btn-primary">Submit</button>
                  <?php  }
                  ?>
                  <?php
                    if($row['REMARKS_ID'] == 14) { ?>
                      <button type="button" id="sign" class="btn btn-success" data-dismiss="modal">Sign Discipline Case Feedback Form</button>
                  <?php }
                  ?>
                  <?php
                    if(($row['PROCEEDING_DATE'] != null && date('Y-m-d H:i:s') > $row['PROCEEDING_DATE']) && $row['REMARKS_ID'] == 16 && $row['PROCEEDING_DECISION'] == null) { ?>
                      <button type="button" id="submitPD" class="btn btn-primary" data-dismiss="modal">Submit</button>
                  <?php }
                  ?>
                  <?php
                    if($row['REMARKS_ID'] == 11 && $row['NEED_ACAD_SERVICE'] && $uploadsrow['FEEDBACK_UPLOADED']) { ?>
                      <button type="button" id="sendAcad" class="btn btn-success" data-dismiss="modal">Send Academic Endorsement Service Form</button>
                  <?php }
                  ?>

                  <?php
                    if(($row['REMARKS_ID'] == 10 || $row['REMARKS_ID'] == 11 || $row['REMARKS_ID'] == 7) && !$uploadsrow['FEEDBACK_UPLOADED']) { ?>
                      <button type="submit" id = "uploading" name="submit" class="btn btn-success" onclick="handle('<?php echo $passData;?>')">Upload Discipline Case Feedback Form</button>
                  <?php }
                  ?>
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

                <?php
                if($row['STATUS_ID'] == 1 || $row['STATUS_ID'] == 2) { ?>
                  <!--REROUTE & REASSIGN-->
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                            <b style = "font-size: 17px;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="color: black">Reroute Case</a>
                            </b>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                              <div class="form-group">
                                <div id="rerouteDiv">
                                  <select id="rerouteCase" class="form-control">
                                    <option value="" disabled selected>Select a stage</option>
                                    <?php
                                      // $getRemarks_id = $dbc->query("SELECT remarks_id FROM cms.cases WHERE case_id = " .$_GET['cn']. " LIMIT 1");
                                      // $remarks_id = $getRemarks_id->fetch_row();

                                      // $remarksQuery= "SELECT * FROM cms.ref_remarks WHERE remarks_id < " . $remarks_id[0];
                                      // $remarksRes = $dbc->query($remarksQuery);
                                      // while($remarks = $remarksRes->fetch_assoc())
                                      // echo 
                                      //   '<option value="' .$remarks['remarks_id']. '">' . $remarks['description'] . '</option>';
                                      if ($row['REMARKS_ID'] > 2) 
                                        echo 
                                          '<option value="2">For investigation by IDO</option>';
                                      if ($row['REMARKS_ID'] > 4) 
                                        echo 
                                          '<option value="4">For resubmission by the student</option>';
                                    ?>
                                  </select>
                                  <br>
                                  <button type="submit" id="btnReroute" name="btnReroute" class="btn btn-primary" style="float: right;">Reroute</button>
                                </div>
                                <div id="rerouteDiv2" hidden>
                                  <i>Rerouting is not applicable.</i>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                            <b style = "font-size: 17px;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="color: black">Reassign Case</a>
                            </b>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                              <div class="form-group">
                                  <select id="reassignIDO" class="form-control">
                                      <option value="" disabled selected>Select an IDO</option>
                                      <?php
                                        $idoQuery= "SELECT * FROM cms.users u WHERE u.user_type_id = 4;";
                                        $IDORes = $dbc->query($idoQuery);
                                        $ido_workloads = array();
                                        $ido_names = array();

                                        while($ido = $IDORes->fetch_assoc()){
                                          $idoName = $ido['first_name'] . ' ' . $ido['last_name'];
                                          $idoNumber = $ido['user_id'];
                                          $workloadQuery = $dbc->query("SELECT COUNT(ic.case_id)
                                                                        FROM ido_cases ic
                                                                          LEFT JOIN cases c on ic.case_id=c.case_id
                                                                          WHERE ic.user_id = ".$idoNumber."
                                                                              && (c.status_id != 3 && c.status_id != 4)
                                                                              && ic.handle = 1");
                                          $workload = $workloadQuery->fetch_row();

                                          if ($idoNumber != $row['HANDLED_BY_ID'] && $workload[0] < 8) {
                                            $ido_names[$idoNumber] = $idoName;
                                            $ido_workloads[$idoNumber] = $workload[0];
                                            // echo 
                                            //   '<option value="' .$idoNumber. '">' . $idoName . ' (Active Cases: ' .$workload[0]. ')</option>';
                                          }
                                        }

                                        asort($ido_workloads);
                                        $ido_names_ordered = array();
                                        
                                        foreach (array_keys($ido_workloads) as $key) {
                                          $ido_names_ordered[$key] = $ido_names[$key] ;
                                        }
                                        
                                        foreach($ido_workloads as $x => $x_value) {
                                          echo '<option value="' .$x. '">' . $ido_names[$x] . ' (Active Cases: ' .$ido_workloads[$x]. ')</option>';
                                        }
                                      ?>
                                  </select>
                                  <br>
                                  <button type="submit" id="btnReassign" name="btnReassign" class="btn btn-primary" style="float: right;">Reassign</button>
                              </div>    
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- REROUTE & REASSIGN -->
                <?php } ?>

              </div>
          </div>
        <br><br><br><br><br>
      </div>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		SDFOD.CASE_ID AS CASE_ID,
                          SDFOD.IF_NEW AS IF_NEW
              FROM 		    SDFOD_CASES SDFOD
              WHERE   	  SDFOD.CASE_ID = "'.$_GET['cn'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if($row2['IF_NEW'] == 1){
          $query2='UPDATE SDFOD_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }

      ?>
  </div>
  <!-- #wrapper -->

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
  var remarks;
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
          url: '../ajax/sdfod-notif-cases.php',
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

    $('#fileUpload').click(function() {
      var data = "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>";
      btnSubmit(data);
      
      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Uploaded Discipline Case Feedback Form for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
    });

    $('#endorse').click(function() {
      var remarks = [];
      var minor = true;
      $.each($("input[name='remarks']:checked"), function(){
          remarks.push($(this).val());
      });

      for(var i = 0; i < remarks.length; ++i ) {
        if(remarks[i] == 3) {
          minor = false;
        }
      }

      if(minor){
        $.ajax({
            url: '../ajax/director-close-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                dRemarks: remarks,
                penalty: $('#finpenalty').val()
            },
            success: function(response) {

              // audit trail
              $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Closed Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })

              loadFile("../templates/template-discipline-case-feedback-form.docx",function(error,content){
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
                  name: "<?php echo $row['STUDENT']; ?>",
                  idn: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
                  degree: "<?php echo $CollegeQRow['degree']; ?>",
                  college: "<?php echo $CollegeQRow['description']; ?>",
                  nature: "<?php echo $row['OFFENSE_DESCRIPTION']; ?>",
                  ido: "<?php echo $row['HANDLED_BY']; ?>",
                  dremark: response,
                  penalty: $('#finpenalty').val()

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
                saveAs(out,"Discipline Case Feedback Form.docx");
              });
              $("#endorse").attr('disabled', true).text("Submitted");
              $('#not-file').hide();
              $('#newFormModal').modal("show");
              //location.reload();
            }
        });
      }
      else {
        $.ajax({
            url: '../ajax/director-endorse-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>
                //proceeding: $("input:radio[name=proceedings]:checked").val()
            },
            success: function(response) {

              // audit trail
              $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Endorsed Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
              })

              loadFile("../templates/template-discipline-case-referral-form.docx",function(error,content){
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
                  casenum: <?php echo $_GET['cn']; ?>,
                  name: "<?php echo $row['STUDENT']; ?>",
                  idn: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
                  college: "<?php echo $CollegeQRow['description']; ?>",
                  degree: "<?php echo $CollegeQRow['degree']; ?>",
                  violation: "<?php echo $row['OFFENSE_DESCRIPTION']; ?>",
                  complainant: "<?php echo $row['COMPLAINANT']; ?>",
                  nature: "",
                  decision: "",
                  reason: "",
                  remark: "",
                  changes: "",
                  others: ""

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
                saveAs(out,"Discipline Case Referral Form.docx");
              });
              $('#penalty').attr("disabled", true);
              $("#endorse").attr('disabled', true).text("Endorsed");
              $("#newFormModal2").modal("show");
            }
        });
      }
      //$("#alertModal").modal("show");
    });

    $('#n1').on('click', function() {
      $.ajax({
            url: '../ajax/users-hellosign.php',
            type: 'POST',
            data: {
                formT: "Discipline Case Feedback Form.docx",
                title : "Discipline Case Feedback Form",
                subject : "Discipline Case Feedback Document Signature",
                message : "Please sign, download, and upload this form.",
                fname : "Michael",
                lname : "Millanes",
                email : "sdfod.cms1@gmail.com",
                filename : $('#inputfile').val()
            },
            success: function(response) {
              location.reload();
          }
      });
    });

    $('#n2').on('click', function() {
      $.ajax({
            url: '../ajax/users-hellosign.php',
            type: 'POST',
            data: {
                formT: "Discipline Case Referral Form.docx",
                title : "Discipline Case Referral Form",
                subject : "Discipline Case Referral Document Signature",
                message : "Please sign the document and forward it to aulc.cms1@gmail.com.",
                fname : "Michael",
                lname : "Millanes",
                email : "sdfod.cms1@gmail.com",
                filename : $('#inputfile').val()
            },
            success: function(response) {
              location.reload();
          }
      });
    });

    $('#n3').on('click', function() {
      $.ajax({
            url: '../ajax/users-hellosign.php',
            type: 'POST',
            data: {
                formT: "Discipline Case Referral Form.docx",
                title : "Discipline Case Referral Form",
                subject : "Discipline Case Referral Document Signature",
                message : "Please sign the document and forward it to aulc.cms1@gmail.com.",
                fname : "Michael",
                lname : "Millanes",
                email : "sdfod.cms1@gmail.com",
                filename : $('#inputfile').val()
            },
            success: function(response) {
              location.reload();
          }
      });
    });

    $('#modalOK').on('click', function() {
      if($('#message').text() == "Academic Service Endorsement Form has been sent to your email. Please sign the form and sent it to the student.") {
        $.ajax({
              url: '../ajax/users-hellosign.php',
              type: 'POST',
              data: {
                  formT: "Academic Service Endorsement Form.docx",
                  title : "Academic Service Endorsement Form",
                  subject : "Academic Service Endorsement Form Signature",
                  message : "Please sign and send to student.",
                  fname : "Michael",
                  lname : "Millanes",
                  email : "sdfod.cms1@gmail.com",
                  filename : $('#inputfile').val()
              },
              success: function(response) {
                location.reload();
            }
        });
      }
      else {
        location.reload();
      }
    });

    $('#btnViewEvidence').click(function() {
      <?php $_SESSION['pass'] = $passCase; ?>
      location.href='sdfod-gdrive-case.php';

      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Viewed Evidence for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
    });

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#sign').on('click', function() {
      var remarks = [];
      $.each($("input[name='remarks']:checked"), function(){
          remarks.push($(this).val());
      });

      $.ajax({
        //../ajax/director-return-to-ido.php
          url: '../ajax/director-return-to-ido.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              decision: '<?php echo $row['CASE_DECISION']; ?>',
              dRemarks: remarks
          },
          success: function(response) {

            // audit trail
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Sign Discipline Feedback Form for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
              })

            loadFile("../templates/template-discipline-case-feedback-form.docx",function(error,content){
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
                name: "<?php echo $row['STUDENT']; ?>",
                idn: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
                degree: "<?php echo $CollegeQRow['degree']; ?>",
                college: "<?php echo $CollegeQRow['description']; ?>",
                nature: "<?php echo $row['OFFENSE_DESCRIPTION']; ?>",
                ido: "<?php echo $row['HANDLED_BY']; ?>",
                dremark: response,
                penalty: $('#finpenalty').val()

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
              saveAs(out,"Discipline Case Feedback Form.docx");
            });

            $("#endorse").attr('disabled', true).text("Submitted");

            if('<?php echo $row['CASE_DECISION']; ?>' == "File Case") {
              //$('#message').text('Check your email to sign the Discipline Case Feedback Form. Case closed.');
              $('#not-file').hide();
            }
            else {
              //$('#message').text('Check your email to sign the Discipline Case Feedback Form. Case returned to IDO for Closure Letter');
              $('#file-close').hide();
            }
            $("#sign").attr('disabled', true)

            //$("#alertModal").modal("show");
            $("#uploading").show();
            $("#newFormModal").modal("show");
          }
      });
    });

    $('#submitPD').on('click', function() {
      var ids = ['#finfinpenalty'];
      var isEmpty = true;

      for(var i = 0; i < ids.length; ++i ) {
        if($.trim($(ids[i]).val()).length == 0) {
          isEmpty = false;
        }
      }
      if(isEmpty) {
        $.ajax({
            url: '../ajax/ulc-verdict.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                decision: $('#finfinpenalty').val(),
                pd: 1
            },
            success: function(msg) {
              $('#message').text('Case is ready for final signature and closing.');
              $("#finfinpenalty").attr('readonly', true);
              $("#submitPD").attr('disabled', true);
              $("#alertModal").modal("show");
            }
        });
      }
      else {
        $("#alertModal").modal("show");
      }
    });

    $('#sendAcad').on('click', function() {
      loadFile("../templates/template-academic-service-endorsement-form - Copy.docx",function(error,content){

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
            idoName: "<?php echo $row['HANDLED_BY'] ?>",
            idn: "<?php echo $row['REPORTED_STUDENT_ID'] ?>",
            studName: "<?php echo $row['STUDENT'] ?>",
            degree: "<?php echo $rowClosure['degree'] ?>"

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
          saveAs(out, "Academic Service Endorsement Form.docx");
      });
      $.ajax({
          url: '../ajax/sdfod-academic-service.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {

            // audit trail
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Sent Academic Endorsement Service Form for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })

            $('#message').text('Academic Service Endorsement Form has been sent to your email. Please sign the form and sent it to the student.');
            $("#sendAcad").attr('disabled', true);
            $("#alertModal").modal("show");
          }
      });
    });

    $('#uploading').click(function() {
      $("#waitModal").modal("show");
    });

    function calculateID() {
      totalID = <?php echo intval($fiveplusRow)?> * 5;
    }

    $('#endorsement').click(function() {
      calculateID();
      $('#hourz').text('Student entered campus with lost or left ID for ' + totalID + ' times.');
      $('#acadService').modal("show");
    });

    // $('#updateTable').click(function() {
    //
    //   <?php
    //      if ($row['REMARKS_ID'] == 6){
    //       $updateQry = 'UPDATE CASE_REFERRAL_FORMS
    //                        SET IF_UPLOADED = 1
    //                      WHERE CASE_ID = "'.$_GET['cn'].'"';
    //
    //       $update = mysqli_query($dbc,$updateQry);
    //       if(!$update){
    //         echo mysqli_error($dbc);
    //       }
    //     }
    //
    //     else if ($row['REMARKS_ID'] == 11) {
    //       $updateQry = 'UPDATE CASE_REFERRAL_FORMS
    //                        SET IF_UPLOADED = 4
    //                      WHERE CASE_ID = "'.$_GET['cn'].'"';
    //
    //       $update = mysqli_query($dbc,$updateQry);
    //       if(!$update){
    //         echo mysqli_error($dbc);
    //       }
    //     }
    //   ?>
    //
    // });

    $('#successOK').on('click', function() {
      $.ajax({
          url: '../ajax/sdfod-update-feedback.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
            location.reload();
          }
      });
    });

    //REROUTE & REASSIGN
    var action = "";

    var rerouteCase = document.getElementById("rerouteCase");

    if (rerouteCase.options.length <= 1) {
      $("#rerouteDiv").hide();
      $("#rerouteDiv2").show();
    } else {
      $("#rerouteDiv").show();
      $("#rerouteDiv2").hide();
    }

    $("#btnReroute").click(function() {
      if($.trim($("#rerouteCase").val()).length > 0) {
        action = "reroute";
        $("#twoFactorModal").modal('show');
      }
      else {
        $("#message2").text("Please select a stage.");
        $("#alertModal2").modal('show');
      }
    });

    $("#btnReassign").click(function() {
      if($.trim($("#reassignIDO").val()).length > 0) {
        action = "reassign";
        $("#twoFactorModal").modal('show');
      }
      else {
        $("#message2").text("Please select an IDO.");
        $("#alertModal2").modal('show');
      }
    });

    $("#modalYes").click(function(){
      if (action == "reroute") {
        $.ajax({
          url: '../ajax/hdo-update-remarks.php',
          type: 'POST',
          data: {
            case_id: <?php echo $_GET['cn'] ?>,
            remark_id : $("#rerouteCase").val(),
          },
          success: function(response) {
            // audit trail
            $("#message2").text("Cases has been rerouted.");
            $("#alertModal2").attr("onclick",'location.reload()');
            $.ajax({
                      url: '../ajax/insert_system_audit_trail.php',
                      type: 'POST',
                      data: {
                          userid: <?php echo $_SESSION['user_id'] ?>,
                          actiondone: 'SDFOD Case - Rerouted Case #<?php echo $_GET['cn']; ?>'
                      },
                      success: function(response) {
                        console.log('Success');
                      }
                  });
          }
    		});
      } else if (action == "reassign") {
        $.ajax({
          url: '../ajax/hdo-update-ido.php',
          type: 'POST',
          data: {
            case_id: <?php echo $_GET['cn'] ?>,
            ido_id: $("#reassignIDO").val(),
          },
          success: function(response) {
            // audit trail
            $("#message2").text("Cases has been reassigned.");
            $("#alertModal2").attr("onclick",'location.reload()');
            $.ajax({
                      url: '../ajax/insert_system_audit_trail.php',
                      type: 'POST',
                      data: {
                          userid: <?php echo $_SESSION['user_id'] ?>,
                          actiondone: 'SDFOD Case - Reassigned IDO for Case #<?php echo $_GET['cn']; ?>'
                      },
                      success: function(response) {
                        console.log('Success');
                      }
                  });
          }
        });
      }
      $("#alertModal2").modal('show');
    });

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

    // sidebar system audit trail
    $('#sidebar_dashboard').click(function() {
      $.ajax({
          url: '../ajax/insert_system_audit_trail.php',
          type: 'POST',
          data: {
              userid: <?php echo $_SESSION['user_id'] ?>,
              actiondone: 'SDFOD Viewed Case - Viewed Dashboard'
          },
          success: function(response) {
            console.log('Success');
          }
      });
    });
    $('#sidebar_cases').click(function() {
      $.ajax({
          url: '../ajax/insert_system_audit_trail.php',
          type: 'POST',
          data: {
              userid: <?php echo $_SESSION['user_id'] ?>,
              actiondone: 'SDFOD Viewed Case - Viewed Cases'
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
              actiondone: 'SDFOD Viewed Case - Viewed Calendar'
          },
          success: function(response) {
            console.log('Success');
          }
      });
    });
    $('#sidebar_drive').click(function() {
      $.ajax({
          url: '../ajax/insert_system_audit_trail.php',
          type: 'POST',
          data: {
              userid: <?php echo $_SESSION['user_id'] ?>,
              actiondone: 'SDFOD Viewed Case - Viewed Files'
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
              actiondone: 'SDFOD Viewed Case - Viewed Inbox'
          },
          success: function(response) {
            console.log('Success');
          }
      });
    });
    $('#sidebar_sysmanagement').click(function() {
      $.ajax({
          url: '../ajax/insert_system_audit_trail.php',
          type: 'POST',
          data: {
              userid: <?php echo $_SESSION['user_id'] ?>,
              actiondone: 'SDFOD Viewed Case - Viewed System Management'
          },
          success: function(response) {
            console.log('Success');
          }
      });
    });
  });



  <?php
    if($row['TYPE'] == "Major"){ ?>
      //$("#endorse").text("Endorse");
      //$("#penaltyarea").hide();
      //$("#proceedingsList").show();
  <?php }
    if($row['REMARKS_ID'] < 6){ ?>
      //$("#finpenalty").hide();
  <?php }
    if($row['REMARKS_ID'] > 5){ ?>
      $("#endorse").hide();
      $("#penalty").hide();
  <?php }
    if($row['REMARKS_ID'] > 5 and ($row['PENALTY_ID'] == 3 or $row['TYPE'] == "Major")){ ?>
      //$("#proceedingsList").show();
      //$("#<?php echo $row['CASE_PROCEEDINGS_ID']; ?>").prop("checked", true);
      //$("input[type=radio]").attr('disabled', true);
  <?php }
  ?>

  </script>

  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Two Factor Authentication Modal -->
  <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Confirmation</b></h4>
				</div>
					<div class="modal-body">
						<p> Are you sure you want to proceed? </p>
					</div>
					<div class="modal-footer">
            <button type="submit" id = "modalNo" style="width: 70px" class="btn btn-danger" data-dismiss="modal">No</button>
            <button type="submit" id = "modalYes" style="width: 70px" class="btn btn-success" data-dismiss="modal">Yes</button>
          </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="alertModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel1"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message2"></p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- New Modal -->
  <div class="modal fade" id="newFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Instructions</b></h4>
        </div>
        <div class="modal-body">
          <!-- <p id="message">Case succesfully endorsed to the AULC! Discipline Case Referral Form has been sent to your email. <br><br> <b>Next Steps: </b>  <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Upload the file on this page using your DLSU email account.</p> -->
          <p id="not-file">Case successfully returned to IDO for closure letter! Discipline Case Feedback Form has been sent to your email. <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Upload the file on this page using your DLSU email account.</p>
          <p id="file-close">Case is closed. Discipline Case Feedback Form has been submitted and sent to your email. <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Upload the file on this page using your DLSU email account.</p>
        </div>
        <div class="modal-footer">
          <button type="button" id="n1" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal2 -->
  <div class="modal fade" id="newFormModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Instructions</b></h4>
        </div>
        <div class="modal-body">
          <p id="message">Discipline Case Referral Form has been submitted and sent to your email successfully! <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Forward the file, along with the pieces of evidence, to <b>aulc.cms1@gmail.com</b> for processing. </p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="n2" class="btn btn-default" data-dismiss="modal">Ok</button>
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
          <input type="file" id="fUpload" class="hide"/>
          <button type="button" id = "fileUpload" class="btn btn-primary" data-dismiss="modal">Upload</button>
        </div>
      </div>
    </div>
  </div>

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

  <!-- Feedback Form Modal -->
  <!--<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Discipline Case Feedback Form Remarks</b></h4>
        </div>
          <div class="modal-body">

            <div class="col-sm-6">
              <b>Student Name:</b><input id="studName" class="schoolyear form-control" value="<?php echo $row['STUDENT']; ?>" readonly/><br>
            </div>

            <div class="col-sm-6">
              <b>ID Number: </b>
              <input id="IDN" class="schoolyear form-control" value="<?php echo $row['REPORTED_STUDENT_ID']; ?>" readonly/><br>
            </div>

            <br>

            <div class="col-sm-6">
              <b>College:</b>
              <input id="degCol" class="schoolyear form-control" value="<?php echo $CollegeQRow['description']; ?>" readonly/><br>
            </div>

            <div class="col-sm-6">
              <b>Degree:</b>
              <input id="degCol" class="schoolyear form-control" value="<?php echo $CollegeQRow['degree']; ?>" readonly/><br>
            </div>

            <b>Nature of Violation: </b>
            <textarea id="nViolation" class="schoolyear form-control" readonly><?php echo $row['OFFENSE_DESCRIPTION']; ?></textarea><br>

            <b>Case Handled By:</b>
            <input id="cHandle" class="schoolyear form-control" value="<?php echo $row['HANDLED_BY']; ?>" readonly/></b><br>

            <b>Remarks:</b>
            <select id="dRemarks" class="form-control">
              <option value="">Select Remark</option>
              <option value="Incident/Violation is recorded but without any offense">Incident/Violation is recorded but without any offense</option>
              <option value="Incident/Violation is recorded as first minor offense">Incident/Violation is recorded as first minor offense</option>
              <option value="Will be processed as a major discipline offense">Will be processed as a major discipline offense</option>
              <option value="Student is referred to University Councelor">Proceed to University Councelor</option>
              <option value="Warning is given">Warning is given</option>
              <option value="Reprimand is given">Reprimand is given</option>
              <option value="Presented a letter from the parent/guardian">Presented a letter from the parent/guardian</option>
              <option value="Incident/Violation is recorded as minor offense of same nature<">Incident/Violation is recorded as minor offense of same nature</option>
              <option value="Incident/Violation is recorded as minor offense of different nature">Incident/Violation is recorded as minor offense of different nature</option>
            </select><br>

          </div>

          <div class="modal-footer">
            <button type="submit" id="submitFeedback" class="btn btn-primary" data-dismiss="modal">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>-->



</body>

</html>
