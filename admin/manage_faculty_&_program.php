<?php
include "../includes/header.php";
// Include database configuration
include "../includes/config.php";
include 'fetch_data.php';
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Fetch data from faculty table
$facultyQuery = "SELECT id, name FROM faculty";
$facultyResult = mysqli_query($conn, $facultyQuery);

// Fetch data from programs table
$programsQuery = "SELECT id, faculty_id, name FROM programs";
$programsResult = mysqli_query($conn, $programsQuery);
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
            <h1 class="m-0">Manage</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row mt-3 bg-white py-4">
       <div class="col-sm-6 col-12 mb-3">
        <table class="table myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Faculties</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($facultyRow = mysqli_fetch_assoc($facultyResult)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($facultyRow['id']) . "</td>";
                echo "<td>" . htmlspecialchars($facultyRow['name']) . "</td>";
                echo "<td>
                        <a href='edit_faculty?id=" . $facultyRow['id'] . "'><i class='bi bi-pencil-square text-info'></i></a> |
                        </td>";
                        echo "</tr>";
                      }
                      // <a href='delete_faculty_confirm?id=" . $facultyRow['id'] . "'><i class='bi bi-trash text-danger'></i></a>
            ?>
            </tbody>
        </table>
    </div> 
    <hr>
      <div class="col-sm-6 col-12 mb-3">
        <!-- <h2>Programs Table</h2> -->
        <table class="table myTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Programs</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($programsRow = mysqli_fetch_assoc($programsResult)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($programsRow['faculty_id']) . "</td>";
                echo "<td>" . htmlspecialchars($programsRow['name']) . "</td>";
                echo "<td>
                        <a href='edit_program?id=" . $programsRow['id'] . "'><i class='bi bi-pencil-square text-info'></i></a> |
                        <a href='delete_program_confirm?id=" . $programsRow['id'] . "'><i class='bi bi-trash text-danger'></i></a>
                    </td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
    </div>
   </div>
    </section>
</div>
</div>
  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Control sidebar content goes here -->
  <!-- </aside> -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include "../includes/footer_content.php"; ?>

<!-- ./wrapper -->
<?php include "../includes/footer2.php"; ?>
</body>
</html>
