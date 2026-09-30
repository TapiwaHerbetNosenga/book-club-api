<?php 

require_once __DIR__ . '/BookRepository.php';
require 'Database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$pdo = getDbConnection();

//TESTER
header('Content-Type: application/json');

if ($uri === '/books' && $method === 'GET') {
    echo json_encode(getAllBooks($pdo));
    exit;
}

if ($uri === '/books' && $method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (empty($input['title']) || empty($input['author'])) {
        http_response_code(422);
        echo json_encode(['error' => 'title and author are required']);
        exit;
    }

    $newId = createBook($pdo, $input);
    http_response_code(201);
    echo json_encode(getBookById($pdo, $newId));
    exit;
}

if (preg_match('#^/books/(\d+)$#', $uri, $matches) && $method === 'GET') {
    $book = getBookById($pdo, (int) $matches[1]);

    if ($book === null) {
        http_response_code(404);
        echo json_encode(['error' => 'Book not found']);
        exit;
    }

    echo json_encode($book);
    exit;
}

if (preg_match('#^/books/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $deleted = deleteBook($pdo, (int) $matches[1]);

    if (!$deleted) {
        http_response_code(404);
        echo json_encode(['error' => 'Book not found']);
        exit;
    }

    http_response_code(200);
    echo json_encode(['message' => 'Book deleted']);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);

