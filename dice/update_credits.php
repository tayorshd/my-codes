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
$bet_amount = $_POST['bet_amount'];
$result = $_POST['result']; 
// 'win' or 'lose'
$winnings = ($result === 'win') ? $bet_amount * 5 : 0;

// Get current credits
$query = "SELECT credits FROM members WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($current_credits);
$stmt->fetch();
$stmt->close();

// Calculate new credits based on game result
if ($result === 'win') {
    $new_credits = $current_credits + $winnings;
} else {
    $new_credits = $current_credits - $bet_amount;
}

// Ensure the user has enough credits before updating
if ($new_credits < 0) {
    echo json_encode(['error' => 'Insufficient credits']);
    exit;
}

// Update credits in the database
$query = "UPDATE members SET credits = ? WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $new_credits, $username);
$stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['new_credits' => $new_credits]);
?>
