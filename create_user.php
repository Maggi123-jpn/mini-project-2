<?php

require_once "config/database.php";
require_once "models/Student.php";

$studentModel = new Student($conn);

$name = "Nur Afifah";
$nric = "050101-01-1234";
$program = "Diploma Teknologi Maklumat";
$marks = 85;

$password = "123456";

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

try {

    $studentModel->addStudent(
        $name,
        $nric,
        $program,
        $marks,
        $hashedPassword
    );

    echo "Student created successfully.<br>";
    echo "NRIC: 050101-01-1234<br>";
    echo "Password: 123456<br>";

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();

}

?>