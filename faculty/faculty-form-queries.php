<?php
  // office
  $officequery = 'SELECT *
                    FROM REF_USER_OFFICE C
                    JOIN USERS U ON C.OFFICE_ID = U.OFFICE_ID
                   WHERE U.USER_ID = "'.$_SESSION['user_id'].'"';
  $officeres = mysqli_query($dbc,$officequery);

  if(!$officeres){
    echo mysqli_error($dbc);
  }
  else{
    $officerow=mysqli_fetch_array($officeres,MYSQLI_ASSOC);
  }

  // complainant name

  $name = 'SELECT *
             FROM USERS
            WHERE USER_ID = "'.$_SESSION['user_id'].'"';
  $nameq = mysqli_query($dbc,$name);

  if(!$nameq){
    echo mysqli_error($dbc);
  }
  else{
    $nameres=mysqli_fetch_array($nameq,MYSQLI_ASSOC);
  }

  // form $query

  $form = 'SELECT *
            FROM INCIDENT_REPORTS
            ORDER BY INCIDENT_REPORT_ID DESC
            LIMIT 1';
  $formq = mysqli_query($dbc,$form);

  if(!$formq){
    echo mysqli_error($dbc);
  }
  else{
    $formres = mysqli_fetch_array($formq,MYSQLI_ASSOC);
  }

?>
