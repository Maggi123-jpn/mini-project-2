<?php

session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Student.php";

$studentModel = new Student($conn);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nric = trim($_POST["nric"]);
    $password = $_POST["password"];

    if ($nric === "" || $password === "") {

        $error = "Please fill in all fields.";

    } else {

        $student = $studentModel->getStudentByNric($nric);

        if (
            $student &&
            password_verify($password, $student["password"])
        ) {

            $_SESSION["student_id"] = $student["id"];

            header("Location: profile.php");
            exit();

        } else {

            $error = "Invalid NRIC or password.";

        }
    }
}

require_once __DIR__ . "/../views/login.php";

?>