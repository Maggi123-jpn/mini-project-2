<?php

session_start();

require_once "config/database.php";
require_once "models/Student.php";

if (!isset($_SESSION["student_id"])) {

    header("Location: login.php");
    exit();

}

$studentModel = new Student($conn);

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $nric = trim($_POST["nric"]);
    $program = trim($_POST["program"]);
    $marks = $_POST["marks"];
    $password = $_POST["password"];

    if (
        $name === "" ||
        $nric === "" ||
        $program === "" ||
        $marks === "" ||
        $password === ""
    ) {

        $error = "Please fill in all fields.";

    } elseif (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $error = "Marks must be between 0 and 100.";

    } elseif (strlen($password) < 6) {

        $error = "Password must contain at least 6 characters.";

    } else {

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

            header("Location: students.php");
            exit();

        } catch (PDOException $e) {

            $error = "NRIC already exists.";

        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Student</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-4">
                Add New Student
            </h3>

            <?php if ($error): ?>

                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <form method="POST"
                  onsubmit="return validateStudentForm()">

                <div class="mb-3">

                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        IC / NRIC
                    </label>

                    <input
                        type="text"
                        name="nric"
                        id="nric"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Program
                    </label>

                    <input
                        type="text"
                        name="program"
                        id="program"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Marks
                    </label>

                    <input
                        type="number"
                        name="marks"
                        id="marks"
                        class="form-control"
                        min="0"
                        max="100"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    Add Student

                </button>

                <a
                    href="students.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

<script>

function validateStudentForm()
{
    let marks =
        document.getElementById("marks").value;

    let password =
        document.getElementById("password").value;

    if (marks < 0 || marks > 100) {

        alert("Marks must be between 0 and 100.");

        return false;
    }

    if (password.length < 6) {

        alert("Password must contain at least 6 characters.");

        return false;
    }

    return true;
}

</script>

</body>

</html>