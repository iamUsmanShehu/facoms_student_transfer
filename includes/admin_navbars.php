
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
              <i class="bi bi-person p-1 text-success mt-2 elevation-2"></i>
          <!-- <img src="" class="img-circle" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block text-success"><?=$_SESSION['first_name']?></a>
        </div>
      <li class="nav-item dropdown show">
        <a class="nav-link btn-danger" data-toggle="dropdown" href="logout" aria-expanded="true">
          <i class="bi bi-box-arrow-right"></i>
        </a>
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