<?php include 'do.php' ?>
<?php
if (!isset($_GET['irn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/cms/php/do-home.php");
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

    <!-- FOR SEARCHABLE DROP-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="./extra-css/bootstrap-chosen.css"/>

</head>

<body>

  <?php
    require_once('./mysql_connect.php');
  ?>

    <div id="wrapper">

        <?php include 'do-sidebar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Incident Report No.: <?php echo $_GET['irn']; ?></h3>

                <div class="col-lg-12">
                  <?php
                    //Gets incident report data
                    $query2='SELECT 	 IR.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                                       IR.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                                       CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS STUDENT,
                                       IR.DETAILS AS DETAILS,
                                       IR.COMPLAINANT_ID AS COMPLAINANT_ID,
                                       CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS COMPLAINANT,
                                       DATE_FILED,
                                       STATUS,
                                       IR.IF_NEW AS IF_NEW
                            FROM 	  	 INCIDENT_REPORTS IR
                            JOIN	     USERS U ON IR.COMPLAINANT_ID = U.USER_ID
                            JOIN	     USERS U2 ON IR.REPORTED_STUDENT_ID = U2.USER_ID
                            WHERE		   IR.INCIDENT_REPORT_ID = "'.$_GET['irn'].'"
                            ORDER BY 	 IR.DATE_FILED';
                    $result2=mysqli_query($dbc,$query2);

                    //Gets list of offenses
                    $query3='SELECT OFFENSE_ID, DESCRIPTION FROM REF_OFFENSES';
                    $result3=mysqli_query($dbc,$query3);
                    if(!$result2 && !$result3){
                      echo mysqli_error($dbc);
                    }
                    else{
                      $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
                    }
                  ?>
                  <form id="form">
                    <div class="form-group" style='width: 300px;'>
                      <label>Student</label>
                      <input class="form-control" value="<?php echo $row2['REPORTED_STUDENT_ID'].' : '.$row2['STUDENT']; ?>" readonly>
                    </div>
                    <div class="form-group" style='width: 300px;'>
                      <label>Offense <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="offense" class="chosen-select" required>
                        <option value="" disabled selected>Select Offense</option>
                        <?php
                        while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
                          echo
                            "<option value=\"{$row3['OFFENSE_ID']}\">{$row3['DESCRIPTION']}</option>";
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
                      <label>Complainant</label>
                      <input class="form-control" value="<?php echo $row2['COMPLAINANT_ID'].' : '.$row2['COMPLAINANT']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Details</label>
                      <textarea class="form-control" rows="3" readonly><?php echo $row2['DETAILS']; ?></textarea>
  				          </div>
                    <div class="form-group">
  				            <label>Comments <span style="font-weight:normal; font-style:italic; font-size:12px;">(Optional)</span></label>
                      <textarea id="comments" class="form-control" rows="3"></textarea>
                    </div>
                    <br><br>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                  </form>
                  <br><br><br>
                  <?php
                    //Removes 'new' badge and reduces notif's count
                    if($row2['IF_NEW']){
                      $query3='UPDATE INCIDENT_REPORTS SET IF_NEW=0 WHERE INCIDENT_REPORT_ID="'.$_GET['irn'].'"';
                      $result3=mysqli_query($dbc,$query3);
                      if(!$result3){
                        echo mysqli_error($dbc);
                      }
                    }

                    include 'do-notif-queries.php';

                    if($row2['STATUS']=="For review by Head of DO"){
                      $query3='SELECT C.OFFENSE_ID AS OFFENSE_ID,
                              			  RO.DESCRIPTION AS DESCRIPTION,
                                      C.COMMENTS AS COMMENTS
                              FROM 		CASES C
                              JOIN		REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
                              WHERE   C.INCIDENT_REPORT_ID = "'.$_GET['irn'].'"';
                      $result3=mysqli_query($dbc,$query3);
                      if(!$result3){
                        echo mysqli_error($dbc);
                      }
                      else{
                        $row3=mysqli_fetch_array($result3,MYSQLI_ASSOC);
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

    <script type='text/javascript'>
    $(document).ready(function() {
      <?php include 'do-notif-scripts.php' ?>

      $('.chosen-select').chosen();

      $('#offense').on('change',function() {
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
        });

        $('#submit').click(function(){
          var isEmpty = true;
          if ($.trim($('#offense').val()).length == 0) {
            isEmpty = false;
          }
          if(isEmpty) {
            $('#message').text('Submitted successfully!');
          }
          else {
            $('#message').text('Please fill all the required (*) fields!');
          }
          $.ajax({
              url: '../ajax/do-insert-case.php',
              type: 'POST',
              data: {
                  incidentreportID: <?php echo $_GET['irn']; ?>,
                  studentID: <?php echo $row2['REPORTED_STUDENT_ID']; ?>,
                  offenseID: $('#offense').val(),
                  otherOffense: $('#other-offense').val(),
                  cheatingType: $('#cheat-type').val(),
                  complainantID: <?php echo $row2['COMPLAINANT_ID']; ?>,
                  details: "<?php echo $row2['DETAILS']; ?>",
                  comments: $('#comments').val()
              },
              success: function(msg) {
                  <?php $message="Submitted successfully!"; ?>
                  $("#alertModal").modal("show");
              }
          });

          $('#form').find('input, textarea, button, select').attr('disabled','disabled');
          $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
        });
    });

    //Changes button text and disabled
    <?php
      if($row2['STATUS']=="For review by Head of DO"){ ?>
        $('#form').find('input, textarea, button, select').attr('disabled','disabled');
        $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
        $('#comments').text("<?php echo $row3['COMMENTS']; ?>");
        $('#submit').text("Submitted");
        $('select[class=chosen-select] > option:first-child').text('<?php echo $row3['DESCRIPTION']; ?>');
    <?php } ?>

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
