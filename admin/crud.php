<?php
/** @var PDO $pdo */
/** @var $review */
/** @var $reviews */
/** @var $reviewsByBook */
require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Додати книгу
    if ($action === 'add') {
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $year = trim($_POST['year']);

        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imagePath = uniqid() . '.' . $ext;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $imagePath)) {
                die('Upload failed');
            }
        } else {
            $imagePath = null;
        }

        if ($title && $author && $year) {
            $stmt = $pdo->prepare("INSERT INTO books (title, author, year, image_path) VALUES (:title, :author, :year, :image_path)");
            $stmt->execute([
                'title' => $title,
                'author' => $author,
                'year' => $year,
                'image_path' => $imagePath
            ]);

        }
        header('Location: index.php');
        exit;
    }

    // Редагувати книгу
    if ($action === 'edit') {
        $id = (int)$_POST['book_id'];
        $title = trim($_POST['title']);
        $author = trim($_POST['author']);
        $year = trim($_POST['year']);

        $imagePath = null;
        if (!empty($_FILES['image']['name'])) {
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imagePath = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $imagePath);

            if ($id && $title && $author && $year) {
                $stmt = $pdo->prepare("UPDATE books SET title = :title, author = :author, year = :year, image_path = :image_path WHERE id = :id");
                $stmt->execute([
                    'title'  => $title,
                    'author' => $author,
                    'year'   => $year,
                    'image_path' => $imagePath,
                    'id' => $id
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE books SET title = :title, author = :author, year = :year WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'author'=> $author,
                    'year'  => $year,
                    'id'    => $id
                ]);
            }
        }
        header('Location: index.php');
        exit;
    }

    // Видалити книгу
    if ($action === 'delete') {
        $id = (int)($_POST['book_id']);
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
        header('Location: index.php');
        exit;
    }

    // Видалити відгук
    if ($action === 'delete_review') {
        $reviewId = (int)($_POST['review_id']);

        if($reviewId) {
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id");
            $stmt->execute(['id' => $reviewId]);
        }

        header('Location: index.php');
        exit;
    }
}
?>
