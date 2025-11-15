<?php
if(file_exists(__DIR__.'/../.env.local')){
    $lines = file(__DIR__.'/../.env.local', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
    <link rel="stylesheet" href="css/template.css">
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