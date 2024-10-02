<?php
include "../includes/config.php"; // Include your database configuration
if (!$_SESSION['id']) {
    header('location: ../login');
}
// Prepare and execute the SQL query with calculated total score and order by total_score
$sql = "SELECT 
    s.id,
    s.first_name,
    s.last_name,
    s.email,
    j.jamb_reg_no,
    SUM(j.english_score + j.subject1_score + j.subject2_score + j.subject3_score) AS total_score
FROM signup s
INNER JOIN jamb_results j ON s.id = j.student_id
GROUP BY s.id
ORDER BY total_score DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>JAMB Total Scores</title>
</head>
<body>

<h2>JAMB Total Scores</h2>

<table border="1">
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>JAMB Registration Number</th>
        <th>Total Score</th>
        <th>Rank</th>
        <th>View</th>
    </tr>

    <?php
    $rank = 1; // Initialize rank
    while ($row = mysqli_fetch_assoc($result)) {
    $applicantId = htmlspecialchars($row['id']);
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jamb_reg_no']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_score']) . "</td>";
        echo "<td>" . $rank . "</td>"; // Display the rank
        echo '<td><a href="view_applications?id=' . $applicantId . '">View</a></td>';
        echo "</tr>";
        $rank++; // Increment rank for the next student
    }
    ?>

</table>

</body>
</html>

<?php
mysqli_close($conn); // Close the database connection
?>
