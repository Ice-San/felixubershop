<?php
    session_start();

    include_once '../basedados/basedados.h';

    if(!isset($_SESSION['email'])) {
        header("Location: ./signin.php");
        exit();
    }
    
    $conn = connect_db();

    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);

    if($user[0]['user_type'] === "client") {
        $orders = run_select($conn, 'CALL get_user_orders(?)', 's', [$_SESSION['email']]);
    }

    if($user[0]['user_type'] === "admin" || $user[0]['user_type'] === "employee") {
        $orders = run_select($conn, 'CALL get_orders()');
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
    <title>FelixUberShop | Orders</title>

    <!-- CSS Files -->
     <link rel="stylesheet" href="orders.css">
     <link rel="stylesheet" href="popup.css">
     <link rel="stylesheet" href="index.css">

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
                    <h2>Order List</h2>
                    <p>Search and manage all existing orders.</p>
                </div>

                <div class="order-input">
                    <div class="search-img-size">
                        <div class="search-img"></div>
                    </div>
                    <input id="search-input" type="text" placeholder="Search orders by name..." >
                </div>

                <div class="orders-box">
                    <?php foreach($orders as $order): ?>
                        <div class="order-content">
                            <form id="order-done-form-<?php echo $order['order_name']; ?>-<?php echo $order['owner_email']; ?>-<?php echo $order['arrival_time'];?>" action="./order-done.php" method="POST" class="hide">
                                <input type="hidden" name="order-name" value="<?php echo $order['order_name'];?>" />
                                <input type="hidden" name="owner-email" value="<?php echo $order['owner_email'];?>" />
                            </form>

                            <form action="./order-info.php" method="POST" class="form-redirect hide">
                                <input type="hidden" name="order-name" value="<?php echo $order['order_name'];?>" />
                                <input type="hidden" name="owner-email" value="<?php echo $order['owner_email'];?>" />
                                <input type="hidden" name="order-status" value="<?php echo $order['order_status'];?>" />
                                <input type="hidden" name="arrival-time" value="<?php echo $order['arrival_time'];?>" />
                                <input type="hidden" name="order-price" value="<?php echo $order['total_price'];?>" />
                            </form>

                            <form method="POST" action="./delete-order.php" class="order">
                                <div class="order-info">
                                    <h2><?php echo $order['order_name']; ?></h2>
                                    <p>Owner: <?php echo $order['owner_email']; ?></p>
                                    <p>Arrival Time: <?php echo date('d/m/Y - H:m', strtotime($order['arrival_time'])) ?>h</p>
                                    <p>Total Price: <?php echo $order['total_price']; ?> EUR</p>
                                    <p>Status: <?php echo $order['order_status']; ?></p>
                                </div>

                                <input type="hidden" name="order-name" value="<?php echo $order['order_name'];?>" />
                                <input type="hidden" name="owner-email" value="<?php echo $order['owner_email'];?>" />
                                <input type="hidden" name="arrival-time" value="<?php echo $order['arrival_time'];?>" />
                                <input type="hidden" name="order-status" value="<?php echo $order['order_status']; ?>" />

                                <?php if($order['order_status'] === "ongoing"): ?>
                                    <button type="submit" form="order-done-form-<?php echo $order['order_name']; ?>-<?php echo $order['owner_email']; ?>-<?php echo $order['arrival_time'];?>" class="check-button">
                                        <div class="delete-button-img-size">
                                            <div class="check-button-img"></div>
                                        </div>
                                    </button>
                                <?php endif; ?>

                                <button type="submit" class="delete-button">
                                    <div class="delete-button-img-size">
                                        <div class="delete-button-img"></div>
                                    </div>
                                </button>
                            </form>
                        </div>
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

    <script src="./popup.js"></script>
    <script src="./orders.js"></script>
</body>
</html>

<?php
close_db($conn);
?>