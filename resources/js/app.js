import './bootstrap';

// Money Input Mask
document.addEventListener('DOMContentLoaded', function() {
    const moneyInputs = document.querySelectorAll('.money');
    
    moneyInputs.forEach(function(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            
            // Remove tudo exceto números
            value = value.replace(/\D/g, '');
            
            // Converte para número e divide por 100 para ter os centavos
            value = (parseInt(value) / 100).toFixed(2);
            
            // Formata o número
            value = value.replace('.', ',');
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            
            // Atualiza o valor do input
            e.target.value = value;
        });
        
        // Adiciona R$ no início quando o input recebe foco
        input.addEventListener('focus', function(e) {
            let value = e.target.value;
            if (!value.startsWith('R$ ')) {
                e.target.value = 'R$ ' + value;
            }
        });
        
        // Remove R$ quando o input perde o foco se estiver vazio
        input.addEventListener('blur', function(e) {
            let value = e.target.value;
            if (value === 'R$ ' || value === 'R$ 0,00') {
                e.target.value = '';
            }
        });
    });
});

// Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
});

// Dropdown Menus
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        new bootstrap.Dropdown(dropdown);
    });
});
