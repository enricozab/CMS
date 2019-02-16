<?php include 'ido.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/ido/ido-home.php");
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

    <!-- FOR SEARCHABLE DROP -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../extra-css/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href ="../extra-css/bootstrap-chosen.css"/>

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
                        C.OULC_VERDICT AS OULC_VERDICT,
                        C.HEARING_DATE AS HEARING_DATE,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW
            FROM 		    CASES C
            LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
            LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
            LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
            LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
            LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
            LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
            WHERE   	  C.CASE_ID = "'.$_GET['cn'].'"
            ORDER BY	  C.LAST_UPDATE';
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
    else{
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    }
  ?>

    <div id="wrapper">

    <?php include 'ido-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
               <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
                <div class="col-lg-6">
          					<b>Offense:</b> <?php echo $row['OFFENSE_DESCRIPTION']; ?><br>
          					<b>Type:</b> <?php echo $row['TYPE']; ?><br>
                    <b>Location:</b> <?php echo $row['LOCATION']; ?><br>
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
                </div>

                <div class="col-lg-6">
					          <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">Updates</b>
                      </div>
                      <!-- .panel-heading -->
                      <div class="panel-body">
                          <div class="panel-group" id="accordion">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style = "font-size: 15px;">History</a>
                                      </h4>
                                  </div>
                                  <div id="collapseOne" class="panel-collapse collapse in">
                                      <div class="panel-body">
                    										<div class="table-responsive">
                    											<table class="table">
                    												<tbody>
                    													<tr>
                    														<td>Reviewing Forms</td>
                    														<td>Carlos Garcia</td>
                    														<td><i>10/14/18</i></td>
                    													</tr>
                    													<tr>
                    														<td>Submitting Forms</td>
                    														<td>Enrico Miguel M. Zabayle</td>
                    														<td><i>10/13/18</i></td>
                    													</tr>
                    													<tr>
                    														<td>Passed Alleged Case</td>
                    														<td>Debbie Simon</td>
                    														<td><i>10/10/18</i></td>
                    													</tr>
                    												</tbody>
                    											</table>
                    										</div>
                                      </div>
                                  </div>
                              </div>

                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h4 class="panel-title">
                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style = "font-size: 15px;">Submitted Forms</a>
                                      </h4>
                                  </div>
                                  <div id="collapseTwo" class="panel-collapse collapse">
                                      <div class="panel-body">
                                        <div class="table-responsive">
                                          <table class="table">
                                            <tbody>
                                              <tr>
                                                <td>Form 1</td>
                                                <td><i>10/14/18</i></td>
                                              </tr>
                                              <tr>
                                                <td>Form 2</td>
                                                <td><i>10/10/18</i></td>
                                              </tr>
                                              <tr>
                                                <td>Form 3</td>
                                                <td><i>10/10/18</i></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- .panel-body -->
                  </div>
                </div>
              </div>
            </div>
          </div>
			<br><br>
      <div class="panel panel-default">
        <div class="panel-heading">
					<b>Details</b>
				</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<p><?php echo $row['DETAILS']; ?></p>
				</div>
      </div>
      <button type="button" class="btn btn-outline btn-primary btn-sm" id="addcomment"><span class=" fa fa-plus"></span>&nbsp; Add comment</button>
      <div class="form-group" id="commentarea" hidden>
        <label>Comment <span style="font-weight:normal; font-style:italic; font-size:12px;">(Please be specific)</span>
          <span id="closecomment" style="font-weight:normal; color:red; cursor: pointer;"><i class="fa fa-times"></i></span>
        </label>
        <textarea id="comment" name="comment" class="form-control" rows="3"><?php echo $row['COMMENT']; ?></textarea>
      </div>

      <br><br>

      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <b>Evidence</b></h4>
            </div>
            <div class="panel-body">
              <div class="row">
                 <div class="col-sm-6">
                    <b>Document/Photo:</b><input type="file">
                 </div>
                 <div class="col-sm-6">
                    <b>Write Up:</b> &nbsp;<button type="button" class="btn btn-outline btn-info btn-xs">Google Docs</button><br>
                 </div>
              </div>
              <div>
                <span class="fa fa-plus" style="color: #5bc0de;">&nbsp; <a href="#" style="color: #5bc0de;">Add another file</a></span>
              </div>
              <br>
              <button type="upload" id="upload" name="upload" class="btn btn-info btn-sm">Upload</button>
            </div>
          </div>
        </div>
        <!-- Verdict panel -->
        <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <b>Verdict</b>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
              <textarea id="verdict" name="verdict" class="form-control" rows="1">1 month suspension</textarea>
            </div>
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-outline btn-primary btn-sm" id="schedule" onclick="location.href='ido-calendar.php'"><span class=" fa fa-calendar-o"></span>&nbsp; Schedule for interview</button>
      <br><br>

      <br>
      <div class="row">
        <div class="col-sm-6">
          <button type="submit" id="dismiss" name="dismiss" class="btn btn-danger">Dismiss</button>
          <button type="submit" id="return" name="return" class="btn btn-primary">Return to Student</button>
          <button type="submit" id="endorse" name="endorse" class="btn btn-primary">Endorse</button></div>
      </div>
      <br><br><br>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		IC.CASE_ID AS CASE_ID,
                          IC.IF_NEW AS IF_NEW
              FROM 		    IDO_CASES IC
              WHERE   	  IC.USER_ID = "'.$_SESSION['user_id'].'" AND IC.CASE_ID = "'.$_GET['cn'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if($row2['IF_NEW']){
          $query2='UPDATE IDO_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }

        include 'ido-notif-queries.php';
      ?>
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

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  $(document).ready(function() {
    <?php include 'ido-notif-scripts.php' ?>

    $('#endorse').click(function() {
      if($('#endorse').text() == "Endorse") {
        $.ajax({
            url: '../ajax/ido-endorse-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                verdict: $('#verdict').val()
            },
            success: function(msg) {
                $('#message').text('Endorsed to OULC successfully!');
                $("#endorse").attr('disabled', true).text("Endorsed");
                $("#return").attr('disabled', true);
                $("#dismiss").attr('disabled', true);
                $("#verdict").attr('disabled', true);

                $("#alertModal").modal("show");
            }
        });
      }

      else if($('#endorse').text() == "Submit") {
        $.ajax({
            url: '../ajax/ido-close-case.php',
            type: 'POST',
            data: {
                caseID: <?php echo $_GET['cn']; ?>,
                verdict: $('#verdict').val()
            },
            success: function(msg) {
                $('#message').text('Case closed.');
                $("#endorse").attr('disabled', true).text("Submitted");
                $("#return").attr('disabled', true);
                $("#dismiss").attr('disabled', true);
                $("#verdict").attr('disabled', true);

                $("#alertModal").modal("show");
            }
        });
      }
    });

    $('#return').click(function() {
      $.ajax({
          url: '../ajax/ido-return-forms.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              comment: $('#comment').val()
          },
          success: function(msg) {
            $('#message').text('Returned to student successfully!');
            $("#endorse").attr('disabled', true);
            $("#return").attr('disabled', true);
            $("#dismiss").attr('disabled', true);
            $("#addcomment").hide();
            $('#closecomment').hide();
            $('#comment').attr('disabled', true);

            $("#alertModal").modal("show");
          }
      });
    });

    $('#dismiss').click(function() {
      $.ajax({
          url: '../ajax/ido-dismiss-case.php',
          type: 'POST',
          data: {
              caseID: <?php echo $_GET['cn']; ?>,
              verdict: $('#verdict').val()
          },
          success: function(msg) {
              $('#message').text('Case dismissed.');
              $("#endorse").attr('disabled', true);
              $("#return").attr('disabled', true);
              $("#dismiss").attr('disabled', true).text("Dismissed");
              $("#verdict").attr('disabled', true);

              $("#alertModal").modal("show");
          }
      });
    });

    $('#addcomment').click(function() {
      $("#addcomment").hide();
      $("#commentarea").show();
    });

    $('#closecomment').click(function() {
      $("#addcomment").show();
      $("#comment").val('<?php echo $row['COMMENT']; ?>');
      $("#commentarea").hide();
    });
  });

  <?php
    if($row['TYPE'] != "Major"){ ?>
      $("#endorse").text('Submit');
  <?php }
    if($row['REMARKS_ID'] < 3 or $row['REMARKS_ID'] == 4){ ?>
      $("#addcomment").hide();
      $('#closecomment').hide();
      $('#comment').attr('disabled', true);
      $("#endorse").attr('disabled', true);
      $("#return").attr('disabled', true);
      $("#dismiss").attr('disabled', true);
  <?php }
    if($row['REMARKS_ID'] > 3 and $row['REMARKS_ID'] != 4) { ?>
      $("#addcomment").hide();
      $('#closecomment').hide();
      $('#comment').attr('disabled', true);
      $("#return").attr('disabled', true);
      $("#dismiss").attr('disabled', true);
      $("#verdict").attr('disabled', true);
      $("#endorse").attr('disabled', true);
  <?php
      if($row['REMARKS_ID'] > 4) { ?>
        $("#verdict").val("<?php echo $row['OULC_VERDICT']; ?>");
  <?php if($row['REMARKS_ID'] < 7) { ?>
          $("#endorse").text("Endorsed");
  <?php }
        else if($row['REMARKS_ID'] == 8) { ?>
          $("#endorse").text("Submitted");
  <?php }
        else if($row['REMARKS_ID'] == 9) { ?>
          $("#dismiss").text("Dismissed");
  <?php }
      }
    }
    if($row['COMMENT'] != null){ ?>
      $("#addcomment").hide();
      $("#commentarea").show();
  <?php } ?>
  </script>

  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message"></message>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
