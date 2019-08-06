<?php
  session_start();
  require_once('../mysql_connect.php');

  $query='SELECT	  *
          FROM 		  REMINDERS R
          WHERE		  R.USER_ID = '.$_SESSION['user_id'].'
          ORDER BY	R.IF_NEW DESC, R.DATE_FILED DESC
          LIMIT     30';
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    if ($result->num_rows > 0) {
      while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $new = '';
        if ($row['if_new']) $new = 'NEW';
        echo "<li>
                <div style='padding: 5px; margin-left: 5px; margin-right: 5px;'>
                  <span class='badge' style='font-size: 10px;'>{$new}</span>&nbsp;&nbsp;<b>Case {$row['case_id']}: </b>{$row['description']}
                </div>
              </li>
              <li class='divider'></li>";
      }
    }
    else {
      echo "<li>
              <div style='padding: 5px; margin-left: 5px; margin-right: 5px;'>
                No notification.
              </div>
            </li>";
    }
  }
?>
