<?php
include '../includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: ../login');
}
include 'fetch_data.php';

echo $Transfer_To_Course;
// Perform the query
$query = "SELECT * FROM `hod_feedback` hf
JOIN choice_of_study cs ON cs.applicant_id = hf.student_id
 WHERE hf.status = 0 ";

$result = mysqli_query($conn, $query);
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
            <h1 class="m-0">Transfer Request(s)</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Incoming Students</li>
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
      <hr>
            <?php
            if ($result) {
                echo '<table class="table" id="myTable">';
                echo '<thead><tr class=""> <th>student_id</th> <th>hod_id</th>, <th>academic_year</th> <th>uni_sam_exam_result</th> <th>cgpa</th> <th>remarks</th> <th>Withdrawn</th> <th>reasons_for_withdrawal</th>
                  <th>source_hod_name</th> <th>designation</th><th>Actions</th></tr></thead>';

                  if ($_SESSION['rank']=='HOD Computer') {
                    $Transfer_To_Course = 'COMPUTER SCIENCE';
                  }
                  if ($_SESSION['rank']=='HOD Computer') {
                    $Transfer_To_Course = 'INFORMATION TECHNOLOGY';
                  }
                  if ($_SESSION['rank']=='HOD Mathematics') {
                    $Transfer_To_Course = 'MATHEMATICS';
                  }
                  if ($_SESSION['rank']=='HOD STATISTICS') {
                    $Transfer_To_Course = 'STATISTICS';
                  }


                  // || $row['Present_Course_of_Study'] == $Present_Course_of_Study
                while ($row = mysqli_fetch_assoc($result)) {

                  if ($row['Transfer_To_Course']== $Transfer_To_Course ) {
                    
                  
                    $applicantId = $row['student_id'];
                    $hod_id = $row['hod_id'];
                    $academic_year = $row['academic_year'];
                    $uni_sam_exam_result = $row['uni_sam_exam_result'];
                    $cgpa = $row['cgpa'];
                    $remarks = $row['remarks'];
                    $candidate_withdrawn = $row['candidate_withdrawn'];
                    $reasons_for_withdrawal = $row['reasons_for_withdrawal'];
                    $source_hod_name = $row['source_hod_name'];
                    $designation = $row['designation'];
                    

                    echo '<tr>';
                    echo '<td>' . $applicantId . '</td>';
                    echo '<td>' . $hod_id .'</td>';
                    echo '<td>' . $academic_year . '</td>';
                    echo '<td>' . $uni_sam_exam_result . '</td>';
                    echo '<td>' . $cgpa . '</td>';
                    echo '<td>' . $remarks . '</td>';
                    echo '<td>' . $candidate_withdrawn . '</td>';
                    echo '<td>' . $reasons_for_withdrawal . '</td>';
                    echo '<td>' . $source_hod_name . '</td>';
                    echo '<td>' . $designation . '</td>';

                    echo '<td><a class="bg-primary p-2 text-light text-decoration-none rounded" href="view_applications?id=' .
                        $applicantId .
                        '">View</a></td>';
                    echo '</tr>';
                  }
                }
                echo '</table>';

                // Free the result set
                mysqli_free_result($result);
            } else {
                echo 'Query failed: ' . mysqli_error($conn);
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
