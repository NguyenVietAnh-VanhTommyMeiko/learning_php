<?php
include "config.php";
$user = $_SESSION['user'];

if($user['role']=='student'){
    $sql = "
    SELECT subjects.name, subjects.credit, scores.score
    FROM scores
    JOIN subjects ON subjects.id = scores.subject_id
    WHERE scores.student_id = {$user['id']}
    ";
} else {
    $sql = "
    SELECT students.full_name, subjects.name subject, scores.score
    FROM scores
    JOIN students ON students.id = scores.student_id
    JOIN subjects ON subjects.id = scores.subject_id
    ";
}

$data = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Bảng điểm</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h2>Bảng điểm</h2>

<table class="table table-striped table-bordered">
<thead>
<tr>
<?php if($user['role']=='admin'): ?>
<th>Sinh viên</th>
<th>Môn học</th>
<th>Điểm</th>
<?php else: ?>
<th>Môn học</th>
<th>Tín chỉ</th>
<th>Điểm</th>
<?php endif; ?>
</tr>
</thead>
<tbody>
<?php
$total = 0; $count = 0;
while($r=$data->fetch_assoc()):
?>
<tr>
<?php if($user['role']=='admin'): ?>
<td><?= $r['full_name'] ?></td>
<td><?= $r['subject'] ?></td>
<td><?= $r['score'] ?></td>
<?php else: ?>
<td><?= $r['name'] ?></td>
<td><?= $r['credit'] ?></td>
<td><?= $r['score'] ?></td>
<?php
$total += $r['score'];
$count++;
?>
<?php endif; ?>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<?php if($user['role']=='student' && $count>0): ?>
<div class="alert alert-info">
Điểm trung bình: <b><?= round($total/$count,2) ?></b>
</div>
<?php endif; ?>

<a href="dashboard.php" class="btn btn-secondary">Quay lại</a>
</div>
</body>
</html>
