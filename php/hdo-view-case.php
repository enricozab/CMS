<?php include 'hdo.php' ?>
<?php
if (!isset($_GET['cn']))
    header("Location: http://".$_SERVER['HTTP_HOST']."/cms/php/hdo-home.php");
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

    $query2='SELECT 		C.CASE_ID AS CASE_ID,
                        C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                        C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                        CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                        C.OFFENSE_ID AS OFFENSE_ID,
                        RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                        C.OTHER_OFFENSE AS OTHER_OFFENSE,
                        C.CHEATING_TYPE AS CHEATING_TYPE,
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
            WHERE   	  C.CASE_ID = "'.$_GET['cn'].'"';
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
               <h3 class="page-header"><b>Alleged Case No.: <?php echo $_GET['cn']; ?></b></h3>
                <div class="col-lg-6">
          					<b>Offense:</b> <?php echo $row2['OFFENSE_DESCRIPTION']; ?><br>
          					<b>Type:</b> <?php echo 'Minor'; ?><br>
          					<b>Date Filed:</b> <?php echo $row2['DATE_FILED']; ?><br>
                    <b>Last Update:</b> <?php echo $row2['LAST_UPDATE']; ?><br>
          					<b>Status:</b> <?php echo $row2['STATUS']; ?><br>
                    <br>
          					<b>Student ID No.:</b> <?php echo $row2['REPORTED_STUDENT_ID']; ?><br>
          					<b>Student Name:</b> <?php echo $row2['STUDENT']; ?><br>
                    <br>
          					<b>Complainant:</b> <?php echo $row2['COMPLAINANT']; ?><br>
          					<b>Apprehended by:</b> <?php echo $row2['APPREHENDED_BY']; ?><br>
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
					<p>Caught cheating by the professor during finals</p>
				</div>
      </div>
      <br>
      <?php
        $query3='SELECT USER_ID, CONCAT(FIRST_NAME," ",LAST_NAME) AS IDO FROM USERS WHERE USER_TYPE_ID = 5';
        $result3=mysqli_query($dbc,$query3);
        if(!$result3){
          echo mysqli_error($dbc);
        }
      ?>
      <form id="form">
        <div id="assignIDO" class="form-group" style='width: 400px;'>
          <label>Assign an Investigation Discipline Officer (IDO) <span style="font-weight:normal; color:red;">*</span></label>
          <select id="ido" class="form-control" required>
            <option value="" disabled selected>Select an IDO</option>
            <?php
            while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
              echo
                "<option value=\"{$row3['USER_ID']}\">{$row3['IDO']}</option>";
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
        if($row2['IF_NEW']){
          $query3='UPDATE CASES SET IF_NEW=0 WHERE CASE_ID="'.$_GET['cn'].'"';
          $result3=mysqli_query($dbc,$query3);
          if(!$result3){
            echo mysqli_error($dbc);
          }
        }

        include 'hdo-notif-queries.php';
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
    <?php include 'hdo-notif-scripts.php' ?>
  });
  </script>

</body>

</html>
