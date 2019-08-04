<?php
  session_start();
  require_once('../mysql_connect.php');

  if($_SESSION['user_type_id'] == 1){
    $query="SELECT 		  C.CASE_ID AS 'CASE_ID',
                        C.REMARKS_ID AS 'REMARKS_ID',
                        DATEDIFF(CURDATE(),C.LAST_UPDATE) AS 'DATEDIFF'
            FROM 		    CASES C
            WHERE		    C.REPORTED_STUDENT_ID = ".$_SESSION['user_id']."
            AND			    (C.STATUS_ID = 1 OR C.STATUS_ID = 2)
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
            AND			    (C.STATUS_ID = 1 OR C.STATUS_ID = 2)
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
            WHERE		    (C.STATUS_ID = 1 OR C.STATUS_ID = 2)
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
        if($row['DATEDIFF'] > 0) {
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
      }
      else if($row['REMARKS_ID'] == 3 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='student-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please submit Student Response Form and evidence if there is any.
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
      else if($row['REMARKS_ID'] == 4 && $_SESSION['user_type_id'] == 1) {
        if($row['DATEDIFF'] > 0) {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='student-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please resubmit Student Response Form.
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
      else if($row['REMARKS_ID'] == 7 && $_SESSION['user_type_id'] == 4) {
        if($row['DATEDIFF'] > 0) {
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
      }
      else if($row['REMARKS_ID'] == 8 && $_SESSION['user_type_id'] == 7) {
        if($row['DATEDIFF'] > 0) {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please schedule a {$row['PROCEEDINGS_DESC']}</i>
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
        }
      }
      else if($row['REMARKS_ID'] == 9 && $_SESSION['user_type_id'] == 7) {
        if($row['DATEPROC'] > 0) {
          echo "<li>
                  <div style='padding: 10px; margin-left: 10px; margin-right: 10px;' onmouseover=\"this.style.cursor='pointer'; this.style.background='#f4f4f4';\" onmouseout=\"this.style.background='white';\" onclick=\"location.href='ulc-view-case.php?cn={$row['CASE_ID']}'\">
                    <b>Case {$row['CASE_ID']}: </b>Please reschedule if the proceeding did not push through and/or submit the verdict and penalty.</i>
                  </div>
                </li>
                <li class='divider'></li>";
          $empty = false;
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
