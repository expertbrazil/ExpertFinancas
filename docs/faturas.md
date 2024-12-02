# Manual do Módulo de Faturas

## Sumário

1. [Visão Geral](#visão-geral)
2. [Listagem de Faturas](#listagem-de-faturas)
3. [Criação de Faturas](#criação-de-faturas)
4. [Visualização de Faturas](#visualização-de-faturas)
5. [Edição de Faturas](#edição-de-faturas)
6. [Status e Ciclo de Vida](#status-e-ciclo-de-vida)
7. [Dicas e Boas Práticas](#dicas-e-boas-práticas)

## Visão Geral

O módulo de Faturas permite o gerenciamento completo do faturamento da empresa, desde a emissão até o controle de pagamentos.

### Principais Funcionalidades

- Emissão de faturas
- Controle de pagamentos
- Geração de boletos
- Histórico de transações
- Relatórios de faturamento

## Listagem de Faturas

A tela de listagem é o ponto central do módulo de faturas.

### Como Acessar

1. No menu lateral, clique em "Faturas"
2. A lista de faturas será exibida na área principal

### Elementos da Tela

- **Barra Superior**
  - Botão "Nova Fatura"
  - Campo de busca
  - Filtros de status

- **Lista de Faturas**
  - Número da fatura
  - Cliente
  - Valor
  - Data de vencimento
  - Status
  - Ações disponíveis

### Filtros Disponíveis

- Por status (Pendente, Pago, Cancelado)
- Por período
- Por cliente
- Por valor

## Criação de Faturas

### Passo a Passo

1. Clique no botão "Nova Fatura"
2. Selecione o cliente
3. Preencha os dados da fatura:
   - Data de emissão
   - Data de vencimento
   - Valor
   - Descrição
4. Clique em "Salvar"

### Campos Importantes

- **Cliente**: Selecione o cliente da fatura
- **Data de Emissão**: Data em que a fatura foi gerada
- **Data de Vencimento**: Data limite para pagamento
- **Valor**: Valor total da fatura
- **Descrição**: Detalhes sobre os serviços/produtos

### Dicas

- Verifique os dados do cliente antes de emitir a fatura
- Configure corretamente as datas para evitar problemas de cobrança
- Adicione uma descrição clara e detalhada

## Visualização de Faturas

### Informações Disponíveis

- Dados completos da fatura
- Histórico de alterações
- Status de pagamento
- Boleto bancário (quando aplicável)
- Dados do cliente

### Ações Possíveis

- Download do boleto
- Envio por email
- Impressão da fatura
- Marcação como paga
- Cancelamento

## Edição de Faturas

### Regras de Edição

- Faturas podem ser editadas apenas se estiverem pendentes
- Faturas pagas não podem ser alteradas
- Alterações são registradas no histórico

### Campos Editáveis

- Data de vencimento
- Valor (se ainda não houver pagamento)
- Descrição
- Observações

## Status e Ciclo de Vida

### Estados Possíveis

1. **Pendente**
   - Fatura emitida aguardando pagamento
   - Permite edição e cancelamento

2. **Pago**
   - Pagamento confirmado
   - Não permite edição
   - Gera registro financeiro

3. **Cancelado**
   - Fatura cancelada
   - Não permite edição
   - Mantém histórico

### Transições de Status

- Pendente → Pago
- Pendente → Cancelado
- Pago → Cancelado (requer permissão especial)

## Dicas e Boas Práticas

### Organização

1. Mantenha um padrão na descrição das faturas
2. Use números sequenciais para facilitar o controle
3. Arquive documentos relacionados junto à fatura

### Segurança

- Verifique os dados antes de emitir
- Confirme o valor e vencimento
- Mantenha backup dos documentos
- Registre todas as alterações

### Produtividade

1. Use os filtros para localizar faturas rapidamente
2. Configure modelos de descrição para casos comuns
3. Mantenha o histórico de pagamentos atualizado

## Relatórios

### Tipos Disponíveis

- Faturamento por período
- Faturas por cliente
- Status de pagamentos
- Previsão de recebimentos

### Como Gerar

1. Acesse a seção de relatórios
2. Selecione o tipo desejado
3. Configure os filtros
4. Clique em "Gerar"

### Exportação

- PDF
- Excel
- CSV

## Resolução de Problemas

### Problemas Comuns

1. **Fatura não aparece na lista**
   - Verifique os filtros ativos
   - Confirme se tem permissão de acesso
   - Atualize a página

2. **Erro ao gerar boleto**
   - Verifique os dados bancários
   - Confirme se o valor está correto
   - Tente gerar novamente

3. **Cliente não encontrado**
   - Verifique se o cliente está ativo
   - Confirme o cadastro do cliente
   - Tente buscar por diferentes critérios

### Suporte

Em caso de problemas:

1. Consulte este manual
2. Verifique as [Perguntas Frequentes](faq.md)
3. Entre em contato com o suporte técnico

---

© 2024 Expert Finanças. Todos os direitos reservados.
