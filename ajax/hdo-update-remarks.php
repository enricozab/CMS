<?php
    session_start();
    require_once('../mysql_connect.php');

    $qUpdateRemarks = "UPDATE cms.cases SET remarks_id = " .$_POST['remarks']. " WHERE case_id = " .$_POST['case_id'];
    $updateRemarks = mysqli_query($dbc, $qUpdateRemarks);
?>