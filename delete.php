<?php
include 'config.php';

$id = $_GET['id'];

try {
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    header('Location: index.php?message=Book deleted successfully!');
    exit();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>