
<?php
include '../includes/config.php'; // Include your database configuration
include 'fetch_data.php';
if (!$_SESSION['id']) {
    header('location: ../login');
}
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['old_password']) &&
    isset($_POST['new_password']) &&
    isset($_POST['confirm_password'])
) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the old password and ensure the new password matches the confirmation
    $query =
        "SELECT `password` FROM `signup` WHERE id='" . $_SESSION['id'] . "'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    if (
        password_verify($oldPassword, $hashedPassword) &&
        $newPassword === $confirmPassword
    ) {
        // Update the password in the database
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery =
            "UPDATE `signup` SET `password`='" .
            $hashedNewPassword .
            "' WHERE id='" .
            $_SESSION['id'] .
            "'";
        if (mysqli_query($conn, $updateQuery)) {
            $message = 'Password updated successfully.';
        } else {
            $errorMessage = 'Password update failed.';
        }
    } else {
        $errorMessage = 'Invalid old password or new passwords do not match.';
    }
}
function getMessage($message){
  echo $message;
}
function getErrorMessage($errorMessage){
  echo $errorMessage;
}

// SQL query to fetch profile data
$query =
    "SELECT `first_name`, `last_name`, `email`, `rank`, `status`, `created_at`, `updated_at` FROM `signup` WHERE id='" .
    $_SESSION['id'] .
    "'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?></title>
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
            <h1 class="m-0">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Profile</li>
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
      <div class="row">
        <div class="col-sm-6 col-12">
      <table class="table">
        <tr>
            <td><b>First Name: </b></td>
            <td><?= $row['first_name'] ?></td>
        </tr>
        <tr>
            <td><b>Last Name: </b></td>
            <td><?= $row['last_name'] ?></td>
        </tr>
        <tr>
            <td><b>Email: </b></td>
            <td><?= $row['email'] ?></td>
        </tr>
        <tr>
            <td><b>Rank: </b></td>
            <td><?= $row['rank'] ?></td>
        </tr>
        <tr>
            <td><b>Status: </b></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <tr>
            <td><b>Created_at: </b></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <tr>
            <td><b>Updated_at: </b></td>
            <td><?= $row['updated_at'] ?></td>
        </tr>
    </table>
</div>
<div class="col-sm-6 col-12">
<h3 class="mt-3">Change Password</h3>
  <form method="post">
      <div class="row mb-2">
      <div class="col-12">
      <label for="old_password" class="form-label">Old Password</label>
      <input type="password" class="form-control" name="old_password" required>
      </div>
      <div class="col-6">
  <label for="new_password" class="form-label">New Password</label>
      <input type="password" class="form-control" name="new_password" required>
      </div>
      <div class="col-6">
  <label for="confirm_password" class="form-label">Confirm Password</label>
      <input type="password" class="form-control"  name="confirm_password" required>
  </div>
      </div>
      <div class="row">
          <div class="col-6">
  <button type="submit" class="btn btn-success">Change Password</button>
  </div>
      </div>   
  </form>
</div>
</div>
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
<?php include "../includes/footer2.php"; ?>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  title: "<?=isset($message) ? 'Updated ' : 'Error'?>",
  text: "<?=isset($message) ? getMessage($message) : getErrorMessage($errorMessage)?>",
  icon: "<?=isset($message) ? 'success' : 'error'?>"
});

</script>
<?php } else {$errorMessage = 'No user profile found.';}
