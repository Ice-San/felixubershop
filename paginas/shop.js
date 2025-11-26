const categoryBox = document.querySelectorAll(".category-box");
const products = document.querySelectorAll(".product");

let activeCategory;

categoryBox.forEach(elem => {
    elem.addEventListener('click', () => {
        const category = elem.querySelector('h2').textContent.toLowerCase();

        if (activeCategory === category) {
            activeCategory = null;
            products.forEach(product => {
                product.closest(".product-form").classList.remove('hide');
            });

            return;
        }

        activeCategory = category;
        products.forEach(product => {
            const form = product.closest(".product-form");
            
            if (product.dataset.category === category) {
                form.classList.remove('hide');
            } else {
                form.classList.add('hide');
            }
        });
    });
});

products.forEach(product => {
    product.addEventListener('click', () => {
        const form = product.closest(".product-form");
        if (!form) return;

        form.submit();
    });
});