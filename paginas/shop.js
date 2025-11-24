const categoryBox = document.querySelectorAll(".category-box");
const products = document.querySelectorAll(".product");

let activeCategory;

categoryBox.forEach(elem => {
    elem.addEventListener('click', () => {
        const category = elem.querySelector('h2').textContent.toLowerCase();

        if (activeCategory === category) {
            activeCategory = null;
            products.forEach(product => product.classList.remove('hide'));
            return;
        }

        activeCategory = category;
        products.forEach(product => {
            if (product.dataset.category.toLowerCase() === category) {
                product.classList.remove('hide');
            } else {
                product.classList.add('hide');
            }
        });
    });
});