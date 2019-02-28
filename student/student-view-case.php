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
                        C.HEARING_DATE AS HEARING_DATE,
                        C.IF_APPEAL AS IF_APPEAL,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW,
                        DATEDIFF(CURRENT_TIMESTAMP(),C.DATE_CLOSED) AS CAN_APPEAL
            FROM 		    CASES C
            LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
            LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
            LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
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

    $case = 'SELECT 	*
               FROM		CASES
              WHERE		CASE_ID = "'.$_GET['cn'].'"';
    $caseRes = mysqli_query($dbc,$case);

    if(!$caseRes) {
       echo mysqli_error($dbc);
    }

    else {
       $caseResRow = mysqli_fetch_array($caseRes,MYSQLI_ASSOC);
    }
  ?>

    <div id="wrapper">

    <?php include 'student-sidebar.php';?>

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

        <div class="form-group" id="commentarea" hidden>
          <label>Comment</label>
          <textarea id="comment" style="width:600px;" name="comment" class="form-control" rows="3" readonly><?php echo $row['COMMENT']; ?></textarea>
        </div>

        <div class="form-group" id="penaltyarea" hidden>
          <label>Penalty</label>
          <textarea id="penalty" style="width:600px;" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
        </div>

        <div class="form-group" id="evidencediv">
          <label>Evidence <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. Document/Photo)</label>
          <br><br>
          <div id="evidencelist">
            <div class="form-group" style="width:300px;">
              <input type="file">
            </div>
          </div>
          <div id="appendevidence">
            <span class="fa fa-plus" style="color: #337ab7;">&nbsp; <a style="color: #337ab7; font-family: Arial;">Add another file</a></span>
          </div>
        </div>
        <div id="viewevidence" hidden>
          <br>
          <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
        </div>
        <br><br>
        <?php
          if($row['TYPE'] == "Major") {
            echo '<button type="submit" id="appeal" name="appeal" class="btn btn-warning">Appeal</button>';
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
            if($row2['IF_NEW']){
              $query2='UPDATE STUDENT_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
              $result2=mysqli_query($dbc,$query2);
              if(!$result2){
                echo mysqli_error($dbc);
              }
            }
          }

          include 'student-notif-queries.php';
        ?>
      </div>
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

    <!-- Form Generation -->
    <script src="../form-generation/docxtemplater.js"></script>
    <script src="../form-generation/jszip.js"></script>
    <script src="../form-generation/FileSaver.js"></script>
    <script src="../form-generation/jszip-utils.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  $(document).ready(function() {

    //response form
    $("#form").click(function(){

      var remark = <?php echo $row['REMARKS_ID']; ?>;
      var stat = <?php echo $row['STATUS_ID']; ?>;

      if (remark == 4) {

        $("#formModalDetails").modal("show");
      }

      else {
        if (stat != 3) {
          $("#formModal").modal("show");
        }

        else {
          //$("#parentModal").modal("show");
          parentLetter();
        }
      }

    });

    <?php include "student-form-queries.php" ?>

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
          frequency: 1,
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
        saveAs(out,"output.docx");

      });

  	  //HELLOSIGN API - Parent Letter
  	  $.ajax({
        url: '../ajax/student-hellosign.php',
        type: 'POST',
        data: {
  					title : "Parent Letter",
  					subject : "Parent Letter Document Signature",
  					message : "Please do sign this document.",
					name : "<?php echo $studentres['guardian_name'] ?>",
  					email : "<?php echo $studentres['guardian_email'] ?>",
  					filename : $('#inputfile').val(),
            caseID : <?php echo $_GET['cn']; ?>
        },
        success: function(response) {
          $("#message").text('Parent Letter has been submitted and sent to your email successfully! Check your email to sign the form.');
          $("#alertModal").modal("show");
          $("#form").attr('disabled',true);
					  //alert("Parent Letter sent to your email! Check your email to sign the form.");
				}
  		});
  	  //HELLOSIGN API
    }

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $("#submitForm").click(function(){
      var ids = ['#schoolyr','#term','#letter','#admissionType'];
      var isEmpty = true;

      for(var i = 0; i < ids.length; ++i ) {
        if($.trim($(ids[i]).val()).length == 0) {
          isEmpty = false;
        }
      }

      if(isEmpty){
        $.ajax({
            url: '../ajax/student-submit-forms.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                admission: document.getElementById("admissionType").value,
                term: document.getElementById("term").value,
                schoolyr: document.getElementById("schoolyr").value,
                response: document.getElementById("letter").value
            },
            success: function(msg) {
                $("#form").attr('disabled', true);
                $("#evidencediv").hide();
                $("#viewevidence").show();
            }
        });

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
        saveAs(out,"output.docx");

        });
        studResponse();
      }
      else {
        $("#alertModal").modal("show");
      }
    });

    $("#submitFormAgain").click(function(){
        var ids = ['#schoolyr2','#term2','#letter2','#admissionType2'];
        var isEmpty = true;

        for(var i = 0; i < ids.length; ++i ) {
          if($.trim($(ids[i]).val()).length == 0) {
            isEmpty = false;
          }
        }

        if(isEmpty) {
          $.ajax({
              url: '../ajax/student-submit-forms.php',
              type: 'POST',
              data: {
                  caseID: <?php echo $_GET['cn']; ?>,
                  remarks: <?php echo $caseResRow['remarks_id']; ?>,
                  admission: document.getElementById("admissionType2").value,
                  term: document.getElementById("term2").value,
                  schoolyr: document.getElementById("schoolyr2").value,
                  response: document.getElementById("letter2").value
              },
              success: function(msg) {
                  $("#form").attr('disabled', true);
                  $("#evidencediv").hide();
                  $("#viewevidence").show();
              }
          });
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
          saveAs(out,"output.docx");

          });
          studResponse();
        }
        else {
          $("#alertModal").modal("show");
        }
    });

    <?php include 'student-notif-scripts.php' ?>

    $("#appendevidence").click(function(){
      $("#evidencelist").append('<div class="form-group input-group" id="newsevidence">'+
      '<span id="removeevidence" style="cursor: pointer; color:red; float: right;"><b>&nbsp;&nbsp; x</b></span>'+
      '<input type="file">'+
      '</div>');
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
              $('#message').text('An appeal has been sent successfully!');
              $("#appeal").attr('disabled', true);
              $("#form").attr('disabled', true);

              $("#alertModal").modal("show");
          }
      });
    });

    $('#admissionType').on('change', function() {
      var option = $("option:selected", this);
      if(this.value == "Full Admission") {
        $('#letterlabel').text("Please write an apology and admission letter");
      }
      else if(this.value == "Partial Admission/Denial") {
        $('#letterlabel').text("Please write an apology and explanation letter");
      }
      else if(this.value == "Full Denial") {
        $('#letterlabel').text("Please write an explanation");
      }
      $('#letterarea').show();
    });

    $('#admissionType2').on('change', function() {
      var option = $("option:selected", this);
      if(this.value == "Full Admission") {
        $('#letterlabel2').text("Please write an apology and admission letter");
      }
      else if(this.value == "Partial Admission/Denial") {
        $('#letterlabel2').text("Please write an apology and explanation letter");
      }
      else if(this.value == "Full Denial") {
        $('#letterlabel2').text("Please write an explanation");
      }
    });
	  
	$('#modalOK').click(function() {

        $("#alertModal").modal("hide");
		

    function studResponse() {
      $.ajax({
          url: '../ajax/student-hellosign.php',
          type: 'POST',
          data: {
              title : "Student Response Form",
              subject : "Student Response Form Document Signature",
              message : "Please do sign this document.",
                        fname : "<?php echo $nameres['first_name'] ?>",
              lname : "<?php echo $nameres['last_name'] ?>",
              email : "<?php echo $nameres['email'] ?>",
              filename : $('#inputfile').val()
          },
          success: function(response) {
            $('#message').text('Student Response Form has been submitted and sent to your email successfully! Check your email to sign the form.');
            $("#alertModal").modal("show");
          //alert("Student Response Form sent to your email! Check your email to sign the form.");
          }
      });
    }
  });
  });



  <?php
    if($row['REMARKS_ID'] > 2 and $row['REMARKS_ID'] != 4){ ?>
      $("#evidencediv").hide();
      $("#viewevidence").show();
  <?php }
    if($row['COMMENT'] != null ){ ?>
      $("#commentarea").show();
  <?php }
    if($row['PENALTY_DESC'] != null ){ ?>
      $("#penaltyarea").show();
  <?php }
    if(($row['REMARKS_ID'] != 10 and $row['TYPE'] != "Major") or $row['CAN_APPEAL'] > 5 or $row['CAN_APPEAL'] == null or $row['IF_APPEAL']) { ?>
      $("#appeal").hide();
  <?php }
    if($row['REMARKS_ID'] < 2 or $row['REMARKS_ID'] > 4) { ?>
      $("#form").hide();
  <?php }
    if($row['REMARKS_ID'] == 3) { ?>
      $("#form").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] > 4) { ?>
      $("#commentarea").hide();
  <?php }
    if($row['REMARKS_ID'] > 11) { ?>
      $("#appeal").attr('disabled', true);
      $("#form").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] == 12) { ?>
      $("#form").show();
      $("#form").text("Send Parent Letter");
  <?php }
    if($row['REMARKS_ID'] == 14) { ?>
      $("#appeal").hide();
      $("#form").hide();
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
            <option value="Full Admission">Full Admission (Apology/Admission)</option>
            <option value="Partial Admission/Denial">Partial Admission (Apology/Explanation)</option>
            <option value="Full Denial">Full Denial (Explanation)</option>
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
            <option value="<?php echo $rowForm['description']; ?>"><?php echo $rowForm['description']; ?></option>
            <?php
              if ($rowForm['admission_type_id'] == 1) { ?>
                <option value="Partial Admission/Denial">Partial Admission/Denial (Apology/Explanation)</option>
                <option value="Full Denial">Full Denial (Explanation)</option>
              <?php }

              else if ($rowForm['admission_type_id'] == 2) {?>
                <option value="Full Admission">Full Admission (Apology/Admission)</option>
                <option value="Full Denial">Full Denial (Explanation)</option>
              <?php }

              else { ?>
                <option value="Full Admission">Full Admission (Apology/Admission)</option>
                <option value="Partial Admission/Denial">Partial Admission/Denial (Apology/Explanation)</option>
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
