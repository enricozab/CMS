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

  $typeq="SELECT * FROM REF_OFFENSES WHERE offense_id = {$_POST['offenseID']}";
  $typeres=mysqli_query($dbc,$typeq);
  if(!$typeres){
    echo mysqli_error($dbc);
  }
  else {
    $typerow=mysqli_fetch_array($typeres,MYSQLI_ASSOC);
  }

  if($_POST['page'] == "HDO-APPREHENSION"){ //new thea
    $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,DATE_INCIDENT,LOCATION,DETAILS,HANDLED_BY_ID)
               VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['dateIncident']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}')";
  }

  else {
    if($typerow['type'] == "Major") {
      $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,DATE_INCIDENT,LOCATION,DETAILS,HANDLED_BY_ID)
                VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['dateIncident']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}')";
    }
    else {
      $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,DATE_INCIDENT,LOCATION,DETAILS,HANDLED_BY_ID,REMARKS_ID)
                VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['dateIncident']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}',3)";
    }
  }

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $student = $_POST['studentID'];

  $newQry = "SELECT LAST_INSERT_ID() AS LATEST";
  $newResult=mysqli_query($dbc,$newQry);
  if(!$newResult){
    echo mysqli_error($dbc);
  }
  else{
    $newRow=mysqli_fetch_array($newResult,MYSQLI_ASSOC);
    // new
    if($_POST['page'] == "HDO-APPREHENSION"){
      $queryStud = 'SELECT *
                      FROM USERS U
                      JOIN REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
                      JOIN REF_STUDENTS RS ON RS.STUDENT_ID = U.USER_ID
                     WHERE U.USER_ID = "'.$student.'"';

      $resultStud = mysqli_query($dbc,$queryStud);

      if(!$resultStud){
        echo mysqli_error($dbc);
      }
      else{
        $rowStud = mysqli_fetch_array($resultStud,MYSQLI_ASSOC);
      }

      if ($rowStud['if_graduating'] == 1) {
        $graduate = "Graduate";
      }

      else {
        $graduate = "Undergraduate";
      }

      $passData = $rowStud['description'] . "/" . $rowStud['degree'] . "/" . $graduate . "/" . $rowStud['user_id'] .  "/" . "HDO-APPREHENSION" . "/" . $newRow['LATEST'];
      echo $passData;
    }

    else {
      echo $newRow['LATEST'];
    }
  }

  // end thea new
?>
