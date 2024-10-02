<?php
include 'includes/config.php';
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query =
        'SELECT id, email, first_name, last_name, rank, status, password FROM signup WHERE email = ?';

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        // User exists and password matches
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $_SESSION['rank'] = $row['rank'];
        $_SESSION['status'] = $row['status'];

        if ($row['status'] == 1) {
            // User is an admin, redirect to the admin dashboard
            $success =
                '<span class="alert alert-success">Login successful.</span>';
            header("refresh:2; url='admin/dashboard'");
        } else {
            // User is a regular user, redirect to the regular user dashboard
            $success =
                '<span class="alert alert-success">Login successful.</span>';
            header('refresh:2; url=dashboard');
        }
        // exit; // Terminate the script after redirection
    } else {
        $error =
            '<span class="alert alert-danger">Invalid email or password. Please try again.</span>';
    }

    mysqli_close($conn);
}

// $errorSuccess = isset($success) ? $success : $error;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
<body>
    <!-- Login -->
<section class="py-3 py-md-5 py-xl-8 m-5">
  <div class="containerW">
    <div class="row">
      <div class="col-12">
        <div class="mb-3">
          <h3 class="fw-bold text-center">Login</h3>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-10">
        <div class="row gy-5 justify-content-center">
          <div class="col-12 col-lg-5">
            <form method="post">
              <div class="row gy-3 overflow-hidden">
                
                    <?php if (isset($success)): ?>
                      <?= $success ?>
                    <?php elseif (isset($error)): ?>
                      <?= $error ?>
                    <?php endif; ?>
                <!-- Email -->
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="email" class="form-control border-0 border-bottom border-success rounded-0" name="email" id="email" placeholder="name@example.com" required>
                    <label for="email" class="form-label">Email</label>
                  </div>
                </div>
                <!-- Password -->
                <div class="col-12 mb-2">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control border-0 border-bottom border-success rounded-0" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="d-grid">
                    <button class="btn btn-success" type="submit" name="login">Log in</button>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <p class="text-center m-0">Don't have an account? <a class="text-success" href="signup">Register</a></p>
              </div>
            </form>
          </div>
    </div>
  </div>
</section>
</body>
</html>
