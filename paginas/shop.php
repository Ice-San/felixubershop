<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();
    $products = run_select($conn, 'SELECT * FROM get_all_products');
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
    <link rel="stylesheet" href="shop.css">

    <!-- Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="./home.php" class="navbar-left">
                <div class="navbar-icon">
                    <div class="navbar-icon-container img-container"></div>
                </div>

                <h1>FelixUber<br/>Shop</h1>
            </a>

            <div class="navbar-middle">
                <a href="">DISCOVER</a>
                <a href="">DISCOUNTS</a>
                <a href="">FOOTER</a>
            </div>

            <div class="navbar-right">
                <?php if(isset($_SESSION['email'])): ?>
                    <div class="profile">
                        <h2>JD</h2>
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
            <?php endforeach ?>
        </div>
    </div>

    <script src="./shop.js"></script>
</body>
</html>