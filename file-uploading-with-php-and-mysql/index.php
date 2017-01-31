<?php
include_once 'dbconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>File Uploading With PHP and MySql</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.js"></script>
</head>
<body>
	<div id="header">
		<label>File Uploading With PHP and MySql</label>
	</div>
	<div id="body">
		<form action="upload.php" method="post" enctype="multipart/form-data">

			<div class="col-md-12" style="background-color:lavender;">
				<input type="file" name="files[]" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
				<label for="file"><img src="uploadicon.svg" width="20" height="17"> <span>Choose a file&hellip;</span></label>
			</div>

			<div class="col-md-12" style="background-color:lavenderblush;">
				<!-- <button class="button1" type="submit" name="btn-upload">Upload</button> -->
				<input class="button1" type="submit" value="Upload" disabled />
			</div>
			<br/>

		</form>
		<br /><br />
		<?php
		if(isset($_GET['success']))
		{
			?>
			<label>File Uploaded Successfully...  <a href="view.php">click here to view file.</a></label>
			<?php
		}
		else if(isset($_GET['fail']))
		{
			?>
			<label>Problem While File Uploading !</label>
			<?php
		}
		else
		{
			?>
			<label>Try to upload any files</label>
			<br>
			<label>(PDF, DOC, EXE, VIDEO, MP3, ZIP,etc...)</label>
			<br/><br/>
			<a href="view.php">click here to view uploaded file</a>
			<?php
		}
		?>
		<script type="text/javascript">
		$(document).ready(
			function(){
				$('input:submit').attr('disabled',true);
				$('input:file').change(
					function(){
						if ($(this).val()){
							$('input:submit').removeAttr('disabled');
						}
						else {
							$('input:submit').attr('disabled',true);
						}
					});
				});
				</script>

				<script src="js/custom-file-input.js"></script>
</body>
</html>
