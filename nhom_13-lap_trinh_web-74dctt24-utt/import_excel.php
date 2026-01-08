<?php
include "config.php";

require 'PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
require 'PhpSpreadsheet/src/PhpSpreadsheet/Spreadsheet.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['import'])){
    $file = $_FILES['excel']['tmp_name'];
    $sheet = IOFactory::load($file)->getActiveSheet()->toArray();

    foreach($sheet as $i=>$row){
        if($i==0) continue; // bỏ dòng tiêu đề
        $conn->query("INSERT INTO scores(student_id,subject_id,score)
                      VALUES('$row[0]','$row[1]','$row[2]')");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Import Excel</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<h2>Import điểm từ Excel</h2>
<form method="post" enctype="multipart/form-data">
<input type="file" name="excel" class="form-control mb-2" required>
<button name="import" class="btn btn-success">Import</button>
</form>
</div>
</body>
</html>
