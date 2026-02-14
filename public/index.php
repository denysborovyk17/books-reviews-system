<?php
    /** @var PDO $pdo */
    /** @var $book */
    /** @var $books */
    /** @var $review */
    /** @var $reviews */
    /** @var $reviewsByBook */
    require __DIR__ . '/../db.php';
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
</head>
<body>
<a href="../admin/index.php">Admin Page</a>
<?php foreach($books as $book): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px">
        <b><?= htmlspecialchars($book['title']) ?></b> |
        <?= htmlspecialchars($book['author']) ?> (<?= $book['year'] ?>)

        <?php if ($book['image_path']): ?>
            <img src="../uploads/<?= $book['image_path'] ?>" width="100" height="150">
        <?php endif; ?>

        <h4>Reviews</h4>
        <?php if (isset($avgByBook[$book['id']])): ?>
            ⭐ <?= $avgByBook[$book['id']] ?>/5
        <?php else: ?>
            <i>No ratings</i>
        <?php endif; ?>
        <?php if (!empty($reviewsByBook[$book['id']])): ?>
            <?php foreach ($reviewsByBook[$book['id']] as $review): ?>
                <div style="margin-bottom:5px; padding:5px; background:#f2f2f2">
                    <b><?= htmlspecialchars($review['username']) ?></b>
                    <?= str_repeat('★', $review['rating']) ?>:
                    <?= htmlspecialchars($review['text']) ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <i>No reviews yet</i>
        <?php endif; ?>

        <form method="POST" action="addReview.php" style="margin-bottom: 10px">
            <input name="username" placeholder="Your name" required>
            <select name="rating" required>
                <option value="">Rating</option>
                <option value="5">★★★★★ (5)</option>
                <option value="4">★★★★☆ (4)</option>
                <option value="3">★★★☆☆ (3)</option>
                <option value="2">★★☆☆☆ (2)</option>
                <option value="1">★☆☆☆☆ (1)</option>
            </select>
            <textarea name="text" placeholder="Your review" required></textarea>
            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
            <button>Send</button>
        </form>
    </div>
<?php endforeach; ?>
</body>
</html>
