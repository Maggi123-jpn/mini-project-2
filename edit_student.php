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

$student = $studentModel->getStudentById($id);

if (!$student) {

    header("Location: students.php");
    exit();

}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $nric = trim($_POST["nric"]);
    $program = trim($_POST["program"]);
    $marks = $_POST["marks"];

    if (
        $name === "" ||
        $nric === "" ||
        $program === "" ||
        $marks === ""
    ) {

        $error = "Please fill in all fields.";

    } elseif (!is_numeric($marks) || $marks < 0 || $marks > 100) {

        $error = "Marks must be between 0 and 100.";

    } else {

        try {

            $studentModel->updateStudent(
                $id,
                $name,
                $nric,
                $program,
                $marks
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

    <title>Edit Student</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-4">
                Edit Student
            </h3>

            <?php if ($error): ?>

                <div class="alert alert-danger">

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="<?= htmlspecialchars($student["name"]) ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        IC / NRIC
                    </label>

                    <input
                        type="text"
                        name="nric"
                        class="form-control"
                        value="<?= htmlspecialchars($student["nric"]) ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Program
                    </label>

                    <input
                        type="text"
                        name="program"
                        class="form-control"
                        value="<?= htmlspecialchars($student["program"]) ?>"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Marks
                    </label>

                    <input
                        type="number"
                        name="marks"
                        class="form-control"
                        min="0"
                        max="100"
                        value="<?= htmlspecialchars($student["marks"]) ?>"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-warning">

                    Update Student

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

</body>

</html>