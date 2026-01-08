<?php
include "config.php";
if(isset($_POST['add_dep'])){
$conn->query("INSERT INTO departments(name) VALUES('{$_POST['dep']}')");
}
if(isset($_POST['add_class'])){
$conn->query("INSERT INTO classes(name,department_id)
VALUES('{$_POST['class']}','{$_POST['dep_id']}')");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<form method="post">
<h3>Khoa</h3>
<input name="dep">
<button name="add_dep">Thêm</button>

<h3>Lớp</h3>
<input name="class">
<input name="dep_id" placeholder="ID Khoa">
<button name="add_class">Thêm</button>
</form>
