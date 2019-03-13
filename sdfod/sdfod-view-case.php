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

    <!-- Form Generation -->
    <script src="../form-generation/docxtemplater.js"></script>
    <script src="../form-generation/jszip.js"></script>
    <script src="../form-generation/FileSaver.js"></script>
    <script src="../form-generation/jszip-utils.js"></script>

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
                        C.HEARING_DATE AS HEARING_DATE,
                        CRF.CASE_DECISION AS CASE_DECISION,
                        RCP.CASE_PROCEEDINGS_ID AS CASE_PROCEEDINGS_ID,
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
  ?>

    <div id="wrapper">

    <?php include 'sdfod-sidebar.php';?>

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
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">Submitted Forms</b>
                      </div>
                      <!-- .panel-heading -->
                      <div class="panel-body">
                        <table class="table">
                          <tbody>
                            <tr>
                              <td>Student Response Form</td>
                              <td><button type="submit" id="info" name="return" class="btn btn-info">View</button></td>
                            </tr>
                            <tr>
                              <td>Parent/Guardian Letter</td>
                              <td><button type="submit" id="info" name="return" class="btn btn-info">View</button></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!-- .panel-body -->
                  </div>
                </div>
          </div>
  			<br><br>
        <div class="row">
          <div class="col-lg-6">
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

            <?php
              $query2='SELECT PENALTY_ID, PENALTY_DESC FROM REF_PENALTIES';
              $result2=mysqli_query($dbc,$query2);
              if(!$result2){
                echo mysqli_error($dbc);
              }
            ?>
            <div id="penaltyarea" class="form-group" style='width: 400px;'>
              <label>Remarks <span style="font-weight:normal; color:red;">*</span></label>
              <select id="penalty" class="form-control">
                <option value="" disabled selected>Select the corresponding penalty</option>
                <?php
                while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                  echo
                    "<option value=\"{$row2['PENALTY_ID']}\">{$row2['PENALTY_DESC']}</option>";
                }
                ?>
              </select>
              <textarea id="finpenalty" name="finpenalty" class="form-control" rows="3" hidden readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
            </div>

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
            <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
        </div>
      </div>
        <br><br><br><br><br>
        <button type="submit" id="endorse" name="endorse" class="btn btn-primary">Submit</button>
        <?php
          if($row['REMARKS_ID'] == 14) { ?>
          <button type="button" id="sign" class="btn btn-success" data-dismiss="modal">Sign Discipline Case Feedback Form</button>
        <?php }
        ?>
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
        if($row2['IF_NEW']){
          $query2='UPDATE SDFOD_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }

      include 'sdfod-notif-queries.php';

      ?>
    </div>
    <!-- #wrapper -->

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
  var remarks;
  $(document).ready(function() {

    <?php include 'sdfod-notif-scripts.php' ?>

    $('#endorse').click(function() {
      var ids = ['#penalty'];
      var isEmpty = true;

      if($('#penalty').is(":visible")){
        for(var i = 0; i < ids.length; ++i ){
          if($.trim($(ids[i]).val()).length == 0){
            isEmpty = false;
          }
        }
      }

      if(isEmpty) {
        if($('#penalty').val() != 3 && $('#penalty').is(":visible")) {
          $.ajax({
            //../ajax/director-close-case.php
              url: '../ajax/director-close-case.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  penalty: $('#penalty').val()
              },
              success: function(response) {
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
                    dRemark: response

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
                $('#penalty').attr("disabled", true);
                $("#endorse").attr('disabled', true).text("Submitted");
                $('#message').text('Case closed. Discipline Case Feedback Form has been sent to the student.');
                $("#alertModal").modal("show");
              }
          });
        }
        else {
          $.ajax({
            //../ajax/director-endorse-case.php
              url: '../ajax/director-endorse-case.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  penalty: $('#penalty').val(),
                  //proceeding: $("input:radio[name=proceedings]:checked").val()
              },
              success: function(response) {
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
                  saveAs(out,"output.docx");
                });
                //$("input[type=radio]").attr('disabled', true);
                $('#penalty').attr("disabled", true);
                $("#endorse").attr('disabled', true).text("Endorsed");
                $('#message').text('Case is endorsed to AULC.');
                $("#alertModal").modal("show");
                //referralFile(pen);
              }
          });
          /*$.ajax({
              url: '../ajax/director-endorse-case.php',
              type: 'POST',
              data: {
                  caseID: "<?php echo $_GET['cn']; ?>",
                  decision: $('#caseDecision').val(),
                  reason: $('#reasonCase').val(),
                  nature: $('#proceedingType').val(),
                  remark: remarks
              },
              success: function(msg) {
                $('#message').text('Case closed.');
                $('#submitFeedback').text("Send Discipline Case Feedback Form");

                $("#alertModal").modal("show");
              }
          });*/
        }
      }
      else {
        $("#alertModal").modal("show");
      }
    });

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#sign').on('click', function() {
      $.ajax({
          url: '../ajax/director-return-to-ido.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              decision: '<?php echo $row['CASE_DECISION']; ?>'
          },
          success: function(msg) {
            if('<?php echo $row['CASE_DECISION']; ?>' == "File Case") {
              $('#message').text('Check your email to sign the Discipline Case Feedback Form.');
            }
            else {
              $('#message').text('Check your email to sign the Discipline Case Feedback Form. Case returned to IDO for Closure Letter');
            }
            $("#sign").attr('disabled', true)

            $("#alertModal").modal("show");
          }
      });
    });

    $('#penalty').on('change', function() {
      var option = $("option:selected", this);
      if(this.value == 3) {
        $("#endorse").text("Endorse");
        //$("#proceedingsList").show();
      }
      else {
        $("#endorse").text("Submit");
        //$("#proceedingsList").hide();
      }
    });
  });

  <?php
    if($row['TYPE'] == "Major"){ ?>
      $("#endorse").text("Endorse");
      $("#penaltyarea").hide();
      //$("#proceedingsList").show();
  <?php }
    if($row['REMARKS_ID'] < 6){ ?>
      $("#finpenalty").hide();
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
          <button type="button" id="submitFeedback" class="btn btn-default" data-dismiss="modal">Ok</button>
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
              <option value="Student is referred to University Councelor">Student is referred to University Councelor</option>
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
