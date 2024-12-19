<?php
session_start();
if (!isset($_SESSION['loged_user_id'])) {
    header('Location: ./auth.php');
}
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>

<body class="HomeBody">

    <nav class="dashboardNav">
        <ul>
            <li><a href="./dashboard.php">Dashboard</a></li>
            <li><a href="./home.php">Home</a></li>
            <li><a href="#">Create</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <div class="overview">
            <div class="stat">
                <?php
                $sql = "SELECT COUNT(*) AS the_numer FROM users JOIN articles ON users.user_id = articles.author_id JOIN comments ON articles.article_id = comments.article_id WHERE {$_SESSION['loged_user_id']} = articles.author_id;";
                $resu = $conn->query($sql);
                if ($resu->num_rows > 0) {
                    while ($total_comments = $resu->fetch_assoc()) {
                        $GLOBALS['comments_num'] = $total_comments["the_numer"];
                    }
                }
                ?>
                <h3>Total Comments</h3>
                <p id="total-comments"><?php
                echo $GLOBALS['comments_num'];?></p>
            </div>
            <div class="stat">
                <h3>Total Views</h3>
                <p id="total-views">0</p>
            </div>
            <div class="stat">
                <h3>Total Posts</h3>
                <p id="total-posts">0</p>
            </div>
        </div>

        <div class="arties">
            <h3>Your Posts</h3>
            <?php
            $sql = "SELECT * FROM articles WHERE author_id = {$_SESSION['loged_user_id']};";
            $res = $conn->query($sql);
            if ($res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $title = $row['title'];
                    $desc = $row['arti_desc'];
                    $created_at = $row['created_at'];
                    $img = $row['arti_img'];
                    $views_number = $row['views_number'];
                    $likes_number = $row['likes_number'];
                    $article_id = $row['article_id'];
                    $sql = "SELECT COUNT(*) AS the_numer FROM comments JOIN articles ON articles.article_id = comments.article_id JOIN users ON users.user_id = articles.author_id WHERE users.user_id = 1;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($ro = $result->fetch_assoc()) {
                            $GLOBALS['the_number'] = $ro['the_numer'];
                        }
                    } else {
                    }
                    echo "<div class='arti'>
                                <a href='./article_page.php?article_id=$article_id'>
                                    <h4>$title</h4>
                                    <p>$desc</p>
                                    <img src='$img' alt='Post's Img'>
                                </a>
                                <div class='post-stats'>
                                    <p>Views: $views_number</p>
                                    <p>Likes: $likes_number</p>
                                    <p>Comments: {$GLOBALS['the_number']}</p>
                                </div>
                                <div class='actions'>
                                    <button class='btn'>Modify</button>
                                    <button class='btn'>Delete</button>
                                </div>
                            </div>";
                }
            }
            ?>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2024 User Dashboard</p>
    </footer>

</body>

</html>
<?php
exit();
?>