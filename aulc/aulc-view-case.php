<?php include 'aulc.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/CMS/aulc/aulc-home.php");
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

    <?php include 'aulc-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
               <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
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
                </div>

                <div class="col-lg-6">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                          <b style = "font-size: 17px;">Submitted Forms</b>
                      </div>
                      <!-- .panel-heading -->
                      <div class="panel-body">
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
                      <!-- .panel-body -->
                  </div>
                </div>
              </div>
			<br><br>
      <div class="form-group">
        <label>Summary of the Incident</label>
        <textarea id="details" style="width:600px;" name="details" class="form-control" rows="5" readonly><?php echo $row['DETAILS']; ?></textarea>
      </div>

      <div class="form-group" id="verdictarea">
        <label>Verdict</label>
        <textarea id="verdict" style="width:600px;" name="verdict" class="form-control" rows="3" readonly><?php echo $row['OULC_VERDICT']; ?></textarea>
      </div>

      <div id="viewevidence">
        <br>
        <button type="submit" id="evidence" name="evidence" class="btn btn-outline btn-primary">View evidence</button>
      </div>

      <br><br><br>

      <div class="row">
        <div class="col-sm-6">
          <button type="submit" id="dismiss" name="dismiss" class="btn btn-danger">Dismiss</button>
          <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

      <br><br><br>

      <?php
      //Removes 'new' badge and reduces notif's count
      $query2='SELECT 		AU.CASE_ID AS CASE_ID,
                          AU.IF_NEW AS IF_NEW
              FROM 		    AULC_CASES AU
              WHERE   	  AU.CASE_ID = "'.$_GET['cn'].'"';
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        if($row2['IF_NEW']){
          $query2='UPDATE AULC_CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result2=mysqli_query($dbc,$query2);
          if(!$result2){
            echo mysqli_error($dbc);
          }
        }
      }

        include 'aulc-notif-queries.php';
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
    <?php include 'aulc-notif-scripts.php' ?>

  });


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
