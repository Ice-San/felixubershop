const search = document.getElementById("search-input");
const searchValues = document.querySelectorAll(".user");

search.addEventListener("input", e => {
    const searchTerm = e.target.value.toLowerCase().trim();
    
    searchValues.forEach(user => {
        const titleElement = user.querySelector(".user-title > h3");
        
        if (!titleElement) return;
        
        const userName = titleElement.innerText.toLowerCase();
        const matches = userName.includes(searchTerm);
        
        user.classList.toggle("hide", !matches);
    });
});