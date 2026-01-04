// Guarda as orders
const orders = document.querySelectorAll(".order-info");

// Quando clicado numa order em especifico o formulario é submetido
orders.forEach(order => {
    order.addEventListener("click", () => {
        const wrapper = order.closest(".order-content");
        const form = wrapper.querySelector(".form-redirect");

        form.submit();
    })
});

// Guarda o input e o local de procura
const search = document.getElementById("search-input");
const searchValues = document.querySelectorAll(".order");

// Procura e mostra apenas o resultado da pesquisa
search.addEventListener("input", e => {
    const searchTerm = e.target.value.toLowerCase().trim();
    
    searchValues.forEach(user => {
        const titleElement = user.querySelector(".order-info > h2");
        
        if (!titleElement) return;
        
        const userName = titleElement.innerText.toLowerCase();
        const matches = userName.includes(searchTerm);
        
        user.classList.toggle("hide", !matches);
    });
});