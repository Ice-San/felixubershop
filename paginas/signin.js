const form = document.getElementById("form");

const errorEmail = document.getElementById("error-email");
const errorPassword = document.getElementById("error-password");

form.addEventListener("submit", e => {
    let hasError = false;
    
    const emailInput = document.getElementById("email").value;
    const passwordInput = document.getElementById("password").value;

    errorEmail.innerText = "";
    errorPassword.innerText = "";

    errorEmail.classList.add("hide");
    errorPassword.classList.add("hide");

    const email = emailInput.trim();
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(!emailRegex.test(email)) {
        errorEmail.innerText = "Invalid email format!";
        errorEmail.classList.remove("hide");
        hasError = true;
    }

    if(emailInput.length > 100) {
        errorEmail.innerText = "Emails cannot have more than 100 characters!";
        errorEmail.classList.remove("hide");
        hasError = true;
    }

    if(passwordInput.length < 6) {
        errorPassword.innerText = "Password needs to be at least 6 characters!";
        errorPassword.classList.remove("hide");
        hasError = true;
    }

    if(passwordInput.length > 255) {
        errorPassword.innerText = "Password cannot have more than 255 characters!";
        errorPassword.classList.remove("hide");
        hasError = true;
    }

    if(hasError) {
        e.preventDefault();
    }
});