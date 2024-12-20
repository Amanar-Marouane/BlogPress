document.addEventListener("DOMContentLoaded", function () {
    if (window.location.href.includes("http://localhost/BlogPress/HTML/article_page.php")) {
        let existing_comments = document.querySelectorAll(".co")
        if (existing_comments.length > 1) {
            existing_comments[existing_comments.length - 1].style.display = "none";
        }
    } else if (window.location.href.includes("http://localhost/BlogPress/HTML/home.php")) {
        let likes = document.querySelectorAll(".likes");
        likes.forEach(e => {
            e.addEventListener("click", () => {
                const url = e.parentElement.parentElement.querySelector("a").href;
                const urlObject = new URL(url);
                const articleId = urlObject.searchParams.get("article_id");

                if (e.querySelector("svg path").style.fill === "rgb(0, 123, 255)") {
                    e.querySelector("svg path").style.fill = "rgb(85, 85, 85)";
                    e.querySelector("h6").innerHTML = Number(e.querySelector("h6").innerHTML) - 1;
                    updateLikes(articleId, false);
                } else {
                    e.querySelector("svg path").style.fill = "rgb(0, 123, 255)";
                    e.querySelector("h6").innerHTML = Number(e.querySelector("h6").innerHTML) + 1;
                    updateLikes(articleId, true);
                }
            })
        })
        function updateLikes(articleId, bool) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        console.log('Likes updated successfully');
                    } else {
                        console.error('Error updating likes');
                    }
                }
            };

            xhttp.open("POST", "./../HTML/likes.php", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(JSON.stringify({ "articleId": articleId, status: bool }));
        }
    }
    else {
        let transi = document.querySelectorAll(".transi");
        let p1 = document.querySelector(".p1");
        let p2 = document.querySelector(".p2");
        let back = document.querySelector(".back");
        let logBtns = document.querySelector(".logBtns");
        let form = document.querySelectorAll(".form");
        let passIcon = document.querySelectorAll(".passIcon");
        let signUpForm = document.querySelector(".signUpForm");
        let logInForm = document.querySelector(".logInForm");
        let errorMsg = document.querySelector(".errorMsg");


        if (errorMsg.innerHTML !== '') {
            setTimeout(() => {
                errorMsg.innerHTML = '';
            }, 3000);
        }
        errorMsg.addEventListener("change", () => {
            setTimeout(() => {
                errorMsg.innerHTML = '';
            }, 3000);
        });

        transi.forEach(e => {
            e.onclick = () => {
                form.forEach(e => e.reset());
                p1.style.height = '0%';
                p2.style.height = '100%';
                if (e.className.includes("signUp")) {
                    setTimeout(() => {
                        signUpForm.style.display = "flex"
                        p1.style.display = 'none';
                        back.style.display = "block";
                        logBtns.style.display = "none";
                    }, 1000)
                }
                if (e.className.includes("logIn")) {
                    setTimeout(() => {
                        logInForm.style.display = "flex"
                        p1.style.display = 'none';
                        back.style.display = "block";
                        logBtns.style.display = "none";
                    }, 1000)
                }
            }
        })

        back.onclick = () => {
            form.forEach(e => e.reset());
            p1.style.display = 'flex';
            p2.style.transform = 'translateY(150%)';
            p2.style.height = '50%';
            setTimeout(() => {
                p1.style.height = '50%';
                form.forEach(e => e.style.display = 'none');
                back.style.display = "none";
                logBtns.style.display = "flex";
                p2.style.transform = 'translateY(0%)';
            }, 1000)
        }

        passIcon.forEach(e => {
            e.onclick = () => {
                passwordInput = e.parentElement.querySelector("input");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    e.querySelector("img").src = "./../media/eye.svg";
                } else {
                    e.querySelector("img").src = "./../media/eye-slash.svg";
                    passwordInput.type = "password";
                }
            }
        })
    }
})