<?php
// Include database configuration
include "../includes/config.php";
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Check if ID parameter is provided
if (isset($_GET['id'])) {
    $facultyId = mysqli_real_escape_string($conn, $_GET['id']);

    // Display a confirmation alert
    echo "
    <script>
        var confirmDelete = confirm('Are you sure you want to delete this faculty?');
        if (confirmDelete) {
            window.location.href = 'delete_faculty?id=$facultyId';
        } else {
            window.location.href = 'manage_faculty_&_program'; // Redirect to the faculty management page
        }
    </script>
    ";
} else {
    echo "ID parameter is missing.";
}

// Close the database connection
mysqli_close($conn);
?>
