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

    <!-- GDRIVE -->

    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/ah2.js" type="text/javascript"></script>
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
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.PROCEEDING_DATE AS PROCEEDING_DATE,
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

    $passData = $rowStud2['description'] . "/" . $rowStud2['degree'] . "/" . $rowStud2['level'] . "/" . $rowStud2['reported_student_id'] . "/" . "AULC-VIEW-CASE" . "/" . $_GET['cn'];
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
  ?>

    <div id="wrapper">

    <?php include 'aulc-sidebar.php';?>

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
                if($row['PROCEEDING'] != null) {
                  echo "<div class='form-group' id='proceedingarea'>
                          <label>Nature of Proceedings</label>
                          <textarea id='proceeding' name='proceeding' class='form-control' rows='3' readonly>{$row['PROCEEDING']}</textarea>
                        </div>";
                }
              ?>

              <div id="viewevidence">
                <br>
                <button type="submit" id="btnViewEvidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
              </div>

              <br><br><br><br>

              <div class="row">
                <div class="col-sm-6">
                  <button type="submit" id="forward" name="submit" class="btn btn-success">Forward Discipline Case Referral Form</button>
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
            </div>
          </div>

      <br><br><br><br><br>

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
          if($row2['IF_NEW'] == 1){
            $query2='UPDATE AULC_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
            $result2=mysqli_query($dbc,$query2);
            if(!$result2){
              echo mysqli_error($dbc);
            }
          }
        }

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
    loadNotif();

    function loadNotif () {
        $.ajax({
          url: '../ajax/aulc-notif-cases.php',
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

    // $('#updateTable').click(function() {
    //
    //   <?php
    //     $updateQry = 'UPDATE CASE_REFERRAL_FORMS
    //                      SET IF_UPLOADED = 2
    //                    WHERE CASE_ID = "'.$_GET['cn'].'"';
    //
    //     $update = mysqli_query($dbc,$updateQry);
    //     if(!$update){
    //       echo mysqli_error($dbc);
    //     }
    //   ?>
    // });


    // FORM GENERATOR

    function loadFile(url,callback){
        JSZipUtils.getBinaryContent(url,callback);
    }

    $('#submitRef').on('click', function() {
      var ids = ['input[name="caseDecision"]:checked','#reasonCase'];
      var isEmpty = true;

      if($('#dispOffense').is(":visible")){
        ids.push('input[name="violationDes"]:checked');
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
        $('#twoFactorModal').modal("show");
      }
      else {
        $("#alertModal").modal("show");
      }
    });

    $('#modalYes').click(function() {
      var changeoff = null;
      var changevio = null;
      var cheat = null;
      if($('#dispOffense').is(":visible")){
        changeoff=$('input[name="violationDes"]:checked').val();
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
            cheat: cheat,
            proceeding: <?php echo $row['ADMISSION_TYPE_ID']; ?>
        },
        success: function(msg) {

          // audit trail
          $.ajax({
                    url: '../ajax/insert_system_audit_trail.php',
                    type: 'POST',
                    data: {
                        userid: <?php echo $_SESSION['user_id'] ?>,
                        actiondone: 'AULC Case - Forwarded Discipline Case Referral Form for Case #<?php echo $_GET['cn']; ?>'
                    },
                    success: function(response) {
                      console.log('Success');
                    }
                })

          // $('#message').text('Case forwarded to ULC successfully!');
          $('#forward').attr('disabled', true);

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

            var admission;
            if(<?php echo $row['ADMISSION_TYPE_ID']; ?> == 1){
              admission = "University Panel for Case Conference";
            }
            else if(<?php echo $row['ADMISSION_TYPE_ID']; ?> == 2){
              admission = "Summary Proceedings";
            }
            else {
              admission = "Formal Hearing";
            }

            if (changevio == null) {
              changevio = "";
            }

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
              decision: $('input[name="caseDecision"]:checked').val(),
              reason: $('#reasonCase').val(),
              remark: $('#aulcRemarks').val(),
              changes: changevio,
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
          $('#newFormModal').modal("show");
        }
      });
    });

    $('#modalNo').on('click', function() {
      $('#formModal').modal("show");
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
  					email : "aulc.cms1@gmail.com",
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

    $('#uploading').click(function(){
        $("#waitModal").modal("show");
    });

    $('#btnViewEvidence').click(function() {
      <?php $_SESSION['pass'] = $passCase; ?>
      location.href='aulc-gdrive-case.php';

      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'AULC Case - Viewed Evidence for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
    });

    $('input[name="caseDecision"]').click(function(){
      if ($(this).val() == "File Case") {
        $('#dispOffense').show();
        $('#proceeding').show();
      }
      else {
        $('#dispOffense').hide();
        $('#proceeding').hide();
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

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
        $.ajax({
            url: '../ajax/insert_system_audit_trail.php',
            type: 'POST',
            data: {
                userid: <?php echo $_SESSION['user_id'] ?>,
                actiondone: 'AULC Viewed Case - Viewed Cases'
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
                actiondone: 'AULC Viewed Case - Viewed Files'
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
                actiondone: 'AULC Viewed Case - Viewed Calendar'
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
                actiondone: 'AULC Viewed Case - Viewed Inbox'
            },
            success: function(response) {
              console.log('Success');
            }
        });
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
  <?php

    if ($rowForm['if_uploaded'] == 1 AND $row['REMARKS_ID'] == 8){ ?>
      $("#uploading").show();
<?php }
  ?>

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

          <div id="proceeding" class="form-group" hidden>
            <?php
              if($row['TYPE'] = "Major") {
                if($row['ADMISSION_TYPE_ID'] == 1) {
                  echo "<label>Nature of Proceedings: &nbsp;&nbsp; </label>University Panel for Case Conference";
                }
                else if($row['ADMISSION_TYPE_ID'] == 2) {
                  echo "<label>Nature of Proceedings: &nbsp;&nbsp; </label>Summary Proceeding&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }
                else {
                  echo "<label>Nature of Proceedings: &nbsp;&nbsp; </label>Formal Hearing";
                }
              }
            ?>
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

  <!-- New Modal -->
  <div class="modal fade" id="newFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Instructions</b></h4>
        </div>
        <div class="modal-body">
          <p id="message">Case successfully forwarded to the ULC! The Discipline Case Referral Form has been sent to your email. <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Forward Discipline Case Referral Form to <b>ulc.cms2@dlsu.edu.ph</b>.</p>
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
          <button type="button" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Wait Modal -->
  <div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Google Drive</b></h4>
        </div>
        <div class="modal-body">
          <p> Please wait. </p>
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
