<?php
include_once 'dbconfig.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>File Uploading With PHP and MySql</title>
  <link rel="stylesheet" href="style1.css" type="text/css" />
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="http://www.w3schools.com/lib/w3data.js"></script>
</head>
<body>
  <div id="header">
    <label>File Uploading With PHP and MySql</label>
  </div>


  <div class="w3-container">
    <h3>your uploads...<label><a href="index.php">upload new files...</a></label></h3>
    <input class="w3-input w3-border w3-padding" type="text" placeholder="Search..." id="myInput" onkeyup="myFunction()">

    <table id="id01" class="w3-table w3-bordered w3-striped w3-margin-top w3-border">
      <tr>
        <th>File Name</th>
        <th>File Type</th>
        <th>File Size(KB)</th>
        <th>View</th>
        <th>Delete</th>
      </tr>
      <?php
      $query="SELECT * FROM tbl_uploads ORDER BY id";
      $res=mysql_query($query);
      while($row=mysql_fetch_array($res))
      {
        ?>
        <tr>
          <td><?php echo $row['file'] ?></td>
          <td><?php echo $row['type'] ?></td>
          <td><?php echo $row['size'] ?></td>
          <td><a href="uploads/<?php echo $row['file'] ?>" target="_blank">view file</a></td>
          <td><a href="delete.php?del=<?php echo $row['file'] ?>&id=<?php echo $row['id'] ?>">delete file</a></td>
        </tr>
        <?php
      }
      // if ($_POST['sort'] == 'name')
      // {
      //   $query .= " ORDER BY file";
      // }
      // elseif ($_POST['sort'] == 'type')
      // {
      //   $query .= " ORDER BY type";
      // }
      // elseif ($_POST['sort'] == 'size')
      // {
      //   $query .= " ORDER BY size";
      // }
      ?>
    </table>
  </div>
</body>
<script>
w3Http("customers.php", function () {
  if (this.readyState == 4 && this.status == 200) {
    var myObject = JSON.parse(this.responseText);
    w3DisplayData("id01", myObject);
  }
});

function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("id01");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
</html>
