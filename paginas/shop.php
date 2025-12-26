<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if(isset($_SESSION['email'])) {
        $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
        $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    }

    $discount = $_GET['discount'] ?? false;
    $search = $_POST['search'] ?? '';

    $products = run_select($conn, 'SELECT * FROM get_all_products');

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Shop</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="shop.css">
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

        <div class="categories">
            <div class="categories-container">
                <div class="category-box">
                    <div class="fruits img-container">
                        <div class="category-overlay">
                            <h2>Fruits</h2>
                        </div>
                    </div>
                </div>

                <div class="category-box">
                    <div class="vegetables img-container">
                        <div class="category-overlay">
                            <h2>Vegetables</h2>
                        </div>
                    </div>
                </div>

                <div class="category-box">
                    <div class="meats img-container">
                        <div class="category-overlay">
                            <h2>Meats</h2>
                        </div>
                    </div>
                </div>

                <div class="category-box">
                    <div class="cereals img-container">
                        <div class="category-overlay">
                            <h2>Cereals</h2>
                        </div>
                    </div>
                </div>

                <div class="category-box">
                    <div class="wealth img-container">
                        <div class="category-overlay">
                            <h2>Wealth</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="products">
            <div class="products-container">
                <?php foreach($products as $product): ?>
                    <form class="product-form" method="POST" action="./product-info.php">
                        <input type="hidden" name="product-name" <?php echo 'value="' . $product['product_name'] . '"' ?> />
                        <input type="hidden" name="product-price" <?php echo 'value="' . $product['price'] . '"' ?> />
                        
                        <div <?php echo 'data-category="' . $product['category'] . '"'; ?> class="product">
                            <div class="product-container">
                                <div class="product-banner">
                                    <p>No Image</p>
                                    <div style="background-image: url('<?php echo $product['product_name']; ?>.png');" class="product-img img-container"></div>
                                </div>

                                <div class="product-info">
                                    <h2><?php echo $product['product_name']; ?></h2>

                                    <div class="product-price">
                                        <?php if($product['discount'] > 0): ?>
                                            <p class="price-discount"><?php echo $product['price'] . ' EUR'; ?></p>
                                            <p class="price-without-discount"><?php echo number_format($product['price'] / (1 - ($product['discount'] / 100)), 2, '.', '') . ' EUR'; ?></p>
                                        <?php else: ?>
                                            <p><?php echo $product['price'] . ' EUR'; ?></p>
                                        <?php endif ?>
                                    </div>

                                    <button class="product-btn">Add to Cart</button>
                                </div>
                            </div>

                            <?php if($product['discount'] > 0): ?>
                                <div class="product-discount">
                                    <p><span><?php echo $product['discount'] ?></span>% OFF</p>
                                </div>
                            <?php endif ?>
                        </div>
                    </form>
                <?php endforeach ?>
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

    <?php
        echo '<input id="discount-input" type="hidden" value="'. htmlspecialchars($discount) .'" />';
        echo '<input id="search-input" type="hidden" value="'. htmlspecialchars($search) .'" />';
    ?>

    <script src="./shop.js"></script>
    <script src="./popup.js"></script>
</body>
</html>

<?php
    close_db($conn);
?>