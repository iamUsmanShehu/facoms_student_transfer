<?php
// Database connection
require_once '../includes/config.php';
include 'fetch_data.php';   
if (!$_SESSION['id']) {
    header('location: ../login');
}
if (isset($_POST['signup'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $rank = mysqli_real_escape_string($conn, $_POST['rank']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $password = password_hash(
        mysqli_real_escape_string($conn, $_POST['password']),
        PASSWORD_DEFAULT
    ); // Hash the password

    // Check if the email already exists
    $checkQuery = 'SELECT COUNT(*) FROM signup WHERE email = ?';
    $checkStmt = mysqli_prepare($conn, $checkQuery);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, 's', $email);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        if ($count > 0) {
            $errorMessage = 'Email already exists. Please use a different email address.';
        } else {
            // Proceed with the registration
            $query =
                'INSERT INTO signup (first_name, last_name, email, rank, status, password) VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param(
                $stmt,
                'ssssis',
                $first_name,
                $last_name,
                $email,
                $rank,
                $status,
                $password
            );

            if (mysqli_stmt_execute($stmt)) {
                $message = 'HOD registered successfully!';
                // Redirect to login.php
                header("refresh:2; url='dashboard'");
            } else {
                $errorMessage = 'Registration failed. Please try again.';
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        $errorMessage = 'Error in preparing the check statement: ' . mysqli_error($conn).'';
    }
}
include "../includes/swal_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?> || Add - Admin</title>
<?php include "../includes/header.php"; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="../dist/img/Adustech.png" alt="Adustech" height="60" width="60">
  </div>

<?php include "../includes/admin_navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor ">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="../dist/img/Adustech.png" alt="Adustech Logo" class="brand-image img-circle " style="opacity: .8">
      <span class="brand-text text-success">FACOMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

     <?php include "../includes/sidebar.php"; ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Create Admin</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div style="background:white;padding: 10px;">
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
        <?php if(isset($message)){echo $message;} ?><!-- Display the message within the form -->
        <hr>
    <form method="post">
        <div class="row mb-2">
            <div class="col-sm-4 col-6">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" name="first_name" required>
            </div>
             <div class="col-sm-4 col-6">
                <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" name="last_name" required>
            </div>
             <div class="col-sm-4 col-12">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" required>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 col-6">
        <label for="rank" class="form-label">Rank</label>
        <select class="form-control" name="rank">
          <option >Select ....</option>
          <option value="HOD Computer">HOD Computer</option>
          <option value="HOD STATISTICS">HOD STATISTICS</option>
          <option value="HOD Mathematics">HOD Mathematics</option>
        </select>
            </div>
            <div class="col-sm-4 col-6">
        <label for="status" class="form-label">Status</label>
        <select type="text" class="form-control" name="status" readonly required>
          <option value="1">Admin</option>
        </select>
            </div>
            <div class="col-sm-4 col-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
            </div>
        </div>
        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-success w-50" name="signup">Add</button>
          </div>
        </div>
    </form>
</main>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include "../includes/footer_content.php"; ?>
</div>
<!-- ./wrapper -->
<?php include "../includes/footer2.php";     mysqli_close($conn);?>
</body>
</html>
<?php include "../includes/swal_script.html"; ?>