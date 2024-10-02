<?php
if (isset($_POST['signup'])) {
    // Database connection
    require_once 'includes/config.php';

    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash(
        mysqli_real_escape_string($conn, $_POST['password']),
        PASSWORD_DEFAULT
    ); // Hash the password
    $query =
        'INSERT INTO signup (first_name, last_name, email, password) VALUES (?, ?, ?, ?)';
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param(
        $stmt,
        'ssss',
        $first_name,
        $last_name,
        $email,
        $password
    );
    if (mysqli_stmt_execute($stmt)) {
        $success = "<script>swal('Done!', 'Registration Successful!', 'success')</script>";
        // Redirect to login.php
        header("refresh:2; url='login'");
    } else {
        $error = "<script>swal('Error!', 'Registration Failed!', 'error')</script>";
    }

    mysqli_close($conn);
} ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Signup</title>
</head>
<body>
    <?php if (isset($success)): ?>
    <p><?= $success ?></p>
    <?php elseif (isset($error)): ?>
    <p><?= $error ?></p>
    <?php endif; ?>
<section class="py-3 py-md-5 py-xl-8 m-3">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="mb-2">
          <h3 class="fw-bold text-center">Create Account</h3>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-10">
        <div class="row gy-5 justify-content-center">
          <div class="col-12 col-lg-5">
            <form method="post">
              <div class="row gy-3 overflow-hidden">
                <!-- First Name -->
                <div class="col-12">
                  <div class="form-floating mb-2">
                    <input type="text" class="form-control border-0 border-bottom border-success rounded-0" name="first_name" placeholder="name@example.com" required>
                    <label for="first_name" class="form-label">First Name</label>
                  </div>
                </div>
                <!-- Last Name -->
                <div class="col-12">
                  <div class="form-floating mb-2">
                    <input type="text" class="form-control border-0 border-bottom border-success rounded-0" name="last_name" placeholder="name@example.com" required>
                    <label for="last_name" class="form-label">Last Name</label>
                  </div>
                </div>
                <!-- Email -->
                <div class="col-12">
                  <div class="form-floating mb-2">
                    <input type="email" class="form-control border-0 border-bottom border-success rounded-0" name="email" placeholder="name@example.com" required>
                    <label for="email" class="form-label">Email</label>
                  </div>
                </div>
                <!-- Password -->
                <div class="col-12 mb-2">
                  <div class="form-floating mb-2">
                    <input type="password" class="form-control border-0 border-bottom border-success rounded-0" name="password"  value="" placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                </div>
                <div class="col-12 mb-2">
                  <div class="d-grid">
                    <button class="btn btn-success" type="submit" name="signup">Register</button>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <p class="text-center m-0">Already have an account? <a class="text-success" href="login">Login</a></p>
              </div>
            </form>
          </div>
    </div>
  </div>
</section>

</body>
</html>
