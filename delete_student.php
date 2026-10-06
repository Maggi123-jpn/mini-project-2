<?php

session_start();

require_once "config/database.php";
require_once "models/Student.php";

if (!isset($_SESSION["student_id"])) {

    header("Location: login.php");
    exit();

}

if (!isset($_GET["id"])) {

    header("Location: students.php");
    exit();

}

$id = (int) $_GET["id"];

$studentModel = new Student($conn);

$studentModel->deleteStudent($id);

header("Location: students.php");
exit();

?>