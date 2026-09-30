<?php

function getDbConnection(): PDO {
    $pdo = new PDO('sqlite:' . __DIR__ . '/books.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}