<?php
include 'includes/config.php'; // Database connection
include "includes/header_student.php";
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';

if (isset($_POST["program"])) {
  $applicant_id = mysqli_real_escape_string($conn, $_SESSION['id']);
  $faculty = mysqli_real_escape_string($conn, $_POST["faculty"]);
  $program = mysqli_real_escape_string($conn, $_POST["program"]);

  // Check if the record exists
  $checkQuery = "SELECT * FROM `choice_of_study` WHERE applicant_id = ?";
  $checkStmt = mysqli_prepare($conn, $checkQuery);
  mysqli_stmt_bind_param($checkStmt, "i", $applicant_id);
  mysqli_stmt_execute($checkStmt);
  $checkResult = mysqli_stmt_get_result($checkStmt);

  if (mysqli_num_rows($checkResult) > 0) {
      // Update the existing record
      $updateQuery = "UPDATE `choice_of_study` SET faculty = ?, program = ? WHERE applicant_id = ?";
      $updateStmt = mysqli_prepare($conn, $updateQuery);
      mysqli_stmt_bind_param($updateStmt, "iii", $faculty, $program, $applicant_id);

      if (mysqli_stmt_execute($updateStmt)) {
          $successMessage = "Program Updated Successfully!";
          header("refresh:2; url=institution");
      } else {
          $errorMessage = "Error updating program!";
      }

      // Close the statement
      mysqli_stmt_close($updateStmt);
  } else {
      // Insert a new record
      $insertQuery = "INSERT INTO `choice_of_study` (applicant_id, faculty, program) VALUES (?, ?, ?)";
      $insertStmt = mysqli_prepare($conn, $insertQuery);
      mysqli_stmt_bind_param($insertStmt, "iii", $applicant_id, $faculty, $program);

      if (mysqli_stmt_execute($insertStmt)) {
          $successMessage = "Program Saved Successfully!";
          header("refresh:2; url=institution");
      } else {
          $errorMessage = "Error saving program!";
      }

      // Close the statement
      mysqli_stmt_close($insertStmt);
  }
}
include "includes/student_swal_functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?></title>
<?php include "includes/header_student.php"; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/Adustech.png" alt="Adustech" height="60" width="60">
  </div>

<?php include "includes/navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="dist/img/Adustech.png" alt="ADUSTECH Logo" class="brand-image img-circle " style="opacity: .8">
      <span class="brand-text text-success">FACOMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

     <?php include "includes/student_sidebar.php"; ?>
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
            <h1 class="m-0">Program</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" class="text-success">Dashboard</a></li>
              <li class="breadcrumb-item active">Program</li>
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
          if (isset($_SESSION['email'])) {
              $user_id = $_SESSION['id'];

              $query =
                  'SELECT programs.name AS "program", faculty.name AS "faculty", signup.first_name, signup.last_name
                   FROM `choice_of_study` 
                   JOIN programs ON programs.id = choice_of_study.program
                   JOIN signup ON signup.id = choice_of_study.applicant_id 
                   JOIN faculty ON faculty.id = choice_of_study.faculty 
                   WHERE choice_of_study.applicant_id = ?';

              $stmt = mysqli_prepare($conn, $query);
              mysqli_stmt_bind_param($stmt, 'i', $user_id);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              $user_data = mysqli_fetch_assoc($result);
          }
          ?>
        <hr>
        <div class="container">
            <h4>Current Program Of Study</h4>
            <form method="POST">
                <div class="row mb-2">
                    <div class="col-sm-6 col-12">
                        <label for="faculty" class="form-label">Faculty</label>
                        <select name="faculty" class="form-control" onchange="fetchFaculty(this.value)">
                        <option><?=$user_data["faculty"]?? 'Select Faculty...'?></option>
                        <?php
                          $query_faculty_data = "SELECT * FROM `faculty` ";
                          $query_faculty = mysqli_query($conn, $query_faculty_data);
                          while($row = mysqli_fetch_assoc($query_faculty)) {
                            $id = $row['id'];
                            $faculty = $row['name'];

                            echo '<option value="'.$id.'">'.$faculty.'</option>';
                          }
                        ?>
                      </select>
                      
                    </div>
                    <div class="col-sm-6 col-12">
                        <label for="program" class="form-label">Program</label>
                        <select id="faculty-data" class="form-control" name="program" >
                        <option><?=$user_data["program"]?? 'Select Program...'?></option>
                            <!-- programs -->
                        </select>
                    </div>
                </div>
            <div class="row">
                <div class="col-sm-6 col-10">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            </form>
            <?php mysqli_close($conn);// Close the database connection?>
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
  <?php include "includes/footer_content.php"; ?>
</div>
<!-- ./wrapper -->
<?php include "includes/footer.php"; ?>
</body>
</html>
<script>
  function fetchFaculty(id){
    $('#faculty-data').html('');
    $.ajax({
      type:"POST",
      url:'fetch-faculty',
      data: {faculty_id:id},
      success: function(data){
        $('#faculty-data').html(data);
      }
    })
  }
</script>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->

<?php include "includes/student_swal_script.html"; ?>


 <!-- $default_message = "Program Selected Successfully!";
 $message = isset($user_data["program"])? $default_message : ''
$message -->  