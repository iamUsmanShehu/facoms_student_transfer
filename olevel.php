<?php
include 'includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';
if (isset($_SESSION['email'])) {
  $student_id = $_SESSION['id'];

  // Fetch all fields for the user with the specific ID
  $query = 'SELECT * FROM `olevel` WHERE student_id = ? AND form_flag = 1';

  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $student_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user_data = mysqli_fetch_assoc($result);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$system_name?></title>
  <style>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
      margin: 0; 
    }
    .text-color{
        color: #adddb6;
    }
  </style>
<?php include "includes/header_student.php"; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/adustech.png" alt="AdminLTELogo" height="60" width="60">
  </div>

<?php include "includes/navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="dist/img/adustech.png" alt="AdminLTE Logo" class="brand-image img-circle " style="opacity: .8">
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
        <div class="row mb-3">
          <div class="col-sm-6">
            <h1 class="m-0">O'Level</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" class="text-success">Dashboard</a></li>
              <li class="breadcrumb-item active">O'Level</li>
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
        <div class="row p-3">
        <div class="col-sm-6 col-12 border border-[#f3f3f3] p-2">
            <h4 class="m-2 text-uppercase text-info font-weight-bold">First Sitting</h4>
        <form id='dataForm'>
        <!-- Row 1: Exam Information -->     
       <hr>
            <div class="row">
                <div class="col-4">
        <label for="exam_type" class="form-label">Exam Type</label>
        <select class="form-control" name="exam_type" required>
            <option value="<?= $user_data[ 'exam_type'] ?? '' ?>"><?= $user_data[ 'exam_type'] ?? 'Not Selected' ?></option>
            <option value="WAEC">WAEC</option>
            <option value="NECO">NECO</option>
            <option value="NABTEB">NABTEB</option>
        </select>
                </div>
                  <div class="col-8">
                     <label for="exam_no" class="form-label">Exam Number</label>
        <input type="text" class="form-control" name="exam_no" value="<?= $user_data[
            'exam_no'
        ] ?? '' ?>" required>
                </div>
                  <div class="col-4">
                     <label for="year" class="form-label">Year</label>
        <select class="form-control" name="year">
            <option value="<?= $user_data[ 'year'] ?? '' ?>"><?= $user_data[ 'year'] ?? 'Not Selected' ?></option>
             <option value='2015'>2015</option>
            <option value='2016'>2016</option>
            <option value='2017'>2017</option>
            <option value='2018'>2018</option>
            <option value='2019'>2019</option>
            <option value='2020'>2020</option>
             <option value='2021'>2021</option>
            <option value='2022'>2022</option>
            <option value='2023'>2023</option>
            <!-- <option value='2023-11-29'>2023-11-29</option> -->
        </select>
                </div>
                  <div class="col-8">     
        <label for="exam_center" class="form-label">Exam Center</label>
        <input type="text" class="form-control" name="exam_center" value="<?= $user_data[
            'exam_center'
        ] ?? '' ?>" required>
                </div>
            </div>
        <hr>
        <div class="row d-flex justify-content-between">
                    <div class="col-8">
                        <p class="text-uppercase text-bold text-info">Subject</p>
                    </div>
                    <div class="col-4">
                        <p class="text-uppercase text-bold text-info">Grade</p>
                    </div>
                </div>
                <hr>
        <div class="row mb-3">
                 <!-- Row 2: English Grade -->
            <div class="col-8">
                <select type="text" class="form-control" name="english" required>
                    <option><?= $user_data['english'] ?? 'Not Selected' ?></option>
                    <option value="English">English</option>
                </select>
            </div>
 <div class="col-4">
    <select class="form-control" name="english_grade" required>
            <option><?= $user_data['english_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
 </div>
                    </div>
                    <div class="row mb-3">
<div class="col-8">
                 <!-- Row 3: Math Grade -->
        <select type="text" class="form-control" name="maths" required>
            <option><?= $user_data['maths'] ?? 'Not Selected' ?></option>
            <option value="Mathematics">Mathematics</option>
        </select>
        </div>
        <div class="col-4">
 <select class="form-control" name="maths_grade" required>
            <option><?= $user_data['maths_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
            </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 4: Subject1 Grade -->
        <!-- <label for="subject1">Subject1:</label> -->
        <select type="text" class="form-control" name="subject1">
            <option><?= $user_data['subject1'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
</div>
<div class="col-4">
    <select class="form-control" name="subject1_grade" required>
            <option><?= $user_data['subject1_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
</div>
    </div>
    <div class="row mb-3">
<div class="col-8">
        <!-- Row 5: Subject2 Grade -->
        <!-- <label for="subject2">Subject2:</label> -->
        <select type="text" class="form-control" name="subject2" required>
            <option><?= $user_data['subject2'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject2_grade" required>
        <option><?= $user_data['subject2_grade'] ?? 'Grade' ?></option>
           <?php include "grades_options.php"; ?>
        </select>
        </div>
</div>
<div class="row mb-3">
    <div class="col-8">
        <!-- Row 6: Subject3 Grade -->
        <!-- <label for="subject3">Subject3:</label> -->
        <select type="text" class="form-control" name="subject3" required>
            <option><?= $user_data['subject3'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject3_grade" required>
            <option><?= $user_data['subject3_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 7: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
        <select class="form-control" type="text" name="subject4" required>
            <option><?= $user_data['subject4'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
        <select class="form-control" name="subject4_grade" required>
            <option><?= $user_data['subject4_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
<div class="row mb-3">
<div class="col-8">
 <!-- Row 8: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
        <select type="text" class="form-control" name="subject5" required>
            <option><?= $user_data['subject5'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject5_grade" required>
            <option><?= $user_data['subject5_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 7: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
       <select type="text" class="form-control" name="subject6" required>
            <option><?= $user_data['subject6'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
    </div>
    <div class="col-4">
<select class="form-control" name="subject6_grade" required>
            <option><?= $user_data['subject6_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
    </div>
    </div>
<div class="row mb-3">
    <div class="col-8">
         <!-- Row 8: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
       <select type="text" class="form-control" name="subject7" required>
            <option><?= $user_data['subject7'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
        <select class="form-control" name="subject7_grade" required>
            <option><?= $user_data['subject7_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
<div class="row mt-2">
    <div class="col-4">
        
    </div>
    <div class="col-4">
        <button type="submit" class="btn btn-success px-3" name="update">Save</button>
    </div>
    <div class="col-4">
        
    </div>
</div>
</div>
</form>

<?php
if (isset($_SESSION['email'])) {
  $student_id = $_SESSION['id'];

  // Fetch all fields for the user with the specific ID
  $query_form_2 = 'SELECT * FROM `olevel` WHERE student_id = ? AND form_flag = 2';

  $stmt = mysqli_prepare($conn, $query_form_2);
  mysqli_stmt_bind_param($stmt, 'i', $student_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $form_2_user_data = mysqli_fetch_assoc($result);
  // Close the database connection
  mysqli_close($conn);
}
?>
            <div class="col-sm-6 col-12 border border-left-0 border-[#f3f3f3] p-2">
                <h4 class="m-2 text-uppercase text-info font-weight-bold">Second Sitting</h4>
 <form id="dataForm2">
        <!-- Row 1: Exam Information -->     
       <hr>
            <div class="row">
                <div class="col-4">
        <label for="exam_type" class="form-label">Exam Type</label>
        <select class="form-control" name="exam_type" required>
            <option value="<?= $form_2_user_data[ 'exam_type'] ?? '' ?>"><?= $form_2_user_data[ 'exam_type'] ?? 'Not Selected' ?></option>
            <option value="WAEC">WAEC</option>
            <option value="NECO">NECO</option>
            <option value="NABTEB">NABTEB</option>
        </select>
                </div>
                  <div class="col-8">
                     <label for="exam_no" class="form-label">Exam Number</label>
        <input type="text" class="form-control" name="exam_no" value="<?= $form_2_user_data[
            'exam_no'
        ] ?? '' ?>" required>
                </div>
                  <div class="col-4">
                     <label for="year" class="form-label">Year</label>
        <select class="form-control" name="year">
            <option value="<?= $form_2_user_data[ 'year'] ?? '' ?>"><?= $form_2_user_data[ 'year'] ?? 'Not Selected' ?></option>
             <option value='2017'>2015</option>
            <option value='2016'>2016</option>
            <option value='2017'>2017</option>
            <option value='2018'>2018</option>
            <option value='2019'>2019</option>
            <option value='2020'>2020</option>
             <option value='2021'>2021</option>
            <option value='2022'>2022</option>
            <option value='2023'>2023</option>
            <!-- <option value='2023-11-29'>2023-11-29</option> -->
        </select>
                </div>
                  <div class="col-8">     
        <label for="exam_center" class="form-label">Exam Center</label>
        <input type="text" class="form-control" name="exam_center" value="<?= $form_2_user_data[
            'exam_center'
        ] ?? '' ?>" required>
                </div>
            </div>
        <hr>
        <div class="row m-2">
                    <div class="col-8">
                        <p class="text-uppercase text-bold text-info">Subject</p>
                    </div>
                    <div class="col-4">
                        <p class="text-uppercase text-bold text-info">Grade</p>
                    </div>
                </div>
                <hr>
        <div class="row mb-3">
                 <!-- Row 2: English Grade -->
            <div class="col-8">
                <select type="text" class="form-control" name="english" required>
                    <option><?= $form_2_user_data['english'] ?? 'Not Selected' ?></option>
                    <option value="English">English</option>
                </select>
            </div>
 <div class="col-4">
    <select class="form-control" name="english_grade" required>
            <option><?= $form_2_user_data['english_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
 </div>
                    </div>
                    <div class="row mb-3">
        <div class="col-8">
                 <!-- Row 3: Math Grade -->
                 <select type="text" class="form-control" name="maths" required>
                    <option><?= $form_2_user_data['maths'] ?? 'Not Selected' ?></option>
                    <option value="Maths">English</option>
                </select>
        </div>
        <div class="col-4">
 <select class="form-control" name="maths_grade" required>
            <option><?= $form_2_user_data['maths_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
            </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 4: Subject1 Grade -->
        <!-- <label for="subject1">Subject1:</label> -->
        <select type="text" class="form-control" name="subject1">
            <option><?= $form_2_user_data['subject1'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
</div>
<div class="col-4">
    <select class="form-control" name="subject1_grade" required>
            <option><?= $form_2_user_data['subject1_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
</div>
    </div>
    <div class="row mb-3">
<div class="col-8">
        <!-- Row 5: Subject2 Grade -->
        <!-- <label for="subject2">Subject2:</label> -->
        <select type="text" class="form-control" name="subject2" required>
            <option><?= $form_2_user_data['subject2'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject2_grade" required>
        <option><?= $form_2_user_data['subject2_grade'] ?? 'Grade' ?></option>
           <?php include "grades_options.php"; ?>
        </select>
        </div>
</div>
<div class="row mb-3">
    <div class="col-8">
        <!-- Row 6: Subject3 Grade -->
        <!-- <label for="subject3">Subject3:</label> -->
        <select type="text" class="form-control" name="subject3" required>
            <option><?= $form_2_user_data['subject3'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject3_grade" required>
            <option><?= $form_2_user_data['subject3_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 7: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
        <select class="form-control" type="text" name="subject4" required>
            <option><?= $form_2_user_data['subject4'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
        <select class="form-control" name="subject4_grade" required>
            <option><?= $form_2_user_data['subject4_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
<div class="row mb-3">
    <div class="col-8">
 <!-- Row 8: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
        <select type="text" class="form-control" name="subject5" required>
            <option><?= $form_2_user_data['subject5'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
<select class="form-control" name="subject5_grade" required>
            <option><?= $form_2_user_data['subject5_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
    <div class="row mb-3">
<div class="col-8">
 <!-- Row 7: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
       <select type="text" class="form-control" name="subject6" required>
            <option><?= $form_2_user_data['subject6'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
    </div>
    <div class="col-4">
<select class="form-control" name="subject6_grade" required>
            <option><?= $form_2_user_data['subject6_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
    </div>
    </div>
<div class="row mb-3">
    <div class="col-8">
         <!-- Row 8: Subject4 Grade -->
        <!-- <label for="subject4">Subject4:</label> -->
       <select type="text" class="form-control" name="subject7" required>
            <option><?= $form_2_user_data['subject7'] ?? 'Not Selected' ?></option>
            <?php include "subjects_options.php"; ?>
        </select>
        </div>
        <div class="col-4">
        <select class="form-control" name="subject7_grade" required>
            <option><?= $form_2_user_data['subject7_grade'] ?? 'Grade' ?></option>
            <?php include "grades_options.php"; ?>
        </select>
        </div>
    </div>
<div class="row mt-2">
    <div class="col-4">
        
    </div>
    <div class="col-4">
        <button type="submit" class="btn btn-success px-3" name="update" onclick="submitForm2()">Save</button>
    </div>
    <div class="col-4">
        
    </div>
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
  <?php include "includes/footer_content.php"; ?>
</div>
<!-- ./wrapper -->
<?php include "includes/footer.php"; ?>
</body>
</html>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // script to handle form submission
    function submitForm() {
        var formData = $('#dataForm').serialize();
        $.ajax({
            type: 'POST',
            url: 'update_olevel',
            data: formData,
            success: function(response) {
                Swal.fire({
                title: "Saved ",
                text: "Successfully Saved!",
                icon: "success"
                });
            },
            error: function(error) {
                Swal.fire({
                title: "error ",
                text: "Data not Saved!",
                icon: "error"
                });
            }
        });
    }

    $(document).ready(function() {
        $('#dataForm').submit(function(e) {
            e.preventDefault();
            submitForm();
        });
    });


    // script to handle form submission
    function submitForm2() {
        var Data = $('#dataForm2').serialize();
        $.ajax({
            type: 'POST',
            url: 'update_olevel_form2',
            data: Data,
            success: function(response) {
                Swal.fire({
                title: "Saved ",
                text: "Successfully Saved!",
                icon: "success"
                });
            },
            error: function(error) {
                Swal.fire({
                title: "error ",
                text: "Data not Saved!",
                icon: "error"
                });
            }
        });
    }

    $(document).ready(function() {
        $('#dataForm2').submit(function(e) {
            e.preventDefault();
            submitForm2();
        });
    });
</script>



<?php include "includes/student_swal_functions.php";
include "includes/student_swal_script.html"; ?>