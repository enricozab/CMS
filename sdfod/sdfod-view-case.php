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
                        C.PENALTY AS PENALTY,
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
              LEFT JOIN USERS U ON U.USER_ID = C.REPORTED_STUDENT_ID
              LEFT JOIN REF_USER_OFFICE R ON R.OFFICE_ID = U.OFFICE_ID
              LEFT JOIN REF_STUDENTS RS ON RS.STUDENT_ID = C.REPORTED_STUDENT_ID
                  WHERE C.CASE_ID = "'.$_GET['cn'].'"';
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
                              <td>Form 1</td>
                              <td><i>10/14/18</i></td>
                            </tr>
                            <tr>
                              <td>Form 2</td>
                              <td><i>10/10/18</i></td>
                            </tr>
                            <tr>
                              <td>Form 3</td>
                              <td><i>10/10/18</i></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <!-- .panel-body -->
                  </div>
                </div>
          </div>
  			<br><br>
        <div class="form-group">
          <label>Summary of the Incident</label>
          <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
        </div>
        <div class="form-group" id="penaltyarea" hidden>
          <label>Penalty</label>
          <textarea id="penalty" style="width:600px;" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY']; ?></textarea>
        </div>
        <br>
        <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
        <br><br><br><br>
        <button type="submit" id="feedbackForm" name="endorse" class="btn btn-primary">Create Discipline Case Feedback Form</button>
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

    $('#feedbackForm').click(function() {

      $("#feedbackModal").modal("show");

    });

    $('#endorse').click(function() {

      $.ajax({
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
            $('#message').text('Case endorsed to AULC successfully!');
            $("#endorse").attr('disabled', true).text("Endorsed");

            $("#alertModal").modal("show");
          }
      });

    });

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#submitFeedback').click(function() {

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
            idn: "<?php echo $row['REPORTED_STUDENT_ID']; ?>",
            degree: "<?php echo $CollegeQRow['degree']; ?>",
            college: "<?php echo $CollegeQRow['description']; ?>",
            nature: "<?php echo $row['OFFENSE_DESCRIPTION']; ?>",
            ido: "<?php echo $row['HANDLED_BY']; ?>",
            dRemark: document.getElementById("dRemarks").value

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

    });

  });

  <?php
    if($row['PENALTY'] != null ){ ?>
      $("#penaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] > 5){ ?>
      $("#endorse").attr('disabled', true).text("Endorsed");
    <?php
    if($row['REMARKS_ID'] == 10 or $row['REMARKS_ID'] == 11){ ?>
        $("#endorse").hide();
  <?php }
    }

    if($row['REMARKS_ID'] == 5 AND $row['TYPE'] == 'Minor'){ ?>

      $("#feedbackForm").show();
      <?php
    }

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
          <p id="message"></message>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Feedback Form Modal -->
  <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
  </div>



</body>

</html>
