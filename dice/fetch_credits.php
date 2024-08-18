<?php
session_start();
include './config.php';
 // Include your database connection file

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$username = $_SESSION['username']; 
// Get username from session

// Query to get credits based on username
$query = "SELECT credits FROM members WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($credits);
$stmt->fetch();
$stmt->close();
$conn->close();

echo json_encode(['credits' => $credits]);
?>
