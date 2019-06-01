<?php
$caseAudit = 'SELECT CA.*, CONCAT(U.first_name," ",U.last_name) as "action_done_by"
                FROM CASE_AUDIT CA
                JOIN USERS U ON CA.HANDLED_BY_ID = U.USER_ID
                WHERE CASE_ID ='.$_GET['cn'];

$caseAuditRes = mysqli_query($dbc,$caseAudit);

if(!$caseAuditRes){
  echo mysqli_error($dbc);
}
?>
