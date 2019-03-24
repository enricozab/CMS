<?php
  session_start();
  require_once('../mysql_connect.php');
  if ($_POST['appeal']) {
    $updateQry = 'UPDATE STUDENT_RESPONSE_FORMS
                     SET IF_UPLOADED = 2
                   WHERE STUDENT_RESPONSE_FORM_ID =  '.$_POST['srf'];
  }
  else {
    $updateQry = 'UPDATE STUDENT_RESPONSE_FORMS
                     SET IF_UPLOADED = 1
                   WHERE STUDENT_RESPONSE_FORM_ID =  '.$_POST['srf'];
  }

  $update = mysqli_query($dbc,$updateQry);
  if(!$update){
    echo mysqli_error($dbc);
  }
?>
