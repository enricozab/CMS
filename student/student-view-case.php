<?php include 'student.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/student/student-home.php");
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

    <!-- FOR SEARCHABLE DROP -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
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
                        C.IF_APPEAL AS IF_APPEAL,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW,
                        DATEDIFF(CURRENT_TIMESTAMP(),C.DATE_CLOSED) AS CAN_APPEAL
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

    $queryForm = 'SELECT 		*
                    FROM		STUDENT_RESPONSE_FORMS S
                    JOIN    CASES C ON C.CASE_ID = S.CASE_ID
                    join    REF_ADMISSION_TYPE RA ON RA.ADMISSION_TYPE_ID = C.ADMISSION_TYPE_ID
                   WHERE		C.CASE_ID = "'.$_GET['cn'].'"';
    $resultForm = mysqli_query($dbc,$queryForm);

    if(!$resultForm) {
       echo mysqli_error($dbc);
    }

    else {
       $rowForm = mysqli_fetch_array($resultForm,MYSQLI_ASSOC);
    }
  ?>

  <div id="wrapper">

    <?php include 'student-sidebar.php';?>
        
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
                  
                  <br><br>

                  <div class="form-group">
                    <label>Summary of the Incident</label>
                    <textarea id="details" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
                  </div>

                  <div class="form-group" id="commentarea" hidden>
                    <label>Comment</label>
                    <textarea id="comment" name="comment" class="form-control" rows="3" readonly><?php echo $row['COMMENT']; ?></textarea>
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
                  <br><br><br>
                  <?php
                    if(($row['TYPE'] == "Major" || $row['PROCEEDING_DATE'] != null) && $row['VERDICT'] == "Guilty" && $row['REMARKS_ID'] == 11) {
                      echo '<button type="submit" id="appeal" name="appeal" class="btn btn-warning">Appeal</button><br>';
                    }
                  ?>
                  <?php
                    if($row['REMARKS_ID'] == 17) {
                      echo '<button type="submit" id="downloadAS" name="downloadAS" class="btn btn-success">Download Academic Service Form</button><br>';
                    }
                  ?>
                  <button type="submit" id="form" name="form" class="btn btn-success">Send Student Response Letter</button>
                  <br><br><br>

                  <?php
                    //Removes 'new' badge and reduces notif's count
                    $query2='SELECT 		SC.CASE_ID AS CASE_ID,
                                        SC.IF_NEW AS IF_NEW
                            FROM 		    STUDENT_CASES SC
                            WHERE   	  SC.USER_ID = "'.$_SESSION['user_id'].'" AND SC.CASE_ID = "'.$_GET['cn'].'"';
                    $result2=mysqli_query($dbc,$query2);
                    if(!$result2){
                      echo mysqli_error($dbc);
                    }
                    else{
                      $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
                      if($row2['IF_NEW'] == 1){
                        $query2='UPDATE STUDENT_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
                        $result2=mysqli_query($dbc,$query2);
                        if(!$result2){
                          echo mysqli_error($dbc);
                        }
                      }
                    }
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
                  <br>
                  <!-- FAQ -->
                  <div class="panel panel-default">
                      <!-- .panel-heading -->
                      <div class="panel-heading">
                        <b style="color: black; font-size: 17px;">FAQ</b>
                       </div>
                      <div class="panel-body">
                          <div class="panel-group" id="accordion">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Possible Evidence</a>
                                      </h4>
                                  </div>
                                  <div id="collapseOne" class="panel-collapse collapse">
                                      <div class="panel-body">
                                          <?php
                                              $ctr=0;
                                              $evidenceQuery= "SELECT * FROM CMS.REF_EVIDENCE_TYPE RET
                                                                WHERE RET.offense_id = " . $row['OFFENSE_ID'];
                                              $evidenceRes = $dbc->query($evidenceQuery);

                                              if ($evidenceRes->num_rows > 0) {
                                                echo 
                                                  '<div class="table-responsive">
                                                  <table class="table table-striped table-bordered table-hover">
                                                  <thead>
                                                  <tr>
                                                    <th style="text-align: center;">Offense</th>
                                                    <th style="text-align: center;">Type of Evidence</th> 
                                                  </tr>
                                                  </thead>
                                                  <tbody>';

                                                while($evidence = $evidenceRes->fetch_assoc()){
                                                  echo 
                                                    '<tr> ';

                                                      if($ctr==0){
                                                        echo '<td>' . $row['OFFENSE_DESCRIPTION'] . '</td>';
                                                        $ctr = $ctr+1;
                                                      }
                                                      else{
                                                        echo '<td></td>';
                                                      }
                                                  echo
                                                      '<td>' . $evidence['evidence_type_desc'] . '</td>
                                                    </tr>';
                                                }
                                                echo '</tbody>
                                                      </table>
                                                      </div>';
                                              }
                                              else{
                                                echo 'No available evidence suggestions';
                                              }
                                          ?>
                                      </div>
                                  </div>
                              </div>

                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Possible Interview Questions</a>
                                      </h4>
                                  </div>
                                  <div id="collapseTwo" class="panel-collapse collapse">
                                      <div class="panel-body">
                                        <?php
                                          $interviewQuery= "SELECT * FROM cms.interview_faq;";
                                          $interviewRes = $dbc->query($interviewQuery);
                                          if ($interviewRes->num_rows > 0) {
                                            echo 
                                              '<div class="table-responsive">
                                              <table class="table table-striped table-bordered table-hover">
                                              <tbody>';
                                            while($questions = $interviewRes->fetch_assoc())
                                              echo 
                                                '<tr>
                                                <td>' . $questions['question_desc'] .'</td>
                                                </tr>';
                                            echo 
                                              '</tbody>
                                              </table>
                                              </div>';
                                          }
                                          else{
                                            echo 'No available interview questions';
                                          }
                                        ?> 
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- .panel-body -->
                  </div>
                  <!-- /.panel -->
                  <!-- /.FAQ -->
              </div>
              <!-- /.col-lg-6 -->

              <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

          </div>
          <br><br><br><br><br>
      </div>
  </div>
  <!-- /#wrapper -->

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

  <!-- Form Generation -->
  <script src="../form-generation/docxtemplater.js"></script>
  <script src="../form-generation/jszip.js"></script>
  <script src="../form-generation/FileSaver.js"></script>
  <script src="../form-generation/jszip-utils.js"></script>

  <script>
  $(document).ready(function() {
    loadNotif();

    var form = "submitForm";

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
    
    var titleForm;

    //response form
    $("#form").click(function(){
      var remark = <?php echo $row['REMARKS_ID']; ?>;
      var stat = <?php echo $row['STATUS_ID']; ?>;

      if (remark == 4) {

        $("#formModalDetails").modal("show");
      }

      else {
        $("#formModal").modal("show");
        //$("#parentModal").modal("show");
        //parentLetter();

      }
    });

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    <?php include "student-form-queries.php" ?>

    <?php
      $countq = 'SELECT 		COUNT(C.CASE_ID) AS CASE_COUNT
                  FROM		  CASES C
                  LEFT JOIN	USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                  LEFT JOIN	REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
                  WHERE		  U.USER_ID = "'.$_SESSION['user_id'].'"
                  AND       RO.TYPE = "'.$row['TYPE'].'" AND C.DATE_FILED <= "'.$row['DATE_FILED'].'"';
      $countres = mysqli_query($dbc,$countq);
      if(!$countres){
        echo mysqli_error($dbc);
      }
      else{
        $countrow = mysqli_fetch_array($countres,MYSQLI_ASSOC);
      }
    ?>

    $("#submitFormAgain").click(function(){
        var ids = ['#schoolyr2','#term2','#letter2','#admissionType2'];
        var isEmpty = true;

        for(var i = 0; i < ids.length; ++i ) {
          if($.trim($(ids[i]).val()).length == 0) {
            isEmpty = false;
          }
        }

        if(isEmpty) {
          form = "submitFormAgain";
          $("#twoFactorModal").modal('show');
        }
        else {
          $("#alertModal").modal("show");
        }
    });

    $("#modalYes").click(function(){
      if (form == "submitForm") {
        $.ajax({
          url: '../ajax/student-submit-forms.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              remarks: <?php echo $row['REMARKS_ID']; ?>,
              admission: document.getElementById("admissionType").value,
              term: document.getElementById("term").value,
              schoolyr: document.getElementById("schoolyr").value,
              response: document.getElementById("letter").value
          },
          success: function(msg) {
            // audit trail
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'Student Case - Accomplished Student Response Form for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
              })

              $("#evidencediv").hide();
              $("#form").attr("disabled", true);

              loadFile("../templates/template-student-reponse-form.docx",function(error,content){

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

              var formNumber;
              <?php
              if ($formres['MAX'] != null) { ?>
                formNumber = <?php echo $formres['MAX'] ?>;
              <?php }
              else { ?>
                formNumber = 1;
              <?php }
              ?>

              titleForm = "Student Response Form #" + formNumber + ".docx";

              doc.setData({
                <?php
                if ($formres2['student_response_form_id'] != null) { ?>
                  formNum: <?php echo $formres2['student_response_form_id'] ?>,
                <?php }
                else {
                  if ($formres['MAX'] != null) { ?>
                    formNum: <?php echo $formres['MAX'] ?>,
                  <?php }
                  else { ?>
                    formNum: 1,
                  <?php }
                }
                ?>
                firstIDO: "<?php echo $idores['first_name'] ?>",
                lastIDO: "<?php echo $idores['last_name'] ?>",
                firstComplainant: "<?php echo $nameres['first_name'] ?>",
                lastComplainant: "<?php echo $nameres['last_name'] ?>",
                nature: "<?php echo $caseres['description'] ?>",
                section: '2.1??',
                date: today,
                dateApp: "<?php echo $caseres['date_filed'] ?>",
                term: document.getElementById("term").value,
                year: document.getElementById("schoolyr").value,
                admission: document.getElementById("admissionType").value,
                letter: document.getElementById("letter").value,
                firstStudent: "<?php echo $caseres['first_name'] ?>",
                lastStudent: "<?php echo $caseres['last_name'] ?>",
                yearLvl: "<?php echo $studentres['year_level'] ?>",
                idn: "<?php echo $nameres['user_id'] ?>",
                college: "<?php echo $nameres['description'] ?>",
                degree: "<?php echo $studentres['degree'] ?>"

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
              saveAs(out,titleForm);

              });
              // $('#message').text('Student Response Form has been submitted and sent to your email successfully! Check your email to sign the form.');
              $('#message').text('form');

              <?php
                if($countrow['CASE_COUNT'] > 1) { ?>
                  $("#parentModal").modal("show");
              <?php }
                else { ?>
                  //$("#alertModal").modal("show");
                  //$('#appealMsg').show();
                  $("#newFormModal").modal("show");
              <?php }
              ?>
          }
        });
      }
      else if (form == "submitFormAgain") {
        $.ajax({
          url: '../ajax/student-submit-forms.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              remarks: <?php echo $row['REMARKS_ID']; ?>,
              admission: document.getElementById("admissionType2").value,
              term: document.getElementById("term2").value,
              schoolyr: document.getElementById("schoolyr2").value,
              response: document.getElementById("letter2").value
          },
          success: function(msg) {
              $("#evidencediv").hide();
              $("#form").attr("disabled", true);

              loadFile("../templates/template-student-reponse-form.docx",function(error,content){
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

                var formNumber;
                <?php
                if ($formres['MAX'] != null) { ?>
                  formNumber = <?php echo $formres['MAX'] ?>;
                <?php }
                else { ?>
                  formNumber = 1;
                <?php }
                ?>

                titleForm = "Student Response Form #" + formNumber + ".docx";

                doc.setData({
                  <?php
                  if ($formres2['student_response_form_id'] != null) { ?>
                    formNum: <?php echo $formres2['student_response_form_id'] ?>,
                  <?php }
                  else { ?>
                    formNum: 1,
                  <?php } ?>
                  firstIDO: "<?php echo $idores['first_name'] ?>",
                  lastIDO: "<?php echo $idores['last_name'] ?>",
                  firstComplainant: "<?php echo $nameres['first_name'] ?>",
                  lastComplainant: "<?php echo $nameres['last_name'] ?>",
                  nature: "<?php echo $caseres['description'] ?>",
                  section: '2.1??',
                  date: today,
                  dateApp: "<?php echo $caseres['date_filed'] ?>",
                  term: document.getElementById("term2").value,
                  year: document.getElementById("schoolyr2").value,
                  admission: document.getElementById("admissionType2").value,
                  letter: document.getElementById("letter2").value,
                  firstStudent: "<?php echo $caseres['first_name'] ?>",
                  lastStudent: "<?php echo $caseres['last_name'] ?>",
                  yearLvl: "<?php echo $studentres['year_level'] ?>",
                  idn: "<?php echo $nameres['user_id'] ?>",
                  college: "<?php echo $nameres['description'] ?>",
                  degree: "<?php echo $studentres['degree'] ?>"

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
                saveAs(out,titleForm);

              });
              $('#message').text('form');
              //$('#message').text('Student Response Form has been submitted and sent to your email successfully! Check your email to sign the form.');
              $("#newFormModal").modal("show");
          }
        });
      }
    });

    $("#modalNo").click(function(){
      if (form == "submitForm") {
        $('#formModal').modal('show');
      }
      else if (form == "submitFormAgain") {
        $('#formModalDetails').modal('show');
      }
    });

    // function sendStudResponseFirst() {
    //   $.ajax({
    //       url: '../ajax/users-hellosign.php',
    //       type: 'POST',
    //       data: {
    //           formT: titleForm,
    //           title : "Student Response Form",
    //           subject : "Student Response Form Document Signature",
    //           message : "Please do sign this document.",
    //                     fname : "<?php echo $nameres['first_name'] ?>",
    //           lname : "<?php echo $nameres['last_name'] ?>",
    //           email : "<?php echo $nameres['email'] ?>",
    //           filename : $('#inputfile').val()
    //       },
    //       success: function(response) {
    //         parentLetter();
    //         //$("#message").text('Student Response Form and Parent Letter have been submitted and sent to your email successfully! Check your email to sign the forms.');
    //         //$("#alertModal").modal("show");
    //         $("#message").text('forms');
    //         $('#waitModal').modal('hide');
    //       }
    //   });
    // }

    function parentLetter() {
      loadFile("../templates/template-parent-letter.docx",function(error,content){

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
          idn: "<?php echo $nameres['user_id'] ?>",
          firstName: "<?php echo $nameres['first_name'] ?>",
          lastName: "<?php echo $nameres['last_name'] ?>",
          course: "<?php echo $studentres['degree'] ?>",
          college: "<?php echo $nameres['description'] ?>",
          frequency: <?php echo $countrow['CASE_COUNT'] ?>,
          type: "<?php echo $caseres['type'] ?>",
          nature: "<?php echo $caseres['description'] ?>",
          guardian: "<?php echo $studentres['guardian_name'] ?>",
          contact: "<?php echo $studentres['guardian_contact'] ?>",
          address: "<?php echo $studentres['address'] ?>"
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
        saveAs(out,"Parent Letter.docx");
        $("#newFormsModal").modal("show");
      });
    }

    $("#submitParent").click(function(){
      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'SDFOD Case - Parent Letter Sent for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
              })
      parentLetter();
      
      // $('#waitModal').modal('show');
    });

    $('#form1').on('click', function() {
      $('#form').attr('disabled',true);
      location.reload();
    });

    $('#form2').on('click', function() {
      $.ajax({
        url: '../ajax/users-hellosign.php',
        type: 'POST',
        data: {
            formT: "Parent Letter.docx",
  					title : "Parent Letter",
  					subject : "Parent Letter Document Signature",
  					message : "Please do sign this document.",
					  name : "enrico_zabayle@dlsu.edu.ph",
  					email : "enrico_zabayle@dlsu.edu.ph",
  					filename : $('#inputfile').val(),
            caseID : <?php echo $_GET['cn']; ?>
        },
        success: function(response) {
          <!-- <?php echo $studentres['guardian_email'] ?> -->
          $("#form").attr('disabled',true);
          location.reload();
				}
  		});
    });

    $("#appendevidence").click(function(){
      $("#evidencelist").append('<div class="form-group input-group" id="newsevidence">'+
      '<span id="removeevidence" style="cursor: pointer; color:red; float: right;"><b>&nbsp;&nbsp; x</b></span>'+
      '<input type="file">'+
      '</div>');
    });

    $('#submitForm').on('click', function() {
      var ids = ['#schoolyr','#term','#letter','#admissionType'];
      var isEmpty = true;

      for(var i = 0; i < ids.length; ++i ) {
        if($.trim($(ids[i]).val()).length == 0) {
          isEmpty = false;
        }
      }

      if(isEmpty){
        form = "submitForm";
        $("#twoFactorModal").modal('show');
      }
      else{
        $("#alertModal").modal("show");
      }
    });

    $(document).on('click', '#removeevidence', function(){
      $(this).closest("#newsevidence").remove();
    });

    $('#appeal').click(function() {
      $.ajax({
          url: '../ajax/student-appeal.php',
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
                    actiondone: 'SDFOD Case - Appeal made for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
              })

              $('#message').text('An appeal has been sent to ULC successfully!');
              $("#appeal").attr('disabled', true);
              $("#alertModal").modal("show");
              //$("#alertModal").modal("show");
          }
      });
    });

    $('#admissionType').on('change', function() {
      var option = $("option:selected", this);
      if(this.value == "1") {
        $('#letterlabel').text("Please write an apology and admission letter");
      }
      else if(this.value == "2") {
        $('#letterlabel').text("Please write an apology and explanation letter");
      }
      else if(this.value == "3") {
        $('#letterlabel').text("Please write an explanation");
      }
      $('#letterarea').show();
    });

    $('#admissionType2').on('change', function() {
      var option = $("option:selected", this);
      if(this.value == "1") {
        $('#letterlabel2').text("Please write an apology and admission letter");
      }
      else if(this.value == "2") {
        $('#letterlabel2').text("Please write an apology and explanation letter");
      }
      else if(this.value == "3") {
        $('#letterlabel2').text("Please write an explanation");
      }
    });

    $('#downloadAS').on('click', function() {
      loadFile("../templates/template-academic-service-form.docx",function(error,content){

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

        var formNumber;
        <?php
        if ($formres['MAX'] != null) { ?>
          formNumber = <?php echo $formres['MAX'] ?>;
        <?php }
        else { ?>
          formNumber = 1;
        <?php }
        ?>

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
        saveAs(out, "Academic Service Form.docx");
        $('#myModalLabel1').text('Academic Service');
        $('#message').text("Academic Service Form has been downloaded. Please proceed to your respective College Department Secretary for further instructions.");
        $('#downloadAS').attr('disabled', true);
        $('#alertModal').modal("show");
      });
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
                actiondone: 'Student Viewed Case - Viewed Cases'
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
                actiondone: 'Student Viewed Case - Viewed Inbox'
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
                actiondone: 'Student Viewed Case - Viewed Calendar'
            },
            success: function(response) {
              console.log('Success');
            }
        });
      });

  });

  <?php
    if($row['REMARKS_ID'] < 3 or $row['REMARKS_ID'] > 4){ ?>
      $("#evidencediv").hide();
  <?php }
    if($row['COMMENT'] != null ){ ?>
      $("#commentarea").show();
  <?php }
    if($row['PROCEEDING'] != null ){ ?>
      $("#proceedingarea").show();
  <?php }
    if($row['REMARKS_ID'] != 11 or $row['CAN_APPEAL'] > 5 or $row['CAN_APPEAL'] == null or $row['IF_APPEAL'] or $row['IF_APPEAL']) { ?>
      $("#appeal").hide();
  <?php }
    if($row['REMARKS_ID'] < 3 or $row['REMARKS_ID'] > 4) { ?>
      $("#form").hide();
  <?php }
    if($row['REMARKS_ID'] == 2) { ?>
      $("#form").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] > 4) { ?>
      $("#commentarea").hide();
  <?php } ?>
  </script>

  <!-- Form Modals -->
  <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Student Response</b></h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-sm-6">
              <b>School Year <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 2018-2019)</span>:</b><span style="font-weight:normal; color:red;"> *</span>
              <input id="schoolyr" pattern="[0-9]{4}-[0-9]{4}" minlength="9" maxlength="9" class="schoolyear form-control" placeholder="Enter School Year."/><br>
            </div>

            <div class="col-sm-6">
              <b>Term Number:</b><span style="font-weight:normal; color:red;"> *</span>
              <select id="term" class="form-control">
                <option value="" disabled selected>Select Term</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
              </select><br>
            </div>
          </div>

          <b>Type of Admission:</b><span style="font-weight:normal; color:red;"> *</span>
          <select id="admissionType" class="form-control">
            <option value="" disabled selected>Select Type</option>
            <option value="1">Full Admission (Apology/Admission)</option>
            <option value="2">Partial Admission (Apology/Explanation)</option>
            <option value="3">Full Denial (Explanation)</option>
          </select>
          <br>
          <div id="letterarea" class="form-group" hidden>
            <b id="letterlabel"></b> <span style="font-weight:normal; color:red;"> *</span><br>
            <textarea id="letter" style="width:550px; height: 400px;" name="details" class="form-control" rows="3"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitForm" class="btn btn-primary" data-dismiss="modal">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Form Modals w Details -->
  <div class="modal fade" id="formModalDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Student Response</b></h4>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-sm-6">
              <b>School Year <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 2018-2019)</span>:</b><span style="font-weight:normal; color:red;"> *</span>
              <input id="schoolyr2" pattern="[0-9]{4}-[0-9]{4}" minlength="9" maxlength="9" class="schoolyear form-control" value="<?php echo $rowForm['school_year']; ?>"/><br>
            </div>

            <div class="col-sm-6">
              <b>Term Number:</b><span style="font-weight:normal; color:red;"> *</span>
              <select id="term2" class="form-control">
                <option value="<?php echo $rowForm['term']; ?>"><?php echo $rowForm['term']; ?></option>
                <?php
                  if ($rowForm['term'] == 1) { ?>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  <?php }

                  else if ($rowForm['term'] == 2) { ?>
                    <option value="1">1</option>
                    <option value="3">3</option>
                  <?php }

                  else { ?>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  <?php } ?>
              </select><br>
            </div>
          </div>

          <b>Type of Admission:</b><span style="font-weight:normal; color:red;"> *</span>
          <select id="admissionType2" class="form-control">
            <option value="<?php echo $rowForm['admission_type_id']; ?>"><?php echo $rowForm['description']; ?></option>
            <?php
              if ($rowForm['admission_type_id'] == 1) { ?>
                <option value="2">Partial Admission/Denial (Apology/Explanation)</option>
                <option value="3">Full Denial (Explanation)</option>
              <?php }

              else if ($rowForm['admission_type_id'] == 2) {?>
                <option value="1">Full Admission (Apology/Admission)</option>
                <option value="3">Full Denial (Explanation)</option>
              <?php }

              else { ?>
                <option value="1">Full Admission (Apology/Admission)</option>
                <option value="2">Partial Admission/Denial (Apology/Explanation)</option>
              <?php } ?>
          </select>
          <br>
          <div class="form-group">
            <?php
              if($rowForm['admission_type_id'] == 1) { ?>
                <b id="letterlabel2">Please write an apology and admission letter</b> <span style="font-weight:normal; color:red;"> *</span><br>
            <?php }
              else if($rowForm['admission_type_id'] == 2) { ?>
                <b id="letterlabel2">Please write an apology and explanation letter</b> <span style="font-weight:normal; color:red;"> *</span><br>
            <?php }
              else { ?>
                <b id="letterlabel2">Please write an explanation</b> <span style="font-weight:normal; color:red;"> *</span><br>
            <?php } ?>
            <textarea id="letter2" style="width:550px; height: 400px;" name="details" class="form-control" rows="5"><?php echo $rowForm['response']; ?></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitFormAgain" class="btn btn-primary" data-dismiss="modal">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Parent Letter Modal -->
  <div class="modal fade" id="parentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Parent/Guardian Letter</b></h4>
        </div>
        <div class="modal-body">

          <p>Date: <?php echo date("d-m-Y"); ?></p>
          <br>
          <p><b>Mr. MICHAEL G. MILLANES</b></p>
          <p><i>Director</i></p>
          <p>Student Discipline Formation Office</p>
          <p>De La Salle University</p>
          <br>
          <p>Dear <b>Mr. Millanes</b>:</p>
          <br>
          <p>Greetings!</p>
          <br>
          <p>Please be informed that my son/daughter, Mr./Ms. <b><?php echo $row["STUDENT"]; ?></b>, taking up
            <b><?php echo $studentres["degree"]; ?></b> under the <b><?php echo $nameres["description"]; ?></b>
            with ID No. <b><?php echo $studentres["user_id"]; ?></b> has notified me that he/she incurred his/her
            <b><?php echo $countrow['CASE_COUNT']; ?></b>; <b><?php echo $caseres["type"]; ?></b> offense on
            <b><?php echo $caseres["description"]; ?></b>.</p>
          <br>
          <p>As his/her parent/guardian, I fully understand the seriousness of my son/daughter’s action/s
            and believes that the University, through the Student Discipline Formation Office has the right
            to enforce the necessary corrective measure/s as recommended in the present student handbook
            Sections 1, 4 and 5.</p>
          <br>
          <p>Thank you very much and More Power!</p>
          <br>
          <p>Parent’s/Guardian’s Name: <b><?php echo $studentres["guardian_name"]; ?></b></p>
          <p>Contact Information: <b><?php echo $studentres["guardian_contact"]; ?></b></p>
          <p>Present Address: <b><?php echo $studentres["address"]; ?></b></p>

        </div>
        <div class="modal-footer">
          <button type="submit" id = "submitParent" class="btn btn-primary" data-dismiss="modal">Submit</button>
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
          <h4 class="modal-title" id="myModalLabel1"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
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
          <p id="message">Student Response Form has been downloaded successfully! 
          <!-- <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Forward the file, along with your pieces of evidence, to <b>hdo.cms@gmail.com</b> for processing. </p> -->
          <br><br> <b>Next Step: </b> Send the Student Response Form together with your pieces of evidence to <b>ido.cms1@gmail.com</b> for processing. </p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="form1" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- New Modal -->
  <div class="modal fade" id="newFormsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Instructions</b></h4>
        </div>
        <div class="modal-body">
          <p id="message">Student Response Form has been downloaded successfully and Parent Letter has been created and sent to your Parent/Guardian's email! 
          <!-- <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Forward the file, along with your pieces of evidence, to <b>hdo.cms@gmail.com</b> for processing. </p> -->
          <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Send the Student Response Form together with your pieces of evidence to <b>ido.cms1@gmail.com</b> for processing. 
          <br> <b>(2)</b> Inform your Parent/Guardian to sign the Parent Letter through their email and forward to <b>ido.cms1@gmail.com</b>. </p>
        </div>
        <div class="modal-footer">
          <button type="button" id="form2" class="btn btn-default" data-dismiss="modal">Ok</button>
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
          <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
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

  <!-- Two Factor Authentication Modal -->
  <div class="modal fade" id="twoFactorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Confirmation</b></h4>
				</div>
					<div class="modal-body">
						<p id="message"> Are you sure you want to proceed? </p>
					</div>
					<div class="modal-footer">
            <button type="submit" id = "modalNo" style="width: 70px" class="btn btn-danger" data-dismiss="modal">No</button>
            <button type="submit" id = "modalYes" style="width: 70px" class="btn btn-success" data-dismiss="modal">Yes</button>
          </div>
      </div>
    </div>
  </div>

</body>

</html>

<style>
/* table, tr, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  align: center;
} */

p{ margin: 0; }
</style>

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
