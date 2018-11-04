<?php include 'faculty.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Report Student</title>

	<!-- Webpage Icon -->
	<link rel="icon" href="../images/favicon.ico">

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
    <?php $message = NULL ?>
    <div id="wrapper">

        <?php include 'faculty-sidebar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Incident Report</h3>

                <div class="col-lg-12">
                  <form id="form">
                    <div class="form-group" style = "width: 200px;">
                      <label>Student ID No. <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 11530022)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter ID No." required />
                    </div>
                    <div class="form-group">
                      <label>Details  <span style="font-weight:normal; font-style:italic; font-size:12px;">(Please be specific)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <textarea id="details" name="details" class="form-control" rows="3" required></textarea>
                    </div>
                    <br><br>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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

    <script>
    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
    }

    $('form').submit(function(e) {
      e.preventDefault();
      $.ajax({
          url: '../ajax/faculty-insert-incident-report.php',
          type: 'POST',
          data: {
              studentID: $('#studentID').val(),
              details: $('#details').val()
          },
          success: function(msg) {
              <?php $message="Submitted successfully!"; ?>
              $("#alertModal").modal("show");
          }
      });
      $('#form')[0].reset();
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
						<?php echo $message; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
    </div>

</body>

</html>
