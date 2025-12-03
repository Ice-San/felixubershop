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
    <title>FelixUberShop - Profile</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="profile.css">

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

    <div class="profile-page">
        <div class="account-info">
            <form class="info">
                <h2>Account Info</h2>

                <div class="inputs">
                    <label for="username">Username</label>

                    <div class="input">
                        <input id="username" type="text" value="JohnDoe_" disabled />

                        <button>
                            <div class="edit-btn img-container"></div>
                        </button>
                    </div>
                </div>

                <div class="inputs">
                    <label for="email">Email</label>

                    <div class="input">
                        <input id="email" type="email" value="john@example.com" disabled />
                        
                        <button>
                            <div class="edit-btn img-container"></div>
                        </button>
                    </div>
                </div>

                <div class="inputs">
                    <label for="password">Password</label>

                    <div class="input">
                        <input id="password" type="password" value="****" disabled />
                        
                        <button>
                            <div class="edit-btn img-container"></div>
                        </button>
                    </div>
                </div>

                <div class="inputs">
                    <label for="address">Address</label>

                    <div class="input">
                        <input id="address" type="text" value="Rua das Flores Nº22" disabled />
                        
                        <button>
                            <div class="edit-btn img-container"></div>
                        </button>
                    </div>
                </div>
            </form>

            <div class="money">
                <div class="money-info">
                    <h2>Money</h2>
                    <p>120,23 EUR</p>
                </div>

                <div class="money-options">
                    <button>Remove Money</button>
                    <button>Add Money</button>
                </div>
            </div>
        </div>

        <div class="orders-history">
            <h2>Orders History</h2>

            <div class="orders">
                <div class="order">
                    <div class="order-left-info">
                        <p><span>To: </span>Rua das Flores Nº22</p>
                        <p><span>Estimated arrival: </span> 16:52 PM</p>
                    </div>

                    <div class="order-right-info">
                        <p>21:03h - 13/05/2025<p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    close_db($conn);
?>