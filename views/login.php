<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h3 class="text-center mb-4">
                        PSP Student Portal
                    </h3>

                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST"
                          onsubmit="return validateLogin()">

                        <div class="mb-3">

                            <label class="form-label">
                                NRIC
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
                            class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function validateLogin()
{
    let nric =
        document.getElementById("nric").value.trim();

    let password =
        document.getElementById("password").value.trim();

    if (nric === "" || password === "") {

        alert("Please fill in all fields.");

        return false;
    }

    return true;
}

</script>

</body>
</html>