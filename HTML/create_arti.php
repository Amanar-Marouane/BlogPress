<?php include_once './header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>

<body class="articleFormBody HomeBody">
    <section class="error">
        <h3 class="errorMsg">
            <?php
            session_start();
            if (!isset($_SESSION['loged_user_id'])) {
                header('Location: ./home.php');
            }
            $GLOBALS['conn'] = new mysqli("localhost", "root", "analikayn", "blogpress");
            if ($GLOBALS['conn']->connect_error) {
                die("Connection failed: " . $GLOBALS['conn']->connect_error);
            }
            if (isset($_GET['article_id'])) {
                $sql = "SELECT * FROM articles WHERE article_id = {$_GET['article_id']};";
                $modify = $GLOBALS['conn']->query($sql);
                if ($modify->num_rows  > 0) {
                    $row = $modify->fetch_assoc();
                    $TITLE = $row['title'];
                    $Desc = $row['arti_desc'];
                    $URL = $row['arti_img'];
                    articleSubmit(false);
                }
            } else {
                articleSubmit(true);
            }
            function articleSubmit($bool)
            {
                if (isset($_POST["post_submit"])) {
                    if (! (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['image']))) {
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $image = $_POST['image'];
                        if (!preg_match('/^[a-zA-Z0-9 ]{8,50}$/', $title)) {
                            echo "The title should include only " . "[a-zA-Z0-9 ]{8,50}";
                        } else {
                            if (!preg_match('/^[a-zA-Z0-9!?* ]{8,1000}$/', $description)) {
                                echo "The description should include only " . "[a-zA-Z0-9!?*/{}() ]{8,1000}";
                            } else {
                                if (!filter_var($image, FILTER_VALIDATE_URL)) {
                                    echo "Invalid URL format!";
                                } else {
                                    $authorId = (int)$_SESSION['loged_user_id'];
                                    if ($bool) {
                                        $sql = "INSERT INTO articles (author_id, title, arti_desc, arti_img) 
                                                VALUES('$authorId', '$title', '$description', '$image');";
                                    } else {
                                        $articleId = (int) $_GET['article_id'];
                                        $sql = "UPDATE articles SET title = '$title', arti_desc = '$description', arti_img = '$image' 
                                                WHERE article_id = $articleId;";
                                    }
                                    $result = $GLOBALS['conn']->query($sql);
                                    if (!$result) {
                                        echo "Something went wrong Try again";
                                    } else {
                                        header('Location: ./dashboard.php');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            ?>
        </h3>
    </section>
    <main>
        <section class="create-article">
            <h1>Create/Modify a New Article</h1>
            <form action="<?php if (isset($_GET['article_id'])) echo "./create_arti.php?article_id={$_GET['article_id']}";
                            else echo "./create_arti.php"; ?>" method="POST" class="article-form">
                <div class="form-group">
                    <label for="title">Article Title</label>
                    <input type="text" id="title" value="<?php if (isset($_GET['article_id'])) echo htmlspecialchars($TITLE);
                                                            else echo htmlspecialchars($title ?? ""); ?>" name="title" placeholder="Enter your article title" required>
                </div>
                <div class="form-group">
                    <label for="description">Article Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Write your article description here"><?php if (isset($_GET['article_id'])) echo htmlspecialchars($Desc);
                                                                                                                                else echo htmlspecialchars($description ?? ""); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="url" id="image" value="<?php if (isset($_GET['article_id'])) echo htmlspecialchars($URL);
                                                        else echo htmlspecialchars($image ?? ""); ?>" name="image" placeholder="https://example.com/image.jpg">
                </div>
                <div class="form-group">
                    <button type="submit" name="post_submit" class="btn">Submit Article</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
<?php
include_once './footer.php';
exit();
?>