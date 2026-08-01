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
    
    <div class="product-outer-dark">
        <div class="product-img">
        </div>
        <?php
            $id = $_GET['id'];

            $envFile = __DIR__ . '/../server.env';

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

                $r = $pdo->query("SELECT * FROM products WHERE id = '$id'");

                $row = $r->fetch();
				
                $company = $row["company"];
                $model = $row['model'];
                $ram = $row['ram'];
                $disk = $row['disk'];
                $rwspeeds = $row['rwspeeds'];
                $display = $row['display'];
                $keyboard = $row['keyboard'];
                $rgb = $row['rgb'];
                $ports = $row['ports'];
                $cpu = $row['cpu'];
                $gpu = $row['gpu'];
                $speakers = $row['speakers'];
                $camera = $row['camera'];
                $extraf = $row['extraf'];
                
                echo "<label>Company: <label1>".$company."</label1></label><br><br>
                    <label>Model Name: <label1>".$model."</label1></label><br><br>
                    <label>Ram: <label1>".$ram."</label1></label><br><br>
                    <label>SSD/HDD: <label1>".$disk."</label1></label><br><br>
                    <label>r/w Speeds: <label1>".$rwspeeds."</label1></label><br><br>
                    <label>Display: <label1>".$display."</label1></label><br><br>
                    <label>Keyboard: <label1>".$keyboard."</label1></label><br><br>
                    <label>RGB: <label1>".$rgb."</label1></label><br><br>
                    <label>Ports: <label1>".$ports."</label1></label><br><br>
                    <label>CPU: <label1>".$cpu."</label1></label><br><br>
                    <label>GPU: <label1>".$gpu."</label1></label><br><br>
                    <label>Speakers: <label1>".$speakers."</label1></label><br><br>
                    <label>Camera: <label1>".$camera."</label1></label><br><br>
                    <label>Extra Features: <label1>".$extraf."</label1></label><br><br>";
            }
            catch (PDOException $e) {
                // Handle error safely without exposing passwords
                error_log("Database Error: " . $e->getMessage());
                echo "Failed: Database operation error.";
            }
        ?>
        
    </div>

   <footer>
        <p>&copy; Copyright 2026<br>WhichLaptop2026</p>
   </footer>
</body>
</html>