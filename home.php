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
 $res = mysql_query("SELECT projectName FROM projects WHERE projectCreatorId=".$userRow[0]);
 $projectNameRow = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $projectNameRow[] = mysql_result($res,$i,0);
 }

 $res = mysql_query("SELECT projectId FROM projects WHERE projectCreatorId=".$userRow[0]);
 $projectIdRow = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $projectIdRow[] = mysql_result($res,$i,0);
 }

?>
<!DOCTYPE html>
<html>
<head>
<title>首頁</title>
</head>

<body>
    首頁<br>
    <?php echo "您好！{$userRow['userName']}同學！"?>
    <br><br>
    <a>專案列表</a><br>
    <?php
      for($i = 0; $i < count($projectNameRow); $i++){
         echo "<a href=\"project_home.php?id=$projectIdRow[$i]\">$projectNameRow[$i]</a><br>";
      }
    ?>
    <br>
    <a href="project_creating.php">創建專案</a><br>
    <a href="todolist.php">待辦清單</a><br>
    <a href="calandar.php">行事曆</a><br>
    <a href="personaldata.php">個人設定</a><br>
    <a href="systemsetting.php">系統設定</a><br>
    <a href="logout.php?logout">登出</a>
</body>
</html>
<?php ob_end_flush(); ?>
