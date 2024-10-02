<?php
// include("includes/config.php");// Database connection
if (isset($_SESSION['email'])) {
    $student_id =  $_SESSION['id'];

    // Fetch all fields for the user with the specific ID
    $query_passport = "SELECT applicants.passport_path FROM `applicants` WHERE applicants.student_id = ?";
    $stmt = mysqli_prepare($conn, $query_passport);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $passport_data = mysqli_fetch_assoc($result);

    // Close the database connection
    // mysqli_close($conn);
}
?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bgColor">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-success" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
       <div class="user-panel d-flex">
        <div class="image">
              <!-- <i class="bi bi-person p-1 text-success mt-2 elevation-2"></i> -->
          <img src="<?= $passport_data['passport_path'] ?>" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-success"><?=$_SESSION['first_name']?></a>
        </div>
        <li class="nav-item dropdown show">
        <a class="nav-link btn-danger" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="bi bi-sign-out"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right show" style="left: inherit; right: -12px;">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <!-- </div>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->