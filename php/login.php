<!DOCTYPE html>
<!--
student@dlsu.edu.ph
do@dlsu.edu.ph
oulc@dlsu.edu.ph

Pass: 1234

-->

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CMS - Login</title>

	<!-- Webpage Icon -->
	<link rel="icon" href="../images/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<?php
		session_start();
		/*require_once('mysql_connect.php');
		/*
			if (isset($_SESSION['badlogin'])){
				if ($_SESSION['badlogin']>=5)
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/blocked.php");
			}
		*/
		$message = NULL;
		if (isset($_POST['login'])){
			if(empty($_POST['email']) || empty($_POST['password'])) {
				$_SESSION['email']=FALSE;
				$_SESSION['password']=FALSE;
				$message.='<p>You forgot to enter your username/password!</p>';
			}
			else {
				$_SESSION['email']=$_POST['email'];
				$_SESSION['password']=$_POST['password'];
			}
			/*if (empty($_POST['email'])){
				$_SESSION['email']=FALSE;
				$message.='<p>You forgot to enter your username!</p>';
			}
			else {
				$_SESSION['email']=$_POST['email'];
			}

			if (empty($_POST['password'])){
				$_SESSION['password']=FALSE;
				$message.='<p>You forgot to enter your password!</p>';
			}
			else {
				$_SESSION['password']=$_POST['password'];
			}

				/*$query='SELECT usertype, EMPID, email, emailpassword FROM EMPLOYEES WHERE username="'.$_SESSION["username"].'" AND PASSWORD = password("'.$_SESSION["password"].'")';
				$result=mysqli_query($dbc,$query);
				$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

				if (!$result) {
					echo mysqli_error($dbc);
				}

				$_SESSION['email'] = $row["email"];
				$_SESSION['emailpassword'] = $row["emailpassword"];

				if ($row["usertype"]==101) {
					$_SESSION['usertype']=101;
					$_SESSION['cashname']=$row["EMPID"];
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/cashier/cashier.php");
				}
				else if($row["usertype"]==102){
					$_SESSION['usertype']=102;
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/koic/home.php");
				}
				else if($row["usertype"]==103){
					$_SESSION['usertype']=103;
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/manager/home.php");
				}

				else {
					$message.='<h5 style="color:red;text-align:center;">Your username and password didn\'t match. Please try again.</h5>';
					if (isset($_SESSION['badlogin']))
						$_SESSION['badlogin']++;
					else
						$_SESSION['badlogin']=1;
				}*/

			if (!isset($message)) {
				if($_SESSION['email']=="student@dlsu.edu.ph" && $_SESSION['password']=="1234"){
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/student-home.php");
				}
				else if($_SESSION['email']=="do@dlsu.edu.ph" && $_SESSION['password']=="1234"){
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/do-home.php");
				}
				else if($_SESSION['email']=="oulc@dlsu.edu.ph" && $_SESSION['password']=="1234"){
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/oulc-home.php");
				}
        else if($_SESSION['email']=="faculty@dlsu.edu.ph" && $_SESSION['password']=="1234"){
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/faculty-home.php");
				}
				else {
					$message.='Your username and password didn\'t match. Please try again.';
				}
			}
		}
		/*End of main Submit conditional*/
	?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Welcome to CMS!</b></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" name="login" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<!-- Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><b>Login Failed</b></h4>
					</div>
					<div class="modal-body">
						<?php echo $message; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
    </div>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

	<script>
	<?php
		if (isset($message)) { ?>
			$(document).ready(function(){
				$("#loginModal").modal("show");
			});
	<?php
		} ?>
	</script>
</body>

</html>
