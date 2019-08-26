<!-- HELLOSIGN API -->
	<?php
		session_start();
		require_once('../mysql_connect.php');

		$filename = $_POST['formT'];

		//CHANGE SOURCEPATH TO YOUR OWN PC'S DOWNLOAD PATH + \\output.docx
		$sourcepath = 'C:\\Users\\Ico\\Downloads\\'.$filename;
		$targetpath = getcwd().'\\'.$filename;

		rename($sourcepath,$targetpath);

		if($_POST['title'] == "Parent Letter"){
			$name = $_POST['name'];

			$query="UPDATE CASES SET WITH_PARENT_LETTER=1 WHERE CASE_ID = {$_POST['caseID']}";
		  $result=mysqli_query($dbc,$query);
		  if(!$result){
		    echo mysqli_error($dbc);
		  }
			echo $filename;
		}
		else{
			$name = $_POST['fname'].' '.$_POST['lname'];
		}

		$output=shell_exec('upload.py "'.$_POST['title'] .'" "'
							.$_POST['subject'] .'" "'
							.$_POST['message'] .'" "'
							.$_POST['email'] .'" "'
							.$name .'" "'
							.$filename .'" "'
							.$sourcepath .'" "'
							.$targetpath .'"');

		exit;
	?>
<!-- HELLOSIGN API -->
