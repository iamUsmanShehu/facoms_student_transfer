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
a.student_id,
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
pr.name As 'Program',
 -- Choice Of Study 
cs.Present_Institution, cs.Present_Course_of_Study, 
cs.Present_Level, cs.Year_of_Entery, cs.University_Reg_No, 
cs.Transfer_To_Course, cs.Transfer_Level, cs.withdraw, 
cs.Reasons_for_withdrawal
FROM applicants a
  INNER JOIN signup s ON a.student_id = s.id
  INNER JOIN jamb_results j ON a.student_id = j.student_id
  LEFT JOIN olevel o ON a.student_id = o.student_id
  LEFT JOIN payments p ON a.student_id = p.student_id
  JOIN choice_of_study cs ON s.id = cs.applicant_id
  JOIN faculty f ON f.id = cs.faculty
  JOIN programs pr ON pr.id = cs.program
  JOIN states st ON st.id = a.state
  JOIN lga ON lga.id = a.lga
WHERE a.student_id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $applicantId);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
// $stmt = mysqli_prepare($conn, $query);
// if ($stmt === false) {
//     die('Error preparing the statement: ' . htmlspecialchars(mysqli_error($conn)));
// }
// mysqli_stmt_bind_param($stmt, 'i', $applicantId);
// if (!mysqli_stmt_execute($stmt)) {
//     die('Error executing the statement: ' . htmlspecialchars(mysqli_stmt_error($stmt)));
// }

// $result = mysqli_stmt_get_result($stmt);
// if ($result === false) {
//     die('Error getting the result: ' . htmlspecialchars(mysqli_stmt_error($stmt)));
// }

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
  <aside class="main-sidebar bgColor elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="../dist/img/Adustech.png" alt="Adustech Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
  <td colspan=""><b><center>';
  // var_dump($row['decision']);
  // var_dump($applicantId);
  
    $searchQuery = "SELECT * FROM `hod_feedback` WHERE student_id = ?";
    $searchStmt = $conn->prepare($searchQuery);
    $searchStmt->bind_param("i", $applicantId);
    $searchStmt->execute();
    $searchResult = $searchStmt->get_result();
  
    if ($searchResult->num_rows > 0) {

      if ($row['decision'] == 2 || $row['decision'] == 0) {
          // echo '<h3>Decision Making</h3>';
          echo '<a href="status_approve_decline?aid=' .
              $applicantId .
              '" class="btn btn-success">Approve Transfer</a>';
      } elseif ($row['decision'] == 1) {
          // echo '<h3>Decision Making</h3>';
          echo '<a ref="status_approve_decline?did=' .
              $applicantId .
              '" class="btn btn-secondary">Transfer Approved</a>';
      }

    }



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $academic_year = mysqli_real_escape_string($conn, $_POST['academic_year']); 
      $uni_sam_exam_result = mysqli_real_escape_string($conn, $_POST['uni_sam_exam_result']);
      $cgpa = mysqli_real_escape_string($conn, $_POST['cgpa']); 
      $remarks = mysqli_real_escape_string($conn, $_POST['remarks']); 
      $candidate_withdrawn = mysqli_real_escape_string($conn, $_POST['candidate_withdrawn']);
      $reasons_for_withdrawal = mysqli_real_escape_string($conn, $_POST['reasons_for_withdrawal']);
      $source_hod_name = mysqli_real_escape_string($conn, $_POST['source_hod_name']);
      $designation = mysqli_real_escape_string($conn, $_POST['designation']);
      $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
      $hod_id = mysqli_real_escape_string($conn, $_POST['hod_id']); 
      
      $checkQuery = "SELECT COUNT(*) FROM hod_feedback WHERE student_id = ?";
      $checkStmt = mysqli_prepare($conn, $checkQuery);
      
      if ($checkStmt) {
          mysqli_stmt_bind_param($checkStmt, "s", $student_id);
          mysqli_stmt_execute($checkStmt);
          mysqli_stmt_bind_result($checkStmt, $count);
          mysqli_stmt_fetch($checkStmt);
          mysqli_stmt_close($checkStmt);
      
          if ($count > 0) {
              $errorMessage = "<font style='color:red;'>Comment Already Being Made</font>";
          } else {
              // Prepare and execute the SQL query to insert into the programs table
              $insertQuery = "INSERT INTO `hod_feedback`(`student_id`, `hod_id`, `academic_year`, `uni_sam_exam_result`, `cgpa`, `remarks`, `candidate_withdrawn`, `reasons_for_withdrawal`, `source_hod_name`, `designation`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              $insertStmt = mysqli_prepare($conn, $insertQuery);
      
              if ($insertStmt) {
                  mysqli_stmt_bind_param($insertStmt, "iissssssss", $student_id, $hod_id, $academic_year, $uni_sam_exam_result, $cgpa, $remarks, $candidate_withdrawn, $reasons_for_withdrawal, $source_hod_name, $designation);
                  $result = mysqli_stmt_execute($insertStmt);
      
                  if ($result) {
                      $message = "Feedback Submitted Successfully!";
                  } else {
                      $errorMessage = "Error: " . mysqli_error($conn).'';
                  }
      
                  mysqli_stmt_close($insertStmt);
              } else {
                  $errorMessage = "Error in preparing the statement: " . mysqli_error($conn).'';
              }
          }
      } else {
          $errorMessage = "Error in preparing the check statement: " . mysqli_error($conn).'';
      }
      
      }
      






    $hod_fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
    $disignation = $_SESSION['rank'];
    $hod_id = $_SESSION['id'];
    echo '</center></b></td>';
    echo '
    <td>
      <form method=\'POST\' class=\'form\'>';
      if (isset($message)) {echo $message;}
      if (isset($errorMessage)) {echo $errorMessage;}
    echo '<input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' academic_year\' name=\'academic_year\' required>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' University Semester Examination Result\' name=\'uni_sam_exam_result\' required>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' cgpa\' name=\'cgpa\' required>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' remarks\' name=\'remarks\' required>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' candidate_withdrawn\' name=\'candidate_withdrawn\' required>
        <textarea type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' Reasons_for_withdrawal\' name=\'reasons_for_withdrawal\' required></textarea>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' Source HOD Fullname\' name=\'source_hod_name\' value=\''.$hod_fullname.'\' readonly>
        <input type=\'text\' class=\'form-control mb-2 rounded-0\' placeholder=\' Designation\' name=\'designation\' value=\''.$disignation.'\' readonly>
        <input type=\'hidden\' class=\'form-control mb-2 rounded-0\' name=\'student_id\' value=\''.$applicantId.'\'>
        <input type=\'hidden\' class=\'form-control mb-2 rounded-0\' name=\'hod_id\' value=\''.$hod_id.'\'>
        <input type=\'submit\' class=\'btn btn-primary\' value=\' Comment\' >
      </form>
    </td><td>
    </tr>';
    // Display Basic Details
    echo '<td><img src="../' .
        htmlspecialchars($row['Photograph']) .
        '" alt="Applicant Photograph" width="100"></td>';
    echo '</tr>';
?>

    <tr>
         <td class="">Present_Institution:<br> <b><?=$row["Present_Institution"] ?? ''?></b></td>
        <td class="px-2 ">Present_Course_of_Study:<br> <b><?=$row["Present_Course_of_Study"] ?? ''?></b></td>
    </tr> 
    <tr>
        <td class="">Present_Level:<br> <b><?=$row["Present_Level"] ?? ''?></b></td>
        <td class="">Year_of_Entery:<br> <b><?=$row["Year_of_Entery"] ?? ''?></b></td>
    </tr>
    <tr>
        <td class="">University_Reg_No:<br> <b><?=$row["University_Reg_No"] ?? ''?></b></td>
        <td class="">Transfer_To_Course:<br> <b><?=$row["Transfer_To_Course"] ?? ''?></b></td>
    </tr>
    <tr>
        <td class="">Transfer_Level:<br> <b><?=$row["Transfer_Level"] ?? ''?></b></td>
        <td class="">have you withdraw from the course before?<br> <b><?=$row["withdraw"] ?? ''?></b></td>
    </tr>
    <tr>
        <td class="" colspan='2'>Reasons_for_withdrawal:<br> <b><?=$row["Reasons_for_withdrawal"] ?? ''?></b></td>
    </tr>
    
<?php
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
