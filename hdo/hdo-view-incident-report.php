<?php include 'hdo.php' ?>
<?php
if (!isset($_GET['irn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/hdo/hdo-home.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Incident Report</title>

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

    <!-- GDRIVE -->
    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/hdo-addNew6.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

</head>

<body>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Incident Report No.: <?php echo $_GET['irn']; ?></h3>

                <div class="col-lg-12">
                  <?php
                    //Gets incident report data
                    $query='SELECT 	   IR.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                                       IR.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                                       CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS STUDENT,
                                       U.EMAIL AS COMPLAINANT_EMAIL,
                                       U2.EMAIL AS STUDENT_EMAIL,
                                       IR.LOCATION AS LOCATION,
                                       IR.DETAILS AS DETAILS,
                                       IR.DATE_INCIDENT AS DATE_INCIDENT,
                                       IR.COMPLAINANT_ID AS COMPLAINANT_ID,
                                       CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS COMPLAINANT,
                                       DATE_FILED,
                                       IR.IF_NEW AS IF_NEW
                            FROM 	  	 INCIDENT_REPORTS IR
                            JOIN	     USERS U ON IR.COMPLAINANT_ID = U.USER_ID
                            JOIN	     USERS U2 ON IR.REPORTED_STUDENT_ID = U2.USER_ID
                            WHERE		   IR.INCIDENT_REPORT_ID = "'.$_GET['irn'].'"
                            ORDER BY 	 IR.DATE_FILED';
                    $result=mysqli_query($dbc,$query);

                    //Gets list of offenses
                    $query2='SELECT OFFENSE_ID, DESCRIPTION FROM REF_OFFENSES';
                    $result2=mysqli_query($dbc,$query2);
                    if(!$result && !$result2){
                      echo mysqli_error($dbc);
                    }
                    else{
                      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                    }

                    $queryStud = 'SELECT *
                                    FROM INCIDENT_REPORTS IR
                                    JOIN USERS U ON IR.REPORTED_STUDENT_ID = U.USER_ID
                                    JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                                    JOIN REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
                                   WHERE IR.INCIDENT_REPORT_ID = "'.$_GET['irn'].'"';

                    $resultStud = mysqli_query($dbc,$queryStud);

                    if(!$queryStud){
                      echo mysqli_error($dbc);
                    }
                    else{
                      $rowStud = mysqli_fetch_array($resultStud,MYSQLI_ASSOC);
                    }

                    $passData = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $rowStud['level'] . "/" . $rowStud['reported_student_id'] .  "/" . "HDO-VIEW-INCIDENT";
                  ?>
                  <form id="form">
                    <div class="form-group" style='width: 300px;'>
                      <label>Student</label>
                      <input class="form-control" value="<?php echo $row['REPORTED_STUDENT_ID'].' : '.$row['STUDENT']; ?>" readonly>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Offense <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="offense" class="chosen-select">
                        <option value="" disabled selected>Select Offense</option>
                        <!-- new - edited -->
                        <!-- <option value="1">Cheating</option>
                        <option value="2">Vandalism</option>
                        <option value="33">Simple Acts of Disrespect</option>
                        <option value="34">Acts Which Disturb Peace</option> -->
                        <?php
                        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                          echo
                            "<option value=\"{$row2['OFFENSE_ID']}\">{$row2['DESCRIPTION']}</option>";
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
                    <div class="form-group" style = "width: 300px;">
                      <label>Complainant </label>
                      <input class="form-control" value="<?php echo $row['COMPLAINANT_ID'].' : '.$row['COMPLAINANT']; ?>" readonly>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Location of the Incident</label>
                      <input class="form-control" value="<?php echo $row['LOCATION']; ?>" readonly>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Date and Time of the Incident</label>
                      <input class="form-control" value="<?php echo $row['DATE_INCIDENT']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Summary of the Incident </label>
                      <textarea id="details" class="form-control" style="width:600px;" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
  				          </div>
                    <!-- new (the div below)-->
                    <div id="detailarea" class="form-group" style='width: 600px;' hidden>
                      <label>Details <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="details2" class="chosen-select">
                      </select>
  				          </div>
                    <?php
                      $query2='SELECT DETAILS FROM CASES WHERE INCIDENT_REPORT_ID = '.$_GET['irn'].'';
                      $result2=mysqli_query($dbc,$query2);
                      if(!$result2){
                        echo mysqli_error($dbc);
                      }
                      else{
                        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
                      }
                      if($row2['DETAILS'] != null) { ?>
                        <div class="form-group">
                          <label>Details</label>
                          <textarea class="form-control" style="width:600px;" readonly><?php echo $row2['DETAILS']; ?></textarea>
      				          </div>
                    <?php }
                    ?>
                    <br>
                    <?php
                      $query2='SELECT USER_ID, CONCAT(FIRST_NAME," ",LAST_NAME) AS IDO FROM USERS WHERE USER_TYPE_ID = 4';
                      $result2=mysqli_query($dbc,$query2);
                      if(!$result2){
                        echo mysqli_error($dbc);
                      }
                    ?>
                    <div class="form-group" style='width: 400px;'>
                      <label>Assign an Investigation Discipline Officer (IDO) <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="ido" class="form-control">
                        <option value="" disabled selected>Select IDO</option>
                        <?php
                        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                          echo
                            "<option value=\"{$row2['USER_ID']}\">{$row2['IDO']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <br><br>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                  </form>
                  <br><br><br>
                  <?php
                    //Removes 'new' badge and reduces notif's count
                    if($row['IF_NEW']){
                      $query2='UPDATE INCIDENT_REPORTS SET IF_NEW=0 WHERE INCIDENT_REPORT_ID='.$_GET['irn'];
                      $result2=mysqli_query($dbc,$query2);
                      if(!$result2){
                        echo mysqli_error($dbc);
                      }
                    }
                  ?>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

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

    <!-- gmail -->
    <?php //include '../gmail/send-email.php'; ?>

    <script type='text/javascript'>
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
            url: '../ajax/hdo-notif-cases.php',
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

      var caseData;

      //new
      $('.chosen-select').chosen({width: '100%'});

      //new
      $('#offense').on('change',function() {
        var offense_id=$(this).val();
        if(offense_id==1) {
          $('#cheat').show();
        }
        else{
          $('#cheat').hide();
        }

        $.ajax({
          url: 'hdo-get-details.php',
          type: 'POST',
          data: {
            offense: offense_id
          },
          success: function(response) {
            $('#detailarea').show();
            $("#details2").html(response);
            $("#details2").trigger("chosen:updated");
          }
        });
      });

      $('form').submit(function(e) {
        e.preventDefault();
      });

      $('#submit').click(function(){

        var ids = ['#offense','#ido'];
        var isEmpty = true;

        if($('#cheat').is(":visible")){
          ids.push('#cheat-type');
        }
        else{
          if($.inArray('#cheat-type', ids) !== -1){
            ids.splice(ids.indexOf('#cheat-type'),1);
          }
        }

        if($('#detailarea').is(":visible")){
          ids.push('#details2');
        }
        else{
          if($.inArray('#details2', ids) !== -1){
            ids.splice(ids.indexOf('#details2'),1);
          }
        }

        for(var i = 0; i < ids.length; ++i ){
          if($.trim($(ids[i]).val()).length == 0){
            isEmpty = false;
          }
        }

        if(isEmpty) {
          handle('<?php echo $passData;?>');
          $('#waitModal').modal("show");
          $.ajax({
              url: '../ajax/hdo-insert-case.php',
              type: 'POST',
              data: {
                  incidentreportID: <?php echo $_GET['irn']; ?>,
                  studentID: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
                  offenseID: $('#offense').val(),
                  cheatingType: $('#cheat-type').val(),
                  complainantID: <?php echo $row['COMPLAINANT_ID']; ?>,
                  dateIncident: "<?php echo $row['DATE_INCIDENT']; ?>",
                  location: "<?php echo $row['LOCATION']; ?>",
                  details: $('#details2').val(),
                  assignIDO: $('#ido').val(),
                  page: "HDO-VIEW-CASE"
              },

              success: function(response) {
                var string = "Case #";
                caseData = string.concat(response);
              }
          });
          $('#message').text('Submitted successfully!');
          $('#form').find('input, textarea, button, select').attr('disabled','disabled');
          $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
          //$('#submit').text("Submitted"); // copy for fill out form
        }

        else{
          $('#done').hide();
          $("#alertModal").modal("show");
        }
      });

      $('#modalOK').click(function() {
        //checks if all necessary values are filled out
        if ($('#message').text() == "Submitted successfully!"){
          //gets IDOs email address
          var idoemail;
          <?php
          $idoquery='SELECT USER_ID, CONCAT(FIRST_NAME," ",LAST_NAME) AS IDO, EMAIL AS IDO_EMAIL FROM USERS WHERE USER_TYPE_ID = 4';
          $idoresult=mysqli_query($dbc,$idoquery);
          if(!$idoresult){
            echo mysqli_error($dbc);
          }
          else{
            while($idorow=mysqli_fetch_array($idoresult,MYSQLI_ASSOC)){ ?>
              var idorow = "<?php echo $idorow['USER_ID']; ?>";
              if (idorow == $('#ido').val()){
                idoemail = "<?php echo $idorow['IDO_EMAIL']; ?>";
              }
          <?php
            }
          }?>

          //sets complainant and student emails
          /*var complainantemail = "<?php echo $row['COMPLAINANT_EMAIL']; ?>";
          var studentemail = "<?php echo $row['STUDENT_EMAIL']; ?>";

          //sends emails
          sendEmail(complainantemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');
          sendEmail(studentemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');
          sendEmail(idoemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');*/

          //hides modal
          $("#alertModal").modal("hide");
        }
        else{
          //hides modal
          $("#alertModal").modal("hide");
        }
      });

      $('#folderBtn').click(function() {
        newCaseFolder(caseData);
      });

      //Changes button text and disabled
      <?php
        $query2='SELECT   RO.DESCRIPTION AS DESCRIPTION,
                          CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS IDO
                FROM 		  CASES C
                JOIN      REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
                JOIN      USERS U ON C.HANDLED_BY_ID = U.USER_ID
                WHERE     C.INCIDENT_REPORT_ID = "'.$_GET['irn'].'"';
        $result2=mysqli_query($dbc,$query2);
        if(!$result2){
          echo mysqli_error($dbc);
        }
        else{
          if($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){ ?>
            $('#form').find('button, select').attr('disabled',true);
            $('#details').attr('readonly',true);
            $(".chosen-select").attr('disabled', true).trigger("chosen:updated");
            $('#submit').text("Submitted");
            $('select[class=chosen-select] > option:first-child').text('<?php echo $row2['DESCRIPTION']; ?>').trigger("chosen:updated");
            $('select[id=ido] > option:first-child').text('<?php echo $row2['IDO']; ?>');
            $('#details').val('<?php echo $row['DETAILS']; ?>');
        <?php }
        } ?>

        $('.modal').attr('data-backdrop', "static");
        $('.modal').attr('data-keyboard', false);
    });

    </script>

    <!-- Modal -->
		<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><b>Student Apprehension</b></h4>
					</div>
					<div class="modal-body">
						<p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</p>
            <div id = "done">
              </p>Case has been created and passed to the assigned IDO successfully!</p>
              <b>Next Step: </b> <br>  Forward the received pieces of evidence sent by the facutly to <b>ido.cms1@gmail.com</b> for processing.</p>
            </div>
          </div>
					<div class="modal-footer">
						<button type="button" id = "modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
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
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "btnSubmit()">Upload</button>
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
            <h4 class="modal-title" id="myModalLabel"><b>File Upload</b></h4>
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

    <!-- Folder Modal -->
    <div class="modal fade" id="folderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><b>Google Authentication</b></h4>
          </div>
          <div class="modal-body">
            <p> Thank you for authenticating the use of Google Drive.</p>
          </div>
          <div class="modal-footer">
            <button type="submit" id = "folderBtn" class="btn btn-default">Ok</button>
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
</body>

</html>
