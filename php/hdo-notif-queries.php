<?php
  $query='SELECT COUNT(CASE_ID) AS "CASES" FROM CASES WHERE IF_NEW=1';
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  }
?>
