<?php
    session_start();
    require_once('../mysql_connect.php');

    $qUpdateRemarks = "UPDATE CASES SET REMARKS_ID = '{$_POST['remark_id']}' WHERE CASE_ID = '{$_POST['case_id']}'";
    $updateRemarks = mysqli_query($dbc, $qUpdateRemarks);
?>