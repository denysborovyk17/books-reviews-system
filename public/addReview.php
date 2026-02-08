<?php
/** @var PDO $pdo */
/** @var $book */
/** @var $books */
/** @var $review */
/** @var $reviews */
/** @var $reviewsByBook */
require __DIR__ . '/../db.php';

// Додаємо відгук користувача
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookId = (int)($_POST['book_id']);
    $rating = (int)($_POST['rating']);
    $username = trim($_POST['username']);
    $text = trim($_POST['text']);

    if ($bookId && $username && $text && $rating >= 1 && $rating <= 5) {
        $stmt = $pdo->prepare("INSERT INTO reviews (book_id, username, text, rating) VALUES (:book_id, :username, :text, :rating)");
        $stmt->execute([
            'book_id' => $bookId,
            'username' => $username,
            'text' => $text,
            'rating' => $rating
        ]);
    }

    header('Location: index.php');
    exit;
}
?>
