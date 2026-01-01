window.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.checkout')?.addEventListener('submit', (e) => {
        const orderNameInput = document.getElementById('order-name');
        const orderNameValue = orderNameInput.value.trim();

        if (orderNameValue === 'order1') {
            alert('Please change the order name from the default placeholder!');
            e.preventDefault();
        }

        const hasProducts = document.querySelector(".order-header > h1").innerText;
        if (hasProducts === '...') {
            alert('You don\'t have any products inside the cart!');
            e.preventDefault();
        }
    });
});

window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if (error) {
        alert(error);
    }
})