<?php
    session_start();

    $productName = $_POST['product-name'];
    $productPrice = $_POST['product-price'];

    include_once '../basedados/basedados.h';

    $conn = $conn = connect_db();
    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $stock = run_select($conn, 'CALL get_stock(?)', 's', [$productName]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Product Info</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="product-info.css">

    <!-- Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="navbar-container">
            <a href="./" class="navbar-left">
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

    <div class="product">
        <div class="product-container">
            <div class="product-size">
                <div style="background-image: url('<?php echo $productName; ?>.png');" class="img-container"></div>
            </div>

            <div class="product-info">
                <div class="product-info-container">
                    <h1><?php echo $productName; ?></h1>
                    <p>Price: <?php echo $productPrice; ?> EUR</p>
                    <p>Stock: <?php echo $stock[0]['stock']; ?></p>
                </div>

                <button>Add to Cart</button>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    close_db($conn);
?>