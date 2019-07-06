<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="SELECT DETAILS FROM REF_DETAILS WHERE OFFENSE_ID = {$_REQUEST['offense']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else {
    echo "<option value='' disabled selected>Select Details</option>";
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        echo "<option value='".$row['DETAILS']."'>".$row['DETAILS']."</option>";
    }
  }
?>
