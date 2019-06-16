<?php
  session_start();
  require_once('../mysql_connect.php');

  $query='SELECT 		  C.CASE_ID AS CASE_ID,
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
                      C.DATE_CLOSED AS DATE_CLOSED,
                      STUD.IF_NEW AS IF_NEW
          FROM 		    CASES C
          LEFT JOIN   STUDENT_CASES STUD ON C.CASE_ID = STUD.CASE_ID
          LEFT JOIN	  USERS U ON C.REPORTED_STUDENT_ID = U.USER_ID
          LEFT JOIN	  USERS U1 ON C.COMPLAINANT_ID = U1.USER_ID
          LEFT JOIN	  USERS U2 ON C.HANDLED_BY_ID = U2.USER_ID
          LEFT JOIN   REF_STUDENTS RS ON U.USER_ID = RS.STUDENT_ID
          LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
          LEFT JOIN   REF_CHEATING_TYPE RCT ON C.CHEATING_TYPE_ID = RCT.CHEATING_TYPE_ID
          LEFT JOIN   REF_STATUS S ON C.STATUS_ID = S.STATUS_ID
          LEFT JOIN   REF_REMARKS R ON C.REMARKS_ID = R.REMARKS_ID
          LEFT JOIN   REF_PENALTIES RP ON C.PENALTY_ID = RP.PENALTY_ID

          WHERE       C.REPORTED_STUDENT_ID = '.$_SESSION['user_id'].'
          ORDER BY	  C.LAST_UPDATE DESC';
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    echo '<thead>
              <tr>
                  <th>Case No.</th>
                  <th>Offense</th>
                  <th>Type</th>
                  <th>Date Filed</th>
                  <th>Last Update</th>
                  <th>Status</th>
                  <th>Remarks</th>
              </tr>
          </thead>
          <tbody>';
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      echo "<tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"location.href='student-view-case.php?cn={$row['CASE_ID']}'\">
            <td>{$row['CASE_ID']}";

      if($row['IF_NEW']) {
          echo "&nbsp;&nbsp;&nbsp;<span class=\"badge\">NEW</span></td>";
      }

      echo "<td>{$row['OFFENSE_DESCRIPTION']}</td>
            <td>{$row['TYPE']}</td>
            <td>{$row['DATE_FILED']}</td>
            <td>{$row['LAST_UPDATE']}</td>
            <td>{$row['STATUS_DESCRIPTION']}</td>
            <td>{$row['REMARKS_DESCRIPTION']}</td>
            </tr>";
    }
    echo '</tbody>';
  }
?>