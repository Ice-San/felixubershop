<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Register</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="signin.css">

    <!-- Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="box">
        <div class="box-container">
            <div class="box-title">
                <h1>Register to your account</h1>
                <p>Enter your info below to register to your account.</p>
            </div>

            <form id="form" method="POST" action="./create-user.php" novalidate>
                <div class="inputs">
                    <label for="username"><span>*</span> Username</label>
                    <input type="text" id="username" name="username" placeholder="John Doe" required />
                    <p id="error-username" class="hide"></p>
                </div>

                <div class="inputs">
                    <label for="email"><span>*</span> Email</label>
                    <input type="email" id="email" name="email" placeholder="user@example.com" required />
                    <p id="error-email" class="hide"></p>
                    
                    <?php 
                        if(isset($_SESSION['errorEmail'])) {
                            echo "<p>" . $_SESSION['errorEmail'] . "</p>";
                            unset($_SESSION['errorEmail']);
                        }
                    ?>
                </div>

                <div class="inputs">
                    <label for="password"><span>*</span> Password</label>
                    <input type="password" id="password" name="password" required />
                    <p id="error-password" class="hide"></p>

                    <?php 
                        if(isset($_SESSION['errorPassword'])) {
                            echo "<p>" . $_SESSION['errorPassword'] . "</p>";
                            unset($_SESSION['errorPassword']);
                        }
                    ?>
                </div>

                <div class="inputs">
                    <button>SignIn</button>
                    <a href="./signin.php">Have an account?</a>
                </div>
            </form>
        </div>
    </div>

    <script src="./signin.js"></script>
</body>
</html>