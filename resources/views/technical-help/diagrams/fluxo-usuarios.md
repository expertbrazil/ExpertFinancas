# Fluxo de Usuários

```mermaid
graph TD;
    A[Início] --> B[Verificar Autenticação];
    B -->|Autenticado| C[Exibir Dashboard];
    B -->|Não Autenticado| D[Redirecionar para Login];
    C --> E[Gerenciar Usuários];
    E --> F[Editar Usuário];
    E --> G[Excluir Usuário];
    F --> H[Salvar Alterações];
    G --> H;
    H --> I[Fim];
```

Este fluxograma representa o fluxo básico de gerenciamento de usuários dentro do sistema, começando pela verificação de autenticação e permitindo ações como edição e exclusão de usuários.
