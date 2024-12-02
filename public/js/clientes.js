$(document).ready(function() {
    // Máscaras
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.telefone').mask('(00) 0000-0000');
    $('.celular').mask('(00) 00000-0000');
    $('.cep').mask('00000-000');

    // Toggle entre PF e PJ
    $('input[name="tipo_pessoa"]').change(function() {
        const tipo = $(this).val();
        if (tipo === 'PF') {
            $('#pessoa_fisica').show();
            $('#pessoa_juridica').hide();
            limparCampos('#pessoa_juridica');
        } else {
            $('#pessoa_fisica').hide();
            $('#pessoa_juridica').show();
            limparCampos('#pessoa_fisica');
        }
    });

    // Validação de CPF
    function validaCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');
        
        if (cpf.length !== 11) return false;
        
        // Elimina CPFs inválidos conhecidos
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        let digito1 = resto > 9 ? 0 : resto;
        
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        let digito2 = resto > 9 ? 0 : resto;
        
        return cpf.charAt(9) == digito1 && cpf.charAt(10) == digito2;
    }

    // Validação de CNPJ
    function validaCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]/g, '');
        
        if (cnpj.length !== 14) return false;
        
        // Elimina CNPJs inválidos conhecidos
        if (/^(\d)\1{13}$/.test(cnpj)) return false;
        
        // Valida DVs
        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) return false;
        
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        
        return resultado == digitos.charAt(1);
    }

    // Validação antes do submit
    $('#formCliente').submit(function(e) {
        const tipo = $('input[name="tipo_pessoa"]:checked').val();
        let valido = true;
        let mensagem = '';

        if (tipo === 'PF') {
            const cpf = $('input[name="cpf"]').val();
            if (!validaCPF(cpf)) {
                valido = false;
                mensagem = 'CPF inválido';
                $('input[name="cpf"]').addClass('is-invalid');
            }
        } else {
            const cnpj = $('input[name="cnpj"]').val();
            if (!validaCNPJ(cnpj)) {
                valido = false;
                mensagem = 'CNPJ inválido';
                $('input[name="cnpj"]').addClass('is-invalid');
            }
        }

        if (!valido) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Erro de validação',
                text: mensagem
            });
        }
    });

    // Limpa campos de um container
    function limparCampos(container) {
        $(container + ' input[type="text"]').val('');
        $(container + ' input[type="date"]').val('');
    }

    // Validação em tempo real
    $('input[name="cpf"]').on('blur', function() {
        const cpf = $(this).val();
        if (cpf && !validaCPF(cpf)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            $(this).after('<div class="invalid-feedback">CPF inválido</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });

    $('input[name="cnpj"]').on('blur', function() {
        const cnpj = $(this).val();
        if (cnpj && !validaCNPJ(cnpj)) {
            $(this).addClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
            $(this).after('<div class="invalid-feedback">CNPJ inválido</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').remove();
        }
    });
});
