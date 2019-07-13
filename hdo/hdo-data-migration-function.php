<?php
  session_start();
  require_once('../mysql_connect.php');
  if(isset($_POST["Import"]))
  {
    $filename=$_FILES["file"]["tmp_name"];    
      if($_FILES["file"]["size"] > 0)
      {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
          // change this to select where the csv will insert into
          $sql =  "  SELECT USER_ID FROM USERS WHERE CONCAT(FIRST_NAME, ' ' , LAST_NAME) LIKE '".$getData[4]."' ";
          $result = mysqli_query($dbc, $sql);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          $complainant = $row['USER_ID'];

          $details = "$getData[5] ,"." $getData[6] ,"." $getData[7]";

          $sql =  "  INSERT INTO CASES (REPORTED_STUDENT_ID, OFFENSE_ID,COMPLAINANT_ID, DATE_INCIDENT, LOCATION, DETAILS, HANDLED_BY_ID, IF_NEW)
                     VALUES (".$getData[1].",".$getData[3].",$complainant,STR_TO_DATE('".$getData[2]."', '%m/%d/%Y'),'DLSU','$details',1,2)
                  ";
          $result = mysqli_query($dbc, $sql);
          if(!isset($result))
          {
            echo "<script type=\"text/javascript\">
            alert(\"Invalid File:Please Upload CSV File.\");
            window.location = \"../hdo/hdo-data-migration.php\"
            </script>";    
          }
          else 
          {
            echo "<script type=\"text/javascript\">
            alert(\"CSV File has been successfully Imported.\");
            window.location = \"../hdo/hdo-data-migration.php\"
            </script>";
          }
        }
        fclose($file);
      }
  }   
?>