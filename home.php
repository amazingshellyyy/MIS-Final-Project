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
?>
<!DOCTYPE html>
<html>
<head>
<title>首頁</title>
</head>

<body>
    <?php echo "您好！{$userRow['userName']}同學！"?>
    </br>
    <a href="logout.php?logout">按我登出</a>
</body>
</html>
<?php ob_end_flush(); ?>
