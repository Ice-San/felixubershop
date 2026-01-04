// Obtêm os elementos da pagina
const categoryBox = document.querySelectorAll(".category-box");
const products = document.querySelectorAll(".product");

let activeCategory;

// Para cada elementos, esconde aqueles que contenha uma categoria não selecionada
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

// Ao clicar num produto o formulario associado ao produto é enviado
products.forEach(product => {
    product.addEventListener('click', () => {
        const form = product.closest(".product-form");
        if (!form) return;

        form.submit();
    });
});

// Ao carregar a pagina, mostra apenas os produtos com desconto, caso um input possua um valor diferente de ""
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

// Ao carregar a pagina, obtêm os dados de um input e demonstra apenas os produtos correspondetes ao valor desse input
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

// Ao clicar no butão de adicionar ao carrinho, é submetido um formulario que guarda os produtos no carrinho
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