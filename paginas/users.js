// Obtêm o elemento
const users = document.querySelectorAll(".user-content");

// Ao clicar em algum dos elementos, é submetido um formulario
users.forEach(user => {
    user.addEventListener("click", () => {
        const userForm = user.closest('.user');

        userForm.submit();
    });
});

// Obtêm a barra de pesquisa e o valor a ser pesquisado
const search = document.getElementById("search-input");
const searchValues = document.querySelectorAll(".user");

// Codigo a ser executado quando é pesquisado um elemento em especifico.
// Mostra apenas os elementos com o valor de pesquisa igual ao do elemento
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