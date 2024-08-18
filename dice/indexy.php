<?php
session_start();
include './config.php'; 

// Get user details
$username = $_SESSION['username'];
$sql = "SELECT username, email, phone, credits FROM members WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found!";
    exit();
}
?>

    
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="game-container">
        <h1>Dice Game</h1>
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
        <p><strong>Credit Balance:</strong> <span id="creditBalance"><?php echo $user['credits']; ?></span></p>
        <div class="credits">Available Credits: <span id="availableCredits">100</span></div>
        <div class="dice-container">
            <div class="dice" id="dice1">1</div>
            <div class="dice" id="dice2">1</div>
        </div>
        
        <input type="number" id="betAmount" placeholder="Enter bet amount" min="1">
        <div class="potential-winnings" id="potentialWinnings">Potential Winnings: 0</div>
        <button id="rollButton">Roll Dice</button>
        <div class="result" id="result"></div>
    </div>
    <script src="script.js"></script>
</body>
</html>
