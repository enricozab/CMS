<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="SELECT CONCAT(a.USER_ID, ' - ', b.FIRST_NAME, ' ', b.LAST_NAME) AS USER, a.ACTION_DONE, a.TIMESTAMP
          FROM SYSTEM_AUDIT_TRAIL a 
          LEFT JOIN USERS b
          ON a.USER_ID = b.USER_ID";
          
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    echo '<thead>
              <tr>
                <th>User</th>
                <th>Action Done</th>
                <th>Timestamp</th>
              </tr>
          </thead>
          <tbody>';
    while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

      echo "<tr>
              <td>{$row['USER']}</td>
              <td>{$row['ACTION_DONE']}</td>
              <td>{$row['TIMESTAMP']}</td>
            </tr>";
    }
    echo '</tbody>';
  }
?>
