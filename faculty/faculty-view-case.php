<?php include 'faculty.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/faculty/faculty-home.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - View Case</title>

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

  <?php
    $query='SELECT 		  C.CASE_ID AS CASE_ID,
                        C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                        C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                        CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                        C.OFFENSE_ID AS OFFENSE_ID,
                        RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                        RO.TYPE AS  TYPE,
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
                        C.LAST_UPDATE AS LAST_UPDATE,
                        C.PENALTY_ID AS PENALTY_ID,
                        RP.PENALTY_DESC AS PENALTY_DESC,
                        C.VERDICT AS VERDICT,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
                        C.PROCEEDING_DATE AS PROCEEDING_DATE,
                        C.PROCEEDING_DECISION AS PROCEEDING_DECISION,
                        C.DATE_CLOSED AS DATE_CLOSED,
                        C.IF_NEW AS IF_NEW
            FROM 		    CASES C
            LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
            LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
            LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
            LEFT JOIN   CASE_REFERRAL_FORMS CRF ON C.CASE_ID = CRF.CASE_ID
            LEFT JOIN   REF_CASE_PROCEEDINGS RCP ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
            LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
            LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
            LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
            LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID

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

    <?php include 'faculty-sidebar.php';?>

      <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-8">
                <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
    					<b>Offense:</b> <?php echo $row['OFFENSE_DESCRIPTION']; ?><br>
    					<b>Type:</b> <?php echo $row['TYPE']; ?><br>
              <b>Location of the Incident:</b> <?php echo $row['LOCATION']; ?><br>
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
          
              <br><br>

              <div class="form-group">
                <label>Summary of the Incident</label>
                <textarea id="details" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
              </div>

              <div class="form-group" id="proceedingarea" hidden>
                <label>Nature of Proceedings</label>
                <textarea id="proceeding" name="proceeding" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING']; ?></textarea>
              </div>

              <?php
              if($row['PENALTY_DESC'] != null || $row['PROCEEDING_DECISION'] != null) { ?>
                <div class="form-group" id="penaltyarea">
                  <label>Penalty</label>
                  <?php
                    if($row['PENALTY_DESC'] != null and $row['PENALTY_DESC'] != "Will be processed as a major discipline offense") { ?>
                      <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PENALTY_DESC']; ?></textarea>
                  <?php }
                    else if($row['PROCEEDING_DECISION'] != null) { ?>
                      <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row['PROCEEDING_DECISION']; ?></textarea>
                  <?php }
                  ?>
                </div>
              <?php }
              ?>
            </div>

            <?php include "../ajax/user-case-audit.php" ?>

            <div class="col-lg-6">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <b style = "font-size: 17px;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#caseHistory" style="color: black;">Case History</a>
                  </b>
                </div>
                <!-- /.panel-heading -->
                <div id="caseHistory" class="panel-collapse collapse">
                  <div class="panel-body" style="overflow-y: scroll; max-height: 300px;">
                    <?php
                      if ($caseAuditRes->num_rows > 0) { ?>
                        <div class="table-responsive">
                          <table class="table table-striped table-hover">
                            <thead>
                              <tr>
                                  <th>Date</th>
                                  <th>Action Done</th>
                                  <th>By Whom</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                while($caseAuditRow = mysqli_fetch_array($caseAuditRes,MYSQLI_ASSOC)) {
                                  echo "<tr>
                                          <td>{$caseAuditRow['date']}</td>
                                          <td>{$caseAuditRow['action_done']}</td>
                                          <td>{$caseAuditRow['action_done_by']}</td>
                                        </tr>";
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                    <?php }
                      else {
                        echo "No case history";
                      }
                    ?>
                    <br>
                  </div>
                  <!-- /.panel-body -->
                </div>
                <!-- </div> -->
              </div>
              <!-- /.panel -->
            </div>
        </div>
  			<br><br><br><br><br>
      </div>

      <?php
        //Removes 'new' badge and reduces notif's count
        $query2='SELECT 		FC.CASE_ID AS CASE_ID,
                            FC.IF_NEW AS IF_NEW
                FROM 		    FACULTY_CASES FC
                WHERE   	  FC.USER_ID = "'.$_SESSION['user_id'].'" AND FC.CASE_ID = "'.$_GET['cn'].'"';
        $result2=mysqli_query($dbc,$query2);
        if(!$result2){
          echo mysqli_error($dbc);
        }
        else{
          $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
          if($row2['IF_NEW'] == 1){
            $query2='UPDATE FACULTY_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
            $result2=mysqli_query($dbc,$query2);
            if(!$result2){
              echo mysqli_error($dbc);
            }
          }
        }
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
    loadNotif();

    function loadNotif () {
        $.ajax({
          url: '../ajax/faculty-notif-cases.php',
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
  });

  <?php
    if($row['PROCEEDING'] != null ){ ?>
      $("#proceedingarea").show();
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
