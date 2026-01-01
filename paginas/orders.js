const orders = document.querySelectorAll(".order-info");

orders.forEach(order => {
    order.addEventListener("click", () => {
        const wrapper = order.closest(".order-content");
        const form = wrapper.querySelector(".form-redirect");

        form.submit();
    })
});

const search = document.getElementById("search-input");
const searchValues = document.querySelectorAll(".order");

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