<?php
  $cquery='SELECT COUNT(CASE_ID) AS "CASES" FROM STUDENT_CASES WHERE IF_NEW=1 AND USER_ID="'.$_SESSION['user_id'].'"';
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
  }
?>
