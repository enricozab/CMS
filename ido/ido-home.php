<?php include 'ido.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Home</title>

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
    include 'ido-notif-queries.php';
  ?>

  <div id="wrapper">

    <?php include 'ido-sidebar.php'; ?>

    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-8">
              <h3 class="page-header">Case Notifications</h3>
          </div>
      </div>
			<!-- case notification table -->
			<div class="row">
        <div class="col-lg-12">
          <br>
          <div class="btn-group">
            <button type="button" class="tableButton btn btn-default" id="all">All Cases</button>
            <button type="button" class="tableButton btn btn-default" id="active">Active</button>
            <button type="button" class="tableButton btn btn-default" id="closed">Closed</button>
          </div>
          <style>
              .tableButton {
                width: 100px;
              }
              #all {border-radius: 3px 0px 0px 3px;}
              #active {border-radius: 0px;}
              #closed {border-radius: 0px 3px 3px 0px;}
          </style>
          <br><br>
          <table width="100%" class="table table-striped table-bordered table-hover" id="case-notif-table">
              <thead>
                  <tr>
                      <th>Case No.</th>
                      <th>Offense</th>
                      <th>Type</th>
                      <th>Date Filed</th>
                      <th>Last Update</th>
                      <th>Status</th>
                      <th>Remarks</th>
                      <th>Graduating?</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                $query='SELECT 		  C.CASE_ID AS CASE_ID,
                                    C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                                    C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                                    CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                                    C.OFFENSE_ID AS OFFENSE_ID,
                                    RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                                    C.CHEATING_TYPE_ID AS CHEATING_TYPE_ID,
                                    RO.TYPE AS TYPE,
                                    RS.IF_GRADUATING AS IF_GRADUATING,
                                    C.COMPLAINANT_ID AS COMPLAINANT_ID,
                                    CONCAT(U1.FIRST_NAME," ",U1.LAST_NAME) AS COMPLAINANT,
                                    C.DETAILS AS DETAILS,
                                    C.ADMISSION_TYPE_ID AS ADMISSION_TYPE_ID,
                                    C.HANDLED_BY_ID AS HANDLED_BY_ID,
                                    CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS HANDLED_BY,
                                    C.DATE_FILED AS DATE_FILED,
                                    C.STATUS_ID AS STATUS_ID,
                                    S.DESCRIPTION AS STATUS_DESCRIPTION,
                                    C.REMARKS_ID AS REMARKS_ID,
                                    R.DESCRIPTION AS REMARKS_DESCRIPTION,
                                    C.LAST_UPDATE AS LAST_UPDATE,
                                    C.PENALTY_ID AS PENALTY_ID,
                                    RP.PENALTY_DESC AS PENALTY_DESC,
                                    C.VERDICT AS VERDICT,
                                    C.PROCEEDING_DATE AS PROCEEDING_DATE,
                                    C.DATE_CLOSED AS DATE_CLOSED,
                                    C.IF_NEW AS IF_NEW
                        FROM 		    CASES C
                        LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                        LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
                        LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
                        LEFT JOIN   REF_STUDENTS RS ON U.USER_ID = RS.STUDENT_ID
                        LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
                        LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
                        LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
                        LEFT JOIN   REF_REMARKS R ON C.REMARKS_ID = R.REMARKS_ID
                        LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID
                        WHERE       C.HANDLED_BY_ID = "'.$_SESSION['user_id'].'"
                        ORDER BY	  C.LAST_UPDATE';
                        $result=mysqli_query($dbc,$query);
                  if(!$result){
                    echo mysqli_error($dbc);
                  }
                  else{
                    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                      $grad;
                      if($row['IF_GRADUATING']) {
                        $grad = "Yes";
                      }
                      else {
                        $grad = "No";
                      }
                      echo "<tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"location.href='ido-view-case.php?cn={$row['CASE_ID']}'\">
                            <td>{$row['CASE_ID']} <span id=\"{$row['CASE_ID']}\" class=\"badge\"></span></td>
                            <td>{$row['OFFENSE_DESCRIPTION']}</td>
                            <td>{$row['TYPE']}</td>
                            <td>{$row['DATE_FILED']}</td>
                            <td>{$row['LAST_UPDATE']}</td>
                            <td>{$row['STATUS_DESCRIPTION']}</td>
                            <td>{$row['REMARKS_DESCRIPTION']}</td>
                            <td>{$grad}</td>
                            </tr>";
                    }
                  }
                ?>
              </tbody>
          </table>
          <!-- /.table-responsive -->
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
  <script>
  $(document).ready(function() {
      $('#case-notif-table').DataTable({
          "order": [[ 4, "desc" ]]
      });

      $('#all').css("background-color", "#e6e6e6");

      $('#all').on('click', function () {
          $('#case-notif-table').DataTable().columns(5).search("").draw();
          $('#all').focus();
          $(this).css("background-color", "#e6e6e6");
          $('#active').css("background-color", "white");
          $('#closed').css("background-color", "white");
      });

      $('#active').on('click', function () {
          $('#case-notif-table').DataTable().columns(5).search("Opened|On Going", true, false).draw();
          $('#active').focus();
          $(this).css("background-color", "#e6e6e6");
          $('#all').css("background-color", "white");
          $('#closed').css("background-color", "white");
      });

      $('#closed').on('click', function () {
          $('#case-notif-table').DataTable().columns(5).search("Closed|Dismissed", true, false).draw();
          $('#closed').focus();
          $(this).css("background-color", "#e6e6e6");
          $('#active').css("background-color", "white");
          $('#all').css("background-color", "white");
      });

      <?php include 'ido-notif-scripts.php'?>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		IC.CASE_ID AS CASE_ID,
                          IC.IF_NEW AS IF_NEW
              FROM 		    IDO_CASES IC
              WHERE   	  IC.USER_ID = "'.$_SESSION['user_id'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
          if($row2['IF_NEW']){ ?>
            $('<?php echo "#".$row2['CASE_ID'] ?>').text('NEW');
          <?php }
          else{ ?>
            $('<?php echo "#".$row2['CASE_ID'] ?>').text('');
          <?php }
        }
      } ?>
  });
  </script>

</body>

</html>
