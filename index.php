<?php

require 'Database.php';
require 'BookRepository.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// browsers send a preflight OPTIONS request before POST/DELETE from a different origin
if ($method === 'OPTIONS') {
    http_response_code(204);
    exit;
}

try {
    $pdo = getDbConnection();

    if ($uri === '/books' && $method === 'GET') {
        echo json_encode(getAllBooks($pdo));
        exit;
    }

    if ($uri === '/books' && $method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input) || empty($input['title']) || empty($input['author'])) {
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

        echo json_encode(['message' => 'Book deleted']);
        exit;
    }

    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Something went wrong']);
}
