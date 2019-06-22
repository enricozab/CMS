<?php include 'hdo.php' ?>
<?php
if (!isset($_GET['cn']))
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

</head>

<body>

  <?php
    $query2='SELECT 		C.CASE_ID AS CASE_ID,
                        C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                        C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                        CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                        C.OFFENSE_ID AS OFFENSE_ID,
                        RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
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
                        C.PROCEEDING_DATE AS PROCEEDING_DATE,
                        RCP.PROCEEDINGS_DESC AS PROCEEDING,
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
    $result2=mysqli_query($dbc,$query2);
    if(!$result2){
      echo mysqli_error($dbc);
    }
    else{
      $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
    }
  ?>
  
    <div id="wrapper">

    <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
          <div class="row">
            <div class="col-lg-8">
              <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <b>Offense:</b> <?php echo $row2['OFFENSE_DESCRIPTION']; ?><br>
                <b>Type:</b> <?php echo $row2['TYPE'];; ?><br>
                <b>Location of the Incident:</b> <?php echo $row2['LOCATION']; ?><br>
                <b>Date Filed:</b> <?php echo $row2['DATE_FILED']; ?><br>
                <b>Last Update:</b> <?php echo $row2['LAST_UPDATE']; ?><br>
                <b>Status:</b> <?php echo $row2['STATUS_DESCRIPTION']; ?><br>
                <br>
                <b>Student ID No.:</b> <?php echo $row2['REPORTED_STUDENT_ID']; ?><br>
                <b>Student Name:</b> <?php echo $row2['STUDENT']; ?><br>
                <br>
                <b>Complainant:</b> <?php echo $row2['COMPLAINANT']; ?><br>
                <b>Investigated by:</b> <?php echo $row2['HANDLED_BY']; ?><br>
                <!--<b>Investigating Officer:</b> Debbie Simon <br>-->

                <br><br>

                <div class="form-group">
                  <label>Summary of the Incident</label>
                  <textarea id="details" name="details" class="form-control" rows="5" readonly><?php echo $row2['DETAILS']; ?></textarea>
                </div>

                <div class="form-group" id="proceedingarea" hidden>
                  <label>Nature of Proceedings</label>
                  <textarea id="proceeding" name="proceeding" class="form-control" rows="3" readonly><?php echo $row2['PROCEEDING']; ?></textarea>
                </div>

                <?php
                if($row2['PENALTY_DESC'] != null || $row2['PROCEEDING_DECISION'] != null) { ?>
                  <div class="form-group" id="penaltyarea">
                    <label>Penalty</label>
                    <?php
                      if($row2['PENALTY_DESC'] != null and $row2['PENALTY_DESC'] != "Will be processed as a major discipline offense") { ?>
                        <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row2['PENALTY_DESC']; ?></textarea>
                    <?php }
                      else if($row2['PROCEEDING_DECISION'] != null) { ?>
                        <textarea id="penalty" name="penalty" class="form-control" rows="3" readonly><?php echo $row2['PROCEEDING_DECISION']; ?></textarea>
                    <?php }
                    ?>
                  </div>
                <?php }
                ?>
                <br>
                <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
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

              <!--RE-ROUTE & RE-ASSIGN-->
              <div class="row">
                <div class="col-lg-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Re-route This Case</a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group">
                              <select class="form-control" id="dropdown">
                                <option value="" disabled selected>Select a Stage</option>
                                <?php
                                  $getRemarks_id = $dbc->query("SELECT remarks_id FROM cms.cases WHERE case_id = " .$_GET['cn']. " LIMIT 1");
                                  $remarks_id = $getRemarks_id->fetch_row();

                                  $remarksQuery= "SELECT * FROM cms.ref_remarks WHERE remarks_id < " . $remarks_id[0];
                                  $remarksRes = $dbc->query($remarksQuery);
                                  while($remarks = $remarksRes->fetch_assoc())
                                  echo 
                                    '<option value="' .$remarks['remarks_id']. '">' . $remarks['description'] . '</option>';
                                ?>
                              </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Re-assign This Case</a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group">
                              <select class="form-control">
                                  <option value="" disabled selected>Select an IDO</option>
                                  <?php
                                    $idoQuery= "SELECT * FROM cms.users u WHERE u.user_type_id = 4;";
                                    $IDORes = $dbc->query($idoQuery);
                                    while($ido = $IDORes->fetch_assoc()){
                                      $idoName = $ido['first_name'] . ' ' . $ido['last_name'];
                                      echo 
                                        '<option value="' .$idoName. '">' . $idoName . '</option>';
                                    }
                                  ?>
                              </select>
                          </div>    
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- RE-ROUTE & RE-ASSIGN -->
              
            </div>
        </div>
        <br><br><br><br><br>
      </div>

      <?php
        //Removes 'new' badge and reduces notif's count
        if($row2['IF_NEW']){
          $query3='UPDATE CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result3=mysqli_query($dbc,$query3);
          if(!$result3){
            echo mysqli_error($dbc);
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

    <!-- Trigger on Select JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  // SELECT TRIGGER
  $(document).ready(function() {
    $("#dropdown").change(function() {
      //alert("Selection: " + $("option:selected", this).val() + ":" + $("option:selected", this).text());
      var selectedRemarks = $("option:selected", this).val();

      $.ajax({
              url: '../ajax/hdo-update-remarks.php',
              type: 'POST',
              data: {
    					remarks : selectedRemarks,
              case_id : <?php echo $_GET['cn'] ?>
                    },
              success: function(response) {
                console.log("Selected Remarks: " + selectedRemarks);
                console.log("Case ID: " + <?php echo $_GET['cn'] ?>);
              }
    		});
        
        var dropdown = document.getElementById("dropdown");
        for(i = dropdown.options.length - 1 ; i >= 0 ; i--)
        {
          if (i > selectedRemarks-1)
            dropdown.remove(i);
        }
    });
  });
  // END OF SELECT TRIGGER

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
  });

  <?php
    if($row2['PROCEEDING'] != null ){ ?>
      $("#proceedingarea").show();
  <?php } ?>
  </script>

</body>

</html>
