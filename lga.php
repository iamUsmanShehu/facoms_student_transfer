<?php
include 'includes/config.php'; 
$state_id = $_POST["state_id"];
$query_lga_data = "SELECT * FROM `lga` WHERE state_id = $state_id ";
$query_lga = mysqli_query($conn, $query_lga_data);
while($row = mysqli_fetch_assoc($query_lga)) {
$id = $row['id'];
$lga = $row['name'];
echo '<option value="'.$id.'">'.$lga.'</option>';
}