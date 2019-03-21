<?php
//////////////MAJOR CASES
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
	$studentlevel = "Graduate";
	$status = 0;

	$z = 1;
	//Cases/complaints under processing	& Dismissed Cases
	for($x = 0; $x < 4; $x++){
		switch ($x){
			case	0:
						$status = 2;
						$studentlevel = "Graduate";
						break;
			case	1:
						$status = 2;
						$studentlevel = "Undergraduate";
						break;
			case	2:
						$status = 4;
						$studentlevel = "Graduate";
						break;
			case	3:
						$status = 4;
						$studentlevel = "Graduate";
						break;
		}

		//Loop per college
		for($i=1; $i<=7; $i++){
			$numcasesquery = "SELECT COUNT(C.REPORTED_STUDENT_ID) AS MAJORCASES FROM CASES C
								LEFT JOIN USERS U 						ON C.REPORTED_STUDENT_ID = U.USER_ID
								LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
								LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
								LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
								LEFT JOIN REF_STUDENTS RS				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
								LEFT JOIN CASE_REFERRAL_FORMS CRF		ON C.CASE_ID = CRF.CASE_ID
								LEFT JOIN REF_CASE_PROCEEDINGS RCP		ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
								WHERE U.OFFICE_ID = " .$i ."
											&& RO.TYPE = 'Major'
											&& SRF.TERM = " .$term ."
											&& SRF.SCHOOL_YEAR = '" .$ay ."'
											&& RS.LEVEL = '" .$studentlevel ."'
											&& C.STATUS_ID = " .$status;
			$numcasesres = mysqli_query($dbc,$numcasesquery);
			if(!$numcasesres){
				echo mysqli_error($dbc);
			}
			else{
				$casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
				$cases = $casesrow['MAJORCASES'];
				$totalcases[]= $cases;
			}
			//echo 'Data Num #', $z, '<br>';
			$z++;
		}
	}

	//Cases Heard Through
	$proceedings = 0;
	for($x = 0; $x < 6; $x++){

		if($x%2 == 0){
			$studentlevel = 'Graduate';
		}

		else{
			$studentlevel = 'Undergraduate';
		}

		switch ($x){
					case	0:
								$proceedings = 3;
								$studentlevel = 'Graduate';
								break;
					case	1:
								$proceedings = 3;
								$studentlevel = 'Undergraduate';
								break;
					case	2:
								$proceedings = 2;
								$studentlevel = 'Graduate';
								break;
					case	3:
								$proceedings = 2;
								$studentlevel = 'Undergraduate';
								break;
					case	4:
								$proceedings = 1;
								$studentlevel = 'Graduate';
								break;
					case	5:
								$proceedings = 1;
								$studentlevel = 'Undergraduate';
								break;
		}

		//Loop per college
		for($i=1; $i<=7; $i++){

			$numcasesquery = "SELECT COUNT(C.REPORTED_STUDENT_ID) AS MAJORCASES FROM CASES C
								LEFT JOIN USERS U 						ON C.REPORTED_STUDENT_ID = U.USER_ID
								LEFT JOIN REF_USER_OFFICE RUO 			ON U.OFFICE_ID = RUO.OFFICE_ID
								LEFT JOIN REF_OFFENSES RO 				ON C.OFFENSE_ID = RO.OFFENSE_ID
								LEFT JOIN STUDENT_RESPONSE_FORMS SRF 	ON C.CASE_ID = SRF.CASE_ID
								LEFT JOIN REF_STUDENTS RS				ON C.REPORTED_STUDENT_ID = RS.STUDENT_ID
								LEFT JOIN CASE_REFERRAL_FORMS CRF		ON C.CASE_ID = CRF.CASE_ID
								LEFT JOIN REF_CASE_PROCEEDINGS RCP		ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
								WHERE U.OFFICE_ID = " .$i ."
											&& RO.TYPE = 'Major'
											&& SRF.TERM = " .$term ."
											&& SRF.SCHOOL_YEAR = '" .$ay ."'
											&& RS.LEVEL = '" .$studentlevel ."'
											&& CRF.PROCEEDINGS = " .$proceedings;

			$numcasesres = mysqli_query($dbc,$numcasesquery);

			if(!$numcasesres){
				echo mysqli_error($dbc);
			}
			else{
				$casesrow=mysqli_fetch_array($numcasesres,MYSQLI_ASSOC);
				$cases = $casesrow['MAJORCASES'];
				$totalcases[]= $cases;
			}
			//echo 'Data Num #', $z, '<br>';
			$z++;
		}
	}

	//Generate exec command to run python
	$exec = 'generate-major-report.py ' .$sdfodrow['email'] .' ' .$ay .' ' .$term . ' ' .$reportNum;
	foreach ($totalcases as $value){
		$exec = $exec .' ' . $value;
	}

	//Create GSheets
	////echo "Exec: ", $exec;
	$output=shell_exec($exec);
?>
