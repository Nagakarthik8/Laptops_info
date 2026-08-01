<?php
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

    $company = $_POST['company'];
    $model = $_POST['model'];
    $ram = $_POST['ram'];
    $disk = $_POST['disk'];
    $rwspeeds = $_POST['rwspeeds'];
    $display = $_POST['display'];
    $keyboard = $_POST['keyboard'];
    $rgb = $_POST['rgb'];
    $ports = $_POST['ports'];
    $cpu = $_POST['cpu'];
    $gpu = $_POST['gpu'];
    $speakers = $_POST['speakers'];
    $camera = $_POST['camera'];
    $extraf = $_POST['extraf'];

    $dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";
    
    try{
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on SQL errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Return array indexed by column names
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
    ]);

    $stmt = $pdo->prepare("INSERT INTO products(company,model,ram,disk,rwspeeds,display,keyboard,rgb,ports,cpu,gpu,speakers,camera,extraf) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    if($stmt === false){
        die('Preparation Failed');
    }

    $success = $stmt->execute([$company, $model, $ram, $disk, $rwspeeds, $display, $keyboard, $rgb, $ports, $cpu, $gpu, $speakers, $camera, $extraf]);
    if($success){
        echo "Success";
    }
    else{
        echo "Failed";
    }
    }
    catch (PDOException $e) {
        // Handle error safely without exposing passwords
        error_log("Database Error: " . $e->getMessage());
        echo "Failed: Database operation error.";
    }
?>