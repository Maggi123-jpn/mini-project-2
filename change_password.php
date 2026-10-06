<?php

session_start();

require_once "config/database.php";
require_once "models/Student.php";

if (!isset($_SESSION["student_id"])) {

    header("Location: login.php");
    exit();

}

$studentModel = new Student($conn);

$student = $studentModel->getStudentById(
    $_SESSION["student_id"]
);

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    if (
        empty($oldPassword) ||
        empty($newPassword) ||
        empty($confirmPassword)
    ) {

        $error = "Please fill in all fields.";

    } elseif (
        !password_verify(
            $oldPassword,
            $student["password"]
        )
    ) {

        $error = "Old password is incorrect.";

    } elseif ($newPassword !== $confirmPassword) {

        $error = "New password and confirm password do not match.";

    } elseif (strlen($newPassword) < 6) {

        $error = "New password must contain at least 6 characters.";

    } else {

        $hashedPassword = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        if (
            $studentModel->updatePassword(
                $_SESSION["student_id"],
                $hashedPassword
            )
        ) {

            $message = "Password updated successfully.";

            $student["password"] = $hashedPassword;

        } else {

            $error = "Failed to update password.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Change Password</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="mb-4">
                        Change Password
                    </h3>

                    <?php if ($message): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($message) ?>
                        </div>

                    <?php endif; ?>

                    <?php if ($error): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST"
                          onsubmit="return validatePassword()">

                        <div class="mb-3">

                            <label class="form-label">
                                Old Password
                            </label>

                            <input
                                type="password"
                                name="old_password"
                                id="old_password"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                id="confirm_password"
                                class="form-control"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            Update Password

                        </button>

                        <a
                            href="profile.php"
                            class="btn btn-secondary">

                            Back

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function validatePassword()
{
    let newPassword =
        document.getElementById("new_password").value;

    let confirmPassword =
        document.getElementById("confirm_password").value;

    if (newPassword.length < 6) {

        alert("Password must contain at least 6 characters.");

        return false;
    }

    if (newPassword !== confirmPassword) {

        alert("Password does not match.");

        return false;
    }

    return true;
}

</script>

</body>
</html>