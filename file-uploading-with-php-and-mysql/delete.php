<?php
include_once('dbconfig.php');

if(isset($_GET['del']) )
	{
		$file = $_GET['del'];
		$id = $_GET['id'];
		$del = unlink('uploads/'.$file);
		if($del){
		$sql = "DELETE FROM tbl_uploads WHERE id = '$id'";
		$res = mysql_query($sql) or die("Failed".mysql_error());
		if($res){
            echo "<script>
            alert('Deleted');
            window.location.href='view.php ';
            </script>";

		} else
		{
            echo "<script>
            alert('error while deleting file');
            window.location.href='view.php';
            </script>";
		}
		}
	}
?>
