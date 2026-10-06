<?php
/** @var array $student */
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

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

        <a href="logout.php"
           class="btn btn-light">
            Logout
        </a>

    </div>

</nav>

<div class="container mt-5 mb-5">

    <div class="card shadow">

        <div class="card-body">

            <h3 class="mb-4">
                Student Profile
            </h3>

            <!-- PAPARAN MESEJ STATUS (TAMBAHAN UNTUK MINI PROJECT 2) -->

            <?php if (isset($_SESSION['success_msg'])): ?>

                <div class="alert alert-success">

                    <?php
                    echo $_SESSION['success_msg'];
                    unset($_SESSION['success_msg']);
                    ?>

                </div>

            <?php endif; ?>


            <?php if (isset($_SESSION['error_msg'])): ?>

                <div class="alert alert-danger">

                    <?php
                    echo $_SESSION['error_msg'];
                    unset($_SESSION['error_msg']);
                    ?>

                </div>

            <?php endif; ?>


            <!-- PAPARAN GAMBAR PROFIL & BORANG UPLOAD (TAMBAHAN UNTUK MINI PROJECT 2) -->

            <div class="text-center mb-4">

                <?php

                    $profilePic = (!empty($student['profile_pic']))
                        ? "uploads/" . $student['profile_pic']
                        : "https://via.placeholder.com/150";

                ?>

                <img
                    src="<?php echo htmlspecialchars($profilePic); ?>"
                    alt="Profile Picture"
                    class="rounded-circle img-thumbnail mb-3"
                    width="130"
                    height="130"
                    style="object-fit: cover;"
                >


                <!-- Borang Muat Naik Gambar -->

                <form
                    action="profile.php"
                    method="POST"
                    enctype="multipart/form-data"
                    class="row justify-content-center g-2 mt-2"
                >

                    <div class="col-auto">

                        <input
                            type="file"
                            class="form-control form-control-sm"
                            name="profile_pic"
                            id="profile_pic"
                            required
                        >

                    </div>


                    <div class="col-auto">

                        <button
                            type="submit"
                            class="btn btn-success btn-sm"
                        >
                            Upload Picture
                        </button>

                    </div>

                </form>


                <small class="text-muted d-block mt-1">
                    Format dibenarkan: JPG, JPEG, PNG (Maksimum: 2MB)
                </small>

            </div>


            <table class="table table-bordered">

                <tr>

                    <th width="30%">
                        Name
                    </th>

                    <td>
                        <?= htmlspecialchars($student["name"]) ?>
                    </td>

                </tr>


                <tr>

                    <th>
                        NRIC
                    </th>

                    <td>
                        <?= htmlspecialchars($student["nric"]) ?>
                    </td>

                </tr>


                <tr>

                    <th>
                        Program
                    </th>

                    <td>
                        <?= htmlspecialchars($student["program"]) ?>
                    </td>

                </tr>

            </table>


            <a
                href="change_password.php"
                class="btn btn-warning"
            >
                Change Password
            </a>


            <a
                href="students.php"
                class="btn btn-primary"
            >
                Student Management
            </a>

        </div>

    </div>

</div>

</body>

</html>