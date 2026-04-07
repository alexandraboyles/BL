<?php
declare(strict_types=1);

$config = require __DIR__ . '/config.php';

try {
    // $pdo = new PDO(
    // 'mysql:host=127.0.0.1;dbname=BL;charset=utf8mb4',
    // 'training_user',
    // 'training_pass',
    // [
    // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // ]
    // ); 
    $pdo = new PDO(
        $config['db']['dsn'],
        $config['db']['user'],
        $config['db']['pass'],
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    echo 'Connected OK' . PHP_EOL . PHP_EOL;

} catch (PDOException $e) {
    echo 'Database connection failed.';
}