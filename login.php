<?php
require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];



$error = '';

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute(['username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('password123' === $password) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: posts.php');
                    exit;
                } else {
                    $error = "Invalid Password!";
                }
            } else {
                $error = "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        body {
            background: linear-gradient(45deg, #37a08e, #000000);
            background-size: 400% 400%;
            font-family: "Raleway", sans-serif; 
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            animation: gradientAnimation 10s infinite; 
        }

        .login-container {
            width: 300px;
            padding: 40px;
            border-radius: 10px;
            background-color: white;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s forwards ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        h2 {
            margin-bottom: 20px;
            color: #37a08e;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInUp 1s forwards ease-in-out;
            animation-delay: 0.2s;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            background-color: #49c1a2;
            color: white;
            font-size: 18px;
            cursor: pointer;
            outline: none;
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInUp 1s forwards ease-in-out;
            animation-delay: 0.4s;
        }

        button:hover {
            background-color: #37a08e;
        }

        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }

        footer {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #FFFFFF;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head> 
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" id="username" placeholder="Enter username" name="username" required>
            <input type="password" id="password" placeholder="Enter password" name="password" required>
            <button id="submit">Login</button>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
    <footer>&copy; 2024 rain.creatives</footer>
</body>
</html>
