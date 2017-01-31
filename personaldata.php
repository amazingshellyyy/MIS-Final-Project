<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 //如果非登入狀態將導回首頁
 if (!isset($_SESSION['user'])) {
     header("Location: index.php");
     exit;
 }

 //抓取登入之帳戶資料
 $res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow = mysql_fetch_array($res);

 $error = false;

 if (isset($_POST['btn-revise'])) {

   $name = trim($_POST['name']);
   $name = strip_tags($name);
   $name = htmlspecialchars($name);

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

   if (!$error) {
       $query = "UPDATE users SET
                 userName = '$name',
                 userDepartment = '$department',
                 userStudentid = '$studentid',
                 userCellphone = '$cellphone',
                 userIntroduction = '$introduction',
                 userInterests = '$interests' WHERE userId=".$_SESSION['user'];
       $res = mysql_query($query);

       if ($res) {
           $errTyp = "success";
           $errMSG = "修改成功";
           unset($name);
           unset($department);
           unset($studentid);
           unset($cellphone);
           unset($introduction);
           unset($interests);
       } else {
           $errTyp = "danger";
           $errMSG = "更改失敗";
       }
   }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>個人資料設定</title>
  </head>
  <body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" id="revise">
      個人資料設定頁面<br><br>
      使用者名稱：<input type="text" name="name" value="<?php echo $userRow[1]; ?>"><br>
      系級：<input type="text" name="department" value="<?php echo $userRow[4]; ?>"><br>
      學號：<input type="number" name="studentid" value="<?php echo $userRow[5]; ?>"><br>
      連絡電話：<input type="nember" name="cellphone" value="<?php echo $userRow[6]; ?>"><br>
      自我介紹：<br>
      <textarea row="5" col="60" name="introduction"><?php echo $userRow[7]; ?></textarea><br>
      興趣：<br>
      <textarea row="5" col="60" name="interests"><?php echo $userRow[8]; ?></textarea><br>
      <button type="submit" name="btn-revise" onClick="window.location.reload();">更改</button></br>
    </form>
    <a href="home.php">回首頁</a>
  </body>
</html>
