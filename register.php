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

     $department = trim($_POST['department']);
     $department = strip_tags($department);
     $department = htmlspecialchars($department);

     $studentid = trim($_POST['studentid']);
     $studentid = strip_tags($studentid);
     $studentid = htmlspecialchars($studentid);

     $cellphone = trim($_POST['cellphone']);
     $cellphone = strip_tags($cellphone);
     $cellphone = htmlspecialchars($cellphone);

     $introduction = strip_tags($_POST['introduction']);
     $introduction = htmlspecialchars($introduction);

     $interests = strip_tags($_POST['interests']);
     $interests = htmlspecialchars($interests);

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
         $query = "INSERT INTO users(userName,userEmail,userPass,userDepartment,userStudentid,userCellphone,userIntroduction,userInterests)
                   VALUES('$name','$email','$password','$department','$studentid','$cellphone','$introduction','$interests')";
         $res = mysql_query($query);

         if ($res) {
             $errTyp = "success";
             $errMSG = "註冊成功";
             unset($name);
             unset($email);
             unset($pass);
             unset($department);
             unset($studentid);
             unset($cellphone);
             unset($introduction);
             unset($interests);
         } else {
             $errTyp = "danger";
             $errMSG = "註冊失敗，請檢查驗證碼是否與圖像相符";
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
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" action="form-handler" onsubmit="return checkForm(this)" autocomplete="off" id="register">
    <h2>註冊</h2>
    重要資料填寫<br>
    <input type="email" name="email" class="form-control" placeholder="請輸入電子郵件" maxlength="40" value="" /></br>
    <?php if (isset($emailError)){echo $emailError.'<br>';} ?>
    <input type="password" name="pass" class="form-control" placeholder="請輸入密碼" maxlength="15" /></br>
    <?php if (isset($passError)){echo $passError.'<br>';} //如無錯誤，以上error均不會顯示?>
    基本資料填寫<br>
    <input type="text" name="pic" class="form-control" placeholder="請上傳大頭貼" /></br>
    <input type="text" name="name" class="form-control" placeholder="請輸入使用者名稱" maxlength="50" value="" /></br>
    <?php if (isset($nameError)){echo $nameError.'<br>';} ?>
    <input type="text" name="department" class="form-control" placeholder="請輸入系級" maxlength="50" value="" /></br>
    <input type="number" name="studentid" class="form-control" placeholder="請輸入學號" maxlength="50" value="" /></br>
    <input type="number" name="cellphone" class="form-control" placeholder="請輸入連絡電話" maxlength="10" value="" /></br>
    <textarea row="5" col="60" name="introduction" form="register"/>請輸入自我介紹...</textarea><br>
    <textarea row="5" col="60" name="interests" form="register"/>請輸入興趣...</textarea><br>
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
