<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if(isset($_SESSION['email'])) {
        $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
        $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    }

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Home</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="home.css">
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
                    <a href="#footer">FOOTER</a>
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

        <div class="hero">
            <div class="title-search-container">
                <div class="title-text">
                    <h2>Fresh Groceries Delivered to Your Doorstep</h2>
                    <p>Quality and Freshness  Guaranteed</p>
                </div>

                <form method="POST" action="./shop.php" class="inputs-button-centralization">
                    <div class="search-input">
                        <input name="search" type="text" placeholder="What do you need today?" >

                        <div class="search-img-size">
                            <div class="search-img"></div>
                        </div>
                    </div>

                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="page-center-img">
                <div class="center-img-size">
                    <div class="center-img"></div>
                </div>
            </div>
        </div>


        <div class="about about-flex">
            <div class="information-container">
                <div class="big-info-panel">
                    <h2>About</h2>
                    <p>FelixUberShop, is your favorite grocery shop to buy your favorite products from your home and get them in speed of light at your home!</p>
                </div>

                <div class="small-info-panel">
                        <h2>Localization</h2>
                        <div class="small-info-panel-text">
                            <div class="small-info-panel-img-size">
                                <div class="small-info-panel-img"></div>
                            </div>
                            <p>Rotunda da Granja, Castelo Branco, Portugal</p>
                        </div>
                </div>

                <div class="small-info-panel">
                    <h2>Working Hours</h2>
                    <div class="small-info-panel-text">
                        <div class="small-info-panel-img-size">
                            <div class="small-info-panel-img2"></div>
                        </div>
                        <p>Dias úteis apartir das 8:00 ás 19:00</p>
                    </div>
                </div>

                <div class="big-info-panel">
                    <h2>Contact</h2>
                    <div class="big-info-panel-down">
                        <div class="big-info-panel-gmail">
                            <div class="big-info-panel-gmail-img-size">
                                <div class="big-info-panel-gmail-img"></div>
                            </div>
                            <p>felixubershop@gmail.com</p>
                        </div>

                        <div class="big-info-panel-contact">
                            <div class="big-info-panel-contact-img-size">
                                <div class="big-info-panel-contact-img"></div>
                            </div>
                            <p>+351 925 099 845</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-container">
                <div class="map-img-size">
                    <div class="map-img"></div>
                </div>
            </div>
        </div>

        <div class="footer footer-flex" id="footer">
            <div class="footer-img-size">
                <div class="footer-img"></div>
            </div>
            <p>© FelixUberShop 2025</p>
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
                    <div class="options-box">
                        <p>View Profile</p>
                    </div>

                    <div class="options-box">
                        <p>Manage Orders</p>
                    </div>

                    <div class="options-box">
                        <p>Cart</p>
                    </div>
                </div>

                <?php if($user[0]['user_type'] === 'employee' || $user[0]['user_type'] === 'admin'): ?>
                    <div class="options-bottom">
                        <?php if($user[0]['user_type'] === 'admin'): ?>
                            <div class="options-box2">
                                <p>Manage Products</p>
                            </div>
                        <?php endif ?>

                        <div class="options-box2">
                            <p>Manage Users</p>
                        </div>
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