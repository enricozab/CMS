<?php
  session_start();
  require_once('../mysql_connect.php');

  $query='SELECT    	C.CASE_ID AS CASE_ID,
                      C.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                      C.REPORTED_STUDENT_ID AS REPORTED_STUDENT_ID,
                      CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS STUDENT,
                      C.OFFENSE_ID AS OFFENSE_ID,
                      RO.DESCRIPTION AS OFFENSE_DESCRIPTION,
                      C.CHEATING_TYPE_ID AS CHEATING_TYPE_ID,
                      RO.TYPE AS TYPE,
                      RS.IF_GRADUATING AS IF_GRADUATING,
                      C.COMPLAINANT_ID AS COMPLAINANT_ID,
                      CONCAT(U1.FIRST_NAME," ",U1.LAST_NAME) AS COMPLAINANT,
                      C.DETAILS AS DETAILS,
                      C.ADMISSION_TYPE_ID AS ADMISSION_TYPE_ID,
                      C.HANDLED_BY_ID AS HANDLED_BY_ID,
                      CONCAT(U2.FIRST_NAME," ",U2.LAST_NAME) AS HANDLED_BY,
                      C.DATE_FILED AS DATE_FILED,
                      C.STATUS_ID AS STATUS_ID,
                      S.DESCRIPTION AS STATUS_DESCRIPTION,
                      C.REMARKS_ID AS REMARKS_ID,
                      R.DESCRIPTION AS REMARKS_DESCRIPTION,
                      C.LAST_UPDATE AS LAST_UPDATE,
                      C.PENALTY_ID AS PENALTY_ID,
                      RP.PENALTY_DESC AS PENALTY_DESC,
                      C.VERDICT AS VERDICT,
                      C.PROCEEDING_DATE AS PROCEEDING_DATE,
                      C.PROCEEDING_DECISION AS PROCEEDING_DECISION,
                      C.DATE_CLOSED AS DATE_CLOSED,
                      C.IF_NEW AS IF_NEW,
                      RCP.PROCEEDINGS_DESC AS PROCEEDINGS,
                      DRL.DIRECTOR_REMARKS_ID AS DIRECTOR_REMARKS_ID,
                      RU.DESCRIPTION AS OFFICE_DESCRIPTION,
                      RS.DEGREE AS DEGREE,
                      RS.LEVEL AS LEVEL
          FROM 		    CASES C
          LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
          LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
          LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
          LEFT JOIN   CASE_REFERRAL_FORMS CRF ON C.CASE_ID = CRF.CASE_ID
          LEFT JOIN   REF_STUDENTS RS ON U.USER_ID = RS.STUDENT_ID
          LEFT JOIN   REF_USER_OFFICE RU ON RU.OFFICE_ID = U.OFFICE_ID
          LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
          LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
          LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
          LEFT JOIN   REF_REMARKS R ON C.REMARKS_ID = R.REMARKS_ID
          LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID
          LEFT JOIN   REF_CASE_PROCEEDINGS RCP ON CRF.PROCEEDINGS = RCP.CASE_PROCEEDINGS_ID
          LEFT JOIN   DIRECTOR_REMARKS_LIST DRL ON C.CASE_ID = DRL.CASE_ID
          WHERE       (RO.TYPE="MAJOR" OR DRL.DIRECTOR_REMARKS_ID=3) 
          AND         S.DESCRIPTION = "Closed"
          AND         (C.IF_NEW != 2 AND C.IF_NEW != 3)
          AND         C.CASE_ID != '.$_POST['cn'].'
          AND         C.REPORTED_STUDENT_ID = '.$_POST["studentID"].'
          ORDER BY	  C.DATE_FILED DESC';
  $relatedres=mysqli_query($dbc,$query);
  if(!$relatedres){
    echo mysqli_error($dbc);
  }
  else{
    if ($relatedres->num_rows > 0) {
      while($relatedrow=mysqli_fetch_array($relatedres,MYSQLI_ASSOC)) {
        echo "<li>
                <div style='margin-right: 20px; margin-left: -20px;'>
                  <p>
                      <strong>Case No. {$relatedrow['CASE_ID']}</strong>
                      <span class='pull-right text-muted'><button type='submit' id='viewCase' name='viewCase' onclick='viewCase({$relatedrow['CASE_ID']})' value='{$relatedrow['CASE_ID']}' class='btn btn-info viewC'>View Case</button></span>
                  </p>
                  <div>
                      <br>
                      <p>Offense: <strong>{$relatedrow['OFFENSE_DESCRIPTION']}</strong></p>
                      <p>Status: <strong>{$relatedrow['STATUS_DESCRIPTION']}</strong></p>
                      <p>Summary of the Incident: <strong>{$relatedrow['DETAILS']}</strong></p>
                      <p>Proceedings: <strong>{$relatedrow['PROCEEDINGS']}</strong></p>
                      <p>Penalty: <strong>{$relatedrow['PROCEEDING_DECISION']}</strong></p>
                  </div>
                </div>
              </li>
              <hr style='margin-right: 20px; margin-left: -20px;'>";
      }
    }
    else {
      echo "<p style='margin-right: 20px; margin-left: -20px;'>No previous closed cases available.</p>";
    }
  }
?>
