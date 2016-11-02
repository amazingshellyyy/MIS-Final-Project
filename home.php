<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 // if session is not set this will redirect to login page
 if (!isset($_SESSION['user'])) {
     header("Location: index.php");
     exit;
 }
 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MIS PROJECT</title>
</head>

<body>
    <?php echo "做專案好累ㄛ...{$userRow['userEmail']}"?>
    <p><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;按我登出</a></p>
    <h1>Have a nice day everyday 凸</h1>

</body>
</html>
<?php ob_end_flush(); ?>
