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
    <link rel="stylesheet" href="users.css">

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
                        <div class="info-icon">
                            <div class="user-add-icon img-container"></div>
                        </div>

                        <h2>Add Product</h2>
                    </div>

                    <p>Fill in the details to add a new product to the system.</p>
                </div>

                <div class="inputs">
                    <label for="name">name</label>

                    <div class="input">
                        <input id="name" name="name" type="text" placeholder="apple" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="price">price</label>

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

                <button>Add Product</button>
            </form>
        </div>

        <div class="orders-history">
            <div class="user-list">
                <div class="user-list-title">
                    <div class="user-list-icon">
                        <div class="user-list-icon-container img-container"></div>
                    </div>

                    <h2>Product List (3)</h2>
                </div>

                <p>Search and manage all existing products in the system.</p>
            </div>

            <div class="search-input">
                <div class="search">
                    <div class="search-icon img-container"></div>
                </div>

                <input type="text" placeholder="Search products by name" />
            </div>

            <div class="users">
                <a href="">
                    <form class="user">
                        <div class="user-content">
                            <div class="user-left-info">
                                <div class="user-title">
                                    <h3>Apple</h3>
                                </div>

                                <p>Price: 10.00 EUR</p>
                                <p>Stock: 120</p>
                            </div>
                        </div>

                        <div class="user-delete">
                            <div class="delete">
                                <div class="delete-icon img-container"></div>
                            </div>
                        </div>
                    </form>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    close_db($conn);
?>