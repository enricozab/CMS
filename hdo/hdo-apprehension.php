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

    <!--Datetimepicker -->
    <!-- scripts from calendar api  -->
    <link rel="stylesheet" href="../extra-css/jquery.datetimepicker.min.css" />
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="../extra-css/jquery.datetimepicker.min.js"></script>

    <!-- GDRIVE -->

    <script src="../gdrive/date.js" type="text/javascript"></script>
    <script src="../gdrive/addFolder4.js" type="text/javascript"></script>
    <script async defer src="https://apis.google.com/js/api.js"
          onload="this.onload=function(){};handleClientLoad()"
          onreadystatechange="if (thigoogle-s.readyState === 'complete') this.onload()">
    </script>
    <script src="../gdrive/upload.js"></script>

</head>

<body>

  <?php
    include 'hdo-notif-queries.php'
  ?>

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
                      <label>Student <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 11530022)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="studentID" name="studentID" value="11530022" pattern="[0-9]{8}" minlength="8" maxlength="8" class="studentID form-control" placeholder="Enter ID No."/>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Offense <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="offense" class="chosen-select">
                        <option value="" disabled selected>Select Offense</option>
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
                      <label>Complainant <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 20151234)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="complainantID" value="20171234" pattern="[0-9]{8}" minlength="8" maxlength="8" class="comID form-control" placeholder="Enter ID No."/>
                    </div>
                    <div class="form-group" style = "width: 300px;">
                      <label>Date of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <div class='input-group date'>
                        <input  id='date' type='text' class="form-control" placeholder="Enter Date"/>
                        <span id='cal' style="cursor: pointer;" class="input-group-addon">
                            <span class="fa fa-calendar"></span>
                        </span>
                      </div>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Location of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="location" value="G201" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Summary of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <textarea id="details" style="width:600px;" class="form-control" rows="3">MAMAMO</textarea>
  				          </div>
                    <?php
                      $query2='SELECT USER_ID, CONCAT(FIRST_NAME," ",LAST_NAME) AS IDO FROM USERS WHERE USER_TYPE_ID = 4';
                      $result2=mysqli_query($dbc,$query2);
                      if(!$result2){
                        echo mysqli_error($dbc);
                      }
                    ?>
                    <div class="form-group">
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
                    <br>
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
    <?php include '../gmail/send-email.php'; ?>

    <script>
    $(document).ready(function() {
      // NEW DRIVE
      var caseData;

      $('#folderBtn').click(function() {
        buttonAddfolder(caseData);
      });
      // END DRIVE

      <?php include 'hdo-notif-scripts.php'?>

      $('.chosen-select').chosen();

      $("#date").datetimepicker({ format: 'Y-m-d H:i', maxDate: 0, maxTime: 0, step: 1});

      $('#cal').on('click', function() {
        $("#date").focus();
      })

      $('.studentID').keypress(validateNumber);
      $('.comID').keypress(validateNumber);

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
      });

      $('form').submit(function(e) {
        e.preventDefault();
      });

      $('#submit').click(function() {
        $('#waitModal').modal("show"); // new drive
        var ids = ['#studentID','#offense','#complainantID','#date','#location','#details','#ido'];
        var isEmpty = true;

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
                  page: "HDO-APPREHENSION" // NEW DRIVE
              },

              success: function(response) {

                data = response.split("/");
            		caseData = "Case #" + data[5];
                loadData(response);
              } // END NEW DRIVE
          });
          //$('#message').text('Submitted successfully!');
          $('#form')[0].reset();
          $(".chosen-select").trigger("chosen:updated");
        }

        //$("#alertModal").modal("show");
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
          sendEmail(studentemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');
          sendEmail(idoemail,'[CMS] Case Created on ' + new Date($.now()), 'Message');

          //hides modal
          $("#alertModal").modal("hide");
          $('#form')[0].reset();
          $(".chosen-select").trigger("chosen:updated");
        }
        else{
          //hides modal
          $("#alertModal").modal("hide");
        }
      });

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
    
</body>

</html>
