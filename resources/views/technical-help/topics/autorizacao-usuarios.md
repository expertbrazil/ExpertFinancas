# Regras de Autorização de Usuários

## Visão Geral
O sistema ExpertFinancas implementa um sistema de controle de acesso baseado em papéis (roles) para garantir segurança e limitar ações de usuários.

## Hierarquia de Papéis
1. **Root**: Usuário com permissões máximas
2. **Admin**: Usuário com permissões administrativas
3. **Usuário Padrão**: Usuário com permissões limitadas

## Permissões por Papel

### Usuário Root
- Pode criar novos usuários
- Pode editar todos os usuários
- Pode ativar/desativar usuários
- Pode excluir usuários
- Único usuário que pode modificar o usuário `root@expertfinancas.com.br`

### Usuário Admin
- Pode criar novos usuários
- Pode editar usuários (exceto usuários Root)
- Não pode ativar/desativar ou excluir usuários

### Usuário Padrão
- Sem permissões de gerenciamento de usuários

## Restrições Específicas
- O usuário `root@expertfinancas.com.br` é protegido e não pode ser modificado
- Usuários Root podem gerenciar todos os aspectos dos usuários
- Usuários Admin têm permissões mais restritas para prevenir alterações críticas

## Boas Práticas
- Mantenha o número de usuários Root ao mínimo necessário
- Utilize o papel de Admin para delegar tarefas administrativas
- Revise regularmente as permissões dos usuários

## Implementação
As regras são implementadas no arquivo `resources/views/users/index.blade.php` utilizando diretivas Blade condicionais baseadas no papel do usuário autenticado.

### Exemplo de Verificação
```php
@if(auth()->user()->role === 'root' || 
    (auth()->user()->role === 'admin' && $user->role !== 'root'))
    // Mostrar botões de edição
@endif
```

## Considerações de Segurança
- As verificações são realizadas tanto na view quanto no backend
- Sempre valide as permissões no servidor para prevenir acessos não autorizados
