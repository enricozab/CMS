<?php

$case = 'SELECT *
           FROM cases c
           JOIN users u ON u.user_id = c.complainant_id
           JOIN ref_offenses r ON r.offense_id = c.offense_id
          WHERE case_id = "'.$_GET['cn'].'"';

$caseq = mysqli_query($dbc,$case);

if(!$caseq){
  echo mysqli_error($dbc);
}
else{
  $caseres = mysqli_fetch_array($caseq,MYSQLI_ASSOC);
}

// ido name

$ido = 'SELECT *
           FROM cases c
           JOIN users u ON u.user_id = c.handled_by_id
          WHERE case_id = "'.$_GET['cn'].'"';

$idoq = mysqli_query($dbc,$ido);

if(!$idoq){
  echo mysqli_error($dbc);
}
else{
  $idores = mysqli_fetch_array($idoq,MYSQLI_ASSOC);
}

// complainant name

$complainant = 'SELECT *
           FROM cases c
           JOIN users u ON u.user_id = c.complainant_id
          WHERE case_id = "'.$_GET['cn'].'"';

$complainantq = mysqli_query($dbc,$complainant);

if(!$complainantq){
  echo mysqli_error($dbc);
}
else{
  $complainantres = mysqli_fetch_array($complainantq,MYSQLI_ASSOC);
}

// student details

$name = 'SELECT *
           FROM USERS U
           JOIN REF_USER_OFFICE R ON R.OFFICE_ID = U.OFFICE_ID
          WHERE U.USER_ID = "'.$row['REPORTED_STUDENT_ID'].'"';
$nameq = mysqli_query($dbc,$name);

if(!$nameq){
  echo mysqli_error($dbc);
}
else{
  $nameres=mysqli_fetch_array($nameq,MYSQLI_ASSOC);
}

// college & year_level

$student = 'SELECT *
           FROM USERS U
           JOIN REF_STUDENTS RS ON U.USER_ID = RS.STUDENT_ID
          WHERE U.USER_ID = "'.$row['REPORTED_STUDENT_ID'].'"';
$studentq = mysqli_query($dbc,$student);

if(!$studentq){
  echo mysqli_error($dbc);
}
else{
  $studentres=mysqli_fetch_array($studentq,MYSQLI_ASSOC);
}

// form

$form = 'SELECT MAX(STUDENT_RESPONSE_FORM_ID)+1 AS MAX
          FROM STUDENT_RESPONSE_FORMS';
$formq = mysqli_query($dbc,$form);

if(!$formq){
  echo mysqli_error($dbc);
}
else{
  $formres = mysqli_fetch_array($formq);
}


$form2 = 'SELECT *
          FROM STUDENT_RESPONSE_FORMS SRF
          WHERE SRF.CASE_ID = "'.$_GET['cn'].'"';
$formq2 = mysqli_query($dbc,$form2);

if(!$formq2){
  echo mysqli_error($dbc);
}
else{
  $formres2 = mysqli_fetch_array($formq2);
}
?>
