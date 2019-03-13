<?php include 'faculty.php' ?>
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

  <?php
    include 'faculty-notif-queries.php';
	include 'faculty-report-queries.php';
  ?>

    <div id="wrapper">

        <?php include 'faculty-sidebar.php';?>

        <div id="page-wrapper">
            <div class="row">
                <h3 class="page-header">Generate Report</h3>

                <div class="col-lg-12">
                  <form id="form" action="faculty-reports.php" method="post">
                    <div id="academicyear_div">
                      <div class="form-group" style = "width: 300px;">
                        <label>Academic Year: <span style="font-weight:normal; font-style:italic; font-size:12px;"></span> <span style="font-weight:normal; color:red;">*</span></label>

                        <select id="academicyear" name="academicyear" class="academicyear form-control" placeholder="2018-2019">
							<option value="2018-2019"> 2018-2019 </option>
						</select>
                      </div>
                    </div>
                    <div class="form-group" style = "width: 300px;">
                      <label>Term <span style="font-weight:normal; color:red;">*</span></label>
                      <select id="term" name="term" class="term form-control">
							<option value=1> 1 </option>
							<option value=2> 2 </option>
							<option value=3> 3 </option>
						</select>
                    </div>
                    <br><br>

                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
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
	require_once('../mysql_connect.php');

	//Get director's email
	  $sdfodquery = 'SELECT * FROM CMS.USERS WHERE USER_TYPE_ID = 9;';
	  $sdfodres = mysqli_query($dbc,$sdfodquery);

	  if(!$sdfodres){
		echo mysqli_error($dbc);
	  }
	  else{
		$sdfodrow=mysqli_fetch_array($sdfodres,MYSQLI_ASSOC);
	  }

	//Get number of students that commited minor offenses per college
	$cases_with_no_acad_service = [];
	$cases_with_acad_service = [];
	$cases_with_forms = [];
	$cases_first_offense = [];
	$cases_second_offense = [];
	$cases_third_offense = [];
	$cases_fourth_offense = [];
	$cases_fifth_offense = [];
	$cases_under_processing = [];
	$cases_dismissed = [];
	$cases_downgraded_to_minor = [];
	$totalcases = [];
	$chosenarray = array();

	$ay = $_POST['academicyear'];
	$term = $_POST['term'];
	$need_AS = 0;
	$need_FORMS = 0;
	$campus = "";
	$studentlevel = 0;
	$studentlevel = "";
	//////////////MINOR CASES

	$z = 1;
	//Formative Case Conference with students where incidents were recorded but without any offense
	for($x = 0; $x < 6; $x++){
		switch ($x){
			case	0:
						$need_AS = 0;
						$need_FORMS = 0;
						$studentlevel = 1;
						break;
			case	1:
						$need_AS = 1;
						$need_FORMS = 0;
						$studentlevel = 1;
						break;
			case	2:
						$need_AS = 0;
						$need_FORMS = 1;
						$studentlevel = 1;
						break;
			case	3:
						$need_AS = 0;
						$need_FORMS = 0;
						$studentlevel = 0;
						$cases_with_no_acad_service = array();
			case	4:
						$need_AS = 1;
						$need_FORMS = 0;
						$studentlevel = 0;
						$cases_with_acad_service = array();
			case	5:
						$need_AS = 0;
						$need_FORMS = 1;
						$studentlevel = 0;
						$cases_with_forms = array();
		}

		$chosenarray = array();

		//Loop per college
		for($i=1; $i<=7; $i++){
			$numcasesquery = "SELECT COUNT(C.REPORTED_STUDENT_ID) AS MINORCASES FROM CASES C
                  LEFT JOIN USERS U             				ON C.REPORTED_STUDENT_ID = U.USER_ID
                  LEFT JOIN REF_STUDENTS RS 						ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
									LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
									LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
									LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
									LEFT JOIN REF_STUDENTS RS				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
									WHERE U.OFFICE_ID = " .$i ." 
									WHERE U.OFFICE_ID = " .$i ."
												&& RO.TYPE = 'Minor'
												&& C.PENALTY_ID = 1
												&& C.NEED_ACAD_SERVICE = " .$need_AS ."
												&& C.NEED_FORMS = " .$need_FORMS ."
												&& SRF.TERM = ".$term ."
												&& SRF.SCHOOL_YEAR = '" .$ay. "'" ."
												&& RS.IF_GRADUATING = " .$studentlevel;
												&& RS.LEVEL = '" .$studentlevel ."'";
			$numcasesres = mysqli_query($dbc,$numcasesquery);

			if(!$numcasesres){
				echo mysqli_error($dbc);
			}
			else{
				$casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
				$cases = $casesrow['MINORCASES'];

				$totalcases[]= $cases;

				switch ($x){
					case	0:
								$cases_with_acad_service[]= $cases;
								$chosenarray = $cases_with_acad_service;
								$wat = "cases with acad service";
								break;
					case	1:
								$cases_with_no_acad_service[]= $cases;
								$chosenarray = $cases_with_no_acad_service;
								$wat = "cases with no acad service";
								break;
					case	2:
								$cases_with_forms[]= $cases;
								$chosenarray = $cases_with_forms;
								$wat = "cases with forms";
								break;
					case	3:
								$cases_with_acad_service[]= $cases;
								$chosenarray = $cases_with_acad_service;
								$wat = "cases with acad service";
								break;
					case	4:
								$cases_with_no_acad_service[]= $cases;
								$chosenarray = $cases_with_no_acad_service;
								$wat = "cases with no acad service";
								break;
					case	5:
								$cases_with_forms[]= $cases;
								$chosenarray = $cases_with_forms;
								$wat = "cases with forms ";
								break;
				}
			}
			$z++;
		}

		if($i=7){
					$sum = array_sum($chosenarray);
				}
	}

	//Formative Case Conferences with Students w/ Minor Offenses
	$offense = 0;
	for($x = 0; $x < 10; $x++){

		if($x%2 == 0){
			$need_AS = 1;
			$need_FORMS = 0;
			$studentlevel = 'Graduate';
			$offense++;
		}

		else{
			$need_AS = 0;
			$need_FORMS = 0;
			$studentlevel = 'Undergraduate';
		}

		//Loop per college
		for($i=1; $i<=7; $i++){
			$numcasesquery = "SELECT C.REPORTED_STUDENT_ID, COUNT(C.REPORTED_STUDENT_ID) CASES FROM CASES C
                LEFT JOIN USERS U             				ON C.REPORTED_STUDENT_ID = U.USER_ID
								LEFT JOIN REF_STUDENTS RS 						ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
								LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
								LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
								LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
								LEFT JOIN REF_STUDENTS RS				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
								WHERE U.OFFICE_ID = 1 
											&& RO.TYPE = 'Minor' 
											&& SRF.TERM = " .$term ."
											&& SRF.SCHOOL_YEAR = " .$ay ."
											&& RS.IF_GRADUATING = " .$studentlevel ."
								GROUP BY C.REPORTED_STUDENT_ID 
								WHERE U.OFFICE_ID = 1
											&& RO.TYPE = 'Minor'
											&& SRF.TERM = " .$term ."
											&& SRF.SCHOOL_YEAR = " .$ay ."
											&& RS.LEVEL = '" .$studentlevel ."'
								GROUP BY C.REPORTED_STUDENT_ID
								HAVING CASES = " .$offense;

			$numcasesres = mysqli_query($dbc,$numcasesquery);

			if(!$numcasesres){
				echo mysqli_error($dbc);
			}
			else{
				$cases=mysqli_num_rows($numcasesres);
				$totalcases[]= $cases;
				switch ($offense){
					case	1:
								$cases_first_offense[]= $cases;
								break;
					case	2:
								$cases_second_offense[]= $cases;
								break;
					case	3:
								$cases_third_offense[]= $cases;
								break;
					case	4:
								$cases_fourth_offense[]= $cases;
								break;
					case	5:
								$cases_fifth_offense[]= $cases;
								break;
				}
			}
		$z++;
		}
	}

	//////////////MAJOR CASES



	//Generate exec command to run python
	$exec = 'generate-report-final.py ' .$sdfodrow['email'] .' ' .$ay .' ' .$term;
	foreach ($totalcases as $value){
		$exec = $exec .' ' . $value;
	}

	$output=shell_exec($exec);
	echo("DONE!");
	exit;
  }
?>
</body>

</html>
