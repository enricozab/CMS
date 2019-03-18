<?php
  $reportedStudent = $row['REPORTED_STUDENT_ID'];
  $dateFiled = $row['DATE_FILED'];
  // MINOR
  $currentMinorOffense = 0;
  $numSameMinorOffense = 0;
  $numSameMinor = 0;

  // GET CASE OFFENSE ID
  $curcaseq = 'SELECT *
               FROM cases c
               WHERE c.case_id = "'.$_GET['cn'].'"';

  $curcaseres = mysqli_query($dbc,$curcaseq);

  if(!$curcaseres){
    echo mysqli_error($dbc);
  }
  else{
    $curcaserow = mysqli_fetch_array($curcaseres,MYSQLI_ASSOC);
    $currentMinorOffense = $curcaserow['offense_id'];
  }

  // COUNT NUMBER OF SAME MINOR OFFENSE
  $countminoroffenseq = 'SELECT COUNT(c.case_id) as count
                         FROM cases c
                         WHERE c.reported_student_id = "'.$reportedStudent.'" AND c.offense_id = "'.$currentMinorOffense.'" AND c.date_filed <= "'.$dateFiled.'"';

  $countminoroffenseres = mysqli_query($dbc,$countminoroffenseq);

  if(!$countminoroffenseres){
    echo mysqli_error($dbc);
  }
  else{
    $countminoroffenserow = mysqli_fetch_array($countminoroffenseres,MYSQLI_ASSOC);
    $numSameMinorOffense = $countminoroffenserow['count'];
  }

  // COUNT NUMBER OF SAME MINOR
  $countminorq = 'SELECT COUNT(c.case_id) as count
                   FROM cases c
                   LEFT JOIN ref_offenses ro on c.offense_id = ro.offense_id
                   WHERE c.reported_student_id = "'.$reportedStudent.'" AND ro.type = "Minor" AND c.date_filed <= "'.$dateFiled.'"';

  $countminorres = mysqli_query($dbc,$countminorq);

  if(!$countminorres){
    echo mysqli_error($dbc);
  }
  else{
    $countminorrow = mysqli_fetch_array($countminorres,MYSQLI_ASSOC);
    $numSameMinor = $countminorrow['count'];
  }
?>
