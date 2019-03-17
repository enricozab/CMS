<?php include 'cdo.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Reports</title>

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

    <div id="wrapper">

        <?php include 'cdo-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Generate Summary Report For Cases</h3>

                <div class="col-lg-12">
				<!--------------------------->
                  <form id="form" action="cdo-reports.php" method="post">
                    <div id="academicyear_div">
                      <div class="form-group" style = "width: 300px;">
                        <label>Academic Year: <span style="font-weight:normal; font-style:italic; font-size:12px;"></span> <span style="font-weight:normal; color:red;">*</span></label>

                        <select id="academicyear" name="academicyear" class="academicyear form-control">
							<!--<option value="2014-2015"> 2014-2015 </option>
							<option value="2015-2016"> 2015-2016 </option>
							<option value="2016-2017"> 2016-2017 </option>
							<option value="2017-2018"> 2017-2018 </option>
							<option value="2018-2019"> 2018-2019 </option>-->
							<?php
								require_once('../mysql_connect.php');
								$sqlQuery = "SELECT DISTINCT(SRF.SCHOOL_YEAR) 
												FROM CMS.STUDENT_RESPONSE_FORMS SRF 
												ORDER BY SRF.SCHOOL_YEAR ASC";
								$sqlRes = mysqli_query($dbc, $sqlQuery);
								while ($row = $sqlRes->fetch_assoc()){
									echo '<option value="' .$row['SCHOOL_YEAR'] .'">' . $row['SCHOOL_YEAR'] . '</option>';
								}
							?>
						</select>
                      </div>
                    </div>
                    <div class="form-group" style = "width: 300px;">
                      <label>Term <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="term" name="term" class="term form-control">
							<option value=1> 1 </option>
							<option value=2> 2 </option>
							<option value=3> 3 </option>
							
							<?php/*
								require_once('../mysql_connect.php');
								$sqlQuery = "SELECT DISTINCT(SRF.TERM) 
												FROM CMS.STUDENT_RESPONSE_FORMS SRF 
												ORDER BY SRF.TERM ASC";
								$sqlRes = mysqli_query($dbc, $sqlQuery);
								while ($row = $sqlRes->fetch_assoc()){
									echo "<option value= ".$row['TERM'] . ">" . $row['TERM'] . "</option>";
								}
							*/?>
						</select>
                    </div>
					<div class="form-group" style = "width: 300px;">
                      <label>Case Type <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="casetype" name="casetype" class="casetype form-control">
							<option value="Minor"> Minor </option>
							<option value="Major"> Major </option>
						</select>
                    </div>
					<br>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Generate</button>
                  </form>
                  <br><br><br>
                </div>

                <div class="col-lg-6">
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
  //all functinos have to be inside this functions
  //function that runs once the page is loaded

  $(document).ready(function() {
      <?php include 'faculty-notif-scripts.php'?>
  });
  </script>

  <?php
		if(isset($_POST['submit'])){
			
			$ay = $_POST['academicyear'];
			$term = $_POST['term'];
			$type = $_POST['casetype'];
			
			include 'insert-generated-report.php';
			
			if($type == "Minor" && $reportNum != 0){
				//echo 'Minor', '<br>';
				include 'cdo-generate-minor-report.php';
			}
			
			else if($type == "Major" && $reportNum != 0){
				//echo 'Major', '<br>';;
				include 'cdo-generate-major-report.php';
			}
		}
	?>
</body>

</html>
