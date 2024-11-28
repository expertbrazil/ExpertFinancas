<div>
    <label for="cpf">CPF:</label>
    <input type="text" 
           id="cpf" 
           name="cpf" 
           class="form-control" 
           maxlength="14" 
           placeholder="000.000.000-00">
    <span id="cpf-message" class="feedback-message"></span>
</div>

<style>
.form-control {
    padding: 8px;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    width: 200px;
    transition: all 0.3s ease;
}

.form-control.valid {
    border-color: #4CAF50;
    background-color: #f8fff8;
}

.form-control.invalid {
    border-color: #f44336;
    background-color: #fff8f8;
}

.feedback-message {
    display: block;
    margin-top: 5px;
    font-size: 14px;
}

.feedback-message.valid {
    color: #4CAF50;
}

.feedback-message.invalid {
    color: #f44336;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');
    const cpfMessage = document.getElementById('cpf-message');

    function formatCPF(value) {
        return value
            .replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    function validateCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');

        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let digit = 11 - (sum % 11);
        if (digit === 10 || digit === 11) digit = 0;
        if (digit !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        digit = 11 - (sum % 11);
        if (digit === 10 || digit === 11) digit = 0;
        if (digit !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Aplica a formatação
        if (value.length <= 14) {
            e.target.value = formatCPF(value);
        }

        // Remove classes existentes
        cpfInput.classList.remove('valid', 'invalid');
        cpfMessage.classList.remove('valid', 'invalid');

        // Só valida se tiver todos os dígitos
        if (value.replace(/\D/g, '').length === 11) {
            if (validateCPF(value)) {
                cpfInput.classList.add('valid');
                cpfMessage.classList.add('valid');
                cpfMessage.textContent = '✓ CPF válido';
            } else {
                cpfInput.classList.add('invalid');
                cpfMessage.classList.add('invalid');
                cpfMessage.textContent = '✗ CPF inválido';
            }
        } else {
            cpfMessage.textContent = '';
        }
    });
});
</script>
