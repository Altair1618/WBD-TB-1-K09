<?php

// Ports
define('HTTP_PORT', 8008);
define('DB_PORT', 5432);

// URL
define('BASE_URL', 'http://localhost:'. HTTP_PORT .'/');

// Database Configuration
define('DB_HOST', $_ENV['POSTGRES_HOST']);
define('DB_NAME', $_ENV['POSTGRES_DB']);
define('DB_USER', $_ENV['POSTGRES_USER']);
define('DB_PASS', $_ENV['POSTGRES_PASSWORD']);

// Pagination Configuration
define('ITEMS_PER_PAGE', 10);

// File Upload Configuration
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100 MB

// Debounce Configuration
define('DEBOUNCE_TIME', 500); // 500 ms
