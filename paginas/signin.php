<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo-green.png" type="image/x-icon">
    <title>FelixUberShop - Login</title>

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
                <h1>Login to your account</h1>
                <p>Enter your email below to login to your account.</p>
            </div>

            <form action="">
                <div class="inputs">
                    <label for="email"><span>*</span> Email</label>
                    <input type="email" id="email" placeholder="user@example.com" required />
                </div>

                <div class="inputs">
                    <label for="password"><span>*</span> Password</label>
                    <input type="password" id="password" required />
                </div>

                <div class="inputs">
                    <button>SignIn</button>
                    <a href="./signup.php">Don't have an account?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>