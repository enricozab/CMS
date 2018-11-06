<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Home</title>

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

  <?php
    require_once('./mysql_connect.php');

    include 'hdo-notif-queries.php';
  ?>

  <div id="wrapper">

    <?php include 'hdo-sidebar.php'; ?>

    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-8">
              <h3 class="page-header">Case Notifications</h3>
          </div>
      </div>
			<!-- case notification table -->
			<div class="row">
        <div class="col-lg-12">
          <table width="100%" class="table table-striped table-bordered table-hover" id="case-notif-table">
              <thead>
                  <tr>
                      <th>Case No.</th>
                      <th>Offense</th>
                      <th>Type</th>
                      <th>Date Filed</th>
                      <th>Last Update</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $query2='SELECT 		C.CASE_ID AS CASE_ID,
                                			C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                                      C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                                      CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                                      C.OFFENSE_ID AS OFFENSE_ID,
                                      RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                                      C.OTHER_OFFENSE AS OTHER_OFFENSE,
                                      C.CHEATING_TYPE AS CHEATING_TYPE,
                                      RO.TYPE AS TYPE,
                                      C.COMPLAINANT_ID AS COMPLAINANT_ID,
                                      CONCAT(U1.FIRST_NAME," ",U1.LAST_NAME) AS COMPLAINANT,
                                      C.DETAILS AS DETAILS,
                                      C.COMMENTS AS COMMENTS,
                                      C.APPREHENDED_BY_ID AS APPREHENDED_BY_ID,
                                      CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS APPREHENDED_BY,
                                      C.DATE_FILED AS DATE_FILED,
                                      C.STATUS AS STATUS,
                                      C.LAST_UPDATE AS LAST_UPDATE,
                                      C.DATE_CLOSED AS DATE_CLOSED,
                                      C.IF_NEW AS IF_NEW
                          FROM 		    CASES C
                          LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
                          LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
                          LEFT JOIN	  USERS U2 ON C.APPREHENDED_BY_ID = U2.USER_ID
                          LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
                          ORDER BY	  C.LAST_UPDATE';
                  $result2=mysqli_query($dbc,$query2);
                  if(!$result2){
                    echo mysqli_error($dbc);
                  }
                  else{
                    while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
                      echo "<tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"location.href='hdo-view-case.php?cn={$row2['CASE_ID']}'\">
                            <td>{$row2['CASE_ID']} <span id=\"{$row2['CASE_ID']}\" class=\"badge\"></span></td>
                            <td>{$row2['OFFENSE_DESCRIPTION']}</td>
                            <td>{$row2['TYPE']}</td>
                            <td>{$row2['DATE_FILED']}</td>
                            <td>{$row2['LAST_UPDATE']}</td>
                            <td>{$row2['STATUS']}</td>
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

      <?php include 'hdo-notif-scripts.php'?>

      <?php
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
