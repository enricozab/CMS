<!-- HELLOSIGN API -->
	<?php
		session_start();
		require_once('../mysql_connect.php');

	  $query="UPDATE CASES SET IF_NEW=1, REMARKS_ID=14 WHERE CASE_ID = {$_POST['caseID']}";
	  $result=mysqli_query($dbc,$query);
	  if(!$result){
	    echo mysqli_error($dbc);
	  }

		$filename = 'output.docx';

		//CHANGE SOURCEPATH TO YOUR OWN PC'S DOWNLOAD PATH + \\output.docx
		$sourcepath = 'C:\\Users\\Enrico Zabayle\\Downloads\\output.docx';
		$targetpath = getcwd().'\\output.docx';

		rename($sourcepath,$targetpath);

		if($_POST['title'] == "Parent's Letter"){
			$name = $_POST['name'];
		}
		else{
			$name = $_POST['fname'].' '.$_POST['lname'];
		}
		$name = $_POST['fname'].' '.$_POST['lname'];

		$output=shell_exec('upload.py "'.$_POST['title'] .'" "'
							.$_POST['subject'] .'" "'
							.$_POST['message'] .'" "'
							.$_POST['email'] .'" "'
							.$name .'" "'
							.$filename .'"');

		exit;
	?>
<!-- HELLOSIGN API -->
