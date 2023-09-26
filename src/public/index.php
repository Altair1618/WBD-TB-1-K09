<?php

require_once __DIR__ . '/../app/config/bootstrap.php';

// Test DB Connection
try {
    $db = new Database();
    print_r($db->fetchAll("SELECT kode_fakultas FROM program_studi"));
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}
