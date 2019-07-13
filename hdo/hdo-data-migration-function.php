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
          $sql =  "  INSERT INTO REF_USER_TYPES (USER_TYPE_ID,DESCRIPTION) 
                     VALUES ('".$getData[0]."','".$getData[1]."')
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