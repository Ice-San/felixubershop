const form = document.getElementById("form");

const errorUsername = document.getElementById("error-username");
const errorEmail = document.getElementById("error-email");
const errorPassword = document.getElementById("error-password");

form.addEventListener("submit", e => {
    let hasError = false;
    
    const usernameInputEl = document.getElementById("username");
    const emailInputEl = document.getElementById("email");
    const passwordInputEl = document.getElementById("password");

    const usernameInput = usernameInputEl ? usernameInputEl.value : "";
    const emailInput = emailInputEl ? emailInputEl.value : "";
    const passwordInput = passwordInputEl ? passwordInputEl.value : "";

    if(usernameInputEl) usernameInputEl.innerText = "";
    if(errorEmail) errorEmail.innerText = "";
    if(errorPassword) errorPassword.innerText = "";

    if(errorUsername) errorUsername.classList.add("hide");
    if(errorEmail) errorEmail.classList.add("hide");
    if(errorPassword) errorPassword.classList.add("hide");

    const email = emailInput.trim();
    const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    if(!emailRegex.test(email) && errorEmail) {
        errorEmail.innerText = "Invalid email format!";
        errorEmail.classList.remove("hide");
        hasError = true;
    }

    if(usernameInput.length > 100 && errorUsername) {
        errorUsername.innerText = "Usernames cannot have more than 100 characters!";
        errorUsername.classList.remove("hide");
        hasError = true;
    }

    if(usernameInput.length < 3 && errorUsername) {
        errorUsername.innerText = "Usernames needs to be at least 3 characters!";
        errorUsername.classList.remove("hide");
        hasError = true;
    }

    if(emailInput.length > 100 && errorEmail) {
        errorEmail.innerText = "Emails cannot have more than 100 characters!";
        errorEmail.classList.remove("hide");
        hasError = true;
    }

    if(passwordInput.length < 6 && errorPassword) {
        errorPassword.innerText = "Password needs to be at least 6 characters!";
        errorPassword.classList.remove("hide");
        hasError = true;
    }

    if(passwordInput.length > 255 && errorPassword) {
        errorPassword.innerText = "Password cannot have more than 255 characters!";
        errorPassword.classList.remove("hide");
        hasError = true;
    }

    if(hasError) 
        e.preventDefault();
});