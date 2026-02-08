<?php
    $host = "localhost";
    $dbname = "books";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $books = $pdo->query("SELECT * FROM books ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $reviews = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

    // Групування відгуків по книгах
    $reviewsByBook = [];
    foreach ($reviews as $review) {
        $reviewsByBook[$review['book_id']][] = $review;
    }

    // Середній рейтинг по книгах
    $ratings = $pdo->query("SELECT book_id, AVG(rating) AS avg_rating FROM reviews GROUP BY book_id")->fetchAll(PDO::FETCH_ASSOC);

    $avgByBook = [];
    foreach ($ratings as $rating) {
        $avgByBook[$rating['book_id']] = round($rating['avg_rating'], 1);
    }

    $editId = isset($_GET['edit']) ? (int)($_GET['edit']) : 0;
?>
