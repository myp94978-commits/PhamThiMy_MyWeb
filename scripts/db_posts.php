<?php
$host = '127.0.0.1';
$db   = 'PhamThiMy_MyWeb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo 'DB connection failed: ' . $e->getMessage() . "\n";
    exit(1);
}

$stmt = $pdo->query('SELECT id, title, slug, user_id, created_at FROM posts');
$rows = $stmt->fetchAll();
if (!$rows) {
    echo "No posts found\n";
    exit(0);
}
foreach ($rows as $r) {
    echo "id={$r['id']} title={$r['title']} user_id={$r['user_id']} created_at={$r['created_at']}\n";
}
