<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="height=device-height, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="/images/favicon1.jpg">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body class = "dark">
    <!--The Top Menu Bar-->
    <div class = "dark">
        <a href="/"><img src="/images/logo_full.jpg" alt="Which Laptop" class="logo_full"></a>
        <a><div class="about">About Us</div></a>
        <a href="/profile/"><div class="about">Profile</div></a>
        <a href="/choose/"><div class="about">Choose</div></a>
        <a href="/compare/"><div class="about">Compare</div></a>
        <a href="/"><div class="about">Home</div></a>
    </div>

    <div class="dark-pro">
        <form action="" method="post">
            <input type="text" class="dark-search">
        </form>
        <div class="dark-products-page">
            <?php
			$envFile = __DIR__ . '/server.env';

            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) continue;
                    list($key, $value) = explode('=', $line, 2);
                    putenv(trim($key) . '=' . trim($value));
                }
            }

            $host = getenv('DB_HOST');
            $db   = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $port = getenv('DB_PORT');

			$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

			try{
                $pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on SQL errors
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return array indexed by column names
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
                ]);

                $r = $pdo->query("SELECT * FROM products");

                while($row = $r->fetch()){
				    $company = $row["company"];
                    $model = $row['model'];
                    echo "<div class='dark-product'><div class='dark-pro-image'></div><label>Company:</label><br><br><label1>".$company."</label1><br><br><label>Model:</label><br><br><label1>".$model."</label1></div>";
			    }
            }
            catch (PDOException $e) {
                // Handle error safely without exposing passwords
                error_log("Database Error: " . $e->getMessage());
                echo "Failed: Database operation error.";
            }
		
            ?>
        </div>
    </div>

   <footer>
        <p>&copy; Copyright 2026<br>WhichLaptop2026</p>
   </footer>
</body>
</html>