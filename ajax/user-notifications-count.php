<?php
  session_start();
  require_once('../mysql_connect.php');

  if($_SESSION['user_type_id'] == 1){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    CASES C
            WHERE		    C.REPORTED_STUDENT_ID = ".$_SESSION['user_id']."
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }
  else if($_SESSION['user_type_id'] == 4){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        RO.TYPE AS TYPE,
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    CASES C
            LEFT JOIN   IDO_CASES IDO ON C.CASE_ID = IDO.CASE_ID
            LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
            WHERE		    C.HANDLED_BY_ID = ".$_SESSION['user_id']."
            AND         IDO.HANDLE = 1
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }
  else if($_SESSION['user_type_id'] == 7){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        RCP.PROCEEDINGS_DESC AS PROCEEDINGS_DESC,
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF',
                        DATEDIFF(CURDATE(),C.PROCEEDING_DATE) AS 'DATEPROC'
            FROM 		    ULC_CASES ULC
            LEFT JOIN   CASES C ON ULC.CASE_ID = C.CASE_ID
            LEFT JOIN   CASE_REFERRAL_FORMS CRF ON C.CASE_ID = CRF.CASE_ID
            LEFT JOIN   REF_CASE_PROCEEDINGS RCP ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }
  
  if(in_array($_SESSION['user_type_id'],array(3,8,9))) {
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    CASES C
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
            
    $query2="SELECT 		IR.INCIDENT_REPORT_ID AS 'INCIDENT_REPORT_ID',
                        C.CASE_ID AS CASE_ID
            FROM 		    INCIDENT_REPORTS IR
            LEFT JOIN		CASES C ON IR.INCIDENT_REPORT_ID = C.INCIDENT_REPORT_ID
            ORDER BY    IR.DATE_FILED DESC, IR.INCIDENT_REPORT_ID DESC";
    $query3="SELECT 		  C.CASE_ID AS CASE_ID,
                          RO.TYPE AS TYPE,
                          DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
              FROM 		    CASES C
              LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
              WHERE       C.STATUS_ID = 1 OR C.STATUS_ID = 2
              ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else {
    $count = 0;
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      if(in_array($row['REMARKS_ID'],array(2,7)) && $_SESSION['user_type_id'] == 4) {
        $count += 1;
      }
      else if(in_array($row['REMARKS_ID'],array(3,4)) && $_SESSION['user_type_id'] == 1) {
        $count += 1;
      }
      else if(in_array($row['REMARKS_ID'],array(8,9,12,13,14,15,16)) && $_SESSION['user_type_id'] == 7) {
        if ($row['REMARKS_ID'] == 9) {
          if($row['DATEPROC'] >= 0) {
            $count += 1;
          }
        }
        else {
          $count += 1;
        }
      }
    }

    if($_SESSION['user_type_id'] == 3) {
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else {
        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
          if($row2['CASE_ID'] == NULL) {
            $count += 1;
          }
        }
      }

      $result3=mysqli_query($dbc,$query3);
      if(!$result3){
        echo mysqli_error($dbc);
      }
      else {
        while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)){
          if($row3['TYPE'] == 'Minor' && $row3['DATEDIFF'] > 2) {
            $count += 1;
          }
          else if($row3['TYPE'] == 'Major' && $row3['DATEDIFF'] > 4) {
            $count += 1;
          }
        }
      }
    }
    echo $count;
  }
?>
