<?php
include 'includes/config.php'; 
$faculty_id = $_POST["faculty_id"];
$query_program_data = "SELECT * FROM `programs` WHERE faculty_id = $faculty_id ";
$query_program = mysqli_query($conn, $query_program_data);
while($row = mysqli_fetch_assoc($query_program)) {
$id = $row['id'];
$program = $row['name'];
echo '<option value="'.$id.'">'.$program.'</option>';
}