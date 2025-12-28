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

document.addEventListener("DOMContentLoaded", () => {
    const discountInput = document.getElementById("discount-input");

    if (!discountInput) return;

    const hasDiscountFilter = discountInput.value.trim() !== "";
    if (!hasDiscountFilter) return;

    products.forEach(product => {
        const hasDiscount = product.querySelector(".product-discount");

        if (!hasDiscount) {
            product.closest(".product-form").classList.add("hide");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const search = document.getElementById("search-input");
    if (!search) return;

    const searchValue = search.value.trim().toLowerCase();
    if (searchValue === "") return;

    products.forEach(product => {
        const titleEl = product.querySelector(".product-info > h2");
        if (!titleEl) return;

        const productName = titleEl.textContent.trim().toLowerCase();
        const matches = productName.includes(searchValue);

        if(!matches) {
            product.closest(".product-form").classList.add("hide");
        }
    });
});

document.querySelectorAll('.product-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const form = btn.closest('.product-form');
        const productName = form.querySelector('input[name="product-name"]').value;
        const formatName = productName.replace(/ /g, '-');

        const addToCartForm = document.getElementById('add-to-cart-form-' + formatName);

        if (addToCartForm) {
            addToCartForm.submit();
        }
    });
});
