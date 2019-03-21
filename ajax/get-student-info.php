<?php
  session_start();
  require_once('../mysql_connect.php');

  $student = "SELECT     *
              FROM 		   USERS U
              JOIN 		   REF_USER_OFFICE RUO ON U.OFFICE_ID = RUO.OFFICE_ID
              JOIN       REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
              WHERE 		 USER_ID = {$_POST['studentID']}";
  $studentq = mysqli_query($dbc,$student);

  if(!$studentq){
   echo mysqli_error($dbc);
  }
  else{
   $studentres=mysqli_fetch_array($studentq,MYSQLI_ASSOC);

   echo json_encode($studentres);
  }
 ?>
