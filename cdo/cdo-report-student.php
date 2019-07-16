<?php include 'cdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Encode Incident Report</title>

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

    <!-- FOR SEARCHABLE DROP-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body>

    <?php $message = NULL ?>
    <div id="wrapper">

    <?php include 'cdo-sidebar.php'; ?>
		<?php include 'cdo-form-queries.php'; ?>

        <div id="page-wrapper">
            <div class="row">
              <div class="col-lg-8">
                <h3 class="page-header">Encode Incident Report</h3>
              </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                  <form id="form">
                    <div class="form-group" style = "width: 300px;">
                      <label>Complainant <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="complainantID" class="chosen-select">
                          <option value="" disabled selected>Select complainant</option>
                          <?php
                            $complainantQ= "SELECT * FROM cms.users WHERE user_type_id != 1 ORDER BY 5;";
                            $complaiantRes = $dbc->query($complainantQ);
                            while($complainant = $complaiantRes->fetch_assoc()){
                              $complainantName = $complainant['first_name'] . ' ' . $complainant['last_name'];
                              echo 
                                '<option value=' .$complainant['user_id']. '>' . $complainant['user_id'] . ' : ' . $complainantName . '</option>';
                            }
                          ?>
                        </select>
                    </div>
                    <div id="studentinvolved">
                      <div class="form-group" style = "width: 300px;">
                        <label>Student ID No. <span style="font-weight:normal; color:red;">*</span></label>
                        <select id="studentID" class="chosen-select">
                          <option value="" disabled selected>Select student</option>
                          <?php
                            $studentQ= "SELECT * FROM cms.users u WHERE u.user_type_id = 1;";
                            $studentRes = $dbc->query($studentQ);
                            while($student = $studentRes->fetch_assoc()){
                              $studentName = $student['first_name'].' '.$student['last_name'];
                              echo 
                                '<option value='.$student['user_id'].'>'.$student['user_id'].' : '.$studentName.'</option>';
                            }
                          ?>
                        </select>
                        <!--<input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" class="studentID form-control" placeholder="Enter ID No."/>-->
                      </div>
                    </div>
                    <!-- <div id="appendstudent">
                      <span class="fa fa-plus" style="color: #337ab7;">&nbsp; <a style="color: #337ab7; font-family: Arial;">Add another student</a></span>
                    </div>
                    <br> -->
                    <div class="form-group" style = "width: 300px;">
                      <label>Location of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="location" name="location" class="form-control" placeholder="Enter Location"/>
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
                    <div class="form-group">
                      <label>Please provide a summary of the incident <span style="font-weight:normal; color:red;">*</span></label>
                      <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5" placeholder="Enter Summary of the Incident"></textarea>
                    </div>
                    <br><br><br>
                    <button type="submit" id="2factor" name="submit" class="btn btn-primary">Submit</button>
                  </form>
                  <br><br><br>
                </div>

                <div class="col-lg-6">
                </div>
                <!-- /.col-lg-12 -->
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

    <!--Datetimepicker -->
    <!-- scripts from calendar api  -->
    <link rel="stylesheet" href="../extra-css/jquery.datetimepicker.min.css" />
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> -->
    <script src="../extra-css/jquery.datetimepicker.min.js"></script>

    <!-- Form Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.9.1/docxtemplater.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.6.1/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.0.2/jszip-utils.js"></script>

    <script>
    $(document).ready(function() {
      loadNotif();

      $('.chosen-select').chosen({width: '100%'});

      function loadNotif () {
          $.ajax({
            url: '../ajax/cdo-notif-cases.php',
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

      var titleForm;

      $("#date").datetimepicker({ format: 'Y-m-d H:i', maxDate: 0, maxTime: 0, step: 1});

      $('#cal').on('click', function() {
        $("#date").focus();
      });

      // $('.studentID').keypress(validateNumber);

      // $(document).on('keypress', '.studentID', function(){
      //   $(this).keypress(validateNumber);
      // });

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

      // $("#appendstudent").click(function() {
      //   $("#studentinvolved").append('<div class="form-group input-group" style="width: 300px;" id="newstudent"><input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" class="studentID form-control" placeholder="Enter ID No."/>'+
      //   '<span id="removestudent" style="cursor: pointer;" class="input-group-addon"><span style="color:red;" class="fa fa-times"></span></span>'+
      //   '</div>');
      // });

      // $(document).on('click', '#removestudent', function(){
      //   $(this).closest("#newstudent").remove();
      // });

      // $(document).on('click', '#removeevidence', function(){
      //   $(this).closest("#newsevidence").remove();
      // });

      $('form').submit(function(e) {
        e.preventDefault();
      });

      var studentlist = [];

      $('#2factor').click(function() {
        var ids = ['#complainantID','#studentID','#location','#date','textarea'];
        var isEmpty = true;

        for(var i = 0; i < ids.length; ++i ) {
          if($.trim($(ids[i]).val()).length == 0) {
            isEmpty = false;
          }
        }
        if(isEmpty) {
          $("#twoFactorModal").modal("show");
        }
        else {
          $("#alertModal").modal("show");
        }
      });

      $('#modalYes').click(function() {
        $.ajax({
          url: '../ajax/cdo-insert-incident-report.php',
          type: 'POST',
          data: {
            complainantID: $('#complainantID').val(),
            studentID: $('#studentID').val(),
            location: $('#location').val(),
            date: $('#date').val(),
            details: $('#details').val()
          },
          success: function(msg) {
              generate();
              //$("#message").text('Incident Report has been submitted and sent to your email successfully! Check your email to sign the form.');
              $("#sendModal").modal("show");
          }
        });
      });

      // $('#submit').click(function() {
        
      // });

      <?php  include 'cdo-form-queries.php'  ?>

      //generate incident report form (doc file)
      function loadFile(url,callback){
          JSZipUtils.getBinaryContent(url,callback);
      }
      function generate(){
        $.ajax({
          url: '../ajax/get-student-info.php',
          type: 'POST',
          data: {
              studentID: $('#studentID').val()
          },
          success: function(response) {
            var stud = JSON.parse(response);
            loadFile("../templates/template-incident-report.docx",function(error,content){
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

                titleForm = "Incident Report Form #" + formNumber + ".docx";
                doc.setData({
                  <?php
                  if ($formres['MAX'] != null) { ?>
                    formNum: <?php echo $formres['MAX'] ?>,
                  <?php }
                  else { ?>
                    formNum: 1,
                  <?php }
                  ?>
                  date: today,
                  first: "<?php echo $nameres['first_name'] ?>",
                  last: "<?php echo $nameres['last_name'] ?>",
                  details: "<?php echo $officerow['description'] ?>",
                  college: stud.description,
                  studentF: stud.first_name,
                  studentL: stud.last_name,
                  idn: stud.user_id,
                  degree: stud.degree,
                  loc: document.getElementById("location").value,
                  dateIncident: document.getElementById("date").value,
                  summary: document.getElementById("details").value
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
                saveAs(out,titleForm,  {
                  locURL: "/localhost/CMS/ajax"
                });
            });
          }
        });
      }

      $('#sentOK').on('click', function() {
        location.reload();
      });
      
      // $('#sentOK').on('click', function() {
      //     $.ajax({
      //           url: '../ajax/users-hellosign.php',
      //           type: 'POST',
      //           data: {
      //               formT: titleForm,
      //               title : "Incident Report",
      //               subject : "Incident Report Document Signature",
      //               message : "Please do sign this document and forward it, along with your pieces of evidence, to hdo.cms@gmail.com",
      //               fname : "<?php echo $nameres['first_name'] ?>",
      //               lname : "<?php echo $nameres['last_name'] ?>",
      //               email : "<?php echo $nameres['email'] ?>",
      //               filename : $('#inputfile').val()
      //           },
      //           success: function(response) {
      //             location.reload();
      //         }
      //     });

      // });

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
						<h4 class="modal-title" id="myModalLabel"><b>Incident Report</b></h4>
					</div>
					<div class="modal-body">
						<p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</p>
					</div>
					<div class="modal-footer">
            <button type="submit" id = "modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
    </div>

    <!-- Modal2 -->
    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><b>Instructions</b></h4>
          </div>
          <div class="modal-body">
            <p id="message">Incident Report has been downloaded successfully! 
            <!-- <br><br> <b>Next Steps: </b> <br> <b>(1)</b> Check your email to sign the form. <br> <b>(2)</b> Forward the file, along with your pieces of evidence, to <b>hdo.cms@gmail.com</b> for processing. </p> -->
            <br><br> <b>Next Step: </b> Send the Incident Report together with the pieces of evidence to <b>hdo.cms@gmail.com</b> for processing. </p>
          </div>
          <div class="modal-footer">
            <button type="submit" id = "sentOK" class="btn btn-default" data-dismiss="modal">Ok</button>
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