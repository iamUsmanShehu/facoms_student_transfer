<?php
include 'includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';

if (isset($_SESSION['email'])) {
  $user_id = $_SESSION['id'];

  // Fetch all fields for the user with the specific ID
  $query = 'SELECT * FROM `jamb_results` WHERE student_id = ?';

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $user_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user_data = mysqli_fetch_assoc($result);
  // Close the database connection
  // mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?></title>
<?php include "includes/header_student.php"; ?>
<script>
        function calculateTotalScore() {
            // Get the individual subject scores
            var englishScore = parseFloat(document.getElementById("english").value) || 0;
            var subject1Score = parseFloat(document.getElementById("subject1").value) || 0;
            var subject2Score = parseFloat(document.getElementById("subject2").value) || 0;
            var subject3Score = parseFloat(document.getElementById("subject3").value) || 0;

            // Calculate the total score
            var totalScore = englishScore + subject1Score + subject2Score + subject3Score;

            // Display the total score
            document.getElementById("totalScore").innerHTML = "Total Score: " + totalScore + " <small><i>real time</i></small>";
        }
    </script>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/adustech.png" alt="adustech logo" height="60" width="60">
  </div>

<?php include "includes/navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="dist/img/adustech.png" alt="adustech Logo" class="brand-image img-circle " style="opacity: .8">
      <span class="brand-text text-success font-weight-bold">FACOMS</span>
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
            <h1 class="m-0">JAMB Result</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" class="text-success">Dashboard</a></li>
              <li class="breadcrumb-item active">JAMB Result</li>
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
        <form method="POST" action="update_jamb_result">
          <div class="row mb-2">
              <div class="col-6">
           <label for="jamb_reg_no" class="form-label">JAMB Registration Number</label><br>
                  <input type="text" class="form-control" id="jamb_reg_no" name="jamb_reg_no" placeholder="Enter registration number" value="<?= $user_data[
                      'jamb_reg_no'
                  ] ?? '' ?>" required>
              </div>
          </div>
          <hr>
                      <div class="row mb-2">
                          <div class="col-6">
           <input type="text" class="form-control mb-2" name="english" value="English" readonly>
                  <input type="number" class="form-control w-50" id="english" name="english_score" placeholder="Enter score" value="<?= $user_data[
                      'english_score'
                  ] ?? '' ?>" oninput="calculateTotalScore()">
                          </div>
                          
                          <div class="col-6">
           <input type="text" class="form-control mb-2" name="subject1" placeholder="Enter Subject" value="<?= $user_data[
               'subject1'
           ] ?? '' ?>">
                  <input type="number" class="form-control w-50" id="subject1" name="subject1_score" placeholder="Enter score" value="<?= $user_data[
                      'subject1_score'
                  ] ?? '' ?>" oninput="calculateTotalScore()">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <div class="col-6">
          <input type="text" class="form-control mb-2" name="subject2" placeholder="Enter Subject" value="<?= $user_data[
              'subject2'
          ] ?? '' ?>">
                  <input type="number" class="form-control w-50" id="subject2" name="subject2_score" placeholder="Enter score" value="<?= $user_data[
                      'subject2_score'
                  ] ?? '' ?>" oninput="calculateTotalScore()">
                          </div>
                          <div class="col-6">
          <input type="text" class="form-control mb-2"  name="subject3" placeholder="Enter Subject" value="<?= $user_data[
              'subject3'
          ] ?? '' ?>">
                  <input type="number" class="form-control w-50" id="subject3" name="subject3_score" placeholder="Enter score" value="<?= $user_data[
                      'subject3_score'
                  ] ?? '' ?>" oninput="calculateTotalScore()">
                          </div>
                      </div>
                      <div class="row mb-2">
                          <div class="col-12">
           <!-- Display the total score here -->
                  <label id="totalScore" style="display: block;">Total Score: 0</label>
                          </div>
                  </div>
                  <div class="row mb-2">
                       <div class="col-6">
                      <button type="submit" class="btn btn-success" name="update">Save</button>
                  </div>
                  </div>
              </form>
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
