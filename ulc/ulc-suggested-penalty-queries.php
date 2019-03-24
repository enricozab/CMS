<?php
  $suggestq='SELECT 		  COUNT(CASE_ID) AS SUGGESTION,
              			      C.PROCEEDING_DECISION AS PROCEEDING_DECISION
              FROM		    CASES C
              LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
              LEFT JOIN	  REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID
              WHERE		    C.OFFENSE_ID = '.$row['OFFENSE_ID'].' AND C.DETAILS = "'.$row['DETAILS'].'" AND C.STATUS_ID=3
                          AND C.CASE_ID != '.$_GET['cn'].'
              GROUP BY	  C.PROCEEDING_DECISION
              ORDER BY	  1 DESC';
  $suggestres=mysqli_query($dbc,$suggestq);
  if(!$suggestres){
    echo mysqli_error($dbc);
  }
  else{
    $suggestrow=mysqli_fetch_array($suggestres,MYSQLI_ASSOC);
  }
?>
