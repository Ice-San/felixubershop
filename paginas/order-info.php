<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as functions e as variaveis do ficheiro
    include_once '../basedados/basedados.h';

    // Verifica se o utilizador esta autenticado
    if(!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }
    
    // Conecta a base de dados
    $conn = connect_db();

    // Obtêm os dados de um utilizador
    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);

    // Guarda dados vindos de outra pagina Front-End
    $ownerEmail = $_POST["owner-email"];
    $orderName = $_POST["order-name"];
    $orderStatus = $_POST["order-status"];
    $arrivalTime = $_POST["arrival-time"];
    $orderPrice = $_POST["order-price"];

    // Verifica se os dados são diferentes de null ou undefined
    if(!isset($ownerEmail) || !isset($orderName) || !isset($orderStatus) || !isset($arrivalTime) || !isset($orderPrice)) {
        header("Location: ./orders.php");
        exit();
    }

    // Obtêm todos os produtos caso o utilizador seja um admin ou funcionario
    if($user[0]['user_type'] === "admin" || $user[0]['user_type'] === "employee") {
        $products = run_select($conn, 'CALL get_products_order(?, ?, ?, ?)', 'ssss', [$ownerEmail, $orderName, $orderStatus, $arrivalTime]);
    }

    // Obtêm todos os produtos do cliente
    if($user[0]['user_type'] === "client") {
        if($ownerEmail !== $_SESSION['email']) {
            header("Location: ./orders.php");
            exit();
        }
        
        $products = run_select($conn, 'CALL get_products_order(?, ?, ?, ?)', 'ssss', [$_SESSION['email'], $orderName, $orderStatus, $arrivalTime]);
    }

    // Caso o utilizador não seja admin, funcionario ou cliente ele é redirecionado para a pagina shop
    if($user[0]['user_type'] !== "admin" && $user[0]['user_type'] !== "employee" && $user[0]['user_type'] !== "client") {
        header("Location: ./shop.php");
        exit();
    }

    // Obtêm a URL da pagina
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop | Order Info</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="popup.css">
    <link rel="stylesheet" href="order-info.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="users.css">

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

        <div class="orders-content">
            <div class="order-dashboard">
                <div class="order-header">
                    <?php if($orderStatus === "ongoing"): ?>
                        <button id="order-edit-btn" class="header-addbtn">
                            <div class="header-add-button-img-size">
                                <div class="header-edit-button-img"></div>
                            </div>
                        </button>
                    <?php endif; ?>

                    <div class="header-text">
                        <div class="order-name-arrival">
                            <h2><?php echo $orderName; ?></h2>
                            <p>Estimated arrival: <?php echo date('d/m/Y - H:m', strtotime($arrivalTime)); ?>h</p>
                        </div>

                        <p>Total: <?php echo $orderPrice; ?> EUR</p>
                        <p>Owner: <?php echo $ownerEmail; ?></p>
                    </div>
                </div>

                <div class="order-input">
                    <div class="search-img-size">
                        <div class="search-img"></div>
                    </div>
                    <input id="search-input" type="text" placeholder="Search products by name..." >
                </div>

                <div class="orders-box">
                    <?php foreach($products as $product): ?>
                        <div class="order">
                            <div class="order-info">
                                <h2><?php echo $product['product_name']; ?></h2>
                                <p>Quantity : <?php echo $product['quantity']; ?></p>
                                <p>Total Price: <?php echo $product['product_price']; ?> EUR</p>
                            </div>

                            <?php if($orderStatus === "ongoing"): ?>
                                <div class="btns-direction">
                                    <button type="submit" form="add-product-form-<?php echo $product['product_name']; ?>" class="addbtn">
                                        <div class="add-button-img-size">
                                            <div class="add-button-img"></div>
                                        </div>
                                    </button>

                                    <?php if($product['quantity'] > 1): ?>
                                        <button type="submit" form="remove-product-form-<?php echo $product['product_name']; ?>" class="delete-button">
                                            <div class="delete-button-img-size">
                                                <div class="minus-button-img"></div>
                                            </div>
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" form="delete-product-form-<?php echo $product['product_name']; ?>" class="delete-button">
                                            <div class="delete-button-img-size">
                                                <div class="delete-button-img"></div>
                                            </div>
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <form id="add-product-form-<?php echo $product['product_name']; ?>" action="./add-product.php" method="POST" class="hide">
                                    <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $ownerEmail; ?>" />
                                    <input type="hidden" name="order-name" value="<?php echo $orderName; ?>" />
                                    <input type="hidden" name="order-status" value="ongoing" />
                                </form>

                                <form id="remove-product-form-<?php echo $product['product_name']; ?>" action="./remove-quantity.php" method="POST" class="hide">
                                    <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $ownerEmail; ?>" />
                                    <input type="hidden" name="order-name" value="<?php echo $orderName; ?>" />
                                    <input type="hidden" name="order-status" value="ongoing" />
                                </form>

                                <form id="delete-product-form-<?php echo $product['product_name']; ?>" action="./remove-product.php" method="POST" class="hide">
                                    <input type="hidden" name="product-name" value="<?php echo $product['product_name']; ?>" />
                                    <input type="hidden" name="email" value="<?php echo $ownerEmail; ?>" />
                                    <input type="hidden" name="order-name" value="<?php echo $orderName; ?>" />
                                    <input type="hidden" name="order-status" value="ongoing" />
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach ?>
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
                <h1>Edit Order</h1>

                <div class="close-img-size">
                    <div class="close-img"></div>
                </div>
            </div>

            <form method="POST" action="./edit-order.php" class="option">
                <div class="inputs">
                    <input name="email" type="hidden" value="<?php echo $ownerEmail; ?>" />
                    <input name="order-name" type="hidden" value="<?php echo $orderName; ?>" />

                    <label for="new-order-name">Order Name</label>
                    <div class="input">
                        <input id="new-order-name" name="new-order-name" type="text" value="<?php echo $orderName; ?>" required />
                    </div>

                    <label for="order-arrival">Arrival Time</label>
                    <div class="input">
                        <input id="order-arrival" name="order-arrival" type="datetime-local" value="<?php echo $arrivalTime ?>" required />
                    </div>
                </div>

                <button type="submit" class="savebtn">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="./popup.js"></script>
    <script src="./orders.js"></script>
</body>
</html>

<?php
close_db($conn);
?>