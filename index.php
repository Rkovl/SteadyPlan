<?php
if(file_exists(__DIR__.'/.env.local')){
    $lines = file(__DIR__.'/.env.local', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        putenv($line);
    }
}

// Database configuration - Neon connection string
$conn_string = getenv('DATABASE_URL');

// Connect to database
try {
    $conn = pg_connect($conn_string);
    if (!$conn) {
        throw new Exception("Failed to connect to database");
    }
    $db_status = "✓ Connected to Neon database";
} catch (Exception $e) {
    $db_status = "✗ Database connection failed: " . $e->getMessage();
    $conn = null;
}

// Fetch some data if connected
$data = [];
if ($conn) {
    $result = pg_query($conn, "SELECT version()");
    if ($result) {
        $row = pg_fetch_assoc($result);
        $data['version'] = $row['version'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP + Neon + Render</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .info-box h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .info-box p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 PHP + Neon + Render</h1>
        <p class="subtitle">Basic website template</p>
        
        <div class="status <?php echo $conn ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($db_status); ?>
        </div>
        
        <?php if ($conn && !empty($data)): ?>
        <div class="info-box">
            <h3>Database Info</h3>
            <p><?php echo htmlspecialchars($data['version']); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="info-box">
            <h3>Setup Instructions</h3>
            <p>1. Replace database credentials at the top of <code>index.php</code></p>
            <p>2. Deploy to Render as a Web Service</p>
            <p>3. Make sure Apache and PHP with PostgreSQL are installed</p>
        </div>
    </div>
</body>
</html>
<?php
if ($conn) {
    pg_close($conn);
}
?>