<?php
session_start();
try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(['error' => 'Method not POST']);
        return;
    }

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Log out successful',
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

exit;
