# Alterações no Formulário de Clientes

## Visão Geral
Recentemente, foram implementadas melhorias no formulário de clientes para garantir que os campos corretos sejam exibidos com base no tipo de pessoa selecionado (Pessoa Física ou Pessoa Jurídica).

## Mudanças Implementadas

### Alternância de Campos
- **Script Adicionado:** Um script foi adicionado para alternar entre os campos de Pessoa Física e Pessoa Jurídica.
- **Funcionamento:**
  - Quando "Pessoa Física" é selecionada, os campos específicos para Pessoa Física são exibidos e os de Pessoa Jurídica são ocultados.
  - Quando "Pessoa Jurídica" é selecionada, os campos específicos para Pessoa Jurídica são exibidos e os de Pessoa Física são ocultados.

### Código do Script
```javascript
$(document).ready(function() {
    function togglePessoaFields() {
        const tipoPessoa = $('input[name="tipo_pessoa"]:checked').val();
        if (tipoPessoa === 'PF') {
            $('#pessoa_fisica').show();
            $('#pessoa_juridica').hide();
        } else {
            $('#pessoa_fisica').hide();
            $('#pessoa_juridica').show();
        }
    }

    togglePessoaFields();

    $('input[name="tipo_pessoa"]').change(function() {
        togglePessoaFields();
    });
});
```

## Benefícios
- **Usabilidade Melhorada:** Os usuários agora têm uma experiência mais fluida ao preencher o formulário, vendo apenas os campos relevantes para o tipo de pessoa selecionado.
- **Redução de Erros:** Minimiza a chance de preenchimento incorreto ao ocultar campos irrelevantes.

## Considerações Finais
Essas alterações visam melhorar a experiência do usuário e garantir que os dados sejam inseridos de forma precisa e eficiente.
