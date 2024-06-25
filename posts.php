<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(#37a08e, #000000);
            font-family: "Raleway", sans-serif; 
            height: 200vh;
            margin: 0;
            padding: 0;
        }

        .posts-container {
            max-width: 600px;
            margin: 140px auto; 
            padding: 20px;  
            border-radius: 20px;
            background-color: #ddd;
            animation: fadeInUp 1s forwards ease-in-out;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: block;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            background-color: #37a08e;
            cursor: pointer;
            align-self: start;
            animation: fadeInUp 1s forwards ease-in-out;
        }

        li:hover {
            background-color: #f0f0f0;
        }

        .signup-heading {
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
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

        .posts-container h1 {
            margin-bottom: 20px;
            color: black;
        }

        #postLists li {
            background-color: #FFFFFF;
            border-radius: px;
            margin: 10px 0;
            padding: 10px;
            color:black;
            font-size: 18px;
        }

        #postLists li a {
            text-decoration: none;
            color: inherit;
            display: block;
            padding: 10px;
        }

        #postLists li:hover {
            background-color: #39E09B;
            color: #FFFFFF;
        }

        #postLists li a:hover {
            color: #FFFFFF;
        }
    </style>
</head>
<body>
    <div class="posts-container">
        <h1 class="signup-heading">Posts Page</h1>
        <ul id="postLists">
            <?php
            require 'config.php';

            if (!isset($_SESSION['id'])) {
                header("Location: post.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $_SESSION['id']]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></li>';
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
</html>
