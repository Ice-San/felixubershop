document.addEventListener('DOMContentLoaded', function() {
    const editBtn = document.getElementById('edit-btn');
    const saveBtn = document.getElementById('save-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const inputs = document.querySelectorAll('.input input:not(#email)'); // Exclui o email
    const originalValues = {};

    inputs.forEach(input => {
        originalValues[input.id] = input.value;
    });

    editBtn.addEventListener('click', function() {
        inputs.forEach(input => {
            input.disabled = false;
        });

        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
        cancelBtn.style.display = 'inline-block';
    });

    cancelBtn.addEventListener('click', function() {
        inputs.forEach(input => {
            input.disabled = true;
            input.value = originalValues[input.id];
        });

        editBtn.style.display = 'inline-block';
        saveBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
    });

    saveBtn.addEventListener('click', function() {
        // Não desabilitar aqui, pois desabilitados não são enviados no POST
        editBtn.style.display = 'inline-block';
        saveBtn.style.display = 'none';
        cancelBtn.style.display = 'none';
    });
});