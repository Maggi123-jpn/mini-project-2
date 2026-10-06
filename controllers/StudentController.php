<?php

session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Student.php";

if (!isset($_SESSION["student_id"])) {

    header("Location: login.php");
    exit();

}

$studentModel = new Student($conn);

$students = $studentModel->getAllStudents();

?>