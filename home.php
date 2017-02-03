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

 //抓取專案名稱資料
 $res = mysql_query("SELECT projectName FROM projects WHERE projectCreatorId=".$_SESSION['user']);
 $projectRow = mysql_fetch_array($res);
 $projectRow = array_values($projectRow);//取出值，因為鍵值有問題

?>
<!DOCTYPE html>
<html>
<head>
<title>首頁</title>
</head>

<body>
    首頁<br>
    <?php echo "您好！{$userRow['userName']}同學！"?>
    </br>
    <a href="project_home.php">專案首頁</a><br>
    <?php
      for($i = 0; $i < count($projectRow); $i++){
        echo "$projectRow[$i]<br>";
      }
      unset($projectRow);
    ?>
    <a href="todolist.php">待辦清單</a><br>
    <a href="calandar.php">行事曆</a><br>
    <a href="personaldata.php">個人設定</a><br>
    <a href="systemsetting.php">系統設定</a><br>
    <a href="logout.php?logout">登出</a>
</body>
</html>
<?php ob_end_flush(); ?>
