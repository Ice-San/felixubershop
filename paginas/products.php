<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();

    if(!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }

    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);

    if($user[0]['user_type'] !== "admin") {
        header("Location: shop.php");
        exit();
    }

    $products = run_select($conn, 'SELECT product_name, price, stock FROM get_all_products WHERE product_status = "active"');
    $categories = run_select($conn, 'CALL get_categories()');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Products</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="users.css">
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
                    <a href="">DISCOUNTS</a>
                    <a href="">FOOTER</a>
                </div>

                <div class="navbar-right">
                    <div class="profile">
                        <h2><?php echo $userInitials; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-page">
            <div class="account-info">
                <form method="POST" action="./create-product.php" class="info">
                    <div class="info-top">
                        <div class="info-title">
                            <div class="info-icon">
                                <div class="user-add-icon img-container"></div>
                            </div>

                            <h2>Add Product</h2>
                        </div>

                        <p>Fill in the details to add a new product to the system.</p>
                    </div>

                    <div class="inputs">
                        <label for="name">Name</label>

                        <div class="input">
                            <input id="name" name="name" type="text" placeholder="apple" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="price">Price</label>

                        <div class="input">
                            <input id="price" name="price" type="number" step="0.01" placeholder="10.00" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="stock">Stock</label>

                        <div class="input">
                            <input id="stock" name="stock" type="number" placeholder="10" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="category">Category</label>

                        <div class="input">
                            <select name="category" id="category">
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" >Add Product</button>
                </form>
            </div>

            <div class="orders-history">
                <div class="user-list">
                    <div class="user-list-title">
                        <div class="user-list-icon">
                            <div class="user-list-icon-container img-container"></div>
                        </div>

                        <h2>Product List (<?php echo count($products); ?>)</h2>
                    </div>

                    <p>Search and manage all existing products in the system.</p>
                </div>

                <div class="search-input">
                    <div class="search">
                        <div class="search-icon img-container"></div>
                    </div>

                    <input id="search-input" type="text" placeholder="Search products by name" />
                </div>

                <div class="users">
                    <?php foreach($products as $product): ?>
                        <form id="delete-product-form" method="POST" action="./delete-product.php" class="user">
                            <input type="hidden" name="product-name" value="<?php echo $product['product_name'] ?>">

                            <div class="user-content">
                                <div class="user-left-info">
                                    <div class="user-title">
                                        <h3><?php echo $product['product_name'] ?></h3>
                                    </div>

                                    <p>Price: <span><?php echo $product['price'] ?></span> EUR</p>
                                    <p>Stock: <span><?php echo $product['stock'] ?></span></p>
                                </div>
                            </div>

                            <button type="submit" form="delete-product-form" class="user-delete">
                                <div class="delete">
                                    <div class="delete-icon img-container"></div>
                                </div>
                            </button>
                        </form>
                    <?php endforeach; ?>
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

    <div class="popup hide">
        <div class="popup-close"></div>

        <div class="popup-content">
            <div class="popup-header">
                <h1>Products Info</h1>

                <div class="close-img-size">
                    <div class="close-img"></div>
                </div>
            </div>

            <form method="POST" action="./edit-product.php" class="options">
                <div class="inputs">
                    <label for="product-name">Name</label>

                    <div class="input">
                        <input id="product-name" name="name" type="text" required />
                    </div>
                </div>

                <div class="inputs">
                    <label for="product-price">Price</label>

                    <div class="input">
                        <input id="product-price" name="price" type="number" step="0.01" required />
                    </div>
                </div>

                <div class="inputs">
                    <label for="product-stock">Stock</label>

                    <div class="input">
                        <input id="product-stock" name="stock" type="number" required />
                    </div>
                </div>

                <div class="inputs">
                    <label for="category">Category</label>

                    <div class="input">
                        <select name="category" id="category">
                            <?php foreach($categories as $category): ?>
                                <option value="<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="inputs">
                    <label for="discounts">Discount</label>

                    <div class="input">
                        <select name="discount" id="discounts">
                            <option value="0">No Discount</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="90">90%</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="savebtn">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="./popup.js"></script>
    <script src="./products.js"></script>
    <script src="./cart.js"></script>
</body>
</html>

<?php
    close_db($conn);
?>