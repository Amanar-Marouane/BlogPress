<?php
    $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $article_id = $_GET['article_id'];
    $sql = "DELETE FROM articles WHERE article_id = $article_id;";
    $res = $conn -> query($sql);
    header('Location: ./dashboard.php');
?>