<?php
$conn = new mysqli("localhost", "root", "analikayn", "blogpress");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data["articleId"]) && isset($data["status"])) {
        $postId = $data['articleId'];
        $status = $data['status'];
        echo json_encode(['success' => true, 'postId' => $postId, 'status' => $status]);
        if ($status == true) {
            $sql = "UPDATE articles SET likes_number = likes_number + 1 WHERE article_id = $postId;";
        } else {
            $sql = "UPDATE articles SET likes_number = likes_number - 1 WHERE article_id = $postId;";
        }
        $result = $conn->query($sql);
        if($result){
            echo json_encode(['success' => true, 'result' => $result]);
        }
    }
}
?>