<!-- HELLOSIGN API -->
	<?php
		session_start();
		$filename = 'output.docx';

		//CHANGE SOURCEPATH TO YOUR OWN PC'S DOWNLOAD PATH + \\output.docx
		$sourcepath = 'C:\\Users\\Enrico Zabayle\\Downloads\\output.docx';
		$targetpath = getcwd().'\\output.docx';

		rename($sourcepath,$targetpath);

		$name = $_POST['fname'].' '.$_POST['lname'];

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
