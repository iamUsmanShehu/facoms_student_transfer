<meta name="viewport" content="width=device-width, initial-scale=1">
<p></p>
<?php 
include "../includes/config.php"; // Include your database configuration
include "../includes/header.php";
// Check if the decision has been made
if (isset($_GET['aid'])) {
    // Approve the applicant
    $applicantId = $_GET['aid'];
    $sql = "UPDATE applicants SET status = 1 WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $applicantId);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Applicant approved successfully.";
        header("refresh:2; url='applications'");
    } else {
        $errorMessage = "Failed to approve the applicant.";
        header("refresh:2; url='applications'");
    }
} elseif (isset($_GET['did'])) {
    // Decline the applicant
    $applicantId = $_GET['did'];
    $sql = "UPDATE applicants SET status = 2 WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $applicantId);
    if (mysqli_stmt_execute($stmt)) {
        $message = "Applicant rejected successfully.";
        header("refresh:2; url='applications'");
    } else {
        $errorMessage = "Failed to reject the applicant.";
        header("refresh:2; url='applications'");
    }
}

include "../includes/swal_functions.php";
include "../includes/swal_script.html"; 