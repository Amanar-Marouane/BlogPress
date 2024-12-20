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
            <li><a href="./create_arti.php">Create</a></li>
            <li><a href="#">Comments</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <div class="overview">
            <div class="stat">
                <?php
                $sql = "SELECT COUNT(*) AS the_numer FROM users JOIN articles ON users.user_id = articles.author_id JOIN comments ON articles.article_id = comments.article_id WHERE {$_SESSION['loged_user_id']} = articles.author_id;";
                $resu = $conn->query($sql);
                if ($resu->num_rows > 0) {
                    $total_comments = $resu->fetch_assoc();
                    $GLOBALS['comments_num'] = $total_comments["the_numer"] ?? 0;
                }

                $sql = "SELECT SUM(views_number) AS views FROM articles WHERE author_id = {$_SESSION['loged_user_id']};";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    $total_views = $res->fetch_assoc();
                    $GLOBALS['total_views'] = $total_views["views"] ?? 0;
                }

                $sql = "SELECT COUNT(*) AS total_posts FROM articles WHERE author_id = {$_SESSION['loged_user_id']};";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $total_posts = $result->fetch_assoc();
                    $GLOBALS['total_posts'] = $total_posts['total_posts'];
                } else {
                    $GLOBALS['total_posts'] = 0;
                }
                ?>
                <h3>Total Comments</h3>
                <p id="total-comments"><?php echo $GLOBALS['comments_num']; ?></p>
            </div>
            <div class="stat">
                <h3>Total Views</h3>
                <p id="total-views"><?php echo $GLOBALS['total_views']; ?></p>
            </div>
            <div class="stat">
                <h3>Total Posts</h3>
                <p id="total-posts"><?php echo $GLOBALS['total_posts']; ?></p>
            </div>
        </div>

        <div class="arties">
            <h3>Your Posts</h3>
            <?php
            $sql = "SELECT a.*, 
                   COALESCE(c.comment_count, 0) AS comment_count 
            FROM articles a
            LEFT JOIN (
                SELECT article_id, COUNT(*) AS comment_count 
                FROM comments 
                GROUP BY article_id
            ) c ON a.article_id = c.article_id
            WHERE a.author_id = {$_SESSION['loged_user_id']};";

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
                    $comment_count = $row['comment_count'];

                    echo "<div class='arti'>
                      <a href='./article_page.php?article_id=$article_id'>
                          <h4>$title</h4>
                          <p>$desc</p>
                          <img src='$img' alt='Post's Img'>
                      </a>
                      <div class='post-stats'>
                          <p>Views: $views_number</p>
                          <p>Likes: $likes_number</p>
                          <p>Comments: $comment_count</p>
                      </div>
                      <div class='actions'>
                          <button class='btn'><a href='./create_arti.php?article_id=$article_id'>Modify</a></button>
                          <button class='btn'><a href='./delete.php?article_id=$article_id'>Delete</a></button>
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