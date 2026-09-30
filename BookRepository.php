<?php

function getAllBooks(PDO $pdo): array {
    $stmt = $pdo->query('SELECT * FROM books ORDER BY id');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createBook(PDO $pdo, array $data): int {
    $stmt = $pdo->prepare(
        'INSERT INTO books (title, author, year) VALUES (:title, :author, :year)'
    );

    $stmt->execute([
        ':title'  => $data['title'],
        ':author' => $data['author'],
        ':year'   => $data['year'],
    ]);

    return (int) $pdo->lastInsertId();
}

function getBookById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
    $stmt->execute([':id' => $id]);

    $book = $stmt->fetch(PDO::FETCH_ASSOC);
    return $book === false ? null : $book;
}

function deleteBook(PDO $pdo, int $id): bool {
    $stmt = $pdo->prepare('DELETE FROM books WHERE id = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount() > 0;
}