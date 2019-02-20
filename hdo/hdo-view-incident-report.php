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
                      <textarea id="details" class="form-control" style="width:600px;" rows="5"><?php echo $row['DETAILS']; ?></textarea>
  				          </div>
                    <br>
                    <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
                    <br><br><br>
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
                      $query2='UPDATE INCIDENT_REPORTS SET IF_NEW=0 WHERE INCIDENT_REPORT_ID="'.$_GET['irn'].'"';
                      $result2=mysqli_query($dbc,$query2);
                      if(!$result2){
                        echo mysqli_error($dbc);
                      }
                    }

                    include 'hdo-notif-queries.php';
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
      <?php include 'hdo-notif-scripts.php' ?>

      $('.chosen-select').chosen();

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

      $('#submit').click(function(){
        var ids = ['#offense','#details','#ido'];
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
          console.log($('#details').val());
          $.ajax({
              url: '../ajax/hdo-insert-case.php',
              type: 'POST',
              data: {
                  incidentreportID: <?php echo $_GET['irn']; ?>,
                  studentID: <?php echo $row['REPORTED_STUDENT_ID']; ?>,
                  offenseID: $('#offense').val(),
                  cheatingType: $('#cheat-type').val(),
                  complainantID: <?php echo $row['COMPLAINANT_ID']; ?>,
                  location: "<?php echo $row['LOCATION']; ?>",
                  details: $('#details').val(),
                  assignIDO: $('#ido').val()
              }
          });
          $('#message').text('Submitted successfully!');
          $('#form').find('input, textarea, button, select').attr('disabled','disabled');
          $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
          $('#submit').text("Submitted"); // copy for fill out form
        }

        $("#alertModal").modal("show");
      });
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
          $(".chosen-select").attr('disabled', true).trigger("chosen:updated")
          $('#submit').text("Submitted");
          $('select[class=chosen-select] > option:first-child').text('<?php echo $row2['DESCRIPTION']; ?>');
          $('select[id=ido] > option:first-child').text('<?php echo $row2['IDO']; ?>');
          $('#details').val('<?php echo $row['DETAILS']; ?>');
      <?php }
      } ?>

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
						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
			</div>
    </div>
</body>

</html>
