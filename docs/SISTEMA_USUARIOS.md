# Sistema de Usuários - ExpertFinancas

## Visão Geral
O sistema de usuários do ExpertFinancas foi projetado para gerenciar diferentes níveis de acesso através de papéis (roles) predefinidos, com uma hierarquia clara de permissões.

## Hierarquia de Papéis

### 1. Root (Superadministrador)
- Acesso total ao sistema
- Único usuário com permissão para:
  - Criar/editar/excluir administradores
  - Acessar todas as configurações do sistema
- Não pode ser excluído ou ter seu papel alterado
- Email fixo: root@expertfinancas.com.br

### 2. Administrador
- Acesso administrativo ao sistema
- Pode:
  - Criar/editar/excluir clientes
  - Gerenciar configurações do sistema
- Não pode:
  - Criar/editar/excluir outros administradores
  - Modificar configurações críticas do sistema

### 3. Cliente
- Acesso limitado ao sistema
- Pode:
  - Acessar apenas suas próprias informações
  - Utilizar as funcionalidades básicas do sistema
- Não tem acesso a configurações administrativas

## Proteções e Restrições

### Usuário Root
- Campo `is_root` na tabela `users` para identificação
- Criado/atualizado automaticamente pelo RootUserSeeder
- Proteções implementadas:
  - Não pode ser excluído
  - Papel não pode ser alterado
  - Credenciais são preservadas mesmo após limpeza do banco

### Administradores
- Podem ser criados/editados/excluídos apenas pelo root
- Têm acesso às funcionalidades administrativas do sistema
- Não podem modificar outros administradores

### Clientes
- Podem ser gerenciados por administradores e root
- Acesso restrito às funcionalidades básicas
- Não têm permissões administrativas

## Validações

### Criação de Usuário
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8|confirmed',
    'role' => 'required|string|in:admin,cliente'
]
```

### Atualização de Usuário
```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    'password' => 'nullable|string|min:8|confirmed',
    'role' => 'required|string|in:admin,cliente'
]
```

## Interface do Usuário

### Listagem (index.blade.php)
- Exibe todos os usuários em formato de tabela
- Badge colorido indica o papel do usuário:
  - Vermelho: root
  - Azul: admin
  - Cinza: cliente

### Criação/Edição
- Opções de papel são mostradas com base no usuário atual:
  - Root vê opções de admin e cliente
  - Administradores veem apenas opção de cliente
- Validações client-side e server-side
- Feedback claro em caso de erros

## Segurança e Boas Práticas
1. Senhas sempre hasheadas antes do armazenamento
2. Validação de email único
3. Proteção contra exclusão acidental do root
4. Validação de papéis válidos
5. Verificações de permissão em múltiplas camadas:
   - Interface do usuário
   - Controller
   - Middleware

## Manutenção
Para adicionar novos papéis:
1. Adicionar o novo papel na validação do UserController
2. Atualizar as views para incluir o novo papel no select
3. Atualizar a documentação
4. Definir claramente as permissões do novo papel

## Logs e Monitoramento
- Ações importantes são registradas no log do sistema
- Erros de validação são capturados e registrados
- Tentativas de violação da hierarquia são registradas

---
*Última atualização: Janeiro 2024*
