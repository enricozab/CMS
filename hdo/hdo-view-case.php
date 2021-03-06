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

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    
    <script>
      function showSnackbar() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
      }
    </script>
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

    $queryStud = 'SELECT *
                         FROM CASES C
                         JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                         JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                         JOIN REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
                        WHERE C.CASE_ID = "'.$_GET['cn'].'"';

    $resultStud = mysqli_query($dbc,$queryStud);

    if(!$queryStud){
      echo mysqli_error($dbc);
    }
    else{
      $rowStud = mysqli_fetch_array($resultStud,MYSQLI_ASSOC);
    }

    $passCase = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $rowStud['level'] . "/" . $rowStud['reported_student_id'] . "/" . "VIEW-FOLDER" . "/" . $_GET['cn'];
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
                <button type="submit" id="btnViewEvidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
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

              <?php
              if($row2['STATUS_ID'] == 1 || $row2['STATUS_ID'] == 2) { ?>
                <!--REROUTE & REASSIGN-->
                <div class="row">
                  <div class="col-lg-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="color: black">Reroute Case</a>
                          </b>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class="form-group">
                              <div id="rerouteDiv">
                                <select id="rerouteCase" class="form-control">
                                  <option value="" disabled selected>Select a stage</option>
                                  <?php
                                    // $getRemarks_id = $dbc->query("SELECT remarks_id FROM cms.cases WHERE case_id = " .$_GET['cn']. " LIMIT 1");
                                    // $remarks_id = $getRemarks_id->fetch_row();

                                    // $remarksQuery= "SELECT * FROM cms.ref_remarks WHERE remarks_id < " . $remarks_id[0];
                                    // $remarksRes = $dbc->query($remarksQuery);
                                    // while($remarks = $remarksRes->fetch_assoc())
                                    // echo 
                                    //   '<option value="' .$remarks['remarks_id']. '">' . $remarks['description'] . '</option>';
                                    if ($row2['REMARKS_ID'] > 2) 
                                      echo 
                                        '<option value="2">For investigation by IDO</option>';
                                    if ($row2['REMARKS_ID'] > 4) 
                                      echo 
                                        '<option value="4">For resubmission by the student</option>';
                                  ?>
                                </select>
                                <br>
                                <button type="submit" id="btnReroute" name="btnReroute" class="btn btn-primary" style="float: right;">Reroute</button>
                              </div>
                              <div id="rerouteDiv2" hidden>
                                <i>Rerouting is not applicable.</i>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="color: black">Reassign Case</a>
                          </b>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class="form-group">
                                <select id="reassignIDO" class="form-control">
                                    <option value="" disabled selected>Select an IDO</option>
                                    <?php
                                      $idoQuery= "SELECT * FROM cms.users u WHERE u.user_type_id = 4;";
                                      $IDORes = $dbc->query($idoQuery);
                                      $ido_workloads = array();
                                      $ido_names = array();

                                      while($ido = $IDORes->fetch_assoc()){
                                        $idoName = $ido['first_name'] . ' ' . $ido['last_name'];
                                        $idoNumber = $ido['user_id'];
                                        $workloadQuery = $dbc->query("SELECT COUNT(ic.case_id)
                                                                      FROM ido_cases ic
                                                                        LEFT JOIN cases c on ic.case_id=c.case_id
                                                                        WHERE ic.user_id = ".$idoNumber."
                                                                            && (c.status_id != 3 && c.status_id != 4)
                                                                            && ic.handle = 1");
                                        $workload = $workloadQuery->fetch_row();

                                        if ($idoNumber != $row2['HANDLED_BY_ID'] && $workload[0] < 8) {
                                          $ido_names[$idoNumber] = $idoName;
                                          $ido_workloads[$idoNumber] = $workload[0];
                                          // echo 
                                          //   '<option value="' .$idoNumber. '">' . $idoName . ' (Active Cases: ' .$workload[0]. ')</option>';
                                        }
                                      }

                                      asort($ido_workloads);
                                      $ido_names_ordered = array();
                                      
                                      foreach (array_keys($ido_workloads) as $key) {
                                        $ido_names_ordered[$key] = $ido_names[$key] ;
                                      }
                                      
                                      foreach($ido_workloads as $x => $x_value) {
                                        echo '<option value="' .$x. '">' . $ido_names[$x] . ' (Active Cases: ' .$ido_workloads[$x]. ')</option>';
                                      }
                                    ?>
                                </select>
                                <br>
                                <button type="submit" id="btnReassign" name="btnReassign" class="btn btn-primary" style="float: right;">Reassign</button>
                            </div>    
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- REROUTE & REASSIGN -->
              <?php } ?>
              
            </div>
        </div>
        <br><br><br><br><br>

        <div id="snackbar"><i class="fa fa-info-circle fa-fw" style="font-size: 20px"></i> <span id="alert-message">Some text some message..</span></div>

      </div>

      <?php
        //Removes 'new' badge and reduces notif's count
        if($row2['IF_NEW'] == 1){
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

    $('#evidence').on('click',function() {
      <?php $_SESSION['pass'] = $passCase; ?>
      location.href='hdo-gdrive-case.php';
    });

    $('#btnViewEvidence').on('click',function() {
      <?php $_SESSION['pass'] = $passCase; ?>
      location.href='hdo-gdrive-case.php';

      // audit trail
      $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Case - Viewed Evidence for Case #<?php echo $_GET['cn']; ?>'
                },
                success: function(response) {
                  console.log('Success');
                }
            })
    });

    //REROUTE & REASSIGN
    <?php 
    if($row2['STATUS_ID'] == 1 || $row2['STATUS_ID'] == 2) { ?>
      var action = "";

      var rerouteCase = document.getElementById("rerouteCase");

      if (rerouteCase.options.length <= 1) {
        $("#rerouteDiv").hide();
        $("#rerouteDiv2").show();
      } else {
        $("#rerouteDiv").show();
        $("#rerouteDiv2").hide();
      }

      $("#btnReroute").click(function() {
        if($.trim($("#rerouteCase").val()).length > 0) {
          action = "reroute";
          $("#twoFactorModal").modal('show');
        }
        else {
          $("#message").text("Please select a stage.");
          $("#alertModal").modal('show');
        }
      });

      $("#btnReassign").click(function() {
        if($.trim($("#reassignIDO").val()).length > 0) {
          action = "reassign";
          $("#twoFactorModal").modal('show');
        }
        else {
          $("#message").text("Please select an IDO.");
          $("#alertModal").modal('show');
        }
      });

      $("#modalYes").click(function(){
        if (action == "reroute") {
          $.ajax({
            url: '../ajax/hdo-update-remarks.php',
            type: 'POST',
            data: {
              case_id: <?php echo $_GET['cn'] ?>,
              remark_id : $("#rerouteCase").val(),
            },
            success: function(response) {
              // audit trail
              $.ajax({
                        url: '../ajax/insert_system_audit_trail.php',
                        type: 'POST',
                        data: {
                            userid: <?php echo $_SESSION['user_id'] ?>,
                            actiondone: 'HDO Case - Rerouted Case #<?php echo $_GET['cn']; ?>'
                        },
                        success: function(response) {
                          console.log('Success');
                        }
                    })
              $("#message2").text("Cases has been rerouted.");
              $("#alertModal2").modal('show');
            }
          });
        } else if (action == "reassign") {
          $.ajax({
            url: '../ajax/hdo-update-ido.php',
            type: 'POST',
            data: {
              case_id: <?php echo $_GET['cn'] ?>,
              ido_id: $("#reassignIDO").val(),
            },
            success: function(response) {
              // audit trail
              $.ajax({
                        url: '../ajax/insert_system_audit_trail.php',
                        type: 'POST',
                        data: {
                            userid: <?php echo $_SESSION['user_id'] ?>,
                            actiondone: 'HDO Case - Reassigned IDO for Case #<?php echo $_GET['cn']; ?>'
                        },
                        success: function(response) {
                          console.log('Success');
                        }
                    })

              $("#message2").text("Cases has been reassigned.");
              $("#alertModal2").modal('show');
            }
          });
        }
      });
    <?php } ?>

    $('.modal').attr('data-backdrop', "static");
    $('.modal').attr('data-keyboard', false);

    var count = 0;
    var prevCount = 0;
    loadCount();

    function loadCount() {
      $.ajax({
        url: '../ajax/user-notifications-count.php',
        type: 'POST',
        data: {
        },
        success: function(response) {
          count = response;
          if(count > 0) {
            $('#notif-badge').text(count);
          }
          else {
            $('#notif-badge').text('');
          }
          if (prevCount != count) {
            loadReminders();
            prevCount = count;
          }
        }
      });

      setTimeout(loadCount, 5000);
    };

    var notifTable;

    function loadReminders() {
      if (count > 0) {
        var notif = " new notification";
        if (count > 1) notif = " new notifications";
        $('#alert-message').text('You have '+count+notif);
        setTimeout(function() { showSnackbar(); }, 1500);
      }
    }

    notifData();

    function notifData() {
      $.ajax({
        url: '../ajax/user-notifications.php',
        type: 'POST',
        data: {
        },
        success: function(response) {
          $('#notifTable').html(response);
        }
      });

      notifTable = setTimeout(notifData, 5000);
    }
    // sidebar system audit trail
    $('#sidebar_cases').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Cases'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_apprehend').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Apprehend'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_reports').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Incidet Reports'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_files').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Files'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_calendar').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Calendar'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_inbox').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Inbox'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });
          $('#sidebar_migration').click(function() {
            $.ajax({
                url: '../ajax/insert_system_audit_trail.php',
                type: 'POST',
                data: {
                    userid: <?php echo $_SESSION['user_id'] ?>,
                    actiondone: 'HDO Viewed Case - Viewed Data Migration'
                },
                success: function(response) {
                  console.log('Success');
                }
            });
          });

  });

  <?php
    if($row2['PROCEEDING'] != null ){ ?>
      $("#proceedingarea").show();
  <?php } ?>
  </script>
  
  <!-- Modal -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel1"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message"></p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="modalOK" class="btn btn-default" data-dismiss="modal">Ok</button>
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
						<p> Are you sure you want to proceed? </p>
					</div>
					<div class="modal-footer">
            <button type="submit" id = "modalNo" style="width: 70px" class="btn btn-danger" data-dismiss="modal">No</button>
            <button type="submit" id = "modalYes" style="width: 70px" class="btn btn-success" data-dismiss="modal">Yes</button>
          </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="alertModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel1"><b>Alleged Case</b></h4>
        </div>
        <div class="modal-body">
          <p id="message2"></p>
        </div>
        <div class="modal-footer">
          <button type="submit" id="modalOK" class="btn btn-default" onclick="location.reload()" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>

<style>
#snackbar {
  visibility: hidden;
  min-width: 300px;
  background-color: #337ab7;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 15px;
  position: fixed;
  z-index: 10;
  right: 40px;
  bottom: 40px;
  font-size: 18px;
  border-radius: 5px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 40px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 40px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 40px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 40px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>