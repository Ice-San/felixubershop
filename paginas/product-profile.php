<?php
    session_start();

    include_once '../basedados/basedados.h';
    
    $conn = connect_db();
    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
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
    <link rel="stylesheet" href="product-profile.css">

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
            <form class="info">
                <div class="info-top">
                    <div class="info-title">
                        <h2>Product Info</h2>
                    </div>
                </div>

                <div class="inputs">
                    <label for="name">Name</label>

                    <div class="input">
                        <input id="name" name="name" type="text" placeholder="apple" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="price">Price</label>

                    <div class="input">
                        <input id="price" name="price" type="number" placeholder="10.00" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="stock">Stock</label>

                    <div class="input">
                        <input id="stock" name="stock" type="number" placeholder="10" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="category">Category</label>

                    <div class="input">
                        <select name="category" id="category">
                            <option value="fruits">Fruits</option>
                            <option value="wealth">Wealth</option>
                            <option value="cereals">Cereals</option>
                        </select>
                    </div>
                </div>

                <div class="inputs">
                    <label for="discount">Discount</label>

                    <div class="input">
                        <select name="discount" id="discount">
                            <option value="0">No Discount</option>
                            <option value="25">25%</option>
                            <option value="50%">50%</option>
                            <option value="75%">75%</option>
                        </select>
                    </div>
                </div>

                <div class="edit-product">
                    <button>Edit Product</button>
                </div>

                <div class="editing-product hide">
                    <button>Cancel</button>
                    <button>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
    close_db($conn);
?>