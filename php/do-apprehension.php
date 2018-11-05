<?php include 'do.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Apprehension</title>

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

    <!-- FOR SEARCHABLE DROP -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
    <link rel = "stylesheet" href = "./extra-css/bootstrap-chosen.css"/>

</head>

<body>

  <?php
    require_once('./mysql_connect.php');

    include 'do-notif-queries.php'
  ?>

    <div id="wrapper">

        <?php include 'do-sidebar.php';?>

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
                      <input id="studentID" name="studentID" pattern="[0-9]{8}" minlength="8" maxlength="8" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter ID No." required/>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Offense <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="offense" class="form-control" required>
                        <option value="" disabled selected>Select Offense</option>
                        <?php
                        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                          echo
                            "<option value=\"{$row2['OFFENSE_ID']}\">{$row2['DESCRIPTION']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div id="other" class="form-group" style="width: 300px;" hidden>
                      <label>If other, please specify <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="other-offense" class="form-control"></input>
                    </div>
                    <div id="cheat" class="form-group" style='width: 300px;' hidden>
                      <label>Type of Cheating <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="cheat-type" class="form-control">
                        <option value="" disabled selected>Select Type</option>
                        <option value="withkodigo">With Kodigo</option>
                        <option value="glancing">Glancing</option>
                        <option value="searching">Searching</option>
                      </select>
                    </div>
                    <div class="form-group" style = "width: 300px;">
                      <label>Complainant <span style="font-weight:normal; font-style:italic; font-size:12px;">(Ex. 20151234)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <input id="complainantID" pattern="[0-9]{8}" minlength="8" maxlength="8" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter ID No." required/>
                    </div>
                    <div class="form-group">
                      <label>Details <span style="font-weight:normal; font-style:italic; font-size:12px;">(Please be specific)</span> <span style="font-weight:normal; color:red;">*</span></label>
                      <textarea id="details" class="form-control" rows="3" required></textarea>
  				          </div>
                    <br><br>
                    <button type="submit" id="apprehend" name="apprehend" class="btn btn-primary">Apprehend</button>
                  </form>
                  <br><br><br>
                </div>
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
    $(document).ready(function() {
        <?php include 'do-notif-scripts.php'?>
    });

    function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
    }

    /*$('#offense').on('change',function() {
      var offense_id=$(this).val();
      if(offense_id==1) {
        $('#other').hide();
        $('#other-offense').attr('required','false');
        $('#cheat').show();
        $('#cheat-type').attr('required','true');
      }
      else if(offense_id==8) {
        $('#other').show();
        $('#other-offense').attr('required','true');
        $('#cheat').hide();
        $('#cheat-type').attr('required','false');
      }
      else{
        $('#other').hide();
        $('#other-offense').attr('required','false');
        $('#cheat').hide();
        $('#cheat-type').attr('required','false');
      }
    });*/

    $('form').submit(function(e) {
      e.preventDefault();
      $.ajax({
          url: '../ajax/do-insert-case.php',
          type: 'POST',
          data: {
              incidentreportID: 0,
              studentID: $('#studentID').val(),
              offenseID: $('#offense').val(),
              otherOffense: $('#other-offense').val(),
              cheatingType: $('#cheat-type').val(),
              complainantID: $('#complainantID').val(),
              details: $('#details').val(),
              comments: ""
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
						<h4 class="modal-title" id="myModalLabel"><b>Student Apprehension</b></h4>
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
