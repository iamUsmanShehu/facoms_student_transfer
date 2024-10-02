<?php
include "../includes/config.php"; // Include database configuration
include 'fetch_data.php';
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Initialize the message variable
//$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected faculty ID and program name from the form
    $facultyId = $_POST["faculty"];
    $programName = $_POST["program"];

    // Check if the program already exists
    $checkQuery = "SELECT COUNT(*) FROM programs WHERE name = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);

    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "s", $programName);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $count);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        if ($count > 0) {
            $errorMessage = "Program Already exist!";
        } else {
            // Prepare and execute the SQL query to insert into the programs table
            $insertQuery = "INSERT INTO programs (faculty_id, name) VALUES (?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);

            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, "is", $facultyId, $programName);
                $result = mysqli_stmt_execute($insertStmt);

                if ($result) {
                    $message = "Program Added Successfully!";
                } else {
                    $errorMessage = "Error: " . mysqli_error($conn).'';
                }

                mysqli_stmt_close($insertStmt);
            } else {
                $errorMessage = "Error in preparing the statement: " . mysqli_error($conn).'';
            }
        }
    } else {
        $errorMessage = "Error in preparing the check statement: " . mysqli_error($conn).'';
    }
}
include "../includes/swal_functions.php";
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
            <h1 class="m-0">Add Program</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Add Program</li>
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
      <form method="post" action="">
    <div class="row mt-3 mb-2">
        <div class="col-sm-6 col-12">
            <label for="faculty" class="form-label">Select Faculty Name</label>
            <select name="faculty" class="form-control">
                <option></option>
                <?php
                $query_faculty_data = "SELECT * FROM `faculty` ";
                $query_faculty = mysqli_query($conn, $query_faculty_data);
                while ($row = mysqli_fetch_assoc($query_faculty)) {
                    $id = $row['id'];
                    $faculty = $row['name'];

                    echo '<option value="' . $id . '">' . $faculty . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-sm-6 col-12">
            <label for="program" class="form-label">Enter Program Name</label>
            <input type="text" name="program" class="form-control" required />
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
  
</div>
<!-- ./wrapper -->
<?php include "../includes/footer2.php"; ?>
<?php include "../includes/footer_content.php"; ?>
<?=mysqli_close($conn);// Close the database connection ?>

</body>
</html>
<?php include "../includes/swal_script.html"; ?>
