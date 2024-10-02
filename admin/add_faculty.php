
<?php
include "../includes/config.php"; // Include database configuration
include 'fetch_data.php';
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the faculty name from the form
    $facultyName = $_POST["faculty"];

    // Check if the faculty already exists
    $checkQuery = "SELECT COUNT(*) FROM faculty WHERE name = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "s", $facultyName);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        if ($count > 0) {
            $errorMessage = "Faculty Already exist!";
        } else {
            // Prepare and execute the SQL query to insert into the faculty table
            $insertQuery = "INSERT INTO faculty (name) VALUES (?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);

            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, "s", $facultyName);
                $result = mysqli_stmt_execute($insertStmt);

                if ($result) {
                    $message = "Faculty Added!";
                } else {
                    $errorMessage = "Error: " . mysqli_error($conn)."";
                }

                mysqli_stmt_close($insertStmt);
            } else {
                $errorMessage = "Error in preparing the statement: " . mysqli_error($conn)."";
            }
        }
    } else {
        $errorMessage = "Error in preparing the check statement: " . mysqli_error($conn)."";
    }
}
include "../includes/swal_functions.php";
// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?></title>
  <Style>
        .error{color:red;}
        .success{color:green;}
    </Style>
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
  <aside class="main-sidebar bgColor">
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
            <h1 class="m-0">Add Faculty</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Faculty</li>
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
      <form method="POST">
        <div class="row mt-3 mb-2">
            <div class="col-sm-6 col-12">
            <label for="faculty" class="form-label">Enter Faculty Name</label>
            <input type="text" name="faculty" class="form-control" >
            <?php if(isset($message)){echo $message;} ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="px-5 btn btn-success" name="">Save</button>
            </div>
        </div>
    </form>
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
  <?php include "../includes/footer2.php"; ?>
</div>
<!-- ./wrapper -->
<!-- Footer -->
<?php include "../includes/footer_content.php"; ?>
</body>
</html>
<?php include "../includes/swal_script.html"; ?>
