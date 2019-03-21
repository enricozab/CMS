<?php
	//Insert report to DB

	require_once('../mysql_connect.php');
	$reportNum = 0;
	$checkReportQuery = "SELECT SR.SUMMARY_REPORT_ID AS REPORT_ID FROM SUMMARY_REPORTS SR
								WHERE SR.ACADEMIC_YEAR = '" .$ay ."'
									&& SR.TERM = " .$term ."
									&& SR.TYPE = '" .$type ."'";

	$checkReportRes = mysqli_query($dbc,$checkReportQuery);

	$ifReportExists=mysqli_num_rows($checkReportRes);

	if ($ifReportExists == 0){
		//Generate report number
		$getLastReportNumQuery = "SELECT SR.SUMMARY_REPORT_ID AS REPORT_ID FROM SUMMARY_REPORTS SR
									ORDER BY SR.SUMMARY_REPORT_ID DESC
									LIMIT 1";

		$getLastReportNumQRes = mysqli_query($dbc,$getLastReportNumQuery);

		if(!$getLastReportNumQRes){
			echo mysqli_error($dbc);
		}

		else{
			$reportRow=mysqli_fetch_array($getLastReportNumQRes,MYSQLI_ASSOC);
			$reportNum = $reportRow['REPORT_ID'] + 1;

			$insertReportQuery = "INSERT INTO `cms`.`summary_reports`
									(`summary_report_id`, `academic_year`, `term`, `type`)
									VALUES ('" .$reportNum ."', '" .$ay ."', '" .$term ."', '" .$type ."')";

			$insertReportRes = mysqli_query($dbc,$insertReportQuery);

			if(!$insertReportRes){
				echo mysqli_error($dbc);
			}
			else{
				echo '<p hidden name="msg" id="msg">Success: Summary Report '. $type . ' Cases for AY '. $ay . ' Term ' . $term. ' generated!</p>';
			}
		}
	}

	else{
		echo '<p hidden name="msg" id="msg">Error: Summary Report ', $type , ' Cases for AY ', $ay , ' Term ' , $term, ' exists already!</p>';
	}
?>
