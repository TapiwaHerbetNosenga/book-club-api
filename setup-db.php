<?php
// setup-db.php — run once: php setup-db.php

$pdo = new PDO('sqlite:' . __DIR__ . '/books.sqlite');
$pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));

echo "Database created.\n";