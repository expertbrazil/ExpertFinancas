$(document).ready(function() {
    // Função para mostrar/esconder campos
    function toggleFields() {
        const tipo = $('input[name="tipo_pessoa"]:checked').val();
        
        if (tipo === 'PF') {
            $('#pessoa_fisica').show();
            $('#pessoa_juridica').hide();
            $('#inscricoes-estaduais-card').show();
        } else {
            $('#pessoa_fisica').hide();
            $('#pessoa_juridica').show();
            $('#inscricoes-estaduais-card').hide();
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
    $('.inscricao-estadual').mask('000.000.000.000');

    // Gerenciamento de Domínios
    let dominioIndex = $('.dominio-row').length;
    
    $('#addDominio').click(function() {
        const newRow = `
            <div class="row mb-3 dominio-row">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="dominios[${dominioIndex}][dominio]" placeholder="dominio.com.br">
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

    // Gerenciamento de Inscrições Estaduais
    let inscricaoIndex = $('.inscricao-row').length;
    
    $('#addInscricao').click(function() {
        const newRow = `
            <div class="row mb-3 inscricao-row">
                <div class="col-md-3">
                    <select class="form-select" name="inscricoes[${inscricaoIndex}][uf]" required>
                        <option value="">Selecione o Estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control inscricao-estadual" 
                        name="inscricoes[${inscricaoIndex}][inscricao]" 
                        placeholder="000.000.000.000">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-inscricao">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#inscricoes-container').append(newRow);
        inscricaoIndex++;
    });

    $(document).on('click', '.remove-inscricao', function() {
        $(this).closest('.inscricao-row').remove();
    });

    // Validação de CPF
    function validaCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g,'');
        if(cpf == '') return false;
        if (cpf.length != 11 || 
            cpf == "00000000000" || 
            cpf == "11111111111" || 
            cpf == "22222222222" || 
            cpf == "33333333333" || 
            cpf == "44444444444" || 
            cpf == "55555555555" || 
            cpf == "66666666666" || 
            cpf == "77777777777" || 
            cpf == "88888888888" || 
            cpf == "99999999999")
            return false;
        add = 0;
        for (i=0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }

    // Validação de CNPJ
    function validaCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g,'');
        if(cnpj == '') return false;
        if (cnpj.length != 14)
            return false;
        if (cnpj == "00000000000000" || 
            cnpj == "11111111111111" || 
            cnpj == "22222222222222" || 
            cnpj == "33333333333333" || 
            cnpj == "44444444444444" || 
            cnpj == "55555555555555" || 
            cnpj == "66666666666666" || 
            cnpj == "77777777777777" || 
            cnpj == "88888888888888" || 
            cnpj == "99999999999999")
            return false;
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }

    // Validação antes do submit
    $('#formCliente').submit(function(e) {
        const tipo = $('input[name="tipo_pessoa"]:checked').val();
        let valido = true;

        if (tipo === 'PF') {
            const cpf = $('input[name="cpf"]').val();
            if (!validaCPF(cpf)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'CPF Inválido',
                    text: 'Por favor, insira um CPF válido.'
                });
                valido = false;
            }
        } else {
            const cnpj = $('input[name="cnpj"]').val();
            if (!validaCNPJ(cnpj)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'CNPJ Inválido',
                    text: 'Por favor, insira um CNPJ válido.'
                });
                valido = false;
            }
        }

        return valido;
    });
});
