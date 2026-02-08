<?php
    /** @var PDO $pdo */
    /** @var $books */
    /** @var $editId */
    require __DIR__ . '/../db.php';
    require 'crud.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Page</title>
</head>
<body>

<a href="../public/index.php">Home Page</a>
<h2>Add book</h2>
<form method="post" enctype="multipart/form-data">
    <input name="title" placeholder="Title" required>
    <input name="author" placeholder="Author" required>
    <input name="year" placeholder="Year" required>
    <input type="file" name="image" accept="image/*">

    <input type="hidden" name="action" value="add">
    <button>Add</button>
</form>

<hr>

<h2>Books and Reviews</h2>
<?php foreach ($books as $book): ?>
    <div style="margin-bottom:10px; display:flex; gap:10px; align-items:center">
        <?php if ($editId === $book['id']): ?>
            <form method="post" style="display:flex; gap:10px; align-items:center" enctype="multipart/form-data">
                <input name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                <input name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                <input name="year" value="<?= htmlspecialchars($book['year']) ?>" required>

                <?php if($book['image_path']): ?>
                    <img src="../uploads/books/<?= $book['image_path'] ?>" width="60">
                <?php endif; ?>

                <input type="file" name="image" accept="image/*">
                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                <input type="hidden" name="action" value="edit">
                <button>Save</button>
                <a href="index.php">Cancel</a>
            </form>
        <?php else: ?>

            <span>
                ID: <?= $book['id'] ?> |
                Назва: <?= htmlspecialchars($book['title']) ?> |
                Автор: <?= htmlspecialchars($book['author']) ?> |
                Рік: <?= $book['year'] ?> |
                <?php if ($book['image_path']): ?>
                    <img src="../uploads/books/<?= $book['image_path'] ?>" width="60">
                <?php endif; ?>
            </span>

            <a href="index.php?edit=<?= $book['id'] ?>">Edit</a>

            <form method="post" onsubmit="return confirm('Delete this book?')" style="display:inline-flex; align-items:center">
                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button>Delete</button>
            </form>
        <?php endif; ?>
    </div>
    <?php if (!empty($reviewsByBook[$book['id']])): ?>
        <?php foreach ($reviewsByBook[$book['id']] as $review): ?>
            <div style="margin-bottom:10px; display:flex; gap:10px; align-items:center">

                <form method="post" onsubmit="return confirm('Delete this review?')" style="display:inline-flex; align-items:center">
                    <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                    <input type="hidden" name="action" value="delete_review">
                    <button>✖</button>
                </form>

                <div style="margin-bottom:5px; padding:5px; background:#f2f2f2">
                    <b>Username: </b><?= htmlspecialchars($review['username']) ?> |
                    <b>Review: </b><?= htmlspecialchars($review['text']) ?> |
                    <b>Rating: </b><?= str_repeat('★', $review['rating']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

</body>
</html>
