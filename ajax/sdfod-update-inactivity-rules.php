<?php
  session_start();
  require_once('../mysql_connect.php');

  $query=
  " UPDATE inactivity_rule 
    SET num_days = '{$_POST['minor']}' 
    WHERE offense_type = 'Minor';
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $query=
  " UPDATE inactivity_rule 
    SET num_days = '{$_POST['major']}' 
    WHERE offense_type = 'Major';
  ";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
