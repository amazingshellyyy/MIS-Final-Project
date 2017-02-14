<?php
 //此功能存在一個bug ： 資料庫必須內建好一個project之後才不會有錯誤產生。
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 //如果非登入狀態將導回首頁
 if (!isset($_SESSION['user'])) {
     header("Location: index.php");
     exit;
 }

 $error = false;

 if (isset($_POST['btn-project_create'])) {
     //排除不合規定之name及passwords
     $project_creatorId = $_POST['project_creatorId'];

     $project_name = strip_tags($_POST['project_name']);
     $project_name = htmlspecialchars($project_name);

     $project_class = strip_tags($_POST['project_class']);
     $project_class = htmlspecialchars($project_class);

     $project_teacher = strip_tags($_POST['project_teacher']);
     $project_teacher = htmlspecialchars($project_teacher);

     $project_creattime = $_POST['project_creattime'];

     $project_deadline = $_POST['project_deadline'];

     $project_Id = $_POST['project_Id'];

     $project_stage_name_1 = $_POST['project_stage_name_1'];
     $project_stage_name_1 = strip_tags($_POST['project_stage_name_1']);
     $project_stage_name_1 = htmlspecialchars($project_stage_name_1);

     $project_stage_start_1 = $_POST['project_stage_start_1'];
     $project_stage_end_1 = $_POST['project_stage_end_1'];

     $project_stage_name_2 = $_POST['project_stage_name_2'];
     $project_stage_name_2 = strip_tags($_POST['project_stage_name_2']);
     $project_stage_name_2 = htmlspecialchars($project_stage_name_2);

     $project_stage_start_2 = $_POST['project_stage_start_2'];
     $project_stage_end_2 = $_POST['project_stage_end_2'];

     $project_stage_name_3 = $_POST['project_stage_name_3'];
     $project_stage_name_3 = strip_tags($_POST['project_stage_name_3']);
     $project_stage_name_3 = htmlspecialchars($project_stage_name_3);

     $project_stage_start_3 = $_POST['project_stage_start_3'];
     $project_stage_end_3 = $_POST['project_stage_end_3'];

     $project_member = $_POST['project_member'];
     $project_member = trim($project_member);

     if (empty($project_name)) {
         $error = true;
         $project_nameError = "請輸入專案名稱";
     }

     if (empty($project_class)) {
         $error = true;
         $project_classError = "請輸入課程(活動)名稱";
     }

     if (empty($project_teacher)){
         $error = true;
         $project_teacherError = "請輸入指導老師";
     }

     if (!$error) {
         $query = "INSERT INTO projects(projectCreatorId,projectMembersId,projectName,projectClassName,projectTeacher,projectCreatetime,projectDeadline)
                   VALUES('$project_creatorId','$project_member','$project_name','$project_class','$project_teacher','$project_creattime','$project_deadline')";
         $res = mysql_query($query);

         $query_stage = "INSERT INTO projects_stage(projectId,project_stageStart,project_stageEnd,project_stageName)
                         VALUES('$project_Id','$project_stage_start_1','$project_stage_end_1','$project_stage_name_1')";
         $res_stage = mysql_query($query_stage);

         $query_stage = "INSERT INTO projects_stage(projectId,project_stageStart,project_stageEnd,project_stageName)
                         VALUES('$project_Id','$project_stage_start_2','$project_stage_end_2','$project_stage_name_2')";
         $res_stage = mysql_query($query_stage);

         $query_stage = "INSERT INTO projects_stage(projectId,project_stageStart,project_stageEnd,project_stageName)
                         VALUES('$project_Id','$project_stage_start_3','$project_stage_end_3','$project_stage_name_3')";
         $res_stage = mysql_query($query_stage);

         if ($res&&$res_stage ) {
             $errTyp = "success";
             $errMSG = "創建成功";
             unset($project_creatorId);
             unset($project_name);
             unset($project_class);
             unset($project_teacher);
             unset($project_creattime);
             unset($project_deadline);
             unset($project_Id);
             unset($project_stage_name_1);
             unset($project_stage_name_2);
             unset($project_stage_name_3);
             unset($project_stage_start_1);
             unset($project_stage_end_1);
             unset($project_stage_start_2);
             unset($project_stage_end_2);
             unset($project_stage_start_3);
             unset($project_stage_end_3);

         } else {
             $errTyp = "danger";
             $errMSG = "創建失敗";
         }
     }
 }

 //抓取登入之帳戶資料
 $res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow = mysql_fetch_array($res);

 $query_projects = mysql_query("SELECT MAX(projectId) FROM projects WHERE projectCreatorId=".$_SESSION['user']);
 $projectRow = mysql_fetch_array($query_projects);



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>專案設定</title>
  </head>
  <body>
    專案設定頁面(目前為創立)<br>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" action="form-handler" autocomplete="off" id="project_create">
    <input type="hidden" name="project_creatorId" value="<?php echo $userRow[0]; ?>">
    <input type="hidden" name="project_Id" value="<?php echo $projectRow[0]+1; ?>">
    <input type="text" name="project_name" placeholder="請輸入專案名稱" maxlength="40" value="" /></br>
    <?php if (isset($project_nameError)){echo $project_nameError.'<br>';} ?>
    <input type="text" name="project_class" placeholder="請輸入課程(活動)名稱" maxlength="40" value="" /><br>
    <?php if (isset($project_classError)){echo $project_classError.'<br>';} ?>
    <input type="text" name="project_member" placeholder="請輸入組員id,例如 : 1,5,10" value="" /><br>
    <input type="text" name="project_teacher" placeholder="請輸入指導老師" maxlength="40" value="" /><br>
    <?php if (isset($project_teacherError)){echo $project_teacherError.'<br>';} ?>
    <input type="hidden" name="project_creattime" value="<?php echo date('Y/m/d', time())?>">
    請輸入到期期限<input type="date" name="project_deadline" maxlength="40" value="" /><br><br>
    大區段一：
    <input type="text" name="project_stage_name_1" placeholder="請輸入區段名稱" maxlength="40" value="" />
    <input type="date" name="project_stage_start_1" maxlength="40" value="" />
    <input type="date" name="project_stage_end_1" maxlength="40" value="" /><br>
    大區段二：
    <input type="text" name="project_stage_name_2" placeholder="請輸入區段名稱" maxlength="40" value="" />
    <input type="date" name="project_stage_start_2" maxlength="40" value="" />
    <input type="date" name="project_stage_end_2" maxlength="40" value="" /><br>
    大區段三：
    <input type="text" name="project_stage_name_3" placeholder="請輸入區段名稱" maxlength="40" value="" />
    <input type="date" name="project_stage_start_3" maxlength="40" value="" />
    <input type="date" name="project_stage_end_3" maxlength="40" value="" /><br>
    <button type="submit" name="btn-project_create">創立</button></br>
    <?php
    if (isset($errMSG)) {
         ?>
         <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
         <?php echo $errMSG; ?>
         <?php
    }
    ?>
  </form>
    <a href="home.php">回首頁</a>
  </body>
</html>

<?php ob_end_flush(); ?>
