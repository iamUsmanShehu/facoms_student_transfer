<?php
include 'includes/config.php'; // Database connection
include "includes/header_student.php";
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';

if (isset($_POST["program"])) {
  $applicant_id = mysqli_real_escape_string($conn, $_SESSION['id']);
    // $faculty = mysqli_real_escape_string($conn, $_POST["faculty"]);
    // $program = mysqli_real_escape_string($conn, $_POST["program"]);
  $Present_Institution = mysqli_real_escape_string($conn, $_POST["Present_Institution"]);
  $Present_Course_of_Study = mysqli_real_escape_string($conn, $_POST["Present_Course_of_Study"]);
  $Present_Level = mysqli_real_escape_string($conn, $_POST["Present_Level"]);
  $Year_of_Entery = mysqli_real_escape_string($conn, $_POST["Year_of_Entery"]);
  $University_Reg_No = mysqli_real_escape_string($conn, $_POST["University_Reg_No"]);
  $Transfer_To_Course = mysqli_real_escape_string($conn, $_POST["Transfer_To_Course"]);
  $Transfer_Level = mysqli_real_escape_string($conn, $_POST["Transfer_Level"]);
  $withdraw = mysqli_real_escape_string($conn, $_POST["withdraw"]);
  $Reasons_for_withdrawal = mysqli_real_escape_string($conn, $_POST["Reasons_for_withdrawal"]);

  // Check if the record exists
  $checkQuery = "SELECT * FROM `choice_of_study` WHERE applicant_id = ?";
  $checkStmt = mysqli_prepare($conn, $checkQuery);
  mysqli_stmt_bind_param($checkStmt, "i", $applicant_id);
  mysqli_stmt_execute($checkStmt);
  $checkResult = mysqli_stmt_get_result($checkStmt);

  if (mysqli_num_rows($checkResult) > 0) {
      // Update the existing record
      $updateQuery = "UPDATE `choice_of_study` SET Present_Institution = ?, Present_Course_of_Study = ?, Present_Level = ?, Year_of_Entery = ?, University_Reg_No = ?, Transfer_To_Course = ?, Transfer_Level = ?, withdraw = ?, Reasons_for_withdrawal = ? WHERE applicant_id = ?";
      $updateStmt = mysqli_prepare($conn, $updateQuery);
      mysqli_stmt_bind_param($updateStmt, "sssssssssi", $Present_Institution, $Present_Course_of_Study, $Present_Level, $Year_of_Entery, $University_Reg_No, $Transfer_To_Course, $Transfer_Level, $withdraw, $Reasons_for_withdrawal, $applicant_id);

      if (mysqli_stmt_execute($updateStmt)) {
          $successMessage = "Institution Updated Successfully!";
          header("refresh:2; url=payment");
      } else {
          $errorMessage = "Error updating Institution!";
      }

      // Close the statement
      mysqli_stmt_close($updateStmt);
  } else {
      // Insert a new record
      $insertQuery = "INSERT INTO `choice_of_study` (applicant_id, Present_Institution, Present_Course_of_Study, Present_Level, Year_of_Entery, University_Reg_No, Transfer_To_Course, Transfer_Level, withdraw, Reasons_for_withdrawal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $insertStmt = mysqli_prepare($conn, $insertQuery);
      mysqli_stmt_bind_param($insertStmt, "isssssssss", $applicant_id, $Present_Institution, $Present_Course_of_Study, $Present_Level, $Year_of_Entery, $University_Reg_No, $Transfer_To_Course, $Transfer_Level, $withdraw, $Reasons_for_withdrawal);

      if (mysqli_stmt_execute($insertStmt)) {
          $successMessage = "Institution Saved Successfully!";
          header("refresh:2; url=payment");
      } else {
          $errorMessage = "Error saving Institution!";
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
            <h1 class="m-0">Institution</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" class="text-success">Dashboard</a></li>
              <li class="breadcrumb-item active">Institution</li>
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
                  'SELECT programs.name AS "program", faculty.name AS "faculty", signup.first_name, signup.last_name, 
                    choice_of_study.Present_Institution, choice_of_study.Present_Course_of_Study, choice_of_study.Present_Level, choice_of_study.Year_of_Entery, choice_of_study.University_Reg_No, 
                    choice_of_study.Transfer_To_Course, choice_of_study.Transfer_Level, choice_of_study.withdraw, choice_of_study.Reasons_for_withdrawal
                   FROM `choice_of_study` 
                   JOIN programs ON programs.id = choice_of_study.id
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
            <!-- <h4>Select the program you want to study</h4> -->
            <form method="POST">
              <?php if (isset($errorMessage)) {echo $errorMessage;}?>
              <?php if (isset($successMessage)) {echo $successMessage;}?>
            <div class="row mb-2">
                <div class="col-sm-6 col-12">
                        <label for="Present_Institution" class="form-label">Present_Institution</label>
                    <input type='text' name='Present_Institution' class='form-control' placeholder='Present_Institution' value='Aliko Dangote University of Science & Technology, Wudil' readonly>
                </div>
                <div class="col-sm-6 col-12">
                        <label for="Present_Course_of_Study" class="form-label">Present_Course_of_Study</label>
                    <!-- <input type='text' name='Present_Course_of_Study' class='form-control' placeholder='Present_Course_of_Study' > -->
                    <select name="Present_Course_of_Study" class="form-control" >
                      <option value='<?=$user_data["Present_Course_of_Study"]?? ""?>'><?=$user_data["Present_Course_of_Study"]?? "Present_Course_of_Study"?></option>
                      <option value="COMPUTER SCIENCE">COMPUTER SCIENCE</option>
                      <option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
                      <option value="STATISTICS">STATISTICS</option>
                      <option value="MATHEMATICS">MATHEMATICS</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6 col-12">
                        <label for="Present_Level" class="form-label">Present_Level</label>
                    <select name='Present_Level' class='form-control'>
                      <option value='<?=$user_data["Present_Level"]?? ""?>'><?=$user_data["Present_Level"]?? "Present_Level"?></option>
                      <option value="LEVEL - 100">LEVEL - 100</option>
                      <option value="LEVEL - 200">LEVEL - 200</option>
                      <option value="LEVEL - 300">LEVEL - 300</option>
                      <option value="LEVEL - 400">LEVEL - 400</option>
                    </select>
                  </div>
                <div class="col-sm-6 col-12">
                        <label for="Year_of_Entery" class="form-label">Year_of_Entery</label>
                    <input type='Year' name='Year_of_Entery' class='form-control' placeholder='Year_of_Entery' value='<?=$user_data["Year_of_Entery"]?? ""?>'>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-4 col-12">
                        <label for="University_Reg_No" class="form-label">University_Reg_No</label>
                    <input type='text' name='University_Reg_No' class='form-control' placeholder='University_Reg_No' value='<?=$user_data["University_Reg_No"]?? ""?>'>
                </div>
                <div class="col-sm-4 col-12">
                        <label for="Transfer_To_Course" class="form-label">Transfer_To_Course</label>
                    <input type='text' name='Transfer_To_Course' class='form-control' placeholder='Transfer_To_Course' value='<?=$user_data["Transfer_To_Course"]?? ""?>'>
                </div>
                <div class="col-sm-4 col-12">
                        <label for="Transfer_Level" class="form-label">Transfer_Level</label>
                    <select name='Transfer_Level' class='form-control'>
                      <option value='<?=$user_data["Transfer_Level"]?? ""?>'><?=$user_data["Transfer_Level"]?? "Transfer_Level"?></option>
                      <option value="LEVEL - 100">LEVEL - 100</option>
                      <option value="LEVEL - 200">LEVEL - 200</option>
                      <option value="LEVEL - 300">LEVEL - 300</option>
                      <option value="LEVEL - 400">LEVEL - 400</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-6 col-12">
                        <label for="withdraw" class="form-label">Withdraw (<i><small>have you withdraw from the course before?</small></i>) </label>
                    <!-- <input type='text' name='withdraw' class='form-control' placeholder='withdraw' > -->
                    <select name='withdraw' class='form-control'>
                      <option><?=$user_data["withdraw"] ?? "(have you withdraw from the course before?)"?></option>
                      <option value='Yes'>Yes</option>
                      <option value='No'>No</option>
                    </select>
                  </div>
                <div class="col-sm-6 col-12">
                        <label for="Reasons_for_withdrawal" class="form-label">Reasons_for_withdrawal</label>
                    <textarea type='text' name='Reasons_for_withdrawal' placeholder='Reasons_for_withdrawal' class='form-control'><?=$user_data["Reasons_for_withdrawal"]?? ""?></textarea>
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