<?php

session_start();

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Student.php";

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

$studentModel = new Student($conn);

// PROSES MUAT NAIK GAMBAR PROFIL
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_pic'])) {
    $file = $_FILES['profile_pic'];
    
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // 1. Validasi Jenis Fail (.jpg, .jpeg, .png)
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            // 2. Validasi Saiz Fail (Maksimum 2MB)
            if ($fileSize <= 2 * 1024 * 1024) {
                
                // 3. Penamaan Selamat menggunakan uniqid()
                $fileNewName = uniqid('profile_', true) . "." . $fileExt;
                
                // Tentukan folder laluan simpan (pastikan folder uploads wujud)
                $uploadDir = __DIR__ . "/../uploads/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileDestination = $uploadDir . $fileNewName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Simpan nama fail baru ke dalam pangkalan data
                    $studentModel->updateProfilePic($_SESSION["student_id"], $fileNewName);
                    
                    $_SESSION['success_msg'] = "Gambar profil berjaya dikemas kini!";
                    header("Location: profile.php");
                    exit();
                } else {
                    $_SESSION['error_msg'] = "Ralat semasa memindahkan fail.";
                }
            } else {
                $_SESSION['error_msg'] = "Saiz fail terlalu besar! Had maksimum adalah 2MB.";
            }
        } else {
            $_SESSION['error_msg'] = "Terdapat ralat pada fail.";
        }
    } else {
        $_SESSION['error_msg'] = "Format fail tidak sah! Hanya format .jpg, .jpeg, dan .png dibenarkan.";
    }

    header("Location: profile.php");
    exit();
}

$student = $studentModel->getStudentById(
    $_SESSION["student_id"]
);

if (!$student) {
    session_destroy();
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/../views/profile.php";

?>