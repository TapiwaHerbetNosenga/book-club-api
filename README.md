# Book Club Manager

A small REST API built with plain PHP (no framework) and SQLite, with a browser frontend built from HTML, CSS, and inline JavaScript.

## Features

- Full CRUD-style API: list, view, add, and delete books
- Input validation with proper HTTP status codes (201, 404, 422, 500)
- Prepared statements through PDO
- CORS support for a separate frontend
- Responsive UI with dark mode

## API

| Method | Endpoint      | Description        |
|--------|---------------|--------------------|
| GET    | /books        | List all books     |
| GET    | /books/{id}   | Get one book       |
| POST   | /books        | Add a book         |
| DELETE | /books/{id}   | Delete a book      |

Example request body for `POST /books`:

```json
{ "title": "Dune", "author": "Frank Herbert", "year": 1965 }
```

## Run it locally

Requires PHP 8+ with the `pdo_sqlite` extension.

```bash
php setup-db.php            # creates books.sqlite from schema.sql
php -S localhost:8000 index.php
```

In a second terminal, open `frontend/index.html` in a browser (or use the VS Code Live Server extension). The frontend expects the API at `http://localhost:8000`.

## Project structure

```
index.php             API router / single entry point
Database.php          PDO connection to SQLite
BookRepository.php    Functions for book queries and writes
schema.sql            Books table definition
setup-db.php          Database setup script
books.sqlite          SQLite database file (created by setup-db.php)
frontend/
	index.html          Browser UI and inline JavaScript
	style.css           Frontend styles
```

## What I learned

- How a single entry point routes requests by URL and HTTP method
- Separating routing, data access, and presentation
- Why validation and error handling matter (never leaking stack traces)
- How CORS and preflight requests work