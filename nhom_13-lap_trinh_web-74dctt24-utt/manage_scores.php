<?php
include "config.php";

if($_SESSION['user']['role']=='admin' && isset($_POST['add'])){
$conn->query("INSERT INTO scores(student_id,subject_id,score)
VALUES('{$_POST['student']}','{$_POST['subject']}','{$_POST['score']}')");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<form method="post">
<?php if($_SESSION['user']['role']=='admin'): ?>
<input name="student" placeholder="ID SV">
<input name="subject" placeholder="ID Môn">
<input name="score">
<button name="add">Nhập điểm</button>
<?php endif; ?>
</form>

<h3>Bảng điểm</h3>
<?php
$r=$conn->query("
SELECT students.full_name,AVG(score) tb
FROM scores
JOIN students ON students.id=scores.student_id
GROUP BY student_id
");
while($row=$r->fetch_assoc()){
echo "{$row['full_name']} - TB: {$row['tb']}<br>";
}
?>
