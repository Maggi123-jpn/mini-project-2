<?php

require_once "controllers/StudentController.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Management</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <span class="navbar-brand">
            PSP Student Portal
        </span>

        <div>

            <a href="profile.php"
               class="btn btn-light">

                Profile

            </a>

            <a href="logout.php"
               class="btn btn-danger">

                Logout

            </a>

        </div>

    </div>

</nav>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-4">

                <h3>
                    Student Management
                </h3>

                <a
                    href="add_student.php"
                    class="btn btn-success">

                    + Add Student

                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>IC</th>
                            <th>Program</th>
                            <th>Marks</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if (count($students) > 0): ?>

                        <?php foreach ($students as $student): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($student["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["nric"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["program"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["marks"]) ?>
                                </td>

                                <td>

                                    <a
                                        href="edit_student.php?id=<?= $student["id"] ?>"
                                        class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    <a
                                        href="delete_student.php?id=<?= $student["id"] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this student?');">

                                        Delete

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6"
                                class="text-center">

                                No student records found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>
</html>