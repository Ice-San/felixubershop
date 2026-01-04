<?php
    // Inicia as SESSIONS
    session_start();

    // Busca as functions e as varivaveis do ficheiro
    include_once '../basedados/basedados.h';
    
    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se o utilizador esta autenticado
    if(!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }

    // Obtêm os dados das orders e do user
    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $order = run_select($conn, 'CALL get_pending_orders(?)', 's', [$_SESSION['email']]);

    // Obtêm os dados dos produtos caso a order seja igual a 1
    if (count($order) === 1) {
        $products = run_select($conn, 'CALL get_products_order(?, ?, ?, ?)', 'ssss', [$_SESSION['email'], $order[0]['order_name'], 'pending', $order[0]['arrival_time']]);
    } else {
        $products = [];
    }
    
    // Obtêm o URL da pagina atual
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop | Cart</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="cart.css">
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

        <div class="cart-container">
            <div class="orders">
                <div class="order-header">
                    <h1><?php echo count($order) === 1 ? $order[0]['order_name'] : "..." ?></h1>
                    <p>Estimated arrival: <?php echo count($order) === 1 ? date('H:i\h - d/m/Y', strtotime($order[0]['arrival_time'])) : "No data" ?></p>
                </div>

                <div class="total-header">
                    <p>Total: <?php echo count($order) === 1 ? $order[0]['total_price'] : "No price" ?></p>   
                </div>

                <div class="product-container">
                    <?php foreach($products as $product): ?>
                        <div class="product">
                            <div class="product-info">
                                <h1><?php echo $product['product_name']; ?></h1>
                                <p>Quantity : <?php echo $product['quantity']; ?></p>
                                <p>Total Price: <?php echo $product['product_price']; ?></p>
                            </div>

                            <div class="product-buttons">
                                <form method="POST" action="./add-product.php">
                                    <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>" />
                                    <input type="hidden" name="order-name" value="order1" />
                                    <input type="hidden" name="order-status" value="pending" />

                                    <button class="add-button">
                                        <div class="add-button-img-size">
                                            <div class="add-button-img"></div>
                                        </div>
                                    </button>
                                </form>

                                <?php if($product['quantity'] > 1): ?>
                                    <form method="POST" action="./remove-quantity.php">
                                        <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                        <input type="hidden" name="order-name" value="<?php echo $order[0]['order_name']; ?>" />
                                        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>" />
                                        <input type="hidden" name="order-status" value="pending" />

                                        <button class="delete-button">
                                            <div class="delete-button-img-size">
                                                <div class="minus-button-img"></div>
                                            </div>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="POST" action="./remove-product.php">
                                        <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                        <input type="hidden" name="order-name" value="<?php echo $order[0]['order_name']; ?>" />
                                        <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>" />
                                        <input type="hidden" name="order-status" value="pending" />

                                        <button class="delete-button">
                                            <div class="delete-button-img-size">
                                                <div class="delete-button-img"></div>
                                            </div>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form method="POST" action="./payment.php" class="checkout">
                <h1>Checkout</h1>

                <p>Order Name</p>
                <div class="check-out-input">
                    <input id="order-name" type="text" name="order-name" placeholder="order1" required>
                </div>

                <p>Destiny</p>
                <div class="check-out-input">
                    <input type="text" name="destiny" placeholder="Rua das Flores" value="<?php echo $user[0]['address'];?>" required>
                </div>

                <input type="hidden" name="money" value="<?php echo $user[0]['money'];?>">
                <input type="hidden" name="total-price" value="<?php echo $order[0]['total_price'];?>">

                <button>buy</button>
            </form>
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
    <script src="./cart.js"></script>
</body>
</html>

<?php
    close_db($conn);
?>