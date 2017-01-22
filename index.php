<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 //使用者登入後會直接導向home
 if (isset($_SESSION['user'])!="") {
     header("Location: home.php");
     exit;
 }

 $error = false; //如遇到error將改為true，藉此做例外處理管控

 if (isset($_POST['btn-login'])) {

  //清除不合規定之email及password
     $email = trim($_POST['email']);
     $email = strip_tags($email);
     $email = htmlspecialchars($email);

     $pass = trim($_POST['pass']);
     $pass = strip_tags($pass);
     $pass = htmlspecialchars($pass);

     if (empty($email)) {
         $error = true;
         $emailError = "請輸入電子信箱";
     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $error = true;
         $emailError = "電子信箱格式錯誤";
     }

     if (empty($pass)) {
         $error = true;
         $passError = "請輸入密碼";
     }

  // 如無上述錯誤，繼續執行login動作
  if (!$error) {
      $password = hash('sha256', $pass); // 密碼採用sha256加密

      $res = mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
      $row = mysql_fetch_array($res);
      $count = mysql_num_rows($res); // 如果帳號密碼皆正確將必return 1

   if ($count == 1 && $row['userPass']==$password) {
       $_SESSION['user'] = $row['userId'];
       header("Location: home.php");
   } else {
       $errMSG = "查無此帳密";
   }
  }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
      <h2>登入</h2>
      <?php
        if (isset($errMSG)) {
            echo $errMSG;
        }
      ?>
      <input type="email" name="email" placeholder="電子郵件" value="<?php echo $email; ?>" maxlength="40" />
      </br>
      <?php echo $emailError; ?>
      <input type="password" name="pass" placeholder="密碼" maxlength="15" />
      <?php echo $passError; ?>
      </br>
      <button type="submit" name="btn-login">登入</button>
      <a href="register.php">按我註冊</a>
  </form>
</body>
</html>
<?php ob_end_flush(); ?>
