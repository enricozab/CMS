<?php
	require_once('../mysql_connect.php');
	//Get academic year
	$ayquery = 'SELECT DISTINCT(SRF.SCHOOL_YEAR) 
					FROM CMS.STUDENT_RESPONSE_FORMS SRF 
					ORDER BY SRF.SCHOOL_YEAR ASC';
	  $ayres = mysqli_query($dbc,$ayquery);

	  if(!$ayres){
		echo mysqli_error($dbc);
	  }
	  else{
		$ayrow=mysqli_fetch_array($ayres,MYSQLI_ASSOC);
	  }
?>