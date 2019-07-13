<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery="INSERT INTO REF_CHECK_OUT (FILENAME, USER_ID, CHECKEDOUT)
                            VALUES	 ('{$_POST['file_name']}', {$_POST['user']}, 1)";
  $cresult=mysqli_query($dbc,$cquery);

  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
  }
?>
