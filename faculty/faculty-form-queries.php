<?php
  // office
  $officequery = 'SELECT C.DESCRIPTION
                    FROM REF_USER_OFFICE C
                    JOIN USERS U ON C.OFFICE_ID = U.OFFICE_ID
                   WHERE U.USER_ID = "'.$_SESSION['user_id'].'"';
  $officeres = mysqli_query($dbc,$officequery);

  if(!$officeres){
    echo mysqli_error($dbc);
  }
  else{
    $officerow=mysqli_fetch_array($officeres,MYSQLI_ASSOC);
  }

  // complainant name

  $name = 'SELECT *
                    FROM USERS
                   WHERE USER_ID = "'.$_SESSION['user_id'].'"';
  $nameq = mysqli_query($dbc,$name);

  if(!$nameq){
    echo mysqli_error($dbc);
  }
  else{
    $nameres=mysqli_fetch_array($nameq,MYSQLI_ASSOC);
  }

  // $array=json_decode($_POST['studentID']);
  //
  // for ($x = 0; $x < count($array); $x++) {
  //   $student = 'SELECT *
  //                FROM USERS
  //               WHERE USER_ID = "'.$array[x].'"';
  //   $studentq = mysqli_query($dbc,$student);
  //
  //   if(!$studentq){
  //     echo mysqli_error($dbc);
  //   }
  //   else{
  //     $studentres=mysqli_fetch_array($studentq,MYSQLI_ASSOC);
  //   }
  // }

  // // student details
  //
  // $student = 'SELECT *
  //             FROM USERS
  //            WHERE USER_ID = "'.$_SESSION['studentIDN'].'"';
  // $studentq = mysqli_query($dbc,$student);
  //
  // if(!$studentq){
  //   echo mysqli_error($dbc);
  // }
  // else{
  //   $studentres=mysqli_fetch_array($studentq,MYSQLI_ASSOC);
  // }
?>
