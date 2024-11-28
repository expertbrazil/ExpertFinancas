// Configuração do CSRF Token para requisições AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Máscaras para inputs
$(document).ready(function() {
    // Máscaras de documentos
    $('.cpf').mask('000.000.000-00', {
        reverse: true,
        placeholder: "___.___.___-__"
    });
    $('.cnpj').mask('00.000.000/0000-00', {
        reverse: true,
        placeholder: "__.___.___/____-__"
    });
    
    // Máscaras de telefone
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        },
        placeholder: "(00) 00000-0000"
    };
    
    $('.telefone').mask(SPMaskBehavior, spOptions);
    
    // Máscara de CEP
    $('.cep').mask('00000-000', {
        placeholder: "_____-___"
    });
});

// Troca entre campos PF e PJ
$('input[name="tipo_pessoa"]').change(function() {
    if ($(this).val() === 'PF') {
        $('#pessoa_fisica').show();
        $('#pessoa_juridica').hide();
    } else {
        $('#pessoa_fisica').hide();
        $('#pessoa_juridica').show();
    }
});

// Consulta de CEP
$('#cep').blur(function() {
    const cepx = $(this).val().replace(/\D/g, '');
    if (cepx.length === 8) {
        $.getJSON('https://viacep.com.br/ws/'+ cepx +'/json/?callback=?', function(data) {
            if (!data.erro) {
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#uf').val(data.uf);
                $('#numero').focus();
            }
        });
    }
});

// Validação de CPF
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]/g, '');
    if (cpf.length !== 11) return false;
    
    // Elimina CPFs inválidos conhecidos
    if (/^(\d)\1{10}$/.test(cpf)) return false;
    
    // Valida 1o dígito
    let add = 0;
    for (let i = 0; i < 9; i++) {
        add += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) rev = 0;
    if (rev !== parseInt(cpf.charAt(9))) return false;
    
    // Valida 2o dígito
    add = 0;
    for (let i = 0; i < 10; i++) {
        add += parseInt(cpf.charAt(i)) * (11 - i);
    }
    rev = 11 - (add % 11);
    if (rev === 10 || rev === 11) rev = 0;
    if (rev !== parseInt(cpf.charAt(10))) return false;
    
    return true;
}

// Validação de CNPJ
function validarCNPJ(cnpj) {
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
    if (resultado !== parseInt(digitos.charAt(0))) return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;

    for (let i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2) pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado !== parseInt(digitos.charAt(1))) return false;

    return true;
}

// Validação do formulário
$('#formCliente').submit(function(e) {
    e.preventDefault();
    
    // Remove mensagens de erro anteriores
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    
    let hasError = false;
    const tipoPessoa = $('input[name="tipo_pessoa"]:checked').val();
    
    // Validação comum para ambos os tipos
    const requiredFields = ['email', 'celular'];
    
    // Adiciona campos específicos baseado no tipo de pessoa
    if (tipoPessoa === 'PF') {
        requiredFields.push('nome_completo', 'cpf');
    } else {
        requiredFields.push('razao_social', 'cnpj');
    }
    
    // Valida campos obrigatórios
    requiredFields.forEach(field => {
        const input = $(`[name="${field}"]`);
        if (!input.val().trim()) {
            input.addClass('is-invalid');
            input.after(`<div class="invalid-feedback">Este campo é obrigatório.</div>`);
            hasError = true;
        }
    });
    
    // Validações específicas
    if (tipoPessoa === 'PF' && !hasError) {
        const cpf = $('[name="cpf"]').val().replace(/\D/g, '');
        if (!validarCPF(cpf)) {
            $('[name="cpf"]').addClass('is-invalid');
            $('[name="cpf"]').after(`<div class="invalid-feedback">CPF inválido.</div>`);
            hasError = true;
        }
    } else if (tipoPessoa === 'PJ' && !hasError) {
        const cnpj = $('[name="cnpj"]').val().replace(/\D/g, '');
        if (!validarCNPJ(cnpj)) {
            $('[name="cnpj"]').addClass('is-invalid');
            $('[name="cnpj"]').after(`<div class="invalid-feedback">CNPJ inválido.</div>`);
            hasError = true;
        }
    }

    // Validação de email
    const email = $('[name="email"]').val().trim();
    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        $('[name="email"]').addClass('is-invalid');
        $('[name="email"]').after(`<div class="invalid-feedback">E-mail inválido.</div>`);
        hasError = true;
    }
    
    // Se não houver erros, envia o formulário
    if (!hasError) {
        this.submit();
    }
});

// Inicialização
$(document).ready(function() {
    // Configura o tipo de pessoa inicial
    const tipoPessoaInicial = $('input[name="tipo_pessoa"]:checked').val() || 'PF';
    $(`#${tipoPessoaInicial}`).prop('checked', true).trigger('change');
});
