<?php
	//Get number of students that commited minor offenses per college
	$totalstudents = [];
	for(i=1; i<=8; i++){
		$numstudentsquery = 'SELECT COUNT(C.REPORTED_STUDENT_ID) AS STUDENTS FROM CASES C 
							LEFT JOIN USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
							LEFT JOIN REF_USER_OFFICE RUO ON U.OFFICE_ID = RUO.OFFICE_ID
							LEFT JOIN REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
							WHERE U.OFFICE_ID = ' .i .'&& RO.TYPE = "Minor"';
							
		$numstudentres = mysqli_query($dbc. $numstudentsquery);
		
		if(!$numstudentres){
			echo mysqli_error($dbc);
		  }
		  else{
			$studentrow=mysqli_fetch_array($numstudentres,MYSQLI_ASSOC);
			$totalstudents[]= $studentrow['STUDENTS'];
			
		  }
	}	
?>