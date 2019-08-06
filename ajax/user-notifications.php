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
  else if($_SESSION['user_type_id'] == 6){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    AULC_CASES AULC
            LEFT JOIN   CASES C ON AULC.CASE_ID = C.CASE_ID
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }
  else if($_SESSION['user_type_id'] == 2){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    FACULTY_CASES FACULTY
            LEFT JOIN   CASES C ON FACULTY.CASE_ID = C.CASE_ID
            ORDER BY    C.LAST_UPDATE DESC, C.CASE_ID DESC";
  }

  if(in_array($_SESSION['user_type_id'],array(3,8,9))) {
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        RO.TYPE AS TYPE,
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    CASES C
            LEFT JOIN	  REF_OFFENSES RO ON C.OFFENSE_ID = RO.OFFENSE_ID
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
    $empty = true;
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
      if($row['REMARKS_ID'] == 2 && $_SESSION['user_type_id'] == 4) {
        if($row['TYPE'] == "Minor") {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ido-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please upload all submitted forms and evidence. Forward the case to the SDFOD afterwards. <i>(The case will be reassigned after 3 days of inactivity)</i>
                  </div>
                </li>
                <li class='divider'></li>";
        }
        else if($row['TYPE'] == "Major") {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ido-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please schedule an interview with the student and/or upload all submitted forms and evidence. Forward the case to the SDFOD afterwards. <i>(The case will be reassigned after 5 days of inactivity)</i>
                  </div>
                </li>
                <li class='divider'></li>";
        }
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 3 && $_SESSION['user_type_id'] == 1) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='student-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please submit Student Response Form and evidence if there is any.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 4 && $_SESSION['user_type_id'] == 1) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='student-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please resubmit Student Response Form.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 7 && $_SESSION['user_type_id'] == 4) {
        $inactivity = '3';
        if($row['TYPE'] == "Major") $inactivity = '5';
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ido-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please accomplish the Closure Letter. <i>(The case will be reassigned after {$inactivity} days of inactivity)</i>
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 8 && $_SESSION['user_type_id'] == 7) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please sign the Discipline Case Referral Form and/or schedule a {$row['PROCEEDINGS_DESC']}.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if(in_array($row['REMARKS_ID'],array(9,15)) && $_SESSION['user_type_id'] == 7) {
        if($row['DATEPROC'] >= 0) {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please reschedule if the proceeding did not push through and/or submit the verdict and penalty.
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
      else if(in_array($row['REMARKS_ID'],array(14,16)) && $_SESSION['user_type_id'] == 7) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please upload the Discipline Case Referral Form.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 12 && $_SESSION['user_type_id'] == 7) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please process the Student Appeal by endorsing the case to the President.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 13 && $_SESSION['user_type_id'] == 7) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please follow-up on the final decision from the President and update the verdict and penalty.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 5 && $_SESSION['user_type_id'] == 9) {
        if($row['TYPE'] == 'Minor') {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='sdfod-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please process the case for closing.
                  </div>
                </li>
                <li class='divider'></li>";
        }
        else if($row['TYPE'] == 'Major') {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='sdfod-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please endorse the case to the OULC.
                  </div>
                </li>
                <li class='divider'></li>";
        }
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 14 && $_SESSION['user_type_id'] == 9) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='sdfod-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please sign the Discipline Case Feedback Form and close the case.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 16 && $_SESSION['user_type_id'] == 9) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='sdfod-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please provide the respective penalty for the case.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
      else if($row['REMARKS_ID'] == 8 && $_SESSION['user_type_id'] == 6) {
        echo "<li>
                <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='aulc-view-case.php?cn={$row['CASE_ID']}'\">
                  <b>Case {$row['CASE_ID']}: </b>Please endorse the case to ULC by filing or dismissing the case.
                </div>
              </li>
              <li class='divider'></li>";
        $empty = false;
      }
    }
    
    if(in_array($_SESSION['user_type_id'],array(3,8,9))) {
      $result2=mysqli_query($dbc,$query2);
      if(!$result2){
        echo mysqli_error($dbc);
      }
      else {
        $user = 'hdo';
        if($_SESSION['user_type_id'] == 8) $user = 'cdo';
        else if($_SESSION['user_type_id'] == 9) $user = 'sdfod';

        while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
          if($row2['CASE_ID'] == NULL) {
            echo "<li>
                    <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='{$user}-view-incident-report.php?irn={$row2['INCIDENT_REPORT_ID']}'\">
                      <b>Incident Report {$row2['INCIDENT_REPORT_ID']}: </b>Please process and assign an IDO to create an alleged case.</i>
                    </div>
                  </li>
                  <li class='divider'></li>";
            $empty = false;
          }
        }
      }

      $result3=mysqli_query($dbc,$query3);
      if(!$result3){
        echo mysqli_error($dbc);
      }
      else {
        while($row3=mysqli_fetch_array($result3,MYSQLI_ASSOC)) {
          if($row3['TYPE'] == 'Minor' && $row3['DATEDIFF'] > 2) {
            echo "<li>
                    <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='{$user}-view-case.php?cn={$row3['CASE_ID']}'\">
                      <b>Case {$row3['CASE_ID']}: </b>The case has been inactive for 3 or more days. Please reassign the case.</i>
                    </div>
                  </li>
                  <li class='divider'></li>";
            $empty = false;
          }
          else if($row3['TYPE'] == 'Major' && $row3['DATEDIFF'] > 4) {
            echo "<li>
                    <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='{$user}-view-case.php?cn={$row3['CASE_ID']}'\">
                      <b>Case {$row3['CASE_ID']}: </b>The case has been inactive for 5 or more days. Please reassign the case.</i>
                    </div>
                  </li>
                  <li class='divider'></li>";
            $empty = false;
          }
        }
      }
    }
    if ($empty) {
      echo "<li>
              <div style='padding: 10px; margin-left: 10px; margin-right: 10px;'>
                No notification.
              </div>
            </li>";
    }
  }
?>
