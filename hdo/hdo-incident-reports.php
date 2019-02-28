<?php include 'hdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Incident Reports</title>

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
    include 'hdo-notif-queries.php'
  ?>

    <div id="wrapper">

        <?php include 'hdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="page-header">Incident Reports</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
      			<!-- case notification table -->
      			<div class="row">
                <div class="col-lg-12">
                  <table width="100%" class="table table-striped table-bordered table-hover" id="incident-reports-table">
                      <thead>
                          <tr>
                              <th>Incident Report No.</th>
                              <th>Complainant</th>
                              <th>Date Filed</th>
                              <th>Remarks</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query='SELECT 	  		IR.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                                  				      CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS COMPLAINANT,
                                  				      IR.DATE_FILED,
                                  				      IR.IF_NEW AS IF_NEW,
                                  				      C.CASE_ID AS CASE_ID
                                  FROM 	    	  INCIDENT_REPORTS IR
                                  LEFT JOIN	    USERS U ON IR.COMPLAINANT_ID = U.USER_ID
                                  LEFT JOIN		  CASES C ON IR.INCIDENT_REPORT_ID = C.INCIDENT_REPORT_ID
                                  ORDER BY  		IR.DATE_FILED, IR.INCIDENT_REPORT_ID DESC';
                          $result=mysqli_query($dbc,$query);
                          if(!$result){
                            echo mysqli_error($dbc);
                          }
                          else{
                            while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                              if($row['CASE_ID'] != null){
                                $caseid='Submitted/Assigned to IDO';
                              }
                              else{
                                $caseid=null;
                              }
                              echo "<tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"location.href='hdo-view-incident-report.php?irn={$row['INCIDENT_REPORT_ID']}'\">
                                    <td>{$row['INCIDENT_REPORT_ID']} <span id=\"{$row['INCIDENT_REPORT_ID']}\" class=\"badge\"></span></td>
                                    <td>{$row['COMPLAINANT']}</td>
                                    <td>{$row['DATE_FILED']}</td>
                                    <td>{$caseid}</td>
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
        $('#incident-reports-table').DataTable({
          "order": [[ 2, "desc" ]]
        });

        <?php include 'hdo-notif-scripts.php' ?>

        <?php
        $result=mysqli_query($dbc,$query);
        if(!$result){
          echo mysqli_error($dbc);
        }
        else{
          while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            if($row['IF_NEW']){ ?>
              $('<?php echo "#".$row['INCIDENT_REPORT_ID'] ?>').text('NEW');
            <?php }
            else{ ?>
              $('<?php echo "#".$row['INCIDENT_REPORT_ID'] ?>').text('');
            <?php }
          }
        } ?>
    });
    </script>

</body>

</html>
