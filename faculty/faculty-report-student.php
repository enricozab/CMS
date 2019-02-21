<?php include 'faculty.php';
header("Access-Control-Allow-Origin: *");?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Report Student</title>

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


</head>

<body>

    <?php include 'faculty-notif-queries.php'; ?>

    <?php $message = NULL ?>
    <div id="wrapper">

        <?php include 'faculty-sidebar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
			
			  <!--Upload File-->
			  <!--<form enctype="multipart/form-data" action="upload.php" method="POST">
				<p>Upload your file</p>
				<input type="file" name="uploaded_file"></input><br />
				<input type="submit" value="Upload"></input>
			  </form>-->
			  
                <h3 class="page-header">Incident Report</h3>

                <div class="col-lg-12">
                  <form id="form">
                    <div id="studentinvolved">
                      <div class="form-group" style = "width: 300px;">
                        <label>Student ID No. <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 11530022)</span> <span style="font-weight:normal; color:red;">*</span></label>
                        <input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" class="studentID form-control" placeholder="Enter ID No."/>
                      </div>
                    </div>
                    <div id="appendstudent">
                      <span class="fa fa-plus" style="color: #337ab7;">&nbsp; <a style="color: #337ab7; font-family: Arial;">Add another student</a></span>
                    </div>
                    <br>
                    <div class="form-group" style = "width: 300px;">
                      <label>Location of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="location" name="location" class="form-control" placeholder="Enter Location"/>
                    </div>
                    <div class="form-group" style = "width: 180px;">
                      <label>Date of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="date" type="date" name="date" class="form-control"/>
                    </div>
                    <div class="form-group" style = "width: 180px;">
                      <label>Time of the Incident <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="time" type="time" name="time" class="form-control"/>
                    </div>
                    <div class="form-group">
                      <label>Please provide a summary of the incident <span style="font-weight:normal; color:red;">*</span></label>
                      <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5"></textarea>
                    </div>
                    <br>
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
                    <br><br>
                    <i>*Insert HelloSign*</i>
                    <br><br><br>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.9.1/docxtemplater.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.6.1/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.0.2/jszip-utils.js"></script>

    <script>
    $(document).ready(function() {

      <?php include 'faculty-notif-scripts.php' ?>
	  <?php  include 'faculty-form-queries.php'  ?>

      $('.studentID').keypress(validateNumber);

      $(document).on('keypress', '.studentID', function(){
        $(this).keypress(validateNumber);
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

      $("#appendstudent").click(function(){
        $("#studentinvolved").append('<div class="form-group input-group" style="width: 300px;" id="newstudent"><input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" class="studentID form-control" placeholder="Enter ID No."/>'+
        '<span id="removestudent" style="cursor: pointer;" class="input-group-addon"><span style="color:red;" class="fa fa-times"></span></span>'+
        '</div>');
      });

      $("#appendevidence").click(function(){
        $("#evidencelist").append('<div class="form-group input-group" id="newsevidence">'+
        '<span id="removeevidence" style="cursor: pointer; color:red; float: right;"><b>&nbsp;&nbsp; x</b></span>'+
        '<input type="file">'+

        '</div>');
      });

      $(document).on('click', '#removestudent', function(){
        $(this).closest("#newstudent").remove();
      });

      $(document).on('click', '#removeevidence', function(){
        $(this).closest("#newsevidence").remove();
      });
	  
	  $('#modalOK').click(function() {
		  
        //$('#form')[0].reset();
        $("#alertModal").modal("hide");
		
		//document.getElementById('inputfile').innerHTML;
		
		//HELLOSIGN API
		$.ajax({
                url: '../ajax/faculty-hellosign.php',
                type: 'POST',
                data: {
					title : "Incident Report",
					subject : "Incident Report Document Signature",
					message : "Please do sign this document.",
                    fname : "<?php echo $nameres['first_name'] ?>",
					lname : "<?php echo $nameres['last_name'] ?>",
					email : "<?php echo $nameres['email'] ?>",
					filename : $('#inputfile').val()
				
                },
				
                success: function(response) {
					//$("#alertModal").modal("show");
					alert("Incident Report sent to your email! Check to sign the form.");
				}
		})
		//HELLOSIGN API
		
      });
	  
      $('form').submit(function(e) {
        e.preventDefault();
      });

      $('#modalOK').click(function() {
        $('#form')[0].reset();
        $("#alertModal").modal("hide");
      });

      $('form').submit(function(e) {
        e.preventDefault();
      });
      var studentlist = [];

      $('#submit').click(function() {
          $("#alertModal").modal("show");

          var ids = ['#location','#date','#time','textarea'];
          var isEmpty = true;

          $('.studentID').each(function(i, obj){
            if(obj.value.length == 0){
              isEmpty = false;
            }
            studentlist.push(parseInt(obj.value));
          });

          for(var i = 0; i < ids.length; ++i ) {
            if($.trim($(ids[i]).val()).length == 0) {
              isEmpty = false;
            }
          }

          if(isEmpty) {
            $.ajax({
                url: '../ajax/faculty-insert-incident-report.php',
                type: 'POST',
                data: {
                    studentID: studentlist,
                    location: $('#location').val(),
                    date: $('#date').val(),
                    time: $('#time').val(),
                    details: $('#details').val()
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
                      doc.setData({
                        date: today,
                        details: "<?php echo $officerow['description'] ?>",
                        college: stud.description,
                        studentF: stud.first_name,
                        studentL: stud.last_name,
                        idn: stud.user_id,
                        degree: stud.student_degree,
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
                      saveAs(out,"output.docx");
                  });

                success: function(msg) {
                    generate();
                    $('#message').text('Submitted successfully!');
                }
            });
          }

          <?php  include 'faculty-form-queries.php'  ?>

          function loadFile(url,callback){
              JSZipUtils.getBinaryContent(url,callback);
          }

          function generate(){
            for(var i = 0; i < studentlist.length; ++i ) {
              $.ajax({
                  url: '../ajax/get-student-info.php',
                  type: 'POST',
                  data: {
                      studentID: studentlist[i]
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
                        doc.setData({
                          formNum: "<?php echo $formres['incident_report_id'] ?>",
                          date: today,
                          first: "<?php echo $nameres['first_name'] ?>",
                          last: "<?php echo $nameres['last_name'] ?>",
                          details: "<?php echo $officerow['description'] ?>",
                          college: stud.description,
                          studentF: stud.first_name,
                          studentL: stud.last_name,
                          idn: stud.user_id,
                          degree: stud.student_degree,
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
                        saveAs(out,"output.docx");
                    });
                  }
              });
            }
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
						<h4 class="modal-title" id="myModalLabel"><b>Incident Report</b></h4>
					</div>
					<div class="modal-body">
						<p id="message">Please fill in all the required ( <span style="color:red;">*</span> ) fields!</p>
					</div>
					<div class="modal-footer">

			  <!--Upload File-->
			  <!--<form enctype="multipart/form-data" action="uploadfile.php" method="POST">
				<p>Upload your file</p>
				<input type="file" name="uploaded_file"></input><br />
				<input type="submit" value="Upload"></input>
			  </form>-->

			  <button type="submit" id = "modalOK" class="btn btn-default">Ok</button>
					</div>
				</div>
			</div>
    </div>

</body>

</html>
