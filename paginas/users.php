<?php
    // Inicia as SESSIONS
    session_start();

    // Obtêm as funções e variaveis do ficheiro
    include_once '../basedados/basedados.h';
    
    // Conecta a base de dados
    $conn = connect_db();

    // Verifica se o utilizador esta autenticado
    if(!isset($_SESSION['email'])) {
        header("Location: signin.php");
        exit();
    }

    // Obtêm os dados do utilizador e dos utilizadores
    $userInitials = get_user_initials($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $user = run_select($conn, 'CALL get_user(?)', 's', [$_SESSION['email']]);
    $users = run_select($conn, 'SELECT username, email, user_type, user_status, joined_at FROM get_all_users WHERE user_status = "active";');

    // Verifica se o utilizador é um admin ou employee, caso contrário redireciona para a pagina shop
    if($user[0]['user_type'] !== "admin" && $user[0]['user_type'] !== "employee") {
        header("Location: shop.php");
        exit();
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
    <title>FelixUberShop - Users</title>

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
                <form method="POST" action="./create-user.php" class="info">
                    <div class="info-top">
                        <div class="info-title">
                            <div class="info-icon">
                                <div class="user-add-icon img-container"></div>
                            </div>

                            <h2>Add User</h2>
                        </div>

                        <p>Fill in the details to add a new user to the system.</p>
                    </div>

                    <div class="inputs">
                        <label for="username">Username</label>

                        <div class="input">
                            <input id="username" name="username" type="text" placeholder="johndoe_" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="email">Email</label>

                        <div class="input">
                            <input id="email" name="email" type="email" placeholder="john@example.com" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="password">Password</label>

                        <div class="input">
                            <input id="password" name="password" type="password" required />
                        </div>
                    </div>

                    <div class="inputs">
                        <label for="role">Role</label>

                        <div class="input">
                            <select name="role" required id="role">
                                <option value="client">Client</option>
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit">Add User</button>
                </form>
            </div>

            <div class="orders-history">
                <div class="user-list">
                    <div class="user-list-title">
                        <div class="user-list-icon">
                            <div class="user-list-icon-container img-container"></div>
                        </div>

                        <h2>User List (<?php echo count($users);?>)</h2>
                    </div>

                    <p>Search and manage all existing users in the system.</p>
                </div>

                <div class="search-input">
                    <div class="search">
                        <div class="search-icon img-container"></div>
                    </div>

                    <input id="search-input" type="text" placeholder="Search users by email..." />
                </div>

                <div class="users">
                    <?php foreach($users as $u): ?>
                        <form id="delete-user-<?php echo $u['email'] ?>" class="hide" action="./delete-user.php" method="POST">
                            <input type="hidden" name="email" value="<?php echo $u['email'] ?>">
                        </form>

                        <form method="POST" action="./profile.php" class="user">
                            <input type="hidden" name="user-from-list" value="<?php echo $u['email'] ?>">

                            <div class="user-content">
                                <div class="user-icon">
                                    <h3><?php echo get_user_initials($conn, 'CALL get_user(?)', 's', [$u['email']]); ?></h3>
                                </div>

                                <div class="user-left-info">
                                    <div class="user-title">
                                        <h3><?php echo $u['username'] ?></h3>
                                        <p data-role="<?php echo $u['user_type'] ?>"><?php echo $u['user_type'] ?></p>
                                    </div>

                                    <p><?php echo $u['email'] ?></p>
                                    <p>Joined: <?php echo date('d/m/Y', strtotime($u['joined_at'])) ?></p>
                                </div>
                            </div>

                            <button type="submit" form="delete-user-<?php echo $u['email'] ?>" class="user-delete">
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

    <script src="./popup.js"></script>
    <script src="./users.js"></script>
</body>
</html>

<?php
    close_db($conn);
?>