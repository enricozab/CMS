<?php

    require ("vendor/autoload.php");
    require_once('./mysql_connect.php');

    // STEP 1 - enter acct credentials

    $g_client = new Google_Client();

    $g_client->setClientId("837302867476-vfgekenddut1bmuggvfesfjued90fviv.apps.googleusercontent.com");
    $g_client->setClientSecret("iwiNAZPU0RJyC_Tt14q684of");
    $g_client->setRedirectUri("http://localhost/Google/signin.php");
    $g_client->setScopes("email");

    // STEP 2 - Create http_build_url

    $auth_url = $g_client->createAuthUrl();
    echo "<a href='$auth_url'>Login Through Google</a>";

    // STEP 3 - Get authorization bind_textdomain_codeset

    $auth_code = isset($_GET['code']) ? $_GET['code'] : NULL;
    //var_dump($auth_code);

    // STEP 4 - Get access token
    /* ISSUE: Cannot Handle Token Prior to Certain Date
        - Go to: vendor\google\apiclient\src\Google\AccessToken\Verify.php
        - Change: $jwtClass::$leeway = 1;
        - Make it: $jwtClass::$leeway += 200;
    */

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
    $check_email = substr($email, strpos($email, "@") + 1);

    echo "<br>EMAIL: ", $email;
    //echo "<br>NEW: ", $check_email;

    $query = 'SELECT EMAIL FROM USERS WHERE EMAIL = "'.$email.'"';
    $result = mysqli_query($dbc,$query);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

    if($row) {
      echo "<br>Valid user!";
    }

    else {
      echo "<br>Invalid user!";
    }
    /*
    session_start();

    if (isset($_POST['drive'])){
      $_SESSION['client'] = $g_client;
      $_SESSION['auth_code'] = $auth_code;
      $_SESSION['payload'] = "hi";
      $_SESSION['token'] = $access_token;

      header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/drive.php");
    }
    ?>

    <form method="post">
      <button type="submit" name = "drive">Drive</button>
    </form>

    <?php
    //echo "<br><br><a href='/Google/Drive/'>Go to Drive</a>";*/
?>
