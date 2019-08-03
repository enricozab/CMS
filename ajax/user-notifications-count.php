<?php
  session_start();
  require_once('../mysql_connect.php');

  if($_SESSION['user_type_id'] == 1){
    $query="SELECT 		C.CASE_ID AS 'CASE_ID',
                      C.REMARKS_ID AS 'REMARKS_ID',
                      DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		  CASES C
            WHERE		  C.REPORTED_STUDENT_ID = ".$_SESSION['user_id']."
            AND			  (C.STATUS_ID = 1 OR C.STATUS_ID = 2)
            ORDER BY  C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else {
    $count = 0;
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      if($row['REMARKS_ID'] == 3 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          $count += 1;
        }
      }
      else if($row['REMARKS_ID'] == 4 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          $count += 1;
        }
      }
    }
    echo $count;
  }
?>
