<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';

 //如果非登入狀態將導回首頁
 if (!isset($_SESSION['user'])) {
     header("Location: index.php");
     exit;
 }

 $error = false;

 $res = mysql_query("SELECT projects_stageId FROM projects_stage WHERE projectId=".$_GET['id']);
 $projects_stageId = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $projects_stageId[] = mysql_result($res,$i,0);
 }

 if (isset($_POST['btn-project_create'])) {
     //排除不合規定之name及passwords
     $project_creatorId = $_POST['project_creatorId'];

     $project_name = strip_tags($_POST['project_name']);
     $project_name = htmlspecialchars($project_name);

     $project_class = strip_tags($_POST['project_class']);
     $project_class = htmlspecialchars($project_class);

     $project_teacher = strip_tags($_POST['project_teacher']);
     $project_teacher = htmlspecialchars($project_teacher);

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
         $query = "UPDATE projects SET
                  projectName = '$project_name',
                  projectClassName = '$project_class',
                  projectTeacher = '$project_teacher',
                  projectDeadline = '$project_deadline' WHERE projectId =".$_GET['id'];
         $res_projects = mysql_query($query);

         $query = "UPDATE projects_stage SET
                  project_stageStart = '$project_stage_start_1',
                  project_stageEnd = '$project_stage_end_1',
                  project_stageName = '$project_stage_name_1' WHERE projects_stageId =".$projects_stageId[0];
         $res_stage = mysql_query($query);

         $query = "UPDATE projects_stage SET
                  project_stageStart = '$project_stage_start_2',
                  project_stageEnd = '$project_stage_end_2',
                  project_stageName = '$project_stage_name_2' WHERE projects_stageId =".$projects_stageId[1];
         $res_stage = mysql_query($query);

         $query = "UPDATE projects_stage SET
                  project_stageStart = '$project_stage_start_3',
                  project_stageEnd = '$project_stage_end_3',
                  project_stageName = '$project_stage_name_3' WHERE projects_stageId =".$projects_stageId[2];
         $res_stage = mysql_query($query);


         if ($res_projects&&$res_stage ) {
             $errTyp = "success";
             $errMSG = "更新成功";
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
             $errMSG = "更新失敗";
         }
     }
 }

 //抓取登入之帳戶資料
 $res = mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow = mysql_fetch_array($res);

 $query_projects = mysql_query("SELECT * FROM projects WHERE projectId=".$_GET['id']);
 $projectRow = mysql_fetch_array($query_projects);

 $res = mysql_query("SELECT project_stageStart FROM projects_stage WHERE projectId=".$_GET['id']);
 $project_stageStartRow = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $project_stageStartRow[] = mysql_result($res,$i,0);
 }

 $res = mysql_query("SELECT project_stageEnd FROM projects_stage WHERE projectId=".$_GET['id']);
 $project_stageEndRow = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $project_stageEndRow[] = mysql_result($res,$i,0);
 }

 $res = mysql_query("SELECT project_stageName FROM projects_stage WHERE projectId=".$_GET['id']);
 $project_stageNameRow = array();
 for ($i = 0; $i < mysql_num_rows($res); $i++) {
   $project_stageNameRow[] = mysql_result($res,$i,0);
 }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>專案設定</title>
  </head>
  <body>
    專案設定頁面<br>
  <form method="post" action="project_setting.php?id=<?php echo $_GET['id']; ?>" action="form-handler" autocomplete="off" id="project_setting">
    <input type="text" name="project_name" placeholder="請輸入專案名稱" maxlength="40" value="<?php echo $projectRow[3]; ?>" /></br>
    <?php if (isset($project_nameError)){echo $project_nameError.'<br>';} ?>
    <input type="text" name="project_class" placeholder="請輸入課程(活動)名稱" maxlength="40" value="<?php echo $projectRow[4]; ?>" /><br>
    <?php if (isset($project_classError)){echo $project_classError.'<br>';} ?>
    <input type="text" name="project_teacher" placeholder="請輸入指導老師" maxlength="40" value="<?php echo $projectRow[5]; ?>" /><br>
    <?php if (isset($project_teacherError)){echo $project_teacherError.'<br>';} ?>
    請輸入到期期限<input type="date" name="project_deadline" maxlength="40" value="<?php echo $projectRow[7]; ?>" /><br><br>
    大區段一：
    <input type="text" name="project_stage_name_1" placeholder="請輸入區段名稱" maxlength="40" value="<?php echo $project_stageNameRow[0]; ?>" />
    <input type="date" name="project_stage_start_1" maxlength="40" value="<?php echo $project_stageStartRow[0]; ?>" />
    <input type="date" name="project_stage_end_1" maxlength="40" value="<?php echo $project_stageEndRow[0]; ?>" /><br>
    大區段二：
    <input type="text" name="project_stage_name_2" placeholder="請輸入區段名稱" maxlength="40" value="<?php echo $project_stageNameRow[1]; ?>" />
    <input type="date" name="project_stage_start_2" maxlength="40" value="<?php echo $project_stageStartRow[1]; ?>" />
    <input type="date" name="project_stage_end_2" maxlength="40" value="<?php echo $project_stageEndRow[1]; ?>" /><br>
    大區段三：
    <input type="text" name="project_stage_name_3" placeholder="請輸入區段名稱" maxlength="40" value="<?php echo $project_stageNameRow[2]; ?>" />
    <input type="date" name="project_stage_start_3" maxlength="40" value="<?php echo $project_stageStartRow[2]; ?>" />
    <input type="date" name="project_stage_end_3" maxlength="40" value="<?php echo $project_stageEndRow[2]; ?>" /><br>
    <button type="submit" name="btn-project_create">更改</button></br>
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
