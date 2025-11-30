<?php
include 'config.php';

$id = $_GET['id'];

// Fetch book data
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die('Book not found');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'] ?: null;
    $rating = $_POST['rating'] ?: null;

    try {
        $sql = "UPDATE books SET title = ?, author = ?, genre = ?, publication_year = ?, rating = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $author, $genre, $publication_year, $rating, $id]);
        
        header('Location: index.php?message=Book updated successfully!');
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>✏️ Edit Book</h1>
            <a href="index.php" class="btn btn-back">← Back to Collection</a>
        </header>

        <section class="form-section">
            <form method="POST" class="book-form">
                <div class="form-group">
                    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
                </div>
                <div class="form-group">
                    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>
                </div>
                <div class="form-group">
                    <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required>
                </div>
                <div class="form-group">
                    <input type="number" name="publication_year" value="<?= $book['publication_year'] ?>" 
                           placeholder="Publication Year" min="1000" max="2024">
                </div>
                <div class="form-group">
                    <input type="number" name="rating" value="<?= $book['rating'] ?>" 
                           placeholder="Rating (1-5)" step="0.1" min="1" max="5">
                </div>
                <button type="submit" class="btn btn-primary">Update Book</button>
            </form>
        </section>
    </div>
</body>
</html>