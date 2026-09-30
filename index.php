<?php 

require_once __DIR__ . '/BookRepository.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

//TESTER
header('Content-Type: application/json');
echo json_encode([
    'uri' => $uri, 
    'method' => $method,
    ]);

require 'Database.php';
$pdo = getDbConnection();
var_dump($pdo);

$newId = createBook($pdo, ['title' => 'Dune', 'author' => 'Herbert', 'year' => 1965]);
var_dump($newId);
var_dump(getAllBooks($pdo));

