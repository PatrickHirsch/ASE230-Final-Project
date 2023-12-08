<?php $host = '127.0.0.1';
$db = 'MyPhotoVault';
$user = 'root';
$pass = 'example';
$charset = 'utf8';
$dsn = "mysql:host=$host; port=3306 ;dbname=$db;charset=$charset";
$opt = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $user, $pass, $opt);
