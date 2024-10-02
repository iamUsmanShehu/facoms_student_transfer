<?php
include '../includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: ../login');
}
include 'fetch_data.php';
if (isset($_POST["submit"])) {
    // Validate form data
    $facultyId = mysqli_real_escape_string($conn, $_POST['id']);
    $facultyName = mysqli_real_escape_string($conn, $_POST['name']);

    // Update faculty in the database
    $query = "UPDATE `faculty` SET `name` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $facultyName, $facultyId);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the faculty management page
        header("Location: manage_faculty_&_program");
        exit();
    } else {
        echo "Update failed. Please try again.";
    }

}
?>
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
      <img src="../dist/img/Adustech.png" alt="AdminLTE Logo" class="brand-image img-circle " style="opacity: .8">
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
            <h1 class="m-0">Edit Faculty</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Faculty</li>
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
        <?php
            // Check if ID parameter is provided
            if (isset($_GET['id'])) {
                $facultyId = mysqli_real_escape_string($conn, $_GET['id']);

                // Fetch faculty data
                $query = "SELECT id, name FROM faculty WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $facultyId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    // Display a form to edit faculty
                    echo "<form method='post'>";
                    echo "<div class='row'>";
                    echo "<div class='col-12 mb-2'>";
                    echo "<input type='hidden' class='form-control' name='id' value='" . $row['id'] . "'>";
                    echo "Name: <input type='text' class='form-control' name='name' value='" . htmlspecialchars($row['name']) . "'>";
                    echo "</div>";
                    echo "<div class='col-4'>";
                    echo "<input type='submit' class='form-control bg-success' name='submit' value='Update'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</form>";
                } else {
                    echo "Faculty not found.";
                }
            } else {
                echo "ID parameter is missing.";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
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
