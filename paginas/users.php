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

                        <h2>Add User</h2>
                    </div>

                    <p>Fill in the details to add a new user to the system.</p>
                </div>

                <div class="inputs">
                    <label for="username">Username</label>

                    <div class="input">
                        <input id="username" type="text" placeholder="johndoe_" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="email">Email</label>

                    <div class="input">
                        <input id="email" type="email" placeholder="john@example.com" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="password">Password</label>

                    <div class="input">
                        <input id="password" type="password" />
                    </div>
                </div>

                <div class="inputs">
                    <label for="role">Role</label>

                    <div class="input">
                        <select name="role" id="role">
                            <option value="user">User</option>
                            <option value="employee">Employee</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <button>Add User</button>
            </form>
        </div>

        <div class="orders-history">
            <div class="user-list">
                <div class="user-list-title">
                    <div class="user-list-icon">
                        <div class="user-list-icon-container img-container"></div>
                    </div>

                    <h2>User List (3)</h2>
                </div>

                <p>Search and manage all existing users in the system.</p>
            </div>

            <div class="search-input">
                <div class="search">
                    <div class="search-icon img-container"></div>
                </div>

                <input type="text" placeholder="Search users by name or email..." />
            </div>

            <div class="users">
                <form class="user">
                    <div class="user-content">
                        <div class="user-icon">
                            <h3>JD</h3>
                        </div>

                        <div class="user-left-info">
                            <div class="user-title">
                                <h3>John Doe</h3>
                                <p data-role="admin">Admin</p>
                            </div>

                            <p>john@example.com</p>
                            <p>Joined: 10/12/2025</p>
                        </div>
                    </div>

                    <div class="user-delete">
                        <div class="delete">
                            <div class="delete-icon img-container"></div>
                        </div>
                    </div>
                </form>

                <form class="user">
                    <div class="user-content">
                        <div class="user-icon">
                            <h3>JD</h3>
                        </div>

                        <div class="user-left-info">
                            <div class="user-title">
                                <h3>John Doe</h3>
                                <p data-role="employee">Employee</p>
                            </div>

                            <p>john@example.com</p>
                            <p>Joined: 10/12/2025</p>
                        </div>
                    </div>

                    <div class="user-delete">
                        <div class="delete">
                            <div class="delete-icon img-container"></div>
                        </div>
                    </div>
                </form>

                <form class="user">
                    <div class="user-content">
                        <div class="user-icon">
                            <h3>JD</h3>
                        </div>

                        <div class="user-left-info">
                            <div class="user-title">
                                <h3>John Doe</h3>
                                <p data-role="user">User</p>
                            </div>

                            <p>john@example.com</p>
                            <p>Joined: 10/12/2025</p>
                        </div>
                    </div>

                    <div class="user-delete">
                        <div class="delete">
                            <div class="delete-icon img-container"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    close_db($conn);
?>