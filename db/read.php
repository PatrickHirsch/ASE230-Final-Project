<?php

require_once('db.php');

$stmt = $pdo->query('SELECT * FROM users');
while ($row = $stmt->fetch()) {
  echo $row['name'] . "\n";
}

