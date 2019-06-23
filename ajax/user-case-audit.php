<?php
$caseAudit = 'SELECT CA.*, RAD.ACTION_DONE_DESC AS "action_done", CONCAT(U.first_name," ",U.last_name) as "action_done_by", C.INCIDENT_REPORT_ID as "incident_report_id"
                    FROM CASE_AUDIT CA
                    LEFT JOIN USERS U ON CA.ACTION_DONE_BY_ID = U.USER_ID
                    LEFT JOIN REF_ACTION_DONE RAD ON CA.ACTION_DONE_ID = RAD.ACTION_DONE_ID
                    LEFT JOIN CASES C ON CA.CASE_ID = C.CASE_ID
                    WHERE CA.CASE_ID ='.$_GET['cn'];

$caseAuditRes = mysqli_query($dbc,$caseAudit);

if(!$caseAuditRes){
  echo mysqli_error($dbc);
}
?>
