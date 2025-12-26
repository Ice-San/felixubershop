<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if(!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Profile</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="popup.css">

    <!-- Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="content">
        <div class="navbar">
            <div class="navbar-container">
                <a href="./home.php" class="navbar-left">
                    <div class="navbar-icon">
                        <div class="navbar-icon-container img-container"></div>
                    </div>

                    <h1>FelixUber<br/>Shop</h1>
                </a>

                <div class="navbar-middle">
                    <a href="./shop.php">DISCOVER</a>
                    <a href="./shop.php?discount=true">DISCOUNTS</a>
                    <a href="./home.php?#footer">FOOTER</a>
                </div>

                <div class="navbar-right">
                    <?php if(isset($_SESSION['email'])): ?>
                        <div class="profile">
                            <h2><?php echo $userInitials; ?></h2>
                        </div>
                    <?php else: ?>
                        <a href="./signin.php" class="signin">
                            <p>SignIn</p>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="profile-page">
            <div class="account-info">
                <form class="info">
                    <h2>Account Info</h2>

                    <div class="inputs">
                        <label for="username">Username</label>

                        <div class="input">
                            <input id="username" type="text" <?php echo 'value="'. $user[0]['username'] .'"'; ?> disabled />

                            <button>
                                <div class="edit-btn img-container"></div>
                            </button>
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="email">Email</label>

                        <div class="input">
                            <input id="email" type="email" <?php echo 'value="'. $user[0]['email'] .'"'; ?> disabled />
                            
                            <button>
                                <div class="edit-btn img-container"></div>
                            </button>
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="password">Password</label>

                        <div class="input">
                            <input id="password" type="password" value="****" disabled />
                            
                            <button>
                                <div class="edit-btn img-container"></div>
                            </button>
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="address">Address</label>

                        <div class="input">
                            <input id="address" type="text" <?php echo 'value="'. $user[0]['address'] .'"'; ?> disabled />
                            
                            <button>
                                <div class="edit-btn img-container"></div>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="money">
                    <div class="money-info">
                        <h2>Money</h2>
                        <p><?php echo $user[0]['money']; ?> EUR</p>
                    </div>

                    <div class="money-options">
                        <button>Remove Money</button>
                        <button>Add Money</button>
                    </div>
                </div>
            </div>

            <div class="orders-history">
                <h2>Orders History</h2>

                <div class="orders">
                    <div class="order">
                        <div class="order-left-info">
                            <p><span>To: </span>Rua das Flores Nº22</p>
                            <p><span>Estimated arrival: </span> 16:52 PM</p>
                        </div>

                        <div class="order-right-info">
                            <p>21:03h - 13/05/2025<p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup hide">
        <div class="popup-close"></div>

        <div class="popup-content">
            <div class="popup-header">
                <h1><?php echo $user[0]['user_type'] ?> Zone</h1>

                <div class="close-img-size">
                    <div class="close-img"></div>
                </div>
            </div>

            <div class="options">
                <div class="options-top">
                    <a href="./profile.php" class="options-box">
                        <p>View Profile</p>
                    </a>

                    <a href="./orders.php" class="options-box">
                        <p>Manage Orders</p>
                    </a>

                    <a href="./cart.php" class="options-box">
                        <p>Cart</p>
                    </a>
                </div>

                <?php if($user[0]['user_type'] === 'employee' || $user[0]['user_type'] === 'admin'): ?>
                    <div class="options-bottom">
                        <?php if($user[0]['user_type'] === 'admin'): ?>
                            <a href="./products.php" class="options-box2">
                                <p>Manage Products</p>
                            </a>
                        <?php endif ?>

                        <a href="./users.php" class="options-box2">
                            <p>Manage Users</p>
                        </a>
                    </div>
                <?php endif ?>

                <form method="POST" action="./logout.php" class="popup-footer">
                    <input type="hidden" name="previous_url" value="<?php echo htmlspecialchars($current_url); ?>">
                    <button>Log Out</button>
                </form>
            </div>
        </div>
    </div>

    <script src="./popup.js"></script>
</body>
</html>

<?php
    close_db($conn);
?>