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
  ?>

    <div id="wrapper">

    <?php include 'ido-sidebar.php';?>

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
              </div>

			<br><br>
      <div class="form-group">
        <label>Summary of the Incident</label>
        <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
      </div>

      <button type="button" class="btn btn-outline btn-primary" id="schedule" onclick="location.href='ido-calendar.php'"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule an interview</button>
      <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
      <button type="submit" id="viewForm" name="viewForm" class="btn btn-outline btn-primary">Review Submitted Form</button>

      <br><br>

      <?php

      if ($rowadmi['description'] == "Full Admission") {
        ?>

        <div class="form-group" id="penaltyarea">
          <br>
          <label>Penalty</label>
          <textarea id="penalty" style="width:600px;" name="penalty" class="form-control" rows="3">1 month suspension</textarea>
        </div>

        <?php
      }

      ?>

      <br><br><br><br>
      <div class="row">
        <div class="col-sm-6">
          <button type="submit" id="dismiss" name="dismiss" class="btn btn-danger">Dismiss</button>
          <button type="submit" id="return" name="return" class="btn btn-primary">Return to Student</button>
          <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
          <button type="submit" id="sendcl" name="sendcl" class="btn btn-success">Send Closure Letter</button>
          <button type="submit" id="endorsement" name="submit" class="btn btn-success">Send Academic Service Endorsement Form</button>
        </div>
      </div>
      <br><br><br>

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

        include 'ido-notif-queries.php';
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

    var totalID;
    <?php include 'ido-notif-scripts.php' ?>

    $('#submit').click(function() {
    <?php
      if($row['TYPE'] == "Major") { ?>
        var admi = "<?php echo $rowadmi['description']; ?>";
        var admission = "<?php echo $rowadmi['admission_type_id']; ?>";
        if(admission == 1) {
          $.ajax({
              url: '../ajax/ido-close-case.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  penalty: $('#penalty').val(),
                  admission: admi
              },
              success: function(msg) {
                  $('#message').text('Case closed.');
                  $("#submit").attr('disabled', true).text("Submitted");
                  $("#return").attr('disabled', true);
                  $("#dismiss").attr('disabled', true);
                  $("#penalty").attr('readonly', true);
                  $("#schedule").attr('disabled', true);
                  $("#addcomment").hide();
                  $('#closecomment').hide();
                  $('#comment').attr('disabled', true);
                  $("input[type=radio]").attr('disabled', true);
                  $("#alertModal").modal("show");
              }
          });
        }

        else {
          $.ajax({
              url: '../ajax/ido-forward-case.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  admission: admission
              },
              success: function(msg) {
                  $('#message').text('Case forwarded to SDFO Director successfully!');
                  $("#submit").attr('disabled', true).text("Submitted");
                  $("#return").attr('disabled', true);
                  $("#dismiss").attr('disabled', true);
                  $("#penalty").attr('readonly', true);
                  $("#schedule").attr('disabled', true);
                  $("#addcomment").hide();
                  $('#closecomment').hide();
                  $('#comment').attr('disabled', true);
                  $("input[type=radio]").attr('disabled', true);

                  $("#alertModal").modal("show");
              }
          });
        }

    <?php }

      else { ?>
        $.ajax({
            url: '../ajax/ido-close-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                penalty: $('#penalty').val()
            },
            success: function(msg) {
                $('#message').text('Case closed.');
                $("#submit").attr('disabled', true).text("Submitted");
                $("#return").attr('disabled', true);
                $("#dismiss").attr('disabled', true);
                $("#penalty").attr('readonly', true);
                $("#schedule").attr('disabled', true);
                $("#addcomment").hide();
                $('#closecomment').hide();
                $('#comment').attr('disabled', true);
                $("input[type=radio]").attr('disabled', true);

                $("#alertModal").modal("show");
            }
        });
    <?php } ?>
    });

    $('#submitComment').click(function() {
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
            $("#dismiss").attr('disabled', true);
            $("#schedule").attr('disabled', true);
            $("#penalty").attr('readonly', true);
            $("#addcomment").hide();
            $('#closecomment').hide();
            $('#comment').attr('disabled', true);
            $("input[type=radio]").attr('disabled', true);

            $("#alertModal").modal("show");
          }
      });
    });

    $('#return').click(function() {
      $("#commentModal").modal("show");
    });

    function calculateID() {
      totalID = <?php echo intval($fiveplusRow)?> * 5;
    }

    $('#endorsement').click(function() {
      calculateID();
      $('#hourz').text('Student entered campus with lost or left ID for ' + totalID + ' times.');
      $("#acadService").modal("show");
    });

    $('#submitHours').click(function() { // create referral form

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

      loadFile("../templates/template-academic-service-printable.docx",function(error,content){

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

      $("#endorsement").attr('disabled', true).text("Sent");
		
		//NOT DONE
		//HELLOSIGN API
    		$.ajax({
              url: '../ajax/faculty-hellosign.php',
              type: 'POST',
              data: {
    					title : "Incident Report",
    					subject : "Incident Report Document Signature",
    					message : "Please do sign this document.",
                        fname : "<?php echo $rowClosure['first_name'] ?>",
    					lname : "<?php echo $rowClosure['last_name'] ?>",
    					email : "<?php echo $rowClosure['email'] ?>",
    					filename : $('#inputfile').val()
                    },
                    success: function(response) {
    					alert("Incident Report sent to your email! Check your email to sign the form.");
    				}
    		})
		//HELLOSIGN API
    });

    $('#dismiss').click(function() {
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
              $("#addcomment").hide();
              $('#closecomment').hide();
              $('#comment').attr('disabled', true);
              $("input[type=radio]").attr('disabled', true);

              $("#alertModal").modal("show");
          }
      });
    });

    // GENERATING FORMS
    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#sendcl').click(function() {
      $.ajax({
          url: '../ajax/ido-send-closure-letter.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>
          },
          success: function(msg) {
              $('#message').text('Case dismissed.');
              $("#sendcl").attr('disabled', true);

              $("#alertModal").modal("show");
          }
      });

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
            college: "<?php echo $rowClosure['description'] ?>",
            degree: "<?php echo $rowClosure['degree'] ?>",
            offense: "<?php echo $rowClosure['description'] ?>",
            dateApp: "<?php echo $rowClosure['date_filed'] ?>",
            comFirst: "<?php echo $rowClosure['first_name'] ?>",
            comLast: "<?php echo $rowClosure['last_name'] ?>",
            idoFirst: "<?php echo $qComplainantRow['first_name'] ?>",
            idoLast: "<?php echo $qComplainantRow['last_name'] ?>",
            term: "<?php echo $rowClosure['term'] ?>",
            schoolYr: "<?php echo $rowClosure['school_year'] ?>",
            verdict: "<?php echo $rowClosure['verdict'] ?>",
            actions: "<?php echo $rowClosure['penalty'] ?>",

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

    $('#addcomment').click(function() {
      $("#addcomment").hide();
      $("#commentarea").show();
    });

    $('#closecomment').click(function() {
      $("#addcomment").show();
      $("#comment").val('');
      $("#commentarea").hide();
    });
  });

  <?php
    if($row['TYPE'] == "Major"){ ?>
      $("#admitarea").show();
  <?php }
    if($row['PENALTY'] != null and $row['TYPE'] == "Major"){ ?>
      $("#penaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] != 3){ ?>
      $("#addcomment").hide();
      $('#closecomment').hide();
      $('#comment').attr('disabled', true);
      $("#submit").attr('disabled', true);
      $("#return").attr('disabled', true);
      $("#dismiss").attr('disabled', true);
      $("#schedule").attr('disabled', true);
      $("#penalty").attr('readonly', true);
      $("input[type=radio]").attr('disabled', true);
      <?php
          if($row['REMARKS_ID'] > 4) { ?>
            $("#penalty").val("<?php echo $row['PENALTY']; ?>");
            $("input[name=admission][value='<?php echo $row['ADMISSION_TYPE_ID']; ?>']").prop('checked',true);
            $("#schedule").hide();
            $("#dismiss").hide();
            $("#return").hide();
            $("#submit").hide();
        <?php if($row['PENALTY'] == null){ ?>
                $("#penaltyarea").hide();
        <?php }
          }
    }
  if($row['REMARKS_ID'] != 7) { ?>
    $("#sendcl").hide();
  <?php }
    if($row['COMMENT'] != null){ ?>
      $("#addcomment").hide();
      $("#commentarea").show();
  <?php }
  if($row['REMARKS_ID'] == 11) { ?>
      $("#endorsement").show(); <?php
  } ?>

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

</body>

</html>
