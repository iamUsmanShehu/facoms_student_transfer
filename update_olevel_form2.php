<?php
include 'includes/config.php'; // Database connection
if (!$_SESSION['id']) {
    header('location: login');
}
include 'admin/fetch_data.php';

// Get data from the AJAX request
$form_flag = 2;
$student_id = $_SESSION['id'];  
$examType = $_POST['exam_type'];
$examNumber = $_POST['exam_no'];
$year = $_POST['year'];
$examCenter = $_POST['exam_center'];
$english = $_POST['english'];
$englishGrade = $_POST['english_grade'];
$maths = $_POST['maths'];
$mathsGrade = $_POST['maths_grade'];
$subject1 = $_POST['subject1'];
$subject1Grade = $_POST['subject1_grade'];
$subject2 = $_POST['subject2'];
$subject2Grade = $_POST['subject2_grade'];
$subject3 = $_POST['subject3'];
$subject3Grade = $_POST['subject3_grade'];
$subject4 = $_POST['subject4'];
$subject4Grade = $_POST['subject4_grade'];
$subject5 = $_POST['subject5'];
$subject5Grade = $_POST['subject5_grade'];
$subject6 = $_POST['subject6'];
$subject6Grade = $_POST['subject6_grade'];
$subject7 = $_POST['subject7'];
$subject7Grade = $_POST['subject7_grade'];

// Check if the record exists
$checkQuery = "SELECT * FROM olevel WHERE student_id = ? AND exam_type = ? AND form_flag = 2";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("is", $student_id, $examType);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
if ($checkResult->num_rows > 0) {
    // Update the existing record
    $updateQuery = "UPDATE olevel SET
    exam_no = ?,
    year = ?,
    exam_center = ?,
    english = ?,
    english_grade = ?,
    maths = ?,
    maths_grade = ?,
    subject1 = ?,
    subject1_grade = ?,
    subject2 = ?,
    subject2_grade = ?,
    subject3 = ?,
    subject3_grade = ?,
    subject4 = ?,
    subject4_grade = ?,
    subject5 = ?,  
    subject5_grade = ?,  
    subject6 = ?,
    subject6_grade = ?,
    subject7 = ?,
    subject7_grade = ?
    WHERE student_id = ? AND exam_type = ? AND form_flag = 2";

$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param("ssssssssssssssssssssssi", 
    $examNumber, $year, $examCenter, 
    $english, $englishGrade, $maths, $mathsGrade, 
    $subject1, $subject1Grade, $subject2, $subject2Grade, 
    $subject3, $subject3Grade, $subject4, $subject4Grade, 
    $subject5, $subject5Grade, $subject6, $subject6Grade, 
    $subject7, $subject7Grade, $student_id, $examType);

if ($updateStmt->execute()) {
    $successMessage = "Data updated successfully";
} else {
    $errorMessage = "Error updating data: " . $updateStmt->error;
}

} else {
    // Insert a new record
    $insertQuery = "INSERT INTO olevel (form_flag, student_id, exam_type, exam_no, year, exam_center, english, english_grade, maths, maths_grade, subject1, subject1_grade, subject2, subject2_grade, subject3, subject3_grade, subject4, subject4_grade, subject5, subject5_grade, subject6, subject6_grade, subject7, subject7_grade)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("iissssssssssssssssssssss", $form_flag, $student_id, $examType, $examNumber, $year, $examCenter, $english, $englishGrade, $maths, $mathsGrade, $subject1, $subject1Grade, $subject2, $subject2Grade, $subject3, $subject3Grade, $subject4, $subject4Grade, $subject5, $subject5Grade, $subject6, $subject6Grade, $subject7, $subject7Grade);

    if ($insertStmt->execute()) {
        $successMessage = "Data Saved successfully";
    } else {
        $errorMessage = "Error inserting data: " . $insertStmt->error;
    }
}

// Close the prepared statements
// $checkStmt->close();
// $updateStmt->close();

// Close the database connection
$conn->close();

