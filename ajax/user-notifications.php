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
    $empty = true;
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      if($row['REMARKS_ID'] == 3 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          echo "<li>
                  <div style='padding: 8px; margin-left: 10px; margin-right: 10px;'>
                    <b>Case {$row['CASE_ID']}: </b>Please submit Student Response Form and evidence if there is any.
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
      else if($row['REMARKS_ID'] == 4 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          echo "<li>
                  <div style='padding: 8px; margin-left: 10px; margin-right: 10px;'>
                    <b>Case {$row['CASE_ID']}: </b>Please resubmit Student Response Form.
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
    }
    if ($empty) {
      echo "<li>
              <div style='padding: 5px; margin-left: 5px; margin-right: 5px;'>
                No notification.
              </div>
            </li>";
    }
  }
?>
