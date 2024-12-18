<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "TITLE"; ?></title>
    <link rel="stylesheet" href="./../CSS/Style.css">
    <script defer src="./../JS/script.js"></script>
</head>
<?php
session_start();
$conn = new mysqli("localhost", "root", "analikayn", "blogpress");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SESSION['loged_user_id']) {
    include_once './header.php';
    echo "<script>
            document.addEventListener('DOMContentLoaded', function(){
                document.getElementById('user_name_comment').style.display = 'none';
            })
        </script>";

    $sql = "SELECT user_name FROM users WHERE user_id = {$_SESSION['loged_user_id']};";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($name = $res->fetch_assoc()) {
            $GLOBALS['user_name_comment'] = $name['user_name'];
        }
    }
}
$article_id = $_POST["article_id"] ?? $_GET['article_id'];
$sql = "UPDATE articles SET views_number = views_number + 1 WHERE articles.article_id = $article_id;";
$views_update = $conn->query($sql);

$sql = "SELECT * FROM articles WHERE article_id = $article_id;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $author_id = $row['author_id'];
?>

        <body class="ArticleBody HomeBody">
            <section class="error">
                <h3 class="errorMsg">
                    <?php
                    if (isset($_POST['comment_submit'])) {
                        $GLOBALS['user_name_comment'] = $GLOBALS['user_name_comment'] ?? htmlspecialchars($_POST['user_name_comment']);
                        echo"<script>console.log('{$GLOBALS['user_name_comment']}')</script>";
                        if (is_null($GLOBALS['user_name_comment']) || empty($_POST['comment_text'])) {
                            echo "All the inputs should be filled.";
                        } else {
                            $GLOBALS['comment_text'] = htmlspecialchars($_POST['comment_text']);
                            if (!preg_match('/^[a-zA-Z 0-9]+$/', $GLOBALS['user_name_comment'])) {
                                echo "The user name should only include [a-zA-Z0-9]";
                            } else {
                                $comment_text = $GLOBALS['comment_text'];
                                $sql = "INSERT INTO comments (article_id, user_name, comment_desc) VALUE ($article_id, '{$GLOBALS['user_name_comment']}', '$comment_text');";
                                $result5 = $conn->query($sql);
                                header("Location: " . $_SERVER["PHP_SELF"] . "?article_id=" . urlencode($article_id));
                            }
                        }
                    }
                    ?>
                </h3>
            </section>
            <main class="article-page">
                <section class="article">
                    <div class="article-header">
                        <h1><?php echo $row['title']; ?></h1>
                        <p>By <span class="author"><?php
                                                    $sql = "SELECT users.user_name FROM users JOIN articles ON users.user_id = $author_id LIMIT 1;";
                                                    $author_name = $conn->query($sql);
                                                    if ($author_name->num_rows > 0) {
                                                        while ($row1 = $author_name->fetch_assoc()) {
                                                            echo $row1["user_name"];
                                                        }
                                                    }
                                                    ?></span> | <span class="post-date"><?php echo $row['created_at']; ?></span></p>
                    </div>
                    <div class="article-content">
                        <img src="<?php echo $row['arti_img']; ?>" alt="Article Image">
                        <p><?php echo $row['arti_desc']; ?></p>
                    </div>
                    <div class="article-stats">
                        <div class="likes">
                            <h6>Likes: <span id="likes-count"><?php echo $row['likes_number']; ?></span></h6>
                        </div>
                        <div class="views">
                            <h6>Views: <span id="views-count"><?php echo $row['views_number']; ?></span></h6>
                        </div>
                    </div>
                </section>
                <section class="comments-section">
                    <h2>Comments(<?php
                                    $sql = "SELECT COUNT(*) AS the_number FROM comments JOIN articles ON articles.article_id = comments.article_id WHERE comments.article_id = $article_id;";
                                    $comment_num = $conn->query($sql);
                                    if ($comment_num->num_rows > 0) {
                                        while ($row2 = $comment_num->fetch_assoc()) {
                                            echo $row2["the_number"];
                                        }
                                    }
                                    ?>)</h2>
                    <div class="All_comments">
                        <?php
                        $sql = "SELECT comments.user_name, comments.comment_desc, comments.created_at FROM comments JOIN articles ON articles.article_id = comments.article_id WHERE comments.article_id = $article_id;";
                        $all_the_comments = $conn->query($sql);
                        if ($all_the_comments->num_rows > 0) {
                            while ($row10 = $all_the_comments->fetch_assoc()) {
                                $name = $row10['user_name'];
                                $context = $row10["comment_desc"];
                                $created_at = $row10["created_at"];
                                echo "<div class='comments'>
                                        <div class='comment co'>
                                            <div class='comment-header'>
                                                <h4 class='comment-user'>$name</h4>
                                                <small class='comment-date'>$created_at</small>
                                            </div>
                                            <p class='comment-desc'>$context</p>
                                        </div>
                                    </div>";
                            }
                        }
                        ?>
                    </div>
                    <p class="no-comments co">No comments yet. Be the first to comment!</p>
                    <h2 class="com_header">Give Us Your Openion</h2>
                    <form class="add-comment" action="article_page.php" method="POST">
                        <input type="text" hidden name="article_id" value="<?php echo $article_id; ?>">
                        <input type="text" name="user_name_comment" id="user_name_comment" placeholder="User Name here..." class="user name input">
                        <textarea name="comment_text" id="comment_text" placeholder="Write your comment here..." rows="4"></textarea>
                        <button type="submit" name="comment_submit" class="btn">Submit Comment</button>
                    </form>
                </section>
            </main>
            <?php include './footer.php' ?>

</html>
<?php
    }
}
exit();
?>