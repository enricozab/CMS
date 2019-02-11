<?php
  session_start();
  session_unset();
  require_once('./mysql_connect.php');
  require ("vendor/autoload.php");
?>
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
	<link rel="icon" href="./images/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="./vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Animated background -->
    <link href="./extra-css/gradient-bg.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<?php
		/*
			if (isset($_SESSION['badlogin'])){
				if ($_SESSION['badlogin']>=5)
					header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/blocked.php");
			}
		*/

    // SIGN IN API
    $g_client = new Google_Client();

    $g_client->setClientId("837302867476-vfgekenddut1bmuggvfesfjued90fviv.apps.googleusercontent.com");
    $g_client->setClientSecret("iwiNAZPU0RJyC_Tt14q684of");
    $g_client->setRedirectUri("http://localhost/CMS/login.php");
    $g_client->setScopes("email");

    $auth_url = $g_client->createAuthUrl();
    $auth_code = isset($_GET['code']) ? $_GET['code'] : NULL;

    if(isset($auth_code)) {

      try {

        $access_token = $g_client->fetchAccessTokenWithAuthCode($auth_code);
        $g_client->setAccessToken($access_token);
        //var_dump($access_token); - just to check if we're getting something

      } catch (Exception $e){

        echo $e->getMessage();

      }

      try {

        $pay_load = $g_client->verifyIdToken();

        //var_dump($pay_load);

      } catch (Exception $e) {

        echo $e->getMessage();

      }
    }

    else {
      $pay_load = null;
    }

    // CMS

    $email = $pay_load["email"];
    $message = NULL;

    if (!isset($message)) {
      $query='SELECT USER_ID, FIRST_NAME, LAST_NAME, USER_TYPE_ID, PHONE FROM USERS WHERE EMAIL="'.$email.'"';
      $result=mysqli_query($dbc,$query);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
      if($row){
        $_SESSION['user_id']=$row['USER_ID'];
        $_SESSION['first_name']=$row['FIRST_NAME'];
        $_SESSION['last_name']=$row['LAST_NAME'];
        $_SESSION['user_type_id']=$row['USER_TYPE_ID'];
        $_SESSION['phone']=$row['PHONE'];

        if($_SESSION['user_type_id']==1){
          header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/student/student-home.php");
        }
        else if($_SESSION['user_type_id']==2){
          header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/faculty/faculty-home.php");
        }
        else if($_SESSION['user_type_id']==3){
          header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/hdo/hdo-home.php");
        }
        else if($_SESSION['user_type_id']==4){
          header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/ido/ido-home.php");
        }
        else if($_SESSION['user_type_id']==6){
          header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/aulc/aulc-home.php");
        }
      }
    }?>

    <div style="position: absolute; top: 50%; left: 50%; width:800px; margin-left:-400px; margin-top: -100px;" align="center">
      <div>
        <h1 style="font-family: Helvetica; font-size: 60px;"><b>Welcome to CMS!</b></h1>
      </div>
    </div>
    <div style="position: absolute; top: 50%; left: 50%; width:800px; margin-left:-400px; margin-top: -20px;" align="center">
      <h4 style="font-family: Helvetica; font-size: 15px;"><i>Case Management System for De La Salle University</i></h4>
    </div>
    <div style="position: absolute; top: 50%; left: 50%; width: 300px; margin-left: -150px; margin-top: 30px;" align="center">
      <?php
        if ($email == NULL) {
          ?>
          <a align="center" class="btn btn-danger" href="<?php echo $auth_url ?>">
            <i class="fa fa-google-plus"></i> Sign in with Google
          </a>
          <?php
        }

        else {

          $query='SELECT USER_ID, FIRST_NAME, LAST_NAME, USER_TYPE_ID, PHONE FROM USERS WHERE EMAIL="'.$email.'"';
          $result=mysqli_query($dbc,$query);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

          if($row){
            $_SESSION['user_id']=$row['USER_ID'];
            $_SESSION['first_name']=$row['FIRST_NAME'];
            $_SESSION['last_name']=$row['LAST_NAME'];
            $_SESSION['user_type_id']=$row['USER_TYPE_ID'];
            $_SESSION['phone']=$row['PHONE'];

            if($_SESSION['user_type_id']==1){
              header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/student/student-home.php");
            }
            else if($_SESSION['user_type_id']==2){
              header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/faculty/faculty-home.php");
            }
            else if($_SESSION['user_type_id']==3){
              header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/hdo/hdo-home.php");
            }
            else if($_SESSION['user_type_id']==4){
              header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/ido/ido-home.php");
            }
            else if($_SESSION['user_type_id']==7){
              header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/ulc/ulc-home.php");
            }
          }

          else {
            ?>
            <a href="<?php echo $auth_url ?>">Invalid Email. Please try again.</a>
            <?php
          }
        }
      ?>
    </div>
    <div style="position: absolute; top: 100%; left: 50%; width:800px; margin-left:-400px; margin-top: -40px;" align="center">
      <h4 style="font-family: Arial; font-size: 10px;">All rights reserved 2019</h4>
    </div>

    <!--<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center"><b>Welcome to CMS!</b></h3>
                    </div>

                    <div class="panel-body" align="center">



                    </div>
                </div>
            </div>
        </div>
    </div>-->
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
      </div>
    </div>

    <!-- jQuery -->
    <script src="./vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="./vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="./dist/js/sb-admin-2.js"></script>

	<script>
	$(document).ready(function(){
    <?php
  		if (isset($message)) { ?>
				$("#loginModal").modal("show");
			});
	<?php } ?>
	</script>
</body>

</html>
