<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>

<body class="articleFormBody">
    <section class="error">
        <h3 class="errorMsg">
            <?php
            session_start();
            if (!isset($_SESSION['loged_user_id'])) {
                header('Location: ./auth.php');
            }
            $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                                    $sql = "INSERT INTO articles (author_id, title, arti_desc, arti_img) VALUES('$authorId', '$title', '$description', '$image');";
                                    $result = $conn->query($sql);
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
            <form action="./create_arti.php" method="POST" class="article-form">
                <div class="form-group">
                    <label for="title">Article Title</label>
                    <input type="text" id="title" value="<?php echo htmlspecialchars($title ?? ""); ?>" name="title" placeholder="Enter your article title" required>
                </div>
                <div class="form-group">
                    <label for="description">Article Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Write your article description here"><?php echo htmlspecialchars($description ?? ""); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="url" id="image" value="<?php echo htmlspecialchars($image ?? ""); ?>" name="image" placeholder="https://example.com/image.jpg">
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
exit();
?>