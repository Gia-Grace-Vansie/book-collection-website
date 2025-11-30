<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'] ?: null;
    $rating = $_POST['rating'] ?: null;

    try {
        $sql = "INSERT INTO books (title, author, genre, publication_year, rating) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $author, $genre, $publication_year, $rating]);
        
        header('Location: index.php?message=Book added successfully!');
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>