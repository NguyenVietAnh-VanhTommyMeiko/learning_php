<?php
session_start();
$conn = new mysqli("localhost","root","","student_management");
if($conn->connect_error) die("Lỗi kết nối");
?>
