<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>

<body class="articleFormBody">
    <main>
        <section class="create-article">
            <h1>Create a New Article</h1>
            <form action="./create_arti.php" method="POST" class="article-form">
                <div class="form-group">
                    <label for="title">Article Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter your article title" required>
                </div>
                <div class="form-group">
                    <label for="description">Article Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Write your article description here" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image URL</label>
                    <input type="url" id="image" name="image" placeholder="https://example.com/image.jpg">
                </div>
                <div class="form-group">
                    <button type="submit" name="post_submit" class="btn">Submit Article</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>