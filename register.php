<?php
 ob_start();
 session_start();
 if (isset($_SESSION['user'])!="") {
     header("Location: home.php");
 }
 include_once 'dbconnect.php';

 $error = false;

 if (isset($_POST['btn-signup'])) {
     //排除不合規定之name及passwords
     $name = trim($_POST['name']);
     $name = strip_tags($name);
     $name = htmlspecialchars($name);

     $email = trim($_POST['email']);
     $email = strip_tags($email);
     $email = htmlspecialchars($email);

     $pass = trim($_POST['pass']);
     $pass = strip_tags($pass);
     $pass = htmlspecialchars($pass);

     if (empty($name)) {
         $error = true;
         $nameError = "請輸入名稱";
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $error = true;
         $emailError = "請輸入正確電子信箱格式.";
     } else {
         $query = "SELECT userEmail FROM users WHERE userEmail='$email'";
         $result = mysql_query($query);
         $count = mysql_num_rows($result);
         if ($count!=0) {
             $error = true;
             $emailError = "您輸入的電子信箱已被使用";
         }
     }

     if (empty($pass)) {
         $error = true;
         $passError = "請輸入密碼";
     } elseif (strlen($pass) < 6) {
         $error = true;
         $passError = "密碼須至少6個字元以上";
     }


     $password = hash('sha256', $pass); //秘密加密sha256格式


     if (!$error) {
         $query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$password')";
         $res = mysql_query($query);

         if ($res) {
             $errTyp = "success";
             $errMSG = "註冊成功";
             unset($name);
             unset($email);
             unset($pass);
         } else {
             $errTyp = "danger";
             $errMSG = "註冊失敗";
         }
     }
 }
?>
<!DOCTYPE html>
<html>
<head>
<title>註冊</title>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
  <h2>註冊</h2>
  <input type="text" name="name" class="form-control" placeholder="請輸入姓名" maxlength="50" value="" /></br>
  <?php if (isset($nameError)){echo $nameError.'<br>';} ?>
  <input type="email" name="email" class="form-control" placeholder="請輸入電子郵件" maxlength="40" value="" /></br>
  <?php if (isset($emailError)){echo $emailError.'<br>';} ?>
  <input type="password" name="pass" class="form-control" placeholder="請輸入密碼" maxlength="15" /></br>
  <?php if (isset($passError)){echo $passError.'<br>';} //如無錯誤，以上error均不會顯示?>
  <button type="submit" name="btn-signup">註冊</button></br>
  <a href="index.php">點我回登入頁面</a>
  <?php
  if (isset($errMSG)) {
       ?>
       <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
       <?php echo $errMSG; ?>
       <?php
  }
  ?>
  </form>
</body>
</html>
<?php ob_end_flush(); ?>
