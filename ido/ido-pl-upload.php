<?php
  session_start();
  require_once('../mysql_connect.php');

  $updateQry = 'UPDATE FORM_UPLOADING
                   SET PL_UPLOADED = 1
                 WHERE CASE_ID = '.$_POST['caseid'];

  $update = mysqli_query($dbc,$updateQry);
  if(!$update){
    echo mysqli_error($dbc);
  }
?>
