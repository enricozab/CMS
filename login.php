<?php
  session_start();
  session_unset();
  require_once('./mysql_connect.php');
  require ("vendor/autoload.php");
?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>CMS - Login</title>
  <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
  <meta name="author" content="Vincent Garreau" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Webpage Icon -->
  <link rel="icon" href="./images/newlogo.png">

  <!-- Bootstrap Core CSS -->
  <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="./vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="./dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Perticles JS -->
  <link rel="stylesheet" media="screen" href="particles/demo/css/style.css">

</head>
<body>

  <!-- particles.js container -->
  <div id="particles-js"></div>

  <!-- scripts -->
  <script src="particles/particles.js"></script>
  <script src="particles/demo/js/app.js"></script>

  <?php
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

        header("Location: http://".$_SERVER['HTTP_HOST']."/CMS");

      }

      try {

        $pay_load = $g_client->verifyIdToken();

        //var_dump($pay_load);

      } catch (Exception $e) {

        header("Location: http://".$_SERVER['HTTP_HOST']."/CMS");

      }
    }

    else {
      $pay_load = null;
    }

    // CMS
    $email = $pay_load["email"];

  ?>

  <div style="position: fixed; top: 50%; left: 50%; width: 520px; height: 300px; margin-left: -260px; margin-top: -150px; background-color: #003366; border-radius: 10px; opacity: 0.9;" align="center">
  </div>

  <div style="position: fixed; top: 50%; left: 50%; width: 500px; height: 300px; margin-left: -250px; margin-top: -150px; background-color: transparent; border-radius: 10px;" align="center">
    <div style="margin-top: 30px;">
      <img src="images/newlogo.png"></img>
      <br><br>
      <p style="font-family: Helvetica; font-size: 50px; color: white;"><b>Welcome to CMS!</b></hp>
    </div>
    <div style="margin-top: 5px;">
      <p style="font-family: Helvetica; font-size: 15px; color: #11cfff;"><i>Case Management System for De La Salle University</i></hp>
    </div>
    <div style="margin-top: 40px;">
      <a align="center" class="btn btn-danger" href="<?php echo $auth_url ?>">
        <i class="fa fa-google-plus"></i>&nbsp; Sign in with Google
      </a>
    </div>
    <?php
      $query='SELECT USER_ID, FIRST_NAME, LAST_NAME, USER_TYPE_ID, PHONE FROM USERS WHERE EMAIL="'.$email.'"';
      $result=mysqli_query($dbc,$query);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

      if($email != null) {
        if($row){
          $_SESSION['user_id']=$row['USER_ID'];
          $_SESSION['first_name']=$row['FIRST_NAME'];
          $_SESSION['last_name']=$row['LAST_NAME'];
          $_SESSION['user_type_id']=$row['USER_TYPE_ID'];
          $_SESSION['phone']=$row['PHONE'];
          $_SESSION['email']=$email;

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
          else if($_SESSION['user_type_id']==7){
            header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/ulc/ulc-home.php");
          }
          else if($_SESSION['user_type_id']==9){
            header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/sdfod/sdfod-home.php");
          }
        }
        else {
          ?>
            <div>
              <br>
              <p style="font-family: Helvetica; font-size: 12px; color: white;">Invalid Email. Please try again.</p>
            </div>
          <?php
        }
      }
    ?>
  </div>

  <!--<div style="position: absolute; top: 50%; left: 50%; width:800px; margin-left:-400px; margin-top: -100px;" align="center">
    <div>
      <p style="font-family: Helvetica; font-size: 60px; color: white;"><b>Welcome to CMS!</b></hp>
    </div>
  </div>
  <div style="position: absolute; top: 50%; left: 50%; width:800px; margin-left:-400px; margin-top: -20px;" align="center">
    <h4 style="font-family: Helvetica; font-size: 15px;"><i>Case Management System for De La Salle University</i></h4>
  </div>
  <div style="position: absolute; top: 50%; left: 50%; width: 300px; margin-left: -150px; margin-top: 30px;" align="center">
    <a align="center" class="btn btn-danger" href="<?php echo $auth_url ?>">
      <i class="fa fa-google-plus"></i> Sign in with Google
    </a>

  </div>-->

  <div style="position: fixed; top: 100%; left: 50%; width:800px; margin-left:-400px; margin-top: -40px;" align="center">
    <p style="font-family: Arial; font-size: 11px; color: #003366;">All rights reserved 2019</p>
  </div>

  <!-- jQuery -->
  <script src="./vendor/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="./vendor/bootstrap/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="./vendor/metisMenu/metisMenu.min.js"></script>

  <!-- Custom Theme JavaScript -->
  <script src="./dist/js/sb-admin-2.js"></script>

</body>
</html>
