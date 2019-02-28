<?php
//Director credentials for signature
$director = 'SELECT *
		FROM USERS U
        WHERE USER_TYPE_ID = 9;';

$directorq = mysqli_query($dbc,$director);

if(!$directorq){
  echo mysqli_error($dbc);
}
else{
  $directorres = mysqli_fetch_array($directorq,MYSQLI_ASSOC);
}

?>
