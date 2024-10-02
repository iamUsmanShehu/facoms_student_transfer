<?php
include '../includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: ../login');
}
include 'fetch_data.php';
// Perform the query
$query = "SELECT a.status, a.id, a.student_id AS applicant_id, a.phone, a.dob, st.name AS 'state', lga.name AS 'lga', a.address, a.next_of_kin, a.nok_address, a.nok_email, a.relation, a.passport_path, s.id AS signup_id, s.first_name, s.last_name, s.email, s.rank, s.status, s.created_at, s.updated_at
FROM applicants a
INNER JOIN signup s ON a.student_id = s.id
JOIN states st ON st.id = a.state
JOIN lga ON lga.id = a.lga WHERE a.status = 2";
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
            <h1 class="m-0">Rejected</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <li class="breadcrumb-item active">Rejected Applications</li>
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
        if ($result) {
            echo '<table  class="table" id="myTable">';
            echo '<thead><tr class=""><th>A-ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Dob</th><th>State</th><th>LGA</th><th>View</th></tr></thead>';
            while ($row = mysqli_fetch_assoc($result)) {
                $applicantId = $row['applicant_id'];
                $firstName = $row['first_name'];
                $lastName = $row['last_name'];
                $email = $row['email'];
                $phone = $row['phone'];
                $dob = $row['dob'];
                $state = $row['state'];
                $lga = $row['lga'];
                
                echo '<tbody>';
                echo '<tr>';
                echo '<td>' . $applicantId . '</td>';
                echo '<td>' . $firstName . ' ' . $lastName . '</td>';
                echo '<td>' . $email . '</td>';
                echo '<td>' . $phone . '</td>';
                echo '<td>' . $dob . '</td>';
                echo '<td>' . $state . '</td>';
                echo '<td>' . $lga . '</td>';
                echo '<td><a class="bg-primary p-2 text-light text-decoration-none rounded" href="view_applications?id=' .
                    $applicantId .
                    '">View</a></td>';
                echo '</tr>';
                echo '</tbody>';
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
