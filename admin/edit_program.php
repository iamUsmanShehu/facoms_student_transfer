<?php
include '../includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: ../login');
}
include 'fetch_data.php';
if (isset($_POST["submit"])) {
    // Validate form data
    $facultyId = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $programName = mysqli_real_escape_string($conn, $_POST['name']);
    $programId = mysqli_real_escape_string($conn, $_POST['program_id']);

    // Update program in the database
    $query = "UPDATE `programs` SET `name` = ?, `faculty_id` = ? WHERE `id` = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sii", $programName, $facultyId, $programId);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the program management page
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
            <h1 class="m-0">Edit Program</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Edit Program</li>
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
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php
            // Check if ID parameter is provided
            if (isset($_GET['id'])) {
                $programId = mysqli_real_escape_string($conn, $_GET['id']);

                // Fetch program data
                $query = "SELECT id, faculty_id, name FROM programs WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $programId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if ($row = mysqli_fetch_assoc($result)) {
                    // Display a form to edit program
                    echo "<form method='post'>";
                    echo "<div class='row'>";
                    echo "<div class='col-sm-6 col-12'>";
                    echo "Faculty <input type='hidden' class='form-control' name='program_id' value='" . htmlspecialchars($row['id']) . "'>";
                    echo '<select name="faculty_id" class="form-control">';
                    $query_faculty_data = "SELECT * FROM `faculty` ";
                    $query_faculty = mysqli_query($conn, $query_faculty_data);
                    while ($row_faculty = mysqli_fetch_assoc($query_faculty)) {
                        $id = $row_faculty['id'];
                        $faculty = $row_faculty['name'];

                        $selected = ($id == $row['faculty_id']) ? 'selected' : '';
                        echo '<option value="' . $id . '" ' . $selected . '>' . $faculty . '</option>';
                    }
                    echo '</select>';
                    echo "</div>";
                    echo "<div class='col-sm-6 col-12'>";
                    echo "Program <input type='text' class='form-control' name='name' value='" . htmlspecialchars($row['name']) . "'>";
                    echo "</div>";
                    echo "<div class='col-6'>";
                    echo "<input class='mt-3 form-control bg-success' type='submit' name='submit' value='Update'>";
                    echo "</div>";
                        echo "</div>";
                    echo "</form>";
                } else {
                    echo "Program not found.";
                }
            } else {
                echo "ID parameter is missing.";
            }
            // Close the database connection
            mysqli_close($conn);
            ?>
            </div>
            </div>
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
<?php include "../includes/footer2.php"; ?>
</body>
</html>
