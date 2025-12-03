// Simple alert function
function showAlert(message, type = 'info') {
    alert(message);
}

// Simple form reset
function resetForm(formId) {
    document.getElementById(formId).reset();
    showAlert('Form telah direset!');
}

// Simple ID generator
function generateId(type) {
    const prefix = type === 'produk' ? 'P' : type === 'pelanggan' ? 'C' : 'S';
    const random = Math.random().toString(36).substring(2, 6).toUpperCase();
    const id = prefix + random;
    
    const input = document.querySelector(`input[name="id_${type}"]`);
    if (input) input.value = id;
    
    showAlert('ID baru: ' + id);
}

// Auto-uppercase for ID fields
document.addEventListener('DOMContentLoaded', function() {
    const idInputs = document.querySelectorAll('input[name^="id_"]');
    idInputs.forEach(input => {
        input.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
});