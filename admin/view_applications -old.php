<?php
include '../includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: ../login');
}
include 'fetch_data.php';
// Check if the applicant ID is provided as a parameter
if (isset($_GET['id'])) {

$applicantId = $_GET['id'];

// Prepare a query to fetch details for the selected applicant
$query = "SELECT 
a.passport_path AS Photograph,
a.phone,
a.dob, 
st.name AS 'state',
lga.name AS 'lga',
a.address, 
a.next_of_kin, 
a.nok_address, 
a.nok_email, 
a.relation,
a.status AS decision, 
s.id AS Basic_Details, 
s.first_name, 
s.last_name, 
s.email, 
j.id AS JAMB_Details, 
j.jamb_reg_no, 
j.english, 
j.english_score, 
j.subject1, 
j.subject1_score, 
j.subject2, 
j.subject2_score, 
j.subject3, 
j.subject3_score,
o.id AS Olevel_Details,
o.exam_type, 
o.exam_no, 
o.year, 
o.exam_center, 
o.english AS English_Language, 
o.english_grade, 
o.maths, 
o.maths_grade, 
o.subject1 AS Subject1, 
o.subject1_grade, 
o.subject2 AS Subject2, 
o.subject2_grade, 
o.subject3 AS Subject3, 
o.subject3_grade, 
o.subject4 AS Subject4, 
o.subject4_grade,
p.id AS Payment_Details,
p.status AS payment_status, 
p.reference, 
p.amount, 
p.paid_at, 
p.channel, 
p.currency,
f.name As 'Faculty',
pr.name As 'Program'
FROM applicants a
INNER JOIN signup s ON a.student_id = s.id
INNER JOIN jamb_results j ON a.student_id = j.student_id
LEFT JOIN olevel o ON a.student_id = o.student_id
LEFT JOIN payments p ON a.student_id = p.student_id
JOIN choice_of_study cs ON s.id = cs.applicant_id
JOIN faculty f ON f.id = cs.faculty
JOIN programs pr ON pr.faculty_id = cs.program
JOIN states st ON st.id = a.state
JOIN lga ON lga.id = a.lga
WHERE a.student_id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $applicantId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
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
    <img class="animation__wobble" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <?php include "../includes/admin_navbars.php"; ?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bgColor elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text text-warning">M.A FOUNDATION</span>
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
            <h1 class="m-0">Applicant Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Applicant Details</li>
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
<?php if ($row = mysqli_fetch_assoc($result)) {
    // Get the session ID and other data for the first row
    $session_id = $row['Basic_Details'];

    // Display the details for the selected applicant
    echo '<table class="table">';
    // buttons for decision making
    echo '<tr>';
    echo '
        <td colspan="2"><b><center>';
    // var_dump($row['decision']);
    // var_dump($applicantId);

    if ($row['decision'] == 2 || $row['decision'] == 0) {
        // echo '<h3>Decision Making</h3>';
        echo '<a href="status_approve_decline?aid=' .
            $applicantId .
            '" class="btn btn-success">Approve</a>';
    } elseif ($row['decision'] == 1) {
        // echo '<h3>Decision Making</h3>';
        echo '<a href="status_approve_decline?did=' .
            $applicantId .
            '" class="btn btn-danger">Reject</a>';
    }
    echo '</center></b></td>';
    echo '</tr>';

    // Display Basic Details
    echo '<td><img src="../' .
        htmlspecialchars($row['Photograph']) .
        '" alt="Applicant Photograph" width="100"></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td colspan="2"><b>Basic Details</b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>First Name</td>';
    echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Last Name</td>';
    echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Email</td>';
    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Phone</td>';
    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Date of Birth</td>';
    echo '<td>' . htmlspecialchars($row['dob']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>State</td>';
    echo '<td>' . htmlspecialchars($row['state']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Local Government Area (LGA)</td>';
    echo '<td>' . htmlspecialchars($row['lga']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Address</td>';
    echo '<td>' . htmlspecialchars($row['address']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td colspan="2"><b>Next Of Kin</b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Next of Kin</td>';
    echo '<td>' . htmlspecialchars($row['next_of_kin']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Next of Kin Address</td>';
    echo '<td>' . htmlspecialchars($row['nok_address']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Next of Kin Email</td>';
    echo '<td>' . htmlspecialchars($row['nok_email']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Relation to Next of Kin</td>';
    echo '<td>' . htmlspecialchars($row['relation']) . '</td>';
    echo '</tr>';

    // Display Payment Details
    echo '<tr>';
    echo '<td colspan="2"><b>Payment Details</b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Payment Status</td>';
    echo '<td>' . htmlspecialchars($row['payment_status']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Reference</td>';
    echo '<td>' . htmlspecialchars($row['reference']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Amount</td>';
    echo '<td>&#8358;' . htmlspecialchars(number_format(($row['amount'] / 100), 2)) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Paid At</td>';
    echo '<td>' . htmlspecialchars($row['paid_at']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Channel</td>';
    echo '<td>' . htmlspecialchars($row['channel']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Currency</td>';
    echo '<td>' . htmlspecialchars($row['currency']) . '</td>';
    echo '</tr>';

    // Display Course of Study Details
    echo '<tr>';
    echo '<td colspan="2"><b>Faculty & Course</b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Faculty</td>';
    echo '<td>' . htmlspecialchars($row['Faculty']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>Program</td>';
    echo '<td>' . htmlspecialchars($row['Program']) . '</td>';
    echo '</tr>';

    // Display JAMB Details
    echo '<tr>';
    echo '<td colspan="2"><b>JAMB Details</b></td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>JAMB Registration Number</td>';
    echo '<td>' . htmlspecialchars($row['jamb_reg_no']) . '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' .
        htmlspecialchars($row['english']) .
        '</td>' .
        '<td>' .
        htmlspecialchars($row['english_score']) .
        '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' .
        htmlspecialchars($row['subject1']) .
        '</td>' .
        '<td>' .
        htmlspecialchars($row['subject1_score']) .
        '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' .
        htmlspecialchars($row['subject2']) .
        '</td>' .
        '<td>' .
        htmlspecialchars($row['subject2_score']) .
        '</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' .
        htmlspecialchars($row['subject3']) .
        '</td>' .
        '<td>' .
        htmlspecialchars($row['subject3_score']) .
        '</td>';
    echo '</tr>';
    $total_jamb_score =
        $row['english_score'] +
        $row['subject1_score'] +
        $row['subject2_score'] +
        $row['subject3_score'];
    echo '<tr>';
    echo '<td></td>';
    echo '<td>Total Score:' . $total_jamb_score . ' </td>';
    echo '</tr>';

    $i = 0; // Initialize the counter
    do {
        // Check if the current row belongs to a different session
        if ($row['Basic_Details'] !== $session_id) {
            $session_id = $row['Basic_Details'];
            $i = 0; // Reset the counter for each session
        }

        echo '<tr>';
        echo '<td colspan="2"><b>Olevel Details (' .
            (isset(['First Sitting', 'Second Sitting'][$i]) ? ['First Sitting', 'Second Sitting'][$i] : 'N/A') .
            ')</b></td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Exam Type</td>';
        echo '<td>' . htmlspecialchars($row['exam_type']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Exam Number</td>';
        echo '<td>' . htmlspecialchars($row['exam_no']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Year</td>';
        echo '<td>' . htmlspecialchars($row['year']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Exam Center</td>';
        echo '<td>' . htmlspecialchars($row['exam_center']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>English Language</td>';
        echo '<td>' . htmlspecialchars($row['English_Language']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>English Grade</td>';
        echo '<td>' . htmlspecialchars($row['english_grade']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Maths</td>';
        echo '<td>' . htmlspecialchars($row['maths']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Maths Grade</td>';
        echo '<td>' . htmlspecialchars($row['maths_grade']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Subject</td>';
        echo '<td>' . htmlspecialchars($row['subject1']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Grade</td>';
        echo '<td>' . htmlspecialchars($row['subject1_grade']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Subject</td>';
        echo '<td>' . htmlspecialchars($row['subject2']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Grade</td>';
        echo '<td>' . htmlspecialchars($row['subject2_grade']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Subject</td>';
        echo '<td>' . htmlspecialchars($row['subject3']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Grade</td>';
        echo '<td>' . htmlspecialchars($row['subject3_grade']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Subject</td>';
        echo '<td>' . htmlspecialchars($row['Subject4']) . '</td>';
        echo '</tr>';

        echo '<tr>';
        echo '<td>Grade</td>';
        echo '<td>' . htmlspecialchars($row['subject4_grade']) . '</td>';
        echo '</tr>';
        $i++; // Increment the counter for the next sitting
    } while ($row = mysqli_fetch_assoc($result));

    echo '</table>';

    // "Back" button to return to the list of applicants
    echo '<br>';
    echo '<a href="applications">Back to List</a>';
} else {
    echo "Applicant did not complete the process!.<a href='applications'>Back to List</a>";
}
} else {
    echo 'Applicant ID is not provided.';
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
