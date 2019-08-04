<?php include 'ulc.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/ulc/ulc-home.php");
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
    <script src="../gdrive/ulc-gdrive.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

    <script type="text/javascript">
      function viewEvidence (pass) {
        location.href='ulc-gdrive-case.php?pass='+pass;
      }

      function viewCase(id) {
        $.ajax({
          url: 'ulc-view-case-queries.php',
          type: 'POST',
          data: {
              caseID: id
          },
          success: function(response) {
            var vc = JSON.parse(response);
            $('#vccn').text('Case No. ' + vc.CASE_ID);
            $('#vco').text(vc.OFFENSE_DESCRIPTION);
            $('#vct').text(vc.TYPE);
            $('#vcli').text(vc.LOCATION);
            $('#vcdf').text(vc.DATE_FILED);
            $('#vclu').text(vc.LAST_UPDATE);
            $('#vcs').text(vc.STATUS_DESCRIPTION);
            $('#vcsid').text(vc.REPORTED_STUDENT_ID);
            $('#vcsn').text(vc.STUDENT);
            $('#vcc').text(vc.COMPLAINANT);
            $('#vci').text(vc.HANDLED_BY);
            $('#vcd').text(vc.DETAILS);
            $('#vcnd').text(vc.PROCEEDING);
            $('#vcv').text(vc.VERDICT);
            if($('#vcv').text() == "") {
              $('#va').hide();
            }
            if($('#vcprd').text() == "") {
              $('#prda').hide();
            }
            if($('#vcnd').text() == "") {
              $('#nda').hide();
            }
            $('#vcprd').text(vc.PROCEEDING_DECISION);

            var pass = vc.OFFICE_DESCRIPTION+"/"+vc.DEGREE+"/"+vc.LEVEL+"/"+vc.REPORTED_STUDENT_ID+"/VIEW-FOLDER/"+vc.CASE_ID;

            $('#btnViewEvidenceVC').attr("onclick","viewEvidence('"+pass+"')");

            $("#viewCaseModal").modal("show");
          }
        });
      };
    </script>
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
                        CRF.PROCEEDINGS AS PROCEEDING_ID,
                        CRF.CASE_DECISION AS CASE_DECISION,
                        CRF.ULC_OTHER_REMARKS AS ULC_OTHER_REMARKS,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
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
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else{
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
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

    $passData = $rowStud2['description'] . "/" . $rowStud2['degree'] . "/" . $rowStud2['level'] . "/" . $rowStud2['reported_student_id'] . "/" . "ULC-VIEW-CASE" . "/" . $_GET['cn'];
    $passCase = $rowStud2['description'] . "/" . $rowStud2['degree'] . "/" . $rowStud2['level'] . "/" . $rowStud2['reported_student_id'] . "/" . "VIEW-FOLDER" . "/" . $_GET['cn'];

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

    $refForm = 'SELECT *
                  FROM CASE_REFERRAL_FORMS
                 WHERE CASE_ID = "'.$_GET['cn'].'"';
    $resultRefForm = mysqli_query($dbc,$refForm);
    if(!$resultRefForm){
       echo mysqli_error($dbc);
    }
    else{
       $rowRefForm = mysqli_fetch_array($resultRefForm,MYSQLI_ASSOC);
   }
  ?>

    <div id="wrapper">

    <?php include 'ulc-sidebar.php';?>

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

                    <div class="form-group" id="penaltyarea" hidden>
                      <label>SDFO Director's Remarks</label>
                      <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
                    </div>

                    <?php
                      if($row['PROCEEDING'] != null) { ?>
                        <div class='form-group' id='proceedingarea'>
                          <label>Nature of Proceedings</label>
                          <textarea id='proceeding' name='proceeding' class='form-control' rows='3' readonly><?php echo $row['PROCEEDING']; ?>
                          </textarea>
                        </div>
                    <?php }
                    ?>

                    <div class="form-group" id="otherarea">
                      <label>Other Comments/Remarks</label>
                      <textarea id="ulcRemarks" style="height: 100px;" class="form-control" placeholder="Enter Comments/Remarks"><?php echo $row['ULC_OTHER_REMARKS']; ?></textarea>
                    </div>

                    <br>

                    <button type="submit" id="btnViewEvidence" name="evidence" onclick="viewEvidence('<?php echo $passCase; ?>')" class="btn btn-outline btn-primary">View evidence</button>

                    <br><br><br>

                    <?php
                    if((($row['PROCEEDING_DATE'] != null && date('Y-m-d H:i:s') > $row['PROCEEDING_DATE']) || $row['PROCEEDING_DECISION'] != null) and $row['REMARKS_ID'] != 16) {
                      if($row['PROCEEDING_ID'] == 3) { ?>
                        <div class="form-group" id="verdictarea">
                          <label>Verdict <span style="font-weight:normal; color:red;">*</span></label>
                          <div class="radio">
                              <label>
                                  <input type="radio" name="verdict" id="Guilty" value="Guilty">Guilty &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="radio" name="verdict" id="NotGuilty" value="Not Guilty">Not Guilty
                              </label>
                          </div>
                        </div>

                        <br>
                      <?php }
                      ?>
                      <?php
                        if($row['PROCEEDING_DECISION'] == null || $row['REMARKS_ID'] == 13) { ?>
                          <?php
                            $query2='SELECT PENALTY_ID, PENALTY_DESC FROM REF_PENALTIES WHERE PENALTY_ID >= 3 AND PENALTY_ID != 4';
                            $result2=mysqli_query($dbc,$query2);
                            if(!$result2){
                              echo mysqli_error($dbc);
                            } ?>

                            <?php include 'ulc-suggested-penalty-queries.php';?>

                            <div id="finpenaltyarea" class="form-group" hidden>
                              <?php
                                if($suggestrow['PROCEEDING_DECISION'] != null) { ?>
                                  <label>Suggested Penalty <span style="font-weight:normal; font-style:italic; font-size:12px;">(This will be disregarded if other penalty is selected.)</span></label>
                                  <input id="suggestedPD" class="form-control" value="<?php echo $suggestrow['PROCEEDING_DECISION']; ?>" readonly />
                                  <br>
                                  <label>Other(s) <span style="font-weight:normal; font-style:italic; font-size:12px;">(For corrective measures, choose 1 only. For formative interventions, choose 1 or more.)</span></label>
                              <?php }
                                else { ?>
                                  <label>Penalty <span style="font-weight:normal; font-style:italic; font-size:12px;">(For corrective measures, choose 1 only. For formative interventions, choose 1 or more.)</span> <span style="font-weight:normal; color:red;">*</span></label>
                              <?php }
                              ?>
                                <div class="row">
                                  <?php
                                  while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                                    if($row2['PENALTY_ID'] == 3) {
                                      echo "<div class='col-lg-8'>";
                                      echo "Formative Interventions<br>";
                                    }
                                    if($row2['PENALTY_ID'] == 8) {
                                      echo "<div class='col-lg-4'>";
                                      echo "Corrective Measures<br>";
                                    }
                                    echo "<label>
                                              <input type='checkbox' name='otherpens' value='{$row2['PENALTY_DESC']}'>&nbsp;&nbsp;&nbsp;{$row2['PENALTY_DESC']}
                                          </label>
                                          <br>";
                                    if($row2['PENALTY_ID'] == 7 || $row2['PENALTY_ID'] == 12) {
                                      echo "</div>";
                                    }
                                  }
                                  ?>
                                </div>
        				          </div>
                        <?php }
                          else { ?>
                            <label>Penalty</label>
                            <textarea id="finalpenalty" style="height: 100px;" class="form-control" placeholder="Enter Penalty"><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                        <?php }
                        ?>
                    <?php }
                    ?>

                    <br><br>

                    <div class="row">
                      <div class="col-sm-6">
                        <button type="submit" id="sign" class="btn btn-success" data-dismiss="modal">Sign Discipline Case Referral Form</button>

                        <?php
                          $signq = 'SELECT      *
                                    FROM        CASE_REFERRAL_FORMS CRF
                                    WHERE       CRF.CASE_ID = "'.$_GET['cn'].'"';
                          $signr = mysqli_query($dbc,$signq);
                          if(!$signr){
                            echo mysqli_error($dbc);
                          }
                          else{
                            $signrow=mysqli_fetch_array($signr,MYSQLI_ASSOC);
                          }
                        ?>

                        <?php
                          if($signrow['if_signed'] && !$signrow['if_uploaded'] && ($row['REMARKS_ID'] == 14 || $row['REMARKS_ID'] == 16)) { ?>
                            <button type="submit" id = "uploading" name="submit" class="btn btn-success" onclick="handle('<?php echo $passData;?>')">Upload Discipline Case Referral Form</button>
                        <?php }
                        ?>

                        <?php
                          if((($row['REMARKS_ID'] == 9 || $row['REMARKS_ID'] == 15) && date('Y-m-d H:i:s') > $row['PROCEEDING_DATE']) || $row['REMARKS_ID'] == 13) { ?>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                        <?php }
                          if($row['REMARKS_ID'] == 8 and $signrow['if_signed'] and $row['PROCEEDING_ID'] == 3){ ?>
                            <button type="button" id="schedule" class="btn btn-success"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule for Formal Hearing</button>
                        <?php }
                          if($row['REMARKS_ID'] == 8 and $signrow['if_signed'] and $row['PROCEEDING_ID'] == 2){ ?>
                            <button type="button" id="schedule" class="btn btn-success"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule for Summary Proceeding</button>
                        <?php }
                          if($row['REMARKS_ID'] == 8 and $signrow['if_signed'] and $row['PROCEEDING_ID'] == 1){ ?>
                            <button type="button" id="schedule" class="btn btn-success"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule for UPCC</button>
                        <?php }
                          if($row['REMARKS_ID'] == 12){ ?>
                            <button type="submit" id="endorse" name="endorse" class="btn btn-primary">Endorse to the President</button>
                        <?php }
                        ?>
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
                          <b style = "font-size: 17px;">Related Cases</b>
                      </div>
                      <div class="panel-body" style="overflow-y: scroll; max-height: 500px;">
                        <ul style="list-style-type:none;">
                          <div class="btn-group" style='margin-right: 20px; margin-left: -20px;'>
                            <button type="button" class="tableButton btn btn-default" id="relatedCases">All Related Cases</button>
                            <button type="button" class="tableButton btn btn-default" id="studentCases">Student's Previous Cases</button>
                          </div>
                          <style>
                              .tableButton {
                                width: 200px;
                              }
                              #relatedCases {border-radius: 3px 0px 0px 3px;}
                              #studentCases {border-radius: 0px 3px 3px 0px;}
                          </style>
                          <br><br>
                          <div id='related-cases-table'>
                          </div>
                        </ul>
                      </div>
                      <!-- .panel-body -->
                    </div>
                </div>
              </div>
			

      <br><br><br><br><br>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		ULC.CASE_ID AS CASE_ID,
                          ULC.IF_NEW AS IF_NEW
              FROM 		    ULC_CASES ULC
              WHERE   	  ULC.CASE_ID = "'.$_GET['cn'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if($row2['IF_NEW'] == 1){
          $query2='UPDATE ULC_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }
      ?>
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
  $(document).ready(function() {
    loadNotif();
    
    var upload = "dl"; 

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

    /*$('#review').click(function() {
      $("#revModal").modal("show");
    });*/

    $('#relatedCases').css("background-color", "#e6e6e6");

    defaultTable();

    function defaultTable() {
      $.ajax({
        url: '../ajax/ulc-related-cases-others.php',
        type: 'POST',
        data: {
          cn: <?php echo $_GET['cn'] ?>,
          offenseID: <?php echo $row['OFFENSE_ID']; ?>
        },
        success: function(response) {
          $('#related-cases-table').html(response);
        }
      });
    }

    $('#studentCases').on('click', function () {
      $('#studentCases').focus();
      $('#studentCases').css("background-color", "#e6e6e6");
      $('#relatedCases').css("background-color", "white");

      $.ajax({
        url: '../ajax/ulc-related-cases-student.php',
        type: 'POST',
        data: {
          studentID: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
          cn: <?php echo $_GET['cn'] ?>
        },
        success: function(response) {
          $('#related-cases-table').html(response);
        }
      });
    });

    $('#relatedCases').on('click', function () {
      $('#relatedCases').focus();
      $('#relatedCases').css("background-color", "#e6e6e6");
      $('#studentCases').css("background-color", "white");
      
      defaultTable();
    });

    $('#sign').click(function() {

      if('<?php echo $row['CASE_DECISION']; ?>' == "File Case") {
        $.ajax({
          //../ajax/ulc-update-dcrf.php
            url: '../ajax/ulc-update-dcrf.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                other: $("#ulcRemarks").val()
            },
            success: function(msg) {
              <?php
              if($row['PROCEEDING_ID'] != null) { ?>
                $("#sign").attr('disabled', true);
                if(<?php echo $row['PROCEEDING_ID']; ?> == 3) {
                  //$('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for formal hearing.');
                  $('#upcc').hide();
                  $('#sumProceeding').hide();
                  $('#dismiss').hide();
                }
                else if(<?php echo $row['PROCEEDING_ID']; ?> == 2) {
                  //$('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for summary proceeding.');
                  $('#upcc').hide();
                  $('#hear').hide();
                  $('#dismiss').hide();
                }
                else {
                  //$('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for UPCC.');
                  $('#hear').hide();
                  $('#sumProceeding').hide();
                  $('#dismiss').hide();
                }
              <?php }
              ?>

              $("#newFormModal").modal("show");
            }
        });
      }
      else {
        $.ajax({
          //../ajax/ulc-return-to-sdfod.php
            url: '../ajax/ulc-return-to-sdfod.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                other: $("#ulcRemarks").val()
            },
            success: function(msg) {
              $('#message').text('Case returned to SDFO Director successfully for dismissal.');
              $("#sign").attr('disabled', true);
              $('#hear').hide();
              $('#sumProceeding').hide();
              $('#upcc').hide();

              $("#newFormModal").modal("show");
            }
        });
      }
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

        <?php
        $crfq='SELECT * FROM case_referral_forms
                WHERE CASE_ID = '.$_GET['cn'];
        $crfres=mysqli_query($dbc,$crfq);
        if(!$crfres){
          echo mysqli_error($dbc);
        }
        else{
          $crfrow = mysqli_fetch_array($crfres,MYSQLI_ASSOC);
        }
         ?>

         var admission;
         <?php
         if($row['PROCEEDING_ID'] != null) { ?>
           if(<?php echo $crfrow['proceedings']; ?> == 1){
             admission = "University Panel for Case Conference";
           }
           else if(<?php echo $crfrow['proceedings']; ?> == 2){
             admission = "Summary Proceedings";
           }
           else {
             admission = "Formal Hearing";
           }
         <?php }
         else { ?>
           admision = "N/A";
         <?php }
         ?>


        doc.setData({

          date: today,
          casenum: <?php echo $_GET['cn']; ?>,
          name: "<?php echo $row['STUDENT']; ?>",
          idn: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
          college: "<?php echo $CollegeQRow['description']; ?>",
          degree: "<?php echo $CollegeQRow['degree']; ?>",
          violation: "<?php echo $row['OFFENSE_DESCRIPTION']; ?>",
          complainant: "<?php echo $row['COMPLAINANT']; ?>",
          nature: admission,
          decision: "<?php echo $crfrow['case_decision']; ?>",
          reason: "<?php echo $crfrow['reason']; ?>",
          remark: "<?php echo $crfrow['aulc_remarks']; ?>",
          changes: "<?php echo $crfrow['change_offense']; ?>",
          others: $('#ulcRemarks').val()


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
    });

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    function submitCase() {
      var ids = [];
      var remarks = [];
      $.each($("input[name='otherpens']:checked"), function(){
          remarks.push($(this).val());
      });

      var isEmpty = true;

      if($('#verdictarea').is(":visible")){
        ids.push('input[name="verdict"]:checked');
      }
      else{
        if($.inArray('input[name="verdict"]:checked', ids) !== -1){
          ids.splice(ids.indexOf('input[name="verdict"]:checked'),1);
        }
      }

      for(var i = 0; i < ids.length; ++i ){
        if($.trim($(ids[i]).val()).length == 0){
          isEmpty = false;
        }
      }

      if($('#finpenaltyarea').is(":visible")){
        if(remarks.length == 0 && $('#suggestedPD').val() == null) {
          isEmpty = false;
        }
      }

      if(isEmpty) {
        var penalty;
        if(remarks.length > 0) {
          penalty = remarks;
        }
        else {
          penalty = $('#suggestedPD').val();
        }

        <?php
        if($row['PROCEEDING_ID'] != null) { ?>
          if(<?php echo $row['PROCEEDING_ID']; ?> == 3) {
            var verdict = $("input[name='verdict']:checked").val();
            if(verdict == "Not Guilty") {
              $.ajax({
                  url: '../ajax/ulc-verdict.php',
                  type: 'POST',
                  data: {
                      caseID: <?php echo $_GET['cn']; ?>,
                      verdict: verdict,
                      remarks: <?php echo $row['REMARKS_ID']; ?>
                  },
                  success: function(msg) {
                    if(<?php echo $row['REMARKS_ID']; ?> == 13) {
                      $('#message').text('Case closed.');
                    }
                    else {
                      $('#message').text('Case returned to SDFO Directory successfully for final signature and dismissal. Upload Discipline Case Referral Form on this page using your DLSU email account');
                    }
                    $("#submit").attr('disabled', true).text("Submitted");
                    $("#finalpenalty").attr('readonly', true);
                    $("input[type=radio]").attr('disabled', true);

                    $("#alertModal").modal("show");
                  }
              });
            }
            else {
              $.ajax({
                  url: '../ajax/ulc-verdict.php',
                  type: 'POST',
                  data: {
                      caseID: <?php echo $_GET['cn']; ?>,
                      decision: penalty,
                      verdict: verdict,
                      remarks: <?php echo $row['REMARKS_ID']; ?>
                  },
                  success: function(msg) {
                    if(<?php echo $row['REMARKS_ID']; ?> == 13) {
                      $('#message').text('Case closed.');
                    }
                    else {
                      $('#message').text('Case returned to SDFO Directory successfully for final signature and dismissal. Upload Discipline Case Referral Form on this page using your DLSU email account');
                    }
                    $("#submit").attr('disabled', true).text("Submitted");
                    $("#finalpenalty").attr('readonly', true);
                    $("input[type=radio]").attr('disabled', true);
                    $("input[name='otherpens']").attr('disabled', true);

                    $("#alertModal").modal("show");
                  }
              });
            }
          }
          else {
            $.ajax({
                url: '../ajax/ulc-verdict.php',
                type: 'POST',
                data: {
                    caseID: <?php echo $_GET['cn']; ?>,
                    decision: penalty,
                    remarks: <?php echo $row['REMARKS_ID']; ?>
                },
                success: function(msg) {
                  $('#message').text('Case returned to SDFO Directory successfully for final signature and closing.');
                  $("#submit").attr('disabled', true).text("Submitted");
                  $("#finalpenalty").attr('readonly', true);
                  $("input[type=radio]").attr('disabled', true);
                  $("input[name='otherpens']").attr('disabled', true);

                  $("#alertModal").modal("show");
                }
            });
          }
        <?php }
        ?>
      }
      else {
        $("#alertModal").modal("show");
      }
    }

    $('#modalOK').click(function() {
      location.reload();
    }); 

    $('#successOK').click(function() {
      if (upload == "dl") {
        submitCase();
      }
    });

    $('input[name="verdict"]').click(function(){
      if ($(this).val() == "Guilty") {
        $('#finpenaltyarea').show();
      }
      else {
        $('#finpenaltyarea').hide();
      }
    });

    if("<?php echo $row['VERDICT']; ?>" == "Guilty") {
      $('#finpenaltyarea').show();
    }

    $('#submit').click(function() {
      $("#decisionModal").modal('show');
    });

    $('#decisionUpload').click(function() {
      $("#waitModal").modal("show");

      var data = "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>" + "|";
      btnSubmit(data);
    });

    $('#endorse').click(function() {
      $.ajax({
          url: '../ajax/ulc-endorse-to-president.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
            $('#message').text('Case is endorsed to the President.');
            $("#endorse").hide();
            $("#submit").show();
            $("#penalty").attr('readonly', false);
            $("input[type=radio]").attr('disabled', false);

            $("#alertModal").modal("show");
          }
      });
    });

    $('#schedule').on('click', function() {
      <?php $_SESSION['caseID']=$_GET['cn']; ?>
      location.href='ulc-calendar.php';
    });

    $('#uploading').click(function() {
      upload = "dcrf";
      $("#uploadB").text("Upload Discipline Case Referral Form");
      $("#uploadP").text("Please upload the Discipline Case Referral Form.");

      $("#waitModal").modal("show");
    });

    $('#n1').on('click', function() {
      //HELLOSIGN API
      $.ajax({
        url: '../ajax/users-hellosign.php',
        type: 'POST',
        data: {
            formT : "Discipline Case Referral Form.docx",
            title : "Discipline Case Referral Form",
            subject : "Discipline Case Referral Form Document Signature",
            message : "Please do sign this document.",
            fname : "Mike",
            lname : "David",
            email : "ulc.cms2@gmail.com",
            filename : $('#inputfile').val()
          },
          success: function(response) {
            location.reload();
          }
      });
      //HELLOSIGN API
    });

    $('#fileUpload').click(function() {
      var data = "<?php echo $row['OFFENSE_DESCRIPTION']; ?>" + "|" + "<?php echo $row['TYPE']; ?>";
      btnSubmit(data);
    });

    $('#logBtn').on('click',function() {
      $("#waitModal").modal("show");
    });

    $('#successModal').on('click', function() {
      if (upload == "dcrf") {
        $.ajax({
          url: '../ajax/ulc-update-referral.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
          }
        });
      }
    });

    if($('#schedule').is(':visible')) {
      $('#sign').hide();
    }

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

    $('#btnViewEvidence').click(function() {
      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'ULC Case - Viewed Evidence for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
    });

    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'ULC Viewed Case - Viewed Cases'
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
                actiondone: 'ULC Viewed Case - Viewed Files'
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
                actiondone: 'ULC Viewed Case - Viewed Calendar'
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
                actiondone: 'ULC Viewed Case - Viewed Inbox'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });

  });

  <?php
    if($row['PENALTY_DESC'] != null) { ?>
      $("#penaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] != 8 and $signrow['if_signed']){ ?>
      $("#sign").hide();
      //$("#schedule").show();
      $("#otherarea").hide();
  <?php }
    if($row['REMARKS_ID'] > 9 and $row['REMARKS_ID'] != 15 and $row['REMARKS_ID'] != 16) { ?>
      $("#finalpenalty").attr('readonly',true);
      //$("#verdictarea").show();
      <?php
      if($row['VERDICT'] != null) { ?>
        $("#<?php echo $row['VERDICT']; ?>").prop("checked", true);
      <?php }
      ?>
      $("input[type=radio]").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] == 12) { ?>
      //$("#endorse").show();
  <?php }
    if($row['PROCEEDING_DECISION'] != null) { ?>
      //$("#finalpenaltyarea").show();
      $("#finalpenalty").attr('readonly',true);
      //$("#verdictarea").show();
      if('<?php echo $row['VERDICT']; ?>' == "Not Guilty") {
        $("#NotGuilty").prop("checked", true);
      }
      else{
        <?php
        if($row['VERDICT'] != null) { ?>
          $("#<?php echo $row['VERDICT']; ?>").prop("checked", true);
        <?php }
        ?>
      }
      $("input[type=radio]").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] == 13) { ?>
      $("#finalpenalty").attr('readonly',false);
      $("input[type=radio]").attr('disabled', false);
  <?php }
    if($row['REMARKS_ID'] == 15 && $row['PROCEEDING_ID'] == 2) { ?>
      $("#finpenaltyarea").show();
  <?php }
  ?>
  <?php
    if($rowRefForm['if_uploaded'] == 2){ ?>
      $("#uploading").show();
  <?php }
  ?>

  </script>

  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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

  <!-- View Case Modal -->
  <div class="modal fade" id="viewCaseModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b id="vccn"></b></h4>
        </div>
        <div class="modal-body" style="max-height: 500px; overflow-y: scroll;">
          <b>Offense:</b> <span id="vco"></span><br>
          <b>Type:</b> <span id="vct"></span><br>
          <b>Location of the Incident:</b> <span id="vcli"></span><br>
          <b>Date Filed:</b> <span id="vcdf"></span><br>
          <b>Last Update:</b> <span id="vclu"></span><br>
          <b>Status:</b> <span id="vcs"></span><br>
          <br>
          <b>Student ID No.:</b> <span id="vcsid"></span><br>
          <b>Student Name:</b> <span id="vcsn"></span><br>
          <br>
          <b>Complainant:</b> <span id="vcc"></span><br>
          <b>Investigated by:</b> <span id="vci"></span><br>
          <br>
          <br>
          <div class="form-group">
            <label>Summary of the Incident</label>
            <textarea id="vcd" name="details" class="form-control" readonly></textarea>
          </div>
          <div class="form-group" id="nda">
            <label>Nature of Proceeding</label>
            <textarea id="vcnd" name="details" class="form-control" readonly></textarea>
          </div>
          <div class="form-group" id="va">
            <label>Verdict</label>
            <textarea id="vcv" name="details" class="form-control" readonly></textarea>
          </div>
          <div class="form-group" id="prda">
            <label>Penalty</label>
            <textarea id="vcprd" name="details" class="form-control" readonly></textarea>
          </div>
          <br>
          <button type="submit" id="btnViewEvidenceVC" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
          <br><br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
          <p style id="hear">The Discipline Case Referral Form has been updated and sent to your email successfully! <br><br> <b>Next Steps: </b> <br>  <b>(1)</b> Check your email to sign the form. <br>  <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Schedule Formal Hearing date. </p>
          <p style id="sumProceeding">The Discipline Case Referral Form has been updated and sent to your email successfully! <br><br> <b>Next Steps: </b> <br>  <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Schedule Summary Proceeding date. </p>
          <p style id="upcc">The Discipline Case Referral Form has been updated and sent to your email successfully! <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Schedule UPCC date. </p>
          <p style id="dismiss">Case returned to SDFO Director successfully for dismissal. <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Download the form after signing. <br> <b>(3)</b> Upload Discipline Case Referral Form on this page using your DLSU email account. </p>
        </div>
        <div class="modal-footer">
          <button type="button" id="n1" class="btn btn-default" data-dismiss="modal">Ok</button>
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
          <h4 class="modal-title"><b id="uploadB">Upload Decision Letter</b></h4>
        </div>
        <div class="modal-body">
          <p id="uploadP"> Please upload the letter to authenticate the case decision. </p>
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

  <!-- Upload Modal -->
  <div class="modal fade" id="decisionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Upload Decision Letter</b></h4>
        </div>
        <div class="modal-body">
        <p> Please authenticate the use of Google Drive. </p>
        </div>
        <div class="modal-footer">
          <input type="file" id="fUpload" class="hide"/>
          <button type="button" id = "logBtn" class="btn btn-primary" data-dismiss="modal" onclick="handle('<?php echo $passData;?>')">Log In</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<style>
p{ margin: 0; }

</style>
