<?php
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
	$totalcases = [];

	$need_AS = 0;
	$need_FORMS = 0;
	$campus = "";
	$studentlevel = "Graduate";
	
	//////////////MINOR CASES

	$z = 1;
	//Formative Case Conference with students where incidents were recorded but without any offense
	for($x = 0; $x < 6; $x++){
		switch ($x){
			case	0:
						$need_AS = 0;
						$need_FORMS = 0;
						$studentlevel = "Graduate";
						break;
			case	1:
						$need_AS = 1;
						$need_FORMS = 0;
						$studentlevel = "Graduate";
						break;
			case	2:
						$need_AS = 0;
						$need_FORMS = 1;
						$studentlevel = "Graduate";
						break;
			case	3:
						$need_AS = 0;
						$need_FORMS = 0;
						$studentlevel = "Undergraduate";
			case	4:
						$need_AS = 1;
						$need_FORMS = 0;
						$studentlevel = "Undergraduate";
			case	5:
						$need_AS = 0;
						$need_FORMS = 1;
						$studentlevel = "Undergraduate";
		}

		$chosenarray = array();

		//Loop per college
		for($i=1; $i<=7; $i++){
			// && C.NEED_FORMS = " .$need_FORMS ."
			
			if($x != 2 || $x != 5){
				$numcasesquery = "SELECT COUNT(C.REPORTED_STUDENT_ID) AS MINORCASES FROM CASES C
										LEFT JOIN USERS U             			ON C.REPORTED_STUDENT_ID = U.USER_ID
										LEFT JOIN REF_STUDENTS RS 				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
										LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
										LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
										LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
										WHERE U.OFFICE_ID = " .$i ."
													&& RO.TYPE = 'Minor'
													&& C.PENALTY_ID = 1
													&& C.NEED_ACAD_SERVICE = " .$need_AS ."
													&& SRF.TERM = ".$term ."
													&& SRF.SCHOOL_YEAR = '" .$ay. "'" ."
													&& RS.LEVEL = '" .$studentlevel ."'";
			}
			else{
				$numcasesquery = "SELECT COUNT(C.REPORTED_STUDENT_ID) AS MINORCASES FROM CASES C
									LEFT JOIN USERS U             			ON C.REPORTED_STUDENT_ID = U.USER_ID
									LEFT JOIN REF_STUDENTS RS 				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
									LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
									LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
									LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
									WHERE U.OFFICE_ID = " .$i ."
												&& RO.TYPE = 'Minor'
												&& C.PENALTY_ID = 1
												&& C.NEED_FORMS = " .$need_FORMS ."
												&& SRF.TERM = ".$term ."
												&& SRF.SCHOOL_YEAR = '" .$ay. "'" ."
												&& RS.LEVEL = '" .$studentlevel ."'";
			}
			$numcasesres = mysqli_query($dbc,$numcasesquery);

			if(!$numcasesres){
				echo mysqli_error($dbc);
			}
			else{
				$casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
				$cases = $casesrow['MINORCASES'];

				$totalcases[]= $cases;
			}
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
								LEFT JOIN REF_STUDENTS RS 				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
								LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
								LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
								LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
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
			}
		}
	}

	//Generate exec command to run python
	$exec = 'generate-minor-report.py ' .$sdfodrow['email'] .' ' .$ay .' ' .$term . ' ' .$reportNum;
	foreach ($totalcases as $value){
		$exec = $exec .' ' . $value;
	}

	//Create GSheets
	$output=shell_exec($exec);
	exit;
?>