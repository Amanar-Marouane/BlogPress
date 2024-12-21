<?php
    session_start();
    $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $id = (int) $_SESSION['loged_user_id'];
    $sql = "SELECT views_number, likes_number, title FROM articles WHERE author_id = $id;";
    $data = $conn->query($sql);
    $DATA = [];
    if ($data->num_rows > 0) {
        while ($view = $data->fetch_assoc()) {
            array_push($DATA, $view);
        }
    }
    echo json_encode($DATA);
    exit();
?>