$(document).ready(function() {
    // Função para mostrar/esconder campos
    function toggleFields() {
        const tipo = $('input[name="tipo_pessoa"]:checked').val();
        
        if (tipo === 'PF') {
            $('#pessoa_fisica').show();
            $('#pessoa_juridica').hide();
            $('#inscricoes-estaduais-card').hide();
            
            // Limpar campos PJ
            $('input[name="razao_social"]').val('');
            $('input[name="nome_fantasia"]').val('');
            $('input[name="cnpj"]').val('');
            $('input[name="inscricao_estadual"]').val('');
            
            // Tornar campos PF obrigatórios
            $('input[name="nome_completo"]').prop('required', true);
            $('input[name="cpf"]').prop('required', true);
            
            // Remover obrigatoriedade dos campos PJ
            $('input[name="razao_social"]').prop('required', false);
            $('input[name="cnpj"]').prop('required', false);
        } else {
            $('#pessoa_fisica').hide();
            $('#pessoa_juridica').show();
            $('#inscricoes-estaduais-card').show();
            
            // Limpar campos PF
            $('input[name="nome_completo"]').val('');
            $('input[name="cpf"]').val('');
            $('input[name="data_nascimento"]').val('');
            
            // Tornar campos PJ obrigatórios
            $('input[name="razao_social"]').prop('required', true);
            $('input[name="cnpj"]').prop('required', true);
            
            // Remover obrigatoriedade dos campos PF
            $('input[name="nome_completo"]').prop('required', false);
            $('input[name="cpf"]').prop('required', false);
        }
    }

    // Executar no carregamento
    toggleFields();

    // Executar quando mudar a seleção
    $('input[name="tipo_pessoa"]').on('change', toggleFields);

    // Máscaras
    $('.cpf').mask('000.000.000-00');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.telefone').mask('(00) 0000-0000');
    $('.celular').mask('(00) 00000-0000');
    $('.cep').mask('00000-000');
    $('.inscricao-estadual').mask('000.000.000.000');

    // Gerenciamento de Domínios
    let dominioIndex = $('.dominio-row').length;
    
    $('#addDominio').click(function() {
        const newRow = `
            <div class="row mb-3 dominio-row">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="dominios[${dominioIndex}][dominio]" 
                           placeholder="dominio.com.br" pattern="^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-dominio">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#dominios-container').append(newRow);
        dominioIndex++;
    });

    $(document).on('click', '.remove-dominio', function() {
        $(this).closest('.dominio-row').remove();
    });

    // Busca CEP
    $('input[name="cep"]').blur(function() {
        const cep = $(this).val().replace(/\D/g, '');
        
        if (cep.length === 8) {
            $.get(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                if (!data.erro) {
                    $('input[name="logradouro"]').val(data.logradouro);
                    $('input[name="bairro"]').val(data.bairro);
                    $('input[name="cidade"]').val(data.localidade);
                    $('select[name="uf"]').val(data.uf);
                }
            });
        }
    });

    // Validação de CPF
    function validaCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf === '') return false;
        
        // Elimina CPFs invalidos conhecidos
        if (cpf.length !== 11 ||
            cpf === "00000000000" ||
            cpf === "11111111111" ||
            cpf === "22222222222" ||
            cpf === "33333333333" ||
            cpf === "44444444444" ||
            cpf === "55555555555" ||
            cpf === "66666666666" ||
            cpf === "77777777777" ||
            cpf === "88888888888" ||
            cpf === "99999999999")
            return false;
            
        // Valida 1o digito	
        let add = 0;
        for (let i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        let rev = 11 - (add % 11);
        if (rev === 10 || rev === 11)
            rev = 0;
        if (rev !== parseInt(cpf.charAt(9)))
            return false;
            
        // Valida 2o digito	
        add = 0;
        for (let i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev === 10 || rev === 11)
            rev = 0;
        if (rev !== parseInt(cpf.charAt(10)))
            return false;
            
        return true;
    }

    // Validação de CNPJ
    function validaCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        if (cnpj === '') return false;
        
        // Elimina CNPJs invalidos conhecidos
        if (cnpj.length !== 14 ||
            cnpj === "00000000000000" ||
            cnpj === "11111111111111" ||
            cnpj === "22222222222222" ||
            cnpj === "33333333333333" ||
            cnpj === "44444444444444" ||
            cnpj === "55555555555555" ||
            cnpj === "66666666666666" ||
            cnpj === "77777777777777" ||
            cnpj === "88888888888888" ||
            cnpj === "99999999999999")
            return false;
            
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

    // Validação antes do submit
    $('#formCliente').submit(function(e) {
        const tipo = $('input[name="tipo_pessoa"]:checked').val();
        let valido = true;
        let mensagem = '';

        if (tipo === 'PF') {
            const cpf = $('input[name="cpf"]').val();
            if (!validaCPF(cpf)) {
                mensagem = 'CPF inválido';
                valido = false;
            }
        } else {
            const cnpj = $('input[name="cnpj"]').val();
            if (!validaCNPJ(cnpj)) {
                mensagem = 'CNPJ inválido';
                valido = false;
            }
        }

        // Validar e-mail
        const email = $('input[name="email"]').val();
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            mensagem = 'E-mail inválido';
            valido = false;
        }

        // Validar domínios
        $('.dominio-row input[name^="dominios"]').each(function() {
            const dominio = $(this).val();
            if (dominio && !/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/.test(dominio)) {
                mensagem = 'Formato de domínio inválido';
                valido = false;
                return false;
            }
        });

        if (!valido) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Erro de Validação',
                text: mensagem
            });
        }
    });
});
