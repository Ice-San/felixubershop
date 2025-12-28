const users = document.querySelectorAll(".user-content");

users.forEach(user => {
    user.addEventListener("click", () => {
        const userForm = user.closest('.user');

        userForm.submit();
    });
});

const search = document.getElementById("search-input");
const searchValues = document.querySelectorAll(".user");

search.addEventListener("input", e => {
    const searchTerm = e.target.value.toLowerCase().trim();
    
    searchValues.forEach(user => {
        const titleElement = user.querySelector(".user-left-info > p");
        
        if (!titleElement) return;
        
        const userName = titleElement.innerText.toLowerCase();
        const matches = userName.includes(searchTerm);
        
        user.classList.toggle("hide", !matches);
    });
});