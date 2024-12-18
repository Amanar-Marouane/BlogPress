<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
</head>
<?php
session_start();
if ($_SESSION['loged_user_id']) {
    include_once './header.php';
}
?>

<body class="HomeBody">
    <main>
        <?php
        $posts = [];
        $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo '<script>console.log("Connected successfully")</script>';
        $sql = "SELECT * FROM articles;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $author_id = $row['author_id'];
                $article_id = $row['article_id'];
                $post_date = $row['created_at'];
                $title = $row['title'];
                $description = $row['arti_desc'];
                $img_src = $row['arti_img'];
                $likes = $row['likes_number'];
                $views = $row['views_number'];
                /*-----------------------------------------------------------------------------------------------------------------*/
                $sql = "SELECT COUNT(*) AS the_number FROM comments WHERE $author_id = comments.user_id;";
                $total_comments = $conn->query($sql);
                if ($total_comments->num_rows > 0) {
                    while ($row = $total_comments->fetch_assoc()) {
                        $comments = $row['the_number'];
                    }
                } else {
                    $comments = 0;
                }
                /*-----------------------------------------------------------------------------------------------------------------*/
                $sql = "SELECT user_name FROM users JOIN articles ON users.user_id = $author_id;";
                $username_result = $conn->query($sql);
                while ($row = $username_result->fetch_assoc()) {
                    $user_name = $row['user_name'];
                }
                /*-----------------------------------------------------------------------------------------------------------------*/
                echo "<div class='post'>
                            <div class='user_p'>
                                <div class='user_name'>
                                    <svg width='40px' height='40px' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M8 7C9.65685 7 11 5.65685 11 4C11 2.34315 9.65685 1 8 1C6.34315 1 5 2.34315 5 4C5 5.65685 6.34315 7 8 7Z' fill='#000000' />
                                        <path d='M14 12C14 10.3431 12.6569 9 11 9H5C3.34315 9 2 10.3431 2 12V15H14V12Z' fill='#000000' />
                                    </svg>
                                    <p>$user_name</p>
                                </div>
                                <div class='post_date'>
                                    <p>$post_date</p>
                                </div>
                            </div>
                            <a href='./article_page.php?article_id=$article_id' class='showPost'>
                                <div class='title'>
                                <h2>$title</h2>
                                </div>
                                <div class='description'>
                                    <p>$description</p>
                                </div>
                                <div class='p_img'>
                                    <img src='$img_src' alt=''>
                                </div>
                            </a>
                            <div class='st'>
                                <div class='likes'>
                                    <svg width='30px' height='30px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M8 10V20M8 10L4 9.99998V20L8 20M8 10L13.1956 3.93847C13.6886 3.3633 14.4642 3.11604 15.1992 3.29977L15.2467 3.31166C16.5885 3.64711 17.1929 5.21057 16.4258 6.36135L14 9.99998H18.5604C19.8225 9.99998 20.7691 11.1546 20.5216 12.3922L19.3216 18.3922C19.1346 19.3271 18.3138 20 17.3604 20L8 20' stroke='#000000' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round' />
                                    </svg>
                                    <h6>$likes</h6>
                                </div>
                                <div class='comments'>
                                    <svg width='30px' height='30px' viewBox='0 -0.5 25 25' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M12.5 19L12.5011 18.25H12.5V19ZM19.5 18L19.4312 18.7468C19.6412 18.7662 19.8496 18.6962 20.0054 18.5541C20.1612 18.412 20.25 18.2109 20.25 18H19.5ZM16.527 17.726L16.5958 16.9792C16.4182 16.9628 16.2405 17.0103 16.0947 17.1131L16.527 17.726ZM8.5 12.25C8.36193 12.25 8.25 12.1381 8.25 12H6.75C6.75 12.9665 7.5335 13.75 8.5 13.75V12.25ZM8.25 12C8.25 11.8619 8.36193 11.75 8.5 11.75V10.25C7.5335 10.25 6.75 11.0335 6.75 12H8.25ZM8.5 11.75C8.63807 11.75 8.75 11.8619 8.75 12H10.25C10.25 11.0335 9.4665 10.25 8.5 10.25V11.75ZM8.75 12C8.75 12.1381 8.63807 12.25 8.5 12.25V13.75C9.4665 13.75 10.25 12.9665 10.25 12H8.75ZM12.5 12.25C12.3619 12.25 12.25 12.1381 12.25 12H10.75C10.75 12.9665 11.5335 13.75 12.5 13.75V12.25ZM12.25 12C12.25 11.8619 12.3619 11.75 12.5 11.75V10.25C11.5335 10.25 10.75 11.0335 10.75 12H12.25ZM12.5 11.75C12.6381 11.75 12.75 11.8619 12.75 12H14.25C14.25 11.0335 13.4665 10.25 12.5 10.25V11.75ZM12.75 12C12.75 12.1381 12.6381 12.25 12.5 12.25V13.75C13.4665 13.75 14.25 12.9665 14.25 12H12.75ZM16.5 12.25C16.3619 12.25 16.25 12.1381 16.25 12H14.75C14.75 12.9665 15.5335 13.75 16.5 13.75V12.25ZM16.25 12C16.25 11.8619 16.3619 11.75 16.5 11.75V10.25C15.5335 10.25 14.75 11.0335 14.75 12H16.25ZM16.5 11.75C16.6381 11.75 16.75 11.8619 16.75 12H18.25C18.25 11.0335 17.4665 10.25 16.5 10.25V11.75ZM16.75 12C16.75 12.1381 16.6381 12.25 16.5 12.25V13.75C17.4665 13.75 18.25 12.9665 18.25 12H16.75ZM12.5 18.25C9.04822 18.25 6.25 15.4518 6.25 12H4.75C4.75 16.2802 8.21979 19.75 12.5 19.75V18.25ZM6.25 12C6.25 8.54822 9.04822 5.75 12.5 5.75V4.25C8.21979 4.25 4.75 7.71979 4.75 12H6.25ZM12.5 5.75C15.9518 5.75 18.75 8.54822 18.75 12H20.25C20.25 7.71979 16.7802 4.25 12.5 4.25V5.75ZM18.75 12V18H20.25V12H18.75ZM19.5688 17.2532L16.5958 16.9792L16.4582 18.4728L19.4312 18.7468L19.5688 17.2532ZM16.0947 17.1131C15.0433 17.8547 13.7878 18.252 12.5011 18.25L12.4989 19.75C14.0959 19.7524 15.6543 19.2594 16.9593 18.3389L16.0947 17.1131Z' fill='#000000' />
                                    </svg>
                                    <h6>$comments</h6>
                                </div>
                                <div class='views'>
                                    <svg width='30px' height='30px' viewBox='0 -0.5 20 20' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>

                                        <title>view_pus [#816]</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs>

                                        </defs>
                                        <g id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                                            <g id='Dribbble-Light-Preview' transform='translate(-220.000000, -4559.000000)' fill='#000000'>
                                                <g id='icons' transform='translate(56.000000, 160.000000)'>
                                                    <path d='M177,4402 C177,4401.448 177.448,4401 178,4401 L179,4401 L179,4400 C179,4399.448 179.448,4399 180,4399 C180.552,4399 181,4399.448 181,4400 L181,4401 L182,4401 C182.552,4401 183,4401.448 183,4402 C183,4402.552 182.552,4403 182,4403 L181,4403 L181,4404 C181,4404.552 180.552,4405 180,4405 C179.448,4405 179,4404.552 179,4404 L179,4403 L178,4403 C177.448,4403 177,4402.552 177,4402 M176,4412.221 C176,4413.325 175.105,4414.221 174,4414.221 C172.895,4414.221 172,4413.325 172,4412.221 C172,4411.116 172.895,4410.221 174,4410.221 C175.105,4410.221 176,4411.116 176,4412.221 M174,4416 C171.011,4416 168.195,4414.577 166.399,4412.221 C168.195,4409.864 171.011,4408.441 174,4408.441 C176.989,4408.441 179.805,4409.864 181.601,4412.221 C179.805,4414.577 176.989,4416 174,4416 M174,4406.441 C169.724,4406.441 165.999,4408.769 164,4412.221 C165.999,4415.672 169.724,4418 174,4418 C178.276,4418 182.001,4415.672 184,4412.221 C182.001,4408.769 178.276,4406.441 174,4406.441' id='view_pus-[#816]'>
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <h6>$views</h6>
                                </div>
                            </div>
                        </div>";
            }
        } else {
            echo "There's no posts at the moment. Be the first and have a candy :)";
        }
        ?>
    </main>
    <?php include './footer.php' ?>

</html>