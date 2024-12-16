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