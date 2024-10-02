<p> </p>
<?php
// Include database configuration
include "../includes/config.php";
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Check if ID parameter is provided
if (isset($_GET['id'])) {
    $facultyId = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete faculty
    $query = "DELETE FROM faculty WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $facultyId);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($conn) > 0) {
        $message = "Faculty deleted successfully.";
        header("location:manage_faculty_&_program");
    } else {
        $errorMessage = "Faculty not found or deletion failed.";
    }
} else {
    $errorMessage = "ID parameter is missing.";
}

include "../includes/swal_functions.php";
// Close the database connection
mysqli_close($conn);
?>

<?php include "../includes/swal_script.html"; ?>