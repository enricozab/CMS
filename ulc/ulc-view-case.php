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
  ?>

    <div id="wrapper">

    <?php include 'ulc-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
               <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
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

                    <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>

                    <br><br><br>

                    <?php
                    if((($row['PROCEEDING_DATE'] != null && date('Y-m-d H:i:s') > $row['PROCEEDING_DATE']) || $row['PROCEEDING_DECISION'] != null) and $row['REMARKS_ID'] != 16) {
                      if($row['PROCEEDING_ID'] == 3) { ?>
                        <div class="form-group" id="verdictarea">
                          <label>Verdict <span style="font-weight:normal; color:red;">*</span></label>
                          <div class="radio">
                              <label>
                                  <input type="radio" name="verdict" id="Guilty" value="Guilty" checked>Guilty &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="radio" name="verdict" id="NotGuilty" value="Not Guilty">Not Guilty
                              </label>
                          </div>
                        </div>

                        <br>
                      <?php }
                      ?>
                      <div class="form-group" id="finalpenaltyarea">
                        <label>Penalty <span style="color:red;">*</span></label>
                        <textarea id="finalpenalty" style="height: 100px;" class="form-control" placeholder="Enter Penalty"><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                      </div>
                    <?php }
                    ?>

                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">Related Cases</b>
                      </div>
                      <div class="panel-body" style="overflow-y: scroll; max-height: 100%;">
                        <ul style="list-style-type:none;">
                          <?php include 'ulc-related-case-queries.php';?>

                          <?php
                            if ($relatedres->num_rows > 0) {
                              while($relatedrow=mysqli_fetch_array($relatedres,MYSQLI_ASSOC)) {
                                echo "<li>
                                        <div style='margin-right: 20px; margin-left: -20px;'>
                                          <p>
                                              <strong>Case No. {$relatedrow['CASE_ID']}</strong>
                                              <span class='pull-right text-muted'><button type='submit' id='viewCase' name='return' class='btn btn-info'>View Case</button></span>
                                          </p>
                                          <div>
                                              <br>
                                              <p>Offense: <strong>{$relatedrow['OFFENSE_DESCRIPTION']}</strong></p>
                                              <p>Status: <strong>{$relatedrow['STATUS_DESCRIPTION']}</strong></p>
                                              <p>Proceedings: <strong>{$relatedrow['PROCEEDINGS']}</strong></p>
                                              <p>Penalty: <strong>{$relatedrow['PROCEEDING_DECISION']}</strong></p>
                                          </div>
                                        </div>
                                      </li>
                                      <hr style='margin-right: 20px; margin-left: -20px;'>";
                              }
                            }
                            else {
                              echo "<p style='margin-right: 20px; margin-left: -20px;'>No related closed cases available.</p>";
                            }
                          ?>
                        </ul>
                      </div>
                      <!-- .panel-body -->
                    </div>
                </div>
              </div>
			<br><br>
      <div class="row">
        <div class="col-lg-6">

        </div>
      </div>

      <br><br><br><br>

      <div class="row">
        <div class="col-sm-6">
          <button type="button" id="sign" class="btn btn-success" data-dismiss="modal">Sign Discipline Case Referral Form</button>

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

      <br><br><br>

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
        if($row2['IF_NEW']){
          $query2='UPDATE ULC_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }

        include 'ulc-notif-queries.php';
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
    <?php include 'ulc-notif-scripts.php' ?>

    /*$('#review').click(function() {
      $("#revModal").modal("show");
    });*/

    $('#sign').click(function() {
      if('<?php echo $row['CASE_DECISION']; ?>' == "File Case") {
        $.ajax({
            url: '../ajax/ulc-update-dcrf.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                other: $("#ulcRemarks").val()
            },
            success: function(msg) {
              $("#sign").attr('disabled', true);
              if(<?php echo $row['PROCEEDING_ID']; ?> == 3) {
                $('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for formal hearing.');
              }
              else if(<?php echo $row['PROCEEDING_ID']; ?> == 2) {
                $('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for summary proceeding.');
              }
              else {
                $('#message').text('Updated Discipline Case Referral Form has been submitted and sent to your email successfully! Check your email to sign the form and schedule for UPCC.');
              }

              $("#alertModal").modal("show");
            }
        });
      }
      else {
        $.ajax({
            url: '../ajax/ulc-return-to-sdfod.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                other: $("#ulcRemarks").val()
            },
            success: function(msg) {
              $('#message').text('Case returned to SDFO Director successfully for dismissal.');
              $("#sign").attr('disabled', true);

              $("#alertModal").modal("show");
            }
        });
      }
    });

    $('#modalOK').click(function() {
      location.reload();
    });

    $('#submit').click(function() {
      if(<?php echo $row['PROCEEDING_ID']; ?> == 3) {
        var verdict = $("input[name='verdict']:checked").val();
        if(verdict == "Not Guilty") {
          $.ajax({
              url: '../ajax/ulc-verdict.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  verdict: verdict
              },
              success: function(msg) {
                $('#message').text('Case returned to SDFO Directory successfully for final signature and dismissal.');
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
                  decision: $('#finalpenalty').val(),
                  verdict: verdict
              },
              success: function(msg) {
                $('#message').text('Case returned to SDFO Directory successfully for final signature and closing.');
                $("#submit").attr('disabled', true).text("Submitted");
                $("#finalpenalty").attr('readonly', true);
                $("input[type=radio]").attr('disabled', true);

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
                decision: $('#finalpenalty').val()
            },
            success: function(msg) {
              $('#message').text('Case returned to SDFO Directory successfully for final signature and closing.');
              $("#submit").attr('disabled', true).text("Submitted");
              $("#finalpenalty").attr('readonly', true);
              $("input[type=radio]").attr('disabled', true);

              $("#alertModal").modal("show");
            }
        });
      }
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

  });

  <?php
    if($row['PENALTY_DESC'] != null) { ?>
      $("#penaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] < 9){ ?>
      //$("#schedule").hide();
      //$("#endorse").hide();
  <?php }
    if($row['REMARKS_ID'] == 8 and $signrow['if_signed']){ ?>
      $("#sign").hide();
      //$("#schedule").show();
      $("#otherarea").hide();
  <?php }
    if($row['REMARKS_ID'] == 7 or $row['REMARKS_ID'] > 8){ ?>
      $("#sign").hide();
      //$("#schedule").hide();
      //$("#endorse").hide();
      $("#otherarea").hide();
  <?php }
    if($row['REMARKS_ID'] > 8) { ?>
      //$("#verdictarea").show();
      //$("#finalpenaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] > 9 and $row['REMARKS_ID'] != 15 and $row['REMARKS_ID'] != 16) { ?>
      $("#finalpenalty").attr('readonly',true);
      //$("#verdictarea").show();
      $("#<?php echo $row['VERDICT']; ?>").prop("checked", true);
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
        $("#<?php echo $row['VERDICT']; ?>").prop("checked", true);
      }
      $("input[type=radio]").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] == 13) { ?>
      $("#finalpenalty").attr('readonly',false);
      $("input[type=radio]").attr('disabled', false);
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

</body>

</html>

<style>
p{ margin: 0; }

</style>
