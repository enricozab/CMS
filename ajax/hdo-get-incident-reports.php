<?php
  session_start();
  require_once('../mysql_connect.php');

  $query='SELECT 	  		IR.INCIDENT_REPORT_ID AS INCIDENT_REPORT_ID,
                        CONCAT(U.FIRST_NAME," ",U.LAST_NAME) AS COMPLAINANT,
                        IR.DATE_FILED,
                        IR.IF_NEW AS IF_NEW,
                        C.CASE_ID AS CASE_ID
          FROM 	    	  INCIDENT_REPORTS IR
          LEFT JOIN	    USERS U ON IR.COMPLAINANT_ID = U.USER_ID
          LEFT JOIN		  CASES C ON IR.INCIDENT_REPORT_ID = C.INCIDENT_REPORT_ID
          ORDER BY  		IR.DATE_FILED DESC';
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    echo '<thead>
              <tr>
                <th>Incident Report No.</th>
                <th>Complainant</th>
                <th>Date Filed</th>
                <th>Remarks</th>
              </tr>
          </thead>
          <tbody>';
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      if($row['CASE_ID'] != null){
        $caseid='Submitted/Assigned to IDO';
      }
      else{
        $caseid='For review by HDO';
      }

      echo "<tr onmouseover=\"this.style.cursor='pointer'\" onclick=\"location.href='hdo-view-incident-report.php?irn={$row['INCIDENT_REPORT_ID']}'; viewIRAudit({$row['INCIDENT_REPORT_ID']});\">
            <td>{$row['INCIDENT_REPORT_ID']}";

      if($row['IF_NEW']) {
          echo "&nbsp;&nbsp;&nbsp;<span class=\"badge\">NEW</span></td>";
      }

      echo "<td>{$row['COMPLAINANT']}</td>
            <td>{$row['DATE_FILED']}</td>
            <td>{$caseid}</td>
            </tr>";
    }
    echo '</tbody>';
  }
?>
