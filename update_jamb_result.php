<?php
require_once("includes/config.php"); // Database connection
include "includes/header_student.php";

if (!$_SESSION['id']) {
    header("location: login");
}

if (isset($_POST['update'])) {
    // Extract and sanitize form data
    $student_id = $_SESSION['id'];
    $jamb_reg_no = mysqli_real_escape_string($conn, $_POST['jamb_reg_no']);
    $english = mysqli_real_escape_string($conn, $_POST['english']);
    $english_score = mysqli_real_escape_string($conn, $_POST['english_score']);
    $subject1 = mysqli_real_escape_string($conn, $_POST['subject1']);
    $subject1_score = mysqli_real_escape_string($conn, $_POST['subject1_score']);
    $subject2 = mysqli_real_escape_string($conn, $_POST['subject2']);
    $subject2_score = mysqli_real_escape_string($conn, $_POST['subject2_score']);
    $subject3 = mysqli_real_escape_string($conn, $_POST['subject3']);
    $subject3_score = mysqli_real_escape_string($conn, $_POST['subject3_score']);

    // Check if the record already exists
    $check_query = "SELECT * FROM jamb_results WHERE student_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "i", $student_id);
    mysqli_stmt_execute($check_stmt);
    $result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($result) > 0) {
        // Record exists, perform an update
        $update_query = "UPDATE jamb_results SET
                         jamb_reg_no = ?,
                         english = ?,
                         english_score = ?,
                         subject1 = ?,
                         subject1_score = ?,
                         subject2 = ?,
                         subject2_score = ?,
                         subject3 = ?,
                         subject3_score = ?
                         WHERE student_id = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "sssssssssi", $jamb_reg_no, $english, $english_score, $subject1, $subject1_score, $subject2, $subject2_score, $subject3, $subject3_score, $student_id);

        if (mysqli_stmt_execute($update_stmt)) {
            $successMessage =  "Data updated successfully!";
            header("refresh:2; url='program'");
        } else {
            $errorMessage =  "Error: " . mysqli_error($conn);
        }
    } else {
        // Record does not exist, perform an insert
        $insert_query = "INSERT INTO jamb_results (student_id, jamb_reg_no, english, english_score, subject1, subject1_score, subject2, subject2_score, subject3, subject3_score)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, "isssssssss", $student_id, $jamb_reg_no, $english, $english_score, $subject1, $subject1_score, $subject2, $subject2_score, $subject3, $subject3_score);

        if (mysqli_stmt_execute($insert_stmt)) {
            $successMessage = "Data inserted successfully!";
            header("refresh:2; url='program'");
        } else {
            $errorMessage =  "Error: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
include "includes/student_swal_functions.php";
?>
<body></body>

<?php include "includes/student_swal_script.html"; ?>
