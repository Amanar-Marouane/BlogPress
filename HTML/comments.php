<?php
session_start();
if (!isset($_SESSION['loged_user_id'])) {
    header('Location: ./auth.php');
}
include_once './header.php';
$conn = new mysqli("localhost", "root", "analikayn", "blogpress");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Comments</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>

<body class="HomeBody">
    <div class="comments-container">
        <h2>Your Comments</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Comment Description</th>
                    <th>Date</th>
                    <th>Article ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <?php
            $user_id = (int) $_SESSION['loged_user_id'];
            $sql = "SELECT * FROM comments WHERE user_id = '$user_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                    $comment_id = $row['comment_id'];
                    $description = $row['comment_desc'];
                    $date = $row['created_at'];
                    $article_id = $row['article_id'];
                    echo "
                        <tbody>
                            <tr>
                                <td>$i</td>
                                <td>$description</td>
                                <td>$date</td>
                                <td>$article_id</td>
                                <td>
                                    <button class='delete-btn'><a href='./comment_delete.php?comment_id=$comment_id'>Delete</a></button>
                                </td>
                            </tr>
                        </tbody>
                        ";
                    $i++;
                }
            }
            ?>
        </table>
    </div>

</body>

</html>
<?php
include_once './footer.php';
exit();
?>