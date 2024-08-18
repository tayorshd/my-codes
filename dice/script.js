// Function to fetch and display credits
function fetchCredits() {
    fetch('fetch_credits.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('result').textContent = data.error;
                return;
            }
            document.getElementById('availableCredits').textContent = data.credits;
        })
        .catch(error => console.error('Error fetching credits:', error));
}

// Function to update potential winnings
function updatePotentialWinnings() {
    let betAmount = parseInt(document.getElementById('betAmount').value);
    if (isNaN(betAmount) || betAmount <= 0) {
        document.getElementById('potentialWinnings').textContent = 'Potential Winnings: 0';
        return;
    }
    let potentialWinnings = betAmount * 5; // Potential winnings are 5 times the bet amount
    document.getElementById('potentialWinnings').textContent = `Potential Winnings: ${potentialWinnings}`;
}

// Function to shuffle dice
function shuffleDice() {
    const diceElements = [document.getElementById('dice1'), document.getElementById('dice2')];
    const shuffleInterval = setInterval(() => {
        diceElements.forEach(die => {
            die.textContent = Math.floor(Math.random() * 6) + 1;
        });
    }, 100);

    return new Promise(resolve => {
        setTimeout(() => {
            clearInterval(shuffleInterval);
            resolve();
        }, 8000); // Shuffle for 1 second
    });
}

// Roll the dice and handle the bet
document.getElementById('rollButton').addEventListener('click', async function() {
    let betAmount = parseInt(document.getElementById('betAmount').value);

    if (isNaN(betAmount) || betAmount <= 0) {
        document.getElementById('result').textContent = 'Please enter a valid bet amount.';
        return;
    }

    fetch('fetch_credits.php')
        .then(response => response.json())
        .then(async data => {
            if (data.error) {
                document.getElementById('result').textContent = data.error;
                return;
            }

            if (betAmount > data.credits) {
                document.getElementById('result').textContent = 'Insufficient credits!';
                return;
            }

            // Shuffle dice before showing final result
            await shuffleDice();

            // Generate random numbers for each die
            let dice1 = Math.floor(Math.random() * 6) + 1;
            let dice2 = Math.floor(Math.random() * 6) + 1;
            document.getElementById('dice1').textContent = dice1;
            document.getElementById('dice2').textContent = dice2;

            // Determine win or loss
            let win = dice1 + dice2 === 7; // Example win condition (sum of dice equals 7)
            let resultMessage;
            let resultType = win ? 'win' : 'lose';

            // Update credits based on game result
            fetch('update_credits.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    bet_amount: betAmount,
                    result: resultType
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('result').textContent = data.error;
                    return;
                }

                if (win) {
                    resultMessage = `Congratulations! You rolled a ${dice1} and a ${dice2}. You win ${betAmount * 5} credits!`;
                } else {
                    resultMessage = `Sorry, you rolled a ${dice1} and a ${dice2}. You lose your bet of ${betAmount} credits.`;
                }

                document.getElementById('result').textContent = resultMessage;
                document.getElementById('availableCredits').textContent = data.new_credits;
            })
            .catch(error => console.error('Error updating credits:', error));
        })
        .catch(error => console.error('Error fetching credits:', error));
});

// Fetch credits on page load
fetchCredits();

// Attach input event listener to update potential winnings
document.getElementById('betAmount').addEventListener('input', updatePotentialWinnings);
