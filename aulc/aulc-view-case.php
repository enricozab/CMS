<?php include 'aulc.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/aulc/aulc-home.php");
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

    <!-- FOR SEARCHABLE DROP-->
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
                        C.PENALTY_ID AS PENALTY_ID,
                        RP.PENALTY_DESC AS PENALTY_DESC,
                        C.VERDICT AS VERDICT,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.HEARING_DATE AS HEARING_DATE,
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

    //Gets list of offenses
    $query2='SELECT OFFENSE_ID, DESCRIPTION FROM REF_OFFENSES';
    $resultOffences=mysqli_query($dbc,$query2);
    if(!$resultOffences){
      echo mysqli_error($dbc);
    }

    // gets other user information
    $queryStud='SELECT *
                  FROM USERS U
             LEFT JOIN REF_STUDENTS R ON U.USER_ID = R.STUDENT_ID
             LEFT JOIN CASES C ON C.REPORTED_STUDENT_ID = U.USER_ID
             LEFT JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                 WHERE C.CASE_ID = "'.$_GET['cn'].'"';
    $resStud=mysqli_query($dbc,$queryStud);
    if(!$resStud){
      echo mysqli_error($dbc);
    }
    else{
      $rowStud=mysqli_fetch_array($resStud,MYSQLI_ASSOC);
    }
  ?>

    <div id="wrapper">

    <?php include 'aulc-sidebar.php';?>

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
                    <div class="panel panel-default" style="width: 500px;">
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
                            <tr>
                              <td>Discipline Case Feedback Form</td>
                              <td><button type="submit" id="info" name="return" class="btn btn-info">View</button></td>
                            </tr>
                            <tr>
                              <td>Discipline Case Referral Form</td>
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
      <div class="form-group">
        <label>Summary of the Incident</label>
        <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
      </div>

      <div class="form-group" id="penaltyarea" hidden>
        <label>SDFO Director's Remarks</label>
        <textarea id="penalty" style="width:600px;" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
      </div>

      <div class="form-group" id="proceedingarea">
        <label>Nature of Proceedings</label>
        <textarea id="proceeding" style="width:600px;" name="proceeding" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING']; ?></textarea>
      </div>

      <div id="viewevidence">
        <br>
        <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
      </div>

      <br><br><br>

      <div class="row">
        <div class="col-sm-6">
          <button type="submit" id="forward" name="submit" class="btn btn-success">Forward Discipline Case Referral Form</button>
        </div>
      </div>

      <br><br><br>

      <?php
        //Removes 'new' badge and reduces notif's count
        $query2='SELECT 		AU.CASE_ID AS CASE_ID,
                            AU.IF_NEW AS IF_NEW
                FROM 		    AULC_CASES AU
                WHERE   	  AU.CASE_ID = "'.$_GET['cn'].'"';
        $result2=mysqli_query($dbc,$query2);
        if(!$result2){
          echo mysqli_error($dbc);
        }
        else{
          $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
          if($row2['IF_NEW']){
            $query2='UPDATE AULC_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
            $result2=mysqli_query($dbc,$query2);
            if(!$result2){
              echo mysqli_error($dbc);
            }
          }
        }

        include 'aulc-notif-queries.php';
		    include 'aulc-form-queries.php';
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
    <?php include 'aulc-notif-scripts.php' ?>

    $('.chosen-select').chosen({width: '100%'});

    $('#offenseSelect').on('change',function() {
      var offense_id=$(this).val();
      if(offense_id==1) {
        $('#cheat').show();
      }
      else{
        $('#cheat').hide();
      }
    });

    $('#forward').click(function() {
      $("#formModal").modal("show");
    });

    // FORM GENERATOR

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('').click(function() {

      // REFERRAL FORM

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
        var change;

        if (document.getElementById("caseDecision").value == "File Case") {

          if (document.getElementById("violationDes").value == "Yes"){

            change = document.getElementById("offenseSelect").value;
          }

          else {
            change = "None";
          }
        }

        if (document.getElementById("remark").value) {
          remarks = "None";
        }

        doc.setData({

          date: today,
          casenum: <?php echo $_GET['cn']; ?>,
          studentFirst: "<?php echo $rowStud['first_name']; ?>",
          studentLast: "<?php echo $rowStud['last_name']; ?>",
          idn: "<?php echo $row['REPORTED_STUDENT_ID']; ?>",
          degree: "<?php echo $rowStud['degree']; ?>",
          college: "<?php echo $rowStud['description']; ?>",
          complainant: "<?php echo $row['COMPLAINANT']; ?>",
          violation: "<?php echo $row["OFFENSE_DESCRIPTION"]; ?>",
          section: "2.1",
          changes: change,
          nature: document.getElementById("proceedingType").value,
          remark: remarks,
          decision: document.getElementById("caseDecision").value,
          reason: document.getElementById("reasonCase").value

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

      $.ajax({
          url: '../ajax/aulc-forward-case.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
          },
          success: function(msg) {
            $('#message').text('Case forwarded to ULC successfully!');
            $("#penalty").attr('readonly', true);
            $("#submit").attr('disabled', true).text('Submitted');
            $("#dismiss").attr('disabled', true);

            $("#alertModal").modal("show");
          }
      });
    });

  	$('#submitRef').click(function() {
      var ids = ['input[name="caseDecision"]:checked','#reasonCase'];
      var isEmpty = true;

      if($('#dispOffense').is(":visible")){
        ids.push('#violationDes');
      }
      else{
        if($.inArray('#violationDes', ids) !== -1){
          ids.splice(ids.indexOf('#violationDes'),1);
        }
      }

      if($('#changeViolation').is(":visible")){
        ids.push('#offenseSelect');
      }
      else{
        if($.inArray('#offenseSelect', ids) !== -1){
          ids.splice(ids.indexOf('#offenseSelect'),1);
        }
      }

      if($('#cheat').is(":visible")){
        ids.push('#cheat-type');
      }
      else{
        if($.inArray('#cheat-type', ids) !== -1){
          ids.splice(ids.indexOf('#cheat-type'),1);
        }
      }

      for(var i = 0; i < ids.length; ++i ){
        if($.trim($(ids[i]).val()).length == 0){
          isEmpty = false;
        }
      }

      if(isEmpty) {
        var changeoff = null;
        var changevio = null;
        var cheat = null;
        if($('#dispOffense').is(":visible")){
          changeoff=$('#violationDes').val();
        }
        if($('#changeViolation').is(":visible")){
          changevio=$('#offenseSelect').val();
        }
        if($('#cheat').is(":visible")){
          cheat=$('#cheat-type').val();
        }
        $.ajax({
            url: '../ajax/aulc-forward-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                decision: $('input[name="caseDecision"]:checked').val(),
                reason: $('#reasonCase').val(),
                aulc_remarks: $('#aulcRemarks').val(),
                changeoff: changeoff,
                changevio: changevio,
                cheat: cheat
            },
            success: function(msg) {
              $('#message').text('Case forwarded to ULC successfully!');
              $('#forward').attr('disabled', true);
            }
        });
      }
      $("#alertModal").modal("show");
  	});

    function helloEndorse() {
      //HELLOSIGN API
  		$.ajax({
  		  url: '../ajax/faculty-hellosign.php',
  		  type: 'POST',
  		  data: {
  					title : "Discipline Case Referral Form",
  					subject : "Discipline Case Referral Form Document Signature",
  					message : "Please do sign this document.",
  					fname : "<?php echo $directorres['first_name'] ?>",
  					lname : "<?php echo $directorres['last_name'] ?>",
  					email : "<?php echo $directorres['email'] ?>",
  					filename : $('#inputfile').val()
  				},
  				success: function(response) {
  					alert("Discipline Case Referral Form sent to SDFO Director!");
  				}
  		});
  		//HELLOSIGN API
    }

    $('input[name="caseDecision"]').click(function(){
      if ($(this).val() == "File Case") {
        $('#dispOffense').show();
      }
      else {
        $('#dispOffense').hide();
        $('#changeViolation').hide();
      }
    });

    $('input[name="violationDes"]').click(function(){
      if ($(this).val() == 1) {
        $('#changeViolation').show();
      }
      else {
        $('#changeViolation').hide();
      }
    });
  });

  <?php
    if($row['PENALTY_DESC'] != null){ ?>
      $("#penaltyarea").show();
  <?php }
    if($row['REMARKS_ID'] == 7){ ?>
      $("#forward").hide();
  <?php }
    if($row['REMARKS_ID'] > 7){ ?>
      $("#forward").hide();
  <?php } ?>

  </script>

  <!-- Form Modal -->
  <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Associate University Legal Counsel Remarks</b></h4>
        </div>

        <div class="modal-body">

          <label>Decision <span style="font-weight:normal; color:red;"> *</span></label>&nbsp;&nbsp;&nbsp;
          <input type ="radio" name="caseDecision" id = "caseDecision" value = "File Case">&nbsp;&nbsp;File Case</input>&nbsp;&nbsp;&nbsp;
          <input type ="radio" name="caseDecision" id = "caseDecision" value = "Dismiss Case">&nbsp;&nbsp;Dismiss Case</input><br><br>

          <label>Reasons <span style="font-weight:normal; color:red;"> *</span></label>
          <textarea id="reasonCase" style="height: 100px;" class="form-control" placeholder="Enter Reason"></textarea><br>

          <label>Remarks</label>
          <textarea id="aulcRemarks" style="height: 100px;" class="form-control" placeholder="Enter Remarks"></textarea><br>

          <div id = "dispOffense" hidden>
            <label>Offense: &nbsp;&nbsp; </label><?php echo $row['OFFENSE_DESCRIPTION']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label>Change Offense? <span style="font-weight:normal; color:red;"> *</span></label>&nbsp;&nbsp;&nbsp;
            <input type = "radio" name="violationDes" id = "violationDes" value = "1">&nbsp;&nbsp;Yes</input>&nbsp;&nbsp;&nbsp;
            <input type = "radio" name="violationDes" id = "violationDes" value = "0">&nbsp;&nbsp;No</input><br><br>
          </div>

          <div id="changeViolation" class="form-group" style='width: 300px;' hidden>
            <label>Select New Offense <span style="font-weight:normal; color:red;">*</span></label><br>
            <select id="offenseSelect" style='width: 300px;' class="chosen-select">
              <option value="" disabled selected>Select Offense</option>
              <?php
              while($rowOffenses=mysqli_fetch_array($resultOffences,MYSQLI_ASSOC)){
                echo
                  "<option value=\"{$rowOffenses['OFFENSE_ID']}\">{$rowOffenses['DESCRIPTION']}</option>";
              }
              ?>
            </select>
          </div>
          <?php
            $query2='SELECT CHEATING_TYPE_ID, DESCRIPTION FROM REF_CHEATING_TYPE';
            $result2=mysqli_query($dbc,$query2);
            if(!$result2){
              echo mysqli_error($dbc);
            }
          ?>
          <div id="cheat" class="form-group" style='width: 300px;' hidden>
            <label>Cheating Type <span style="font-weight:normal; color:red;">*</span></label>
            <select id="cheat-type" class="form-control">
              <option value="" disabled selected>Select Type</option>
              <?php
              while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                echo
                  "<option value=\"{$row2['CHEATING_TYPE_ID']}\">{$row2['DESCRIPTION']}</option>";
              }
              ?>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="submitRef" class="btn btn-primary" data-dismiss="modal">Submit</button>
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
          <button type="button" id = "modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
