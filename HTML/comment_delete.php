<?php
    $comment_id = $_GET['comment_id'];
    $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM comments WHERE comment_id = $comment_id";
    $result = $conn->query($sql);
    header("Location: ./comments.php");
?>