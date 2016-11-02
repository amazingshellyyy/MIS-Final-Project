<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // it will never let you open index(login) page if session is set
 if (isset($_SESSION['user'])!="") {
     header("Location: home.php");
     exit;
 }

 $error = false;

 if (isset($_POST['btn-login'])) {

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
     $email = strip_tags($email);
     $email = htmlspecialchars($email);

     $pass = trim($_POST['pass']);
     $pass = strip_tags($pass);
     $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs

  if (empty($email)) {
      $error = true;
      $emailError = "Please enter your email address.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = true;
      $emailError = "Please enter valid email address.";
  }

     if (empty($pass)) {
         $error = true;
         $passError = "Please enter your password.";
     }

  // if there's no error, continue to login
  if (!$error) {
      $password = hash('sha256', $pass); // password hashing using SHA256

   $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
      $row=mysql_fetch_array($res);
      $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

   if ($count == 1 && $row['userPass']==$password) {
       $_SESSION['user'] = $row['userId'];
       header("Location: home.php");
   } else {
       $errMSG = "Incorrect Credentials, Try again...";
   }
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Have a nice day every day !!!</title>
</head>
<body>
  <script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '{your-app-id}',
    cookie     : true,  // enable cookies to allow the server to access
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.5' // use graph api version 2.5
  });

  // Now that we've initialized the JavaScript SDK, we call
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1109539102467473',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  </script>
<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

     <div class="col-md-12">

         <div class="form-group">
             <h2 class="">登入</h2>
            </div>

         <div class="form-group">
             <hr />
            </div>

            <?php
   if (isset($errMSG)) {
       ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php

   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">登入</button>
            </div>

            <div class="form-group">
             <hr />
            </div>

            <div class="form-group">
             <a href="register.php">按我註冊</a>
            </div>

        </div>

    </form>
    </div>

</div>
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>


</body>
</html>
<?php ob_end_flush(); ?>
