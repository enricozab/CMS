<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="SELECT EMAIL, CONCAT(FIRST_NAME,' ',LAST_NAME,' ',EMAIL) AS VAL FROM USERS WHERE USER_TYPE_ID IN {$_REQUEST["usertype"]}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else {
    echo "<option value='' disabled selected>Select Details</option>";
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        echo "<option value='".$row['EMAIL']."'>".$row['VAL']."</option>";
    }
  }
?>
