// Executa o codigo quando a pagina é carregada
window.addEventListener('DOMContentLoaded', () => {
    // executa codigo quando o formulario é submetido
    document.querySelector('.checkout')?.addEventListener('submit', (e) => {
        // Guarda o valor do input
        const orderNameInput = document.getElementById('order-name');
        const orderNameValue = orderNameInput.value.trim();

        // Verifica se o valor do input é igual a order1
        if (orderNameValue === 'order1') {
            alert('Please change the order name from the default placeholder!');
            e.preventDefault();
        }

        // Verifica se têm productos
        // Caso não tenha, envia uma mensagem de erro
        const hasProducts = document.querySelector(".order-header > h1").innerText;
        if (hasProducts === '...') {
            alert('You don\'t have any products inside the cart!');
            e.preventDefault();
        }
    });
});

// Verifica se existe um erro ao carregar a pagina, se existir exibe a mensagem.
window.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if (error) {
        alert(error);
    }
})