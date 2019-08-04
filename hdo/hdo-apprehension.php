<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Apprehension</title>

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

    <!--Datetimepicker -->
    <!-- scripts from calendar api  -->
    <link rel="stylesheet" href="../extra-css/jquery.datetimepicker.min.css" />
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="../extra-css/jquery.datetimepicker.min.js"></script>

    <!-- GDRIVE -->

    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/hdo-addNewFolder3.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js">
    </script>
    <script src="../gdrive/upload.js"></script>

</head>

<body>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Student Apprehension</h3>

                <div class="col-lg-12">
                  <?php
                    //Gets list of offenses
                    $query2='SELECT OFFENSE_ID, DESCRIPTION FROM REF_OFFENSES';
                    $result2=mysqli_query($dbc,$query2);
                    if(!$result2){
                      echo mysqli_error($dbc);
                    }
                  ?>
                  <form id="form">
                    <div class="form-group" style='width: 300px;'>
                      <label>Student <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="studentID" class="chosen-select">
                          <option value="" disabled selected>Select student</option>
                          <?php
                            $studentQ= "SELECT * FROM cms.users u WHERE u.user_type_id = 1 ORDER BY 5;";
                            $studentRes = $dbc->query($studentQ);
                            while($student = $studentRes->fetch_assoc()){
                              $studentName = $student['first_name'] . ' ' . $student['last_name'];
                              echo 
                                '<option value=' .$student['user_id']. '>' . $student['user_id'] . ' : ' . $studentName . '</option>';
                            }
                          ?>
                      </select>
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
                      //Gets list of cheat types
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
                      <label>Complainant <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="complainantID" class="chosen-select">
                          <option value="" disabled selected>Select complainant</option>
                          <?php
                            $complainantQ= "SELECT * FROM cms.users WHERE user_type_id != 1 ORDER BY 5;";
                            $complaiantRes = $dbc->query($complainantQ);
                            while($complainant = $complaiantRes->fetch_assoc()){
                              $complainantName = $complainant['first_name'] . ' ' . $complainant['last_name'];
                              if ($complainant['user_id'] != 1)
                                echo 
                                  '<option value=' .$complainant['user_id']. '>' . $complainant['user_id'] . ' : ' . $complainantName . '</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group" style = "width: 300px;">
                      <label>Date of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <div class='input-group date'>
                        <input id='date' type='text' class="form-control" placeholder="Enter Date"/>
                        <span id='cal' style="cursor: pointer;" class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Location of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="location" class="form-control">
                    </div>
                    <!-- new - edited from previous -->
                    <div id="detailarea" class="form-group" style='width: 300px;' hidden>
                      <label>Summary of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="details" class="chosen-select">
                      </select>
  				          </div>

                    <div class="form-group" style='width: 300px;'>
                      <label>Assign an IDO <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="ido" class="chosen-select">
                        <option value="" disabled selected>Select an IDO</option>
                        <?php
                          $idoQuery= "SELECT * FROM cms.users u WHERE u.user_type_id = 4;";
                          $IDORes = $dbc->query($idoQuery);
                          $ido_workloads = array();
                          $ido_names = array();

                          while($ido = $IDORes->fetch_assoc()){
                            $idoName = $ido['first_name'] . ' ' . $ido['last_name'];
                            $idoNumber = $ido['user_id'];
                            $workloadQuery = $dbc->query("SELECT COUNT(ic.case_id)
                                                          FROM ido_cases ic
                                                            LEFT JOIN cases c on ic.case_id=c.case_id
                                                            WHERE ic.user_id = ".$idoNumber."
                                                                && (c.status_id != 3 && c.status_id != 4)
                                                                && ic.handle = 1");
                            $workload = $workloadQuery->fetch_row();

                            if ($idoNumber != $row2['HANDLED_BY_ID'] && $workload[0] < 8) {
                              $ido_names[$idoNumber] = $idoName;
                              $ido_workloads[$idoNumber] = $workload[0];
                            }
                          }

                          asort($ido_workloads);
                          $ido_names_ordered = array();
                          
                          foreach (array_keys($ido_workloads) as $key) {
                            $ido_names_ordered[$key] = $ido_names[$key] ;
                          }
                          
                          foreach($ido_workloads as $x => $x_value) {
                            echo '<option value="' .$x. '">' . $ido_names[$x] . ' (Active Cases: ' .$ido_workloads[$x]. ')</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <br><br>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                  </form>
                  <br><br><br>
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

	  <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- gmail -->
    <?php //include '../gmail/send-email.php'; ?>

    <script>
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

      $('.chosen-select').chosen({width: '100%'});

      $("#date").datetimepicker({ format: 'Y-m-d H:i', maxDate: 0, maxTime: 0, step: 1});

      $('#cal').on('click', function() {
        $("#date").focus();
      })

      $('.studentID').keypress(validateNumber);
      $('.comID').keypress(validateNumber);

      $('#folderBtn').click(function() {
        //buttonAddfolder(caseData);

        newCaseFolder(caseData);
      });

      function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8 || event.keyCode === 46) {
            return true;
        } else if ( key < 48 || key > 57 ) {
            return false;
        } else {
            return true;
        }
      };

      $("#appendevidence").click(function(){
        $("#evidencelist").append('<div class="form-group input-group" id="newsevidence">'+
        '<span id="removeevidence" style="cursor: pointer; color:red; float: right;"><b>&nbsp;&nbsp; x</b></span>'+
        '<input type="file">'+

        '</div>');
      });

      $(document).on('click', '#removeevidence', function(){
        $(this).closest("#newsevidence").remove();
      });

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
            $("#details").html(response);
            $("#details").trigger("chosen:updated");
          }
        });
      });

      $('form').submit(function(e) {
        e.preventDefault();
      });

      $('#submit').click(function() {
        var ids = ['#studentID','#offense','#complainantID','#date','#location','#ido'];
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
          ids.push('#details');
        }
        else{
          if($.inArray('#details', ids) !== -1){
            ids.splice(ids.indexOf('#details'),1);
          }
        }

        for(var i = 0; i < ids.length; ++i ){
          if($.trim($(ids[i]).val()).length == 0){
            isEmpty = false;
          }
        }
        if(isEmpty) {
          $('#twoFactorModal').modal('show');
        }

        else {
          $("#done").hide();
          $("#alertModal").modal("show");
        }
      });

      $('#modalYes').on('click', function() {
        handleApprehend();
        $('#waitModal').modal("show");
        $.ajax({
            url: '../ajax/hdo-insert-case.php',
            type: 'POST',
            data: {
                incidentreportID: null,
                studentID: $('#studentID').val(),
                offenseID: $('#offense').val(),
                cheatingType: $('#cheat-type').val(),
                complainantID: $('#complainantID').val(),
                dateIncident: $('#date').val(),
                location: $('#location').val(),
                details: $('#details').val(),
                assignIDO: $('#ido').val(),
                page: "HDO-APPREHENSION"
            },
            success: function(response) {

              data = response.split("/");
              caseData = "Case #" + data[5];
              loadData(response);
              //$('#message').text('Submitted successfully!');
            }
        });
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
          //gets students email address
          <?php
          $studentquery='SELECT USER_ID, CONCAT(FIRST_NAME," ",LAST_NAME) AS STUDENT, EMAIL AS STUDENT_EMAIL FROM USERS WHERE USER_TYPE_ID = 1';
          $studentresult=mysqli_query($dbc,$studentquery);
          if(!$studentresult){
            echo mysqli_error($dbc);
          }
          else{
            while($studentrow=mysqli_fetch_array($studentresult,MYSQLI_ASSOC)){ ?>
              var studentrow = "<?php echo $studentrow['USER_ID']; ?>";
              if (studentrow == $('#studentID').val()){
                studentemail = "<?php echo $studentrow['STUDENT_EMAIL']; ?>";
              }
          <?php
            }
          }?>

          //sends emails
          //sendEmail(studentemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');
          //sendEmail(idoemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');

          $('#form')[0].reset();
          $(".chosen-select").trigger("chosen:updated");
          location.reload();
        }
        else{
          //hides modal
          $("#alertModal").modal("hide");
        }
      });

      $('.modal').attr('data-backdrop', "static");
      $('.modal').attr('data-keyboard', false);

      $('#modalOK').on('click', function() {
        if($('#done').is(":visible")) {
          location.reload();
        }
      })
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
            <p id = "done">Case has been created and passed to the assigned IDO successfully!</p>
            <p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</message>
					</div>
					<div class="modal-footer">
						<button type="button" id = "modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
    </div>


    <!-- NEW DRIVE  -->

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
