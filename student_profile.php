<?php
include 'includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';
if (isset($_SESSION['email'])) {
    $student_id = $_SESSION['id'];

    // Fetch selected fields for the Student with the specific ID
    $query = 'SELECT 
      states.id AS "state_id",
      states.name AS "states",
      lga.id AS "lga_id",
      lga.name AS "lga",
      applicants.passport_path,
      applicants.phone,
      applicants.dob,
      applicants.address,
      applicants.next_of_kin,
      applicants.nok_address,
      applicants.nok_email,
      applicants.relation 
    FROM `applicants`
    JOIN states ON applicants.state = states.id
    JOIN lga ON applicants.lga = lga.id
    WHERE applicants.student_id = ?';

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_data = mysqli_fetch_assoc($result);

// Fetch all fields for the Student with the specific ID
    $query_signup = 'SELECT * FROM `signup` WHERE id = ?';

    $stmt = mysqli_prepare($conn, $query_signup);
    mysqli_stmt_bind_param($stmt, 'i', $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user_signup_data = mysqli_fetch_assoc($result);
}
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
    <img class="animation__wobble" src="dist/img/adustech.png" alt="AdminLTELogo" height="60" width="60">
  </div>

<?php include "includes/navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="dist/img/adustech.png" alt="adustech.png Logo" class="brand-image img-circle" style="opacity: .8">
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
            <h1 class="m-0">MyProfile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#" class="text-success">Home</a></li>
              <li class="breadcrumb-item active">MyProfile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid m-1" style="background:white;padding: 10px;">
        <div >
        <hr>
<div class="container">
    <form method="post" id="dataForm" enctype="multipart/form-data">
        <div class="row mb-2">
        <?php if (!empty($user_data['passport_path'])) { ?>
            <img src="<?= $user_data[
                'passport_path'
            ] ?>" alt="Passport Image" style="max-width: 100px;">
        <?php } ?>
        <div class="col-sm-6 col-8 mb-2">
  <label for="formFile" class="form-label">Upload Passport</label>
  <input class="form-control border-success" type="file" name="passport" accept=".jpg, .jpeg, .png" id="formFile" value="<?= $user_data[
      'passport_path'
  ] ?? '' ?>" required><!-- accept="image/*" -->
</div>
  </div>
</div>
</div>
<div class="row mb-2">
  <div class="col-sm-4 col-6">
        <label for="first_name" class="form-label">First Name</label>
          <input type="text" name="first_name" class="form-control" value="<?= $user_signup_data[
              'first_name'
          ] ?? '' ?>" required>
  </div>
  <div class="col-sm-4 col-6">
      <label for="last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="last_name" value="<?= $user_signup_data[
              'last_name'
          ] ?? '' ?>" required>
  </div>
  <div class="col-sm-4 col-6">
      <label for="other_name"  class="form-label">Other Name</label>
          <input type="text" class="form-control" name="other_name" value="<?= $user_signup_data[
              'other_name'
          ] ?? '' ?>">
  </div>
</div>
<hr>
<div class="row mb-2">
    <div class="col-sm-4 col-6">
 <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= $user_signup_data[
            'email'
        ] ?? '' ?>" required>
    </div>
<div class="col-sm-4 col-6">
             <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= $user_data[
            'phone'
        ] ?? '' ?>" required>
        </div>
        <div class="col-sm-4 col-6">
<label for="dob" class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control" value="<?= $user_data[
            'dob'
        ] ?? '' ?>" required>
        </div>
</div>
<hr>
    <div class="row mb-2">
        <div class="col-sm-4 col-6">
              <label for="" class="form-label">State</label>
          <select name="state" id="state" onchange="fetch_LGAs(this.value)" class="form-control" autocomplete="off" class="select" required>
          <option value="<?=$user_data["state_id"]?? 'Null ID'?>"><?=$user_data["states"]?? 'Select State...'?></option>
          <?php
                $query_states_data = "SELECT * FROM `states` ";
                $query_states = mysqli_query($conn, $query_states_data);
                while($row = mysqli_fetch_assoc($query_states)) {
                $id = $row['id'];
                $states = $row['name'];

                echo '<option value="'.$id.'">'.$states.'</option>';
                }
            ?>
        </select>
        </div>
        <div class="col-sm-4 col-6">
              <label for="lga" class="form-label">Local Government</label>
        <select name="lga" id="lga" class="form-control" autocomplete="off" class="lga" required>
          <option value="<?=$user_data["lga_id"]?? 'Null ID'?>"><?=$user_data['lga']?? 'Select LGA...'?></option>
        </select>
        </div>
    </div>
    <hr>
    <div class="row mb-2">
<div class="col-sm-4 col-6">
<label for="address" class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="4" required cols="50"><?= $user_data[
            'address'
        ] ?? '' ?></textarea>
</div>
<div class="col-sm-4 col-6">
<label for="nok_address" class="form-label">Next of Kin Address</label>
        <textarea name="nok_address" class="form-control" rows="4" required cols="50"><?= $user_data[
            'nok_address'
        ] ?? '' ?></textarea>
</div>
</div>
<hr>
<div class="row mb-2">
<div class="col-sm-4 col-6">
<label for="next_of_kin" class="form-label">Next of Kin</label>
        <input type="text" class="form-control" name="next_of_kin" value="<?= $user_data[
            'next_of_kin'
        ] ?? '' ?>" required>
</div>
<div class="col-sm-4 col-6">
    <label for="nok_email" class="form-label">Next of Kin Email</label>
        <input type="email" class="form-control" name="nok_email" value="<?= $user_data[
            'nok_email'
        ] ?? '' ?>" required>
</div>
<div class="col-sm-4 col-12">
<label for="relation" class="form-label">Relationship</label>
        <input type="text" class="form-control" name="relation" value="<?= $user_data[
            'relation'
        ] ?? '' ?>" required>
</div>
    </div>
    <hr>
    <div class="row mb-2">
<div class="col-12">
 <button type="submit" name="update" class="btn btn-success px-3">Save</button>
</div>
    </div>       
        </div>
    </form>
    </div>
    </main>
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

<?php include "includes/footer_content.php"; ?>
</div>
<!-- ./wrapper -->
<?php include "includes/footer.php"; ?>

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function fetch_LGAs(id){
    $('#lga').html('');
    $.ajax({
      type:"POST",
      url:'lga',
      data: {state_id:id},
      success: function(data){
        $('#lga').html(data);
      }
    })
  }
  function submitForm() {
    var formData = new FormData($('#dataForm')[0]);

    $.ajax({
        type: 'POST',
        url: 'update_profile',
        data: formData,
        processData: false,
        contentType: false,
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


</script>
      
</body>
</html>
