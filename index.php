<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Collection Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Book Collection Manager</h1>
            <p>Manage your personal book collection</p>
        </header>

        <!-- Add Book Form -->
        <section class="form-section">
            <h2>Add New Book</h2>
            <form action="create.php" method="POST" class="book-form">
                <div class="form-group">
                    <input type="text" name="title" placeholder="Book Title" required>
                </div>
                <div class="form-group">
                    <input type="text" name="author" placeholder="Author" required>
                </div>
                <div class="form-group">
                    <input type="text" name="genre" placeholder="Genre" required>
                </div>
                <div class="form-group">
                    <input type="number" name="publication_year" placeholder="Publication Year" min="1000" max="2024">
                </div>
                <div class="form-group">
                    <input type="number" name="rating" placeholder="Rating (1-5)" step="0.1" min="1" max="5">
                </div>
                <button type="submit" class="btn btn-primary">Add Book</button>
            </form>
        </section>

        <!-- Books Table -->
        <section class="table-section">
            <h2>Your Book Collection</h2>
            <?php
            $stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($books) > 0): ?>
            <div class="table-container">
                <table class="books-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Rating</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= $book['id'] ?></td>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['genre']) ?></td>
                            <td><?= $book['publication_year'] ?></td>
                            <td>
                                <?php if ($book['rating']): ?>
                                    ⭐ <?= $book['rating'] ?>/5
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $book['id'] ?>" class="btn btn-edit">Edit</a>
                                <a href="delete.php?id=<?= $book['id'] ?>" 
                                   class="btn btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="no-books">No books in your collection yet. Add your first book above!</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>