<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up/In</title>
    <link rel="stylesheet" href="./../CSS/Style.css">
    <script defer src="./../JS/script.js"></script>
</head>

<body class="authPage">
    <section class="error">
        <h3 class="errorMsg">
            <?php
            session_start();
            if ($_SESSION['loged_user_id']) {
                header('Location: ./home.php');
            }
            $passwordToVerify = null;
            if (isset($_POST['signup'])) {
                if (empty($_POST['user_name']) || empty($_POST['email']) || empty($_POST['password'])) {
                    echo "All the inputs should be filled.";
                } else {
                    $user_name = htmlspecialchars($_POST['user_name']);
                    $GLOBALS['email'] = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);
                    function signUpForm($user_name, $email, $password)
                    {
                        echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let signUpForm = document.querySelector('.signUpForm');
                                        let p1 = document.querySelector('.p1');
                                        let p2 = document.querySelector('.p2');
                                        let back = document.querySelector('.back');
                                        let logBtns = document.querySelector('.logBtns');
                                        logBtns.style.display = 'none';
                                        p1.style.height = '0%';
                                        p2.style.height = '100%';
                                        signUpForm.style.display = 'flex';
                                        p1.style.display = 'none';
                                        back.style.display = 'block';
                                        logBtns.style.display = 'none';
                                        signUpForm.querySelectorAll('input')[0].value= '$user_name';
                                        signUpForm.querySelectorAll('input')[1].value= '$email';
                                        signUpForm.querySelectorAll('input')[2].value= '$password';
                                    });
                                </script>";
                    }
                    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "You should include a valid Email format!!";
                        signUpForm($user_name, $GLOBALS['email'], $password);
                    } else {
                        if (!preg_match('/^[a-zA-Z 0-9]+$/', $user_name)) {
                            echo "The user name should only include [a-zA-Z0-9]";
                            signUpForm($user_name, $GLOBALS['email'], $password);
                        } else {
                            if (
                                !(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[*!@#?\-_$£]).{8,20}+$/', $password))
                            ) {
                                echo "The user name should only include [a-zA-Z0-9!@#?-_\$£] and got at least 8 caracters and maximum of 20 caracters";
                                signUpForm($user_name, $GLOBALS['email'], $password);
                            } else {
                                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                                $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                echo '<script>console.log("Connected successfully")</script>';
                                $sql = "SELECT gmail FROM users WHERE gmail = '$email';";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "This email adress already in use!";
                                    signUpForm($user_name, $GLOBALS['email'], $password);
                                } else {
                                    $sql = "SELECT user_name FROM users WHERE user_name = '$user_name';";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        echo "This user name already in use!";
                                        signUpForm($user_name, $GLOBALS['email'], $password);
                                    } else {
                                        $sql = 'INSERT INTO users (user_name, gmail, user_password) VALUES ("' . $user_name . '", "' . $email . '", "' . $hashedPassword . '");';
                                        $result = $conn->query($sql);
                                        header('Location: https://www.google.com/');
                                        exit();
                                    }
                                }
                                $conn->close();
                            }
                        }
                    }
                }
            }
            if (isset($_POST['login'])) {
                if (empty($_POST['emailToLogIn']) || empty($_POST['passwordToLogIn'])) {
                    echo "All the inputs should be filled.";
                } else {
                    $logPassword = htmlspecialchars($_POST['passwordToLogIn']);
                    $logEmail = htmlspecialchars($_POST['emailToLogIn']);
                    function logInForm($logEmail, $logPassword)
                    {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let logInForm = document.querySelector('.logInForm');
                                    let p1 = document.querySelector('.p1');
                                    let p2 = document.querySelector('.p2');
                                    let back = document.querySelector('.back');
                                    let logBtns = document.querySelector('.logBtns');
                                    logBtns.style.display = 'none';
                                    p1.style.height = '0%';
                                    p2.style.height = '100%';
                                    logInForm.style.display = 'flex'
                                    p1.style.display = 'none';
                                    back.style.display = 'block';
                                    logBtns.style.display = 'none';
                                    logInForm.querySelectorAll('input')[1].value = '$logPassword';
                                    logInForm.querySelectorAll('input')[0].value = '$logEmail';
                                });
                            </script>";
                    }
                    if (! filter_var($logEmail, FILTER_VALIDATE_EMAIL)) {
                        echo "You should include a valid Email format!!";
                        logInForm($logEmail, $logPassword);
                    } else {
                        $conn = new mysqli("localhost", "root", "analikayn", "blogpress");
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        echo '<script>console.log("Connected successfully for log in")</script>';
                        $sql = "SELECT user_password, user_id from users WHERE gmail = '$logEmail';";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $GLOBALS['passwordToVerify'] = htmlspecialchars($row['user_password']);
                                $_SESSION['loged_user_id'] = $row['user_id'];
                            }
                        }
                        if (password_verify($logPassword, $GLOBALS['passwordToVerify'])) {
                            echo "Sign In Done Successfully";
                            header('Location: ./home.php');
                            exit();
                        } else {
                            echo "Check your email adress or password.";
                            logInForm($logEmail, $logPassword);
                        }
                        $conn->close();
                    }
                }
            }
            ?>
        </h3>
    </section>
    <section class="logPage">
        <div class="p1">
            <img class="logo" src="./../media/logo.svg" alt="Logo">
            <h1>Welcome to</h1>
            <h2><span>BlogPress</span> — Your Gateway to Inspiration</h2>
        </div>
        <div class="p2">
            <img class="back" src="./../media/back.svg" alt="Previous Tap">
            <form class="form signUpForm" action="auth.php" method="POST">
                <h2>Create your account:</h2>
                <input required type="text" autocomplete="off" name="user_name" id="user_name" placeholder="user name">
                <input required type="email" name="email" id="email" placeholder="example@gmail.com">
                <div class="password">
                    <input required type="password" autocomplete="on" name="password" id="password" placeholder="Enter your password">
                    <label for="password" class="icon-label passIcon">
                        <img src="./../media/eye-slash.svg" alt="Toggle visibility">
                    </label>
                </div>
                <button type="submit" name="signup" class="formBtn btn">Sign Up</button>
            </form>
            <form class="form logInForm" action="auth.php" method="POST">
                <h2>Sign in to your account:</h2>
                <input required type="email" name="emailToLogIn" id="emailToLogIn" placeholder="example@gmail.com">
                <div class="password">
                    <input required type="password" autocomplete="on" name="passwordToLogIn" id="passwordToLogIn" placeholder="Enter your password">
                    <label for="password" class="icon-label passIcon">
                        <img src="./../media/eye-slash.svg" alt="Toggle visibility">
                    </label>
                </div>
                <button type="submit" name="login" class="formBtn btn">Log IN</button>
            </form>
            <div class="logBtns">
                <button class="btn signUp transi">Sign Up</button>
                <button class="btn logIn transi">Log In</button>
                <button class="btn visit"><a href="./home.php">I'm just a visitor</a></button>
            </div>
        </div>
    </section>
</body>

</html>