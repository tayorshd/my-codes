<?php
session_start();
include './config.php'; 
// Check if user is logged in and is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../../sign-in.php");

    exit();
}
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
    
    <!-- meta tags and other links -->
    <!DOCTYPE html>
<html lang="en">

<!-- Mirrored from template.viserlab.com/casinous/demo/game-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Aug 2024 23:19:05 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice - Online Casino Platform</title>

    <link rel="icon" type="image/png" href="../../assets/images/favicon.png" sizes="16x16">
    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="../../assets/css/lib/bootstrap.min.css">
    <!-- Icon Link  -->
    <link rel="stylesheet" href="../../assets/css/all.min.css"> 
    <link rel="stylesheet" href="../../assets/css/line-awesome.min.css"> 
    <link rel="stylesheet" href="../../assets/css/lib/animate.css"> 

    <!-- Plugin Link -->
    <link rel="stylesheet" href="../../assets/css/lib/slick.css">
    <link rel="stylesheet" href="stylesy.css">

    <!-- Main css -->
    <link rel="stylesheet" href="../../assets/css/main.css">

</head>
    <body data-bs-spy="scroll" data-bs-offset="170" data-bs-target=".privacy-policy-sidebar-menu">

        <div class="overlay"></div>
        <div class="preloader">
            <div class="scene" id="scene">
                <input type="checkbox" id="andicator" />
                <div class="cube">
                    <div class="cube__face cube__face--front"><i></i></div>
                    <div class="cube__face cube__face--back"><i></i><i></i></div>
                    <div class="cube__face cube__face--right">
                        <i></i> <i></i> <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--left">
                        <i></i> <i></i> <i></i> <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--top">
                        <i></i> <i></i> <i></i>
                    </div>
                    <div class="cube__face cube__face--bottom">
                        <i></i> <i></i> <i></i> <i></i>
                    </div>
                </div>
            </div>
        </div>

    <div class="header">
    <div class="container">
        <div class="header-bottom">
            <div class="header-bottom-area align-items-center">
                <div class="logo"><a href="index.html"><img src="../../assets/images/logo.png" alt="logo"></a></div>
                <ul class="menu">
                <li>
                        <a href="buy_credit.php">Add Credit</a>
                    </li>
                    <li>
                        <a href="../../users_dashboard.php">Home</a>
                    </li>
                    <li>
                        <a href="../../about.html">About</a>
                    </li>
                    <li>
                        <a href="../../games.php">Games <span class="badge badge--sm badge--base text-dark">NEW</span></a>
                    </li>
                    <li>
                        <a href="../../faq.html">Faq</a>
                    </li>
                    
                    <li>
                        <a href="../../contact.php">Contact</a>
                        <ul class="sub-menu">
                            <li><a href="../../blog.html">Blog</a></li>
                            <li><a href="../../blog-details.html">Blog Details</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="../../logout.php">SignOut</a>
                    </li>
                    <button class="btn-close btn-close-white d-lg-none"></button>
                </ul>
                <div class="header-trigger-wrapper d-flex d-lg-none align-items-center">
                    <div class="header-trigger me-4">
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- inner hero section start -->
<section class="inner-banner bg_img" style="background: url('../../assets/images/inner-banner/bg2.jpg') top;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-xl-6 text-center">
        <h2 class="title text-white">Dice Details</h2>
        <ul class="breadcrumbs d-flex flex-wrap align-items-center justify-content-center">
          <li><a href="index.html">Home</a></li>
          <li>Game Details</li>     

        </ul>
      </div>
    </div>
  </div>
</section>
<!-- credit notitification -->

<!-- inner hero section end -->

    <section class="padding-top padding-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-6">
                    <div class="game-details-left">
                        <div id="coin-flip-cont">
                            <div class="coins-wrapper">
                                <div class="front"><img src="../../assets/images/game/item4.png" class="rounded-circle" alt="game"></div>
                                <div class="back"><img src="../../assets/images/game/dice.jpg" class="rounded-circle" alt="game"></div>
                            </div>
                        </div>
                        <div class="cd-ft"></div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="game-details-right">

                    
                            <h3 class="mb-4 text-center">Welcome : <span class="base--color"><span class="bal"><?php echo htmlspecialchars($user['username']); ?></span></span></h3>

                            <h3 class="mb-4 text-center">Current Balance : <span class="base--color"><span class="bal"><?php echo htmlspecialchars($user['credits']); ?></span> NG</span></h3>
                            <h3 class="mb-4 text-center"><span class="base--color"><span id="potentialWinnings">0</span> NG</span></h3>
                            <div class="dice-container">
                                    <div class="dice bg--danger" id="dice1">1</div>
                                    <div class="dice bg--success" id="dice2">1</div>
                                </div>
                            <div id="wheelResult" class="mb-4 text-center bg--info"></div>
                            <div id="result" class="mb-4 text-center bg--primary"></div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                
                                    <input type="number" id="betAmount" class="form-control form--control amount-field" placeholder="Enter amount in NG">
                                </div>
                                <small class="form-text text-muted"><i class="fas fa-info-circle mr-2"></i>Minimum: 100 NG | Maximum: 500.00 NG | 
                                <span class="text-warning">Win Amount 500 %</span></small>
                            </div>
                        
                        
                            <div class="mt-5 text-center">
                                <button id="rollButton" class="cmn--btn active w-100 text-center">Play Now</button>
                                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter" class="mt-3 btn btn-link btn--sm radius-5">Game Instruction <i class="las la-info-circle"></i></a>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Game Section Starts Here -->
    <section class="game-section padding-top padding-bottom bg_img" style="background: url(../../assets/images/game/bg3.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6">
                    <div class="section-header text-center">
                        <h2 class="section-header__title">You may Also Like</h2>
                        <p>These are some interesting game challenge to make more cash in your wallet through trusted and realiable lucky draws.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="game-item">
                        <div class="game-inner">
                            <div class="game-item__thumb">
                                <img src="../../assets/images/game/item2.png" alt="game">
                            </div>
                            <div class="game-item__content">
                                <h4 class="title">Slot Machine</h4>
                                <p class="invest-info">Invest Limit</p>
                                <p class="invest-amount">$100.49 - $1,000</p>
                                <a href="../../games/kenoballs" class="cmn--btn active btn--md radius-0">Play Now</a>
                            </div>
                        </div>
                        <div class="ball"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="game-item">
                        <div class="game-inner">
                            <div class="game-item__thumb">
                                <img src="../../assets/images/game/item1.png" alt="game">
                            </div>
                            <div class="game-item__content">
                                <h4 class="title">Slot Machine</h4>
                                <p class="invest-info">Invest Limit</p>
                                <p class="invest-amount">$100.49 - $1,000</p>
                                <a href="../../games/slotmachine" class="cmn--btn active btn--md radius-0">Play Now</a>
                            </div>
                        </div>
                        <div class="ball"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="game-item">
                        <div class="game-inner">
                            <div class="game-item__thumb">
                                <img src="../../assets/images/game/item3.png" alt="game">
                            </div>
                            <div class="game-item__content">
                                <h4 class="title">Pocker Game</h4>
                                <p class="invest-info">Invest Limit</p>
                                <p class="invest-amount">$100.49 - $1,000</p>
                                <a href="../../games/pokergame" class="cmn--btn active btn--md radius-0">Play Now</a>
                            </div>
                        </div>
                        <div class="ball"></div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
                    <div class="game-item">
                        <div class="game-inner">
                            <div class="game-item__thumb">
                                <img src="../../assets/images/game/item4.png" alt="game">
                            </div>
                            <div class="game-item__content">
                                <h4 class="title">Dice</h4>
                                <p class="invest-info">Invest Limit</p>
                                <p class="invest-amount">$100.49 - $1,000</p>
                                <a href="../../games/dice" class="cmn--btn active btn--md radius-0">Play Now</a>
                            </div>
                        </div>
                        <div class="ball"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Game Section Ends Here -->


    <div class=" modal custom--modal fade show" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"  aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content section-bg border-0">
                <div class="modal-header modal--header bg--base">
                    <h4 class="modal-title text-dark" id="exampleModalLongTitle">Game Rules</h4>
                </div>
                <div class="modal-body modal--body">
                    <h3 class="title mb-2">Before Game Start: </h3>
                    <p>How to Play the Virtual Dice Game

Log in and navigate to the Dice Game section.
Place Your Bet: Choose your bet amount and predict the outcome (e.g., specific number, odd/even, high/low).
Roll the Dice: Click the "Roll Dice" button to see the result.
Win or Lose: If your prediction is correct, you win; if not, you lose the bet amount.
Play Again or Cash Out: Roll again or collect your winnings.

Enjoy the game!</p>
                </div>
                <div class="modal-footer modal--footer">
                    <button type="button" class="btn btn--danger btn--md" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer Section Starts Here -->
<footer class="footer-section bg_img" style="background: url(../../assets/images/footer/bg.jpg) center;">
    <div class="footer-top">
        <div class="container">
            <div class="footer-wrapper d-flex flex-wrap align-items-center justify-content-md-between justify-content-center">
                <div class="logo mb-3 mb-md-0"><a href="index.html"><img src="../../assets/images/logo.png" alt="logo"></a></div>
                <ul class="footer-links d-flex flex-wrap justify-content-center">
                    <li><a href="games.html">Games</a></li>
                    <li><a href="terms-conditions.html">Terms & Conditions</a></li>
                    <li><a href="policy.html">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-wrapper d-flex flex-wrap justify-content-center align-items-center text-center">
                <p class="copyright text-white">Copyrights &copy; 2024 All Rights Reserved by <a href="#0" class=" text--base ms-2">Viserlab</a></p>
            </div>
        </div>
    </div>
    <div class="shapes">
        <img src="../../assets/images/footer/shape.png" alt="footer" class="shape1">
    </div>
</footer>
<!-- Footer Section Ends Here -->
<script src="script.js"></script>


<!-- jQuery library -->
<script src="../../assets/js/lib/jquery-3.6.0.min.js"></script>
<!-- bootstrap 5 js -->
<script src="../../assets/js/lib/bootstrap.min.js"></script>

<!-- Pluglin Link -->
<script src="../../assets/js/lib/slick.min.js"></script>

<!-- main js -->
<script src="../../assets/js/main.js"></script>  
</body>

<!-- Mirrored from template.viserlab.com/casinous/demo/game-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 02 Aug 2024 23:19:06 GMT -->
</html>