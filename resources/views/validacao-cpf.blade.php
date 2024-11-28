<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de CPF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
            margin-top: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .feedback-message.valid {
            color: #4CAF50;
        }

        .feedback-message.invalid {
            color: #f44336;
        }

        .feedback-message::before {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
            background-size: contain;
            background-repeat: no-repeat;
        }

        .feedback-message.valid::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234CAF50'%3E%3Cpath d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'/%3E%3C/svg%3E");
        }

        .feedback-message.invalid::before {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23f44336'%3E%3Cpath d='M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" 
                   id="cpf" 
                   name="cpf" 
                   class="form-control" 
                   maxlength="14" 
                   placeholder="000.000.000-00">
            <div id="cpf-message" class="feedback-message"></div>
        </div>
    </div>

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
                        cpfMessage.textContent = 'CPF válido';
                    } else {
                        cpfInput.classList.add('invalid');
                        cpfMessage.classList.add('invalid');
                        cpfMessage.textContent = 'CPF inválido';
                    }
                } else {
                    cpfMessage.textContent = '';
                }
            });
        });
    </script>
</body>
</html>
