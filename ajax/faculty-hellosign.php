<!-- HELLOSIGN API -->
	<?php
		session_start(); 
		
		$sourcepath = 'C:\\Users\\debbiesimon11\\Downloads\\output.docx';
		$targetpath = getcwd().'\\output.docx';
		rename($sourcepath,$targetpath);
		
		$filename = 'output.docx';
		
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