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
          WHERE U.USER_ID = "'.$_SESSION['user_id'].'"';
$nameq = mysqli_query($dbc,$name);

if(!$nameq){
  echo mysqli_error($dbc);
}
else{
  $nameres=mysqli_fetch_array($nameq,MYSQLI_ASSOC);
}

?>
