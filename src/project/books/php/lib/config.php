<?php

define('DB_HOST', 'mysql-container');
define('DB_NAME', 'testdb');
define('DB_USER', 'testuser');
define('DB_PASS', 'mysecret');
define('DB_CHARSET', 'utf8mb4');

define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET);

define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);

spl_autoload_register(function ($class) {
    $classFile = __DIR__ . '/../classes/' . $class . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

?>