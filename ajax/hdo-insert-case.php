<?php
  session_start();
  require_once('../mysql_connect.php');

  $cheatType = 'NULL';
  if($_POST['cheatingType'] != null){
    $cheatType = $_POST['cheatingType'];
  }

  $incidentReport = 'NULL';
  if($_POST['incidentreportID'] != null){
    $incidentReport = $_POST['incidentreportID'];
  }
  //Insert in cases
  $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,LOCATION,DETAILS,HANDLED_BY_ID)
            VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}')";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }

  //Insert in users_ido
  $query="SELECT USER_ID FROM USERS_IDO WHERE USER_ID = {$_POST['assignIDO']} LIMIT 1";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }
  else{
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(empty($row['USER_ID'])){
      $query2="SELECT HANDLED_BY_ID FROM CASES WHERE CASE_ID = (SELECT MAX(CASE_ID) FROM CASES)";
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo 'mysqli_error($dbc)';
      }
      else{
        $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);
        $query3="INSERT INTO USERS_IDO (USER_ID)
                  VALUES ('{$row2['HANDLED_BY_ID']}')";
        $result3=mysqli_query($dbc,$query3);
        if(!$result3){
          echo 'mysqli_error($dbc)';
        }
      }
    }
    $query="SELECT    RO.TYPE AS TYPE
            FROM 		  CASES C
            JOIN      REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
            WHERE     C.CASE_ID = (SELECT MAX(CASE_ID) FROM CASES)";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo 'mysqli_error($dbc)';
    }
    else{
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
      if($row['TYPE'] == "Major"){
        $query2="UPDATE USERS_IDO SET HANDLING_MAJOR_CASE = HANDLING_MAJOR_CASE+1 WHERE USER_ID = {$_POST['assignIDO']}";
        $result2=mysqli_query($dbc,$query2);
        if(!$result2){
          echo 'mysqli_error($dbc)';
        }
      }
      else{
        $query2="UPDATE USERS_IDO SET HANDLING_MINOR_CASE = HANDLING_MINOR_CASE+1 WHERE USER_ID = {$_POST['assignIDO']}";
        $result2=mysqli_query($dbc,$query2);
        if(!$result2){
          echo 'mysqli_error($dbc)';
        }
      }
    }
  }
?>
