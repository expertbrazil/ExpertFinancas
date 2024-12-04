# ExpertFinancas

Sistema de gestão financeira desenvolvido para auxiliar profissionais e empresas no controle de suas finanças.

## Tecnologias

- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Bootstrap 5
- JavaScript/jQuery

## Requisitos

- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js >= 14.x
- NPM >= 6.x

## Instalação

1. Clone o repositório
```bash
git clone [url-do-repositorio]
```

2. Instale as dependências do PHP
```bash
composer install
```

3. Instale as dependências do Node.js
```bash
npm install
```

4. Configure o ambiente
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure o banco de dados no arquivo `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expert_financas
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. Execute as migrations e seeders
```bash
php artisan migrate --seed
```

7. Compile os assets
```bash
npm run dev
```

8. Inicie o servidor
```bash
php artisan serve
```

## Sistema de Usuários

O sistema possui três níveis de acesso:

### Root (Superadministrador)
- Acesso total ao sistema
- Único com permissão para gerenciar administradores
- Não pode ser excluído ou modificado
- Credenciais padrão:
  - Email: root@expertfinancas.com.br
  - Senha: [definida no seeder]

### Administrador
- Gerencia clientes e configurações gerais
- Não pode modificar outros administradores
- Criado apenas pelo root

### Cliente
- Acesso às funcionalidades básicas
- Gerenciado por administradores e root

Para mais detalhes sobre o sistema de usuários, consulte [docs/SISTEMA_USUARIOS.md](docs/SISTEMA_USUARIOS.md)

## Estrutura do Projeto

### Diretórios Principais
```
app/
├── Console/         # Comandos personalizados
├── Http/
│   ├── Controllers/ # Controladores da aplicação
│   ├── Middleware/ # Middlewares personalizados
│   └── Requests/   # Form requests para validação
├── Models/         # Modelos do Eloquent
└── Services/       # Serviços da aplicação

database/
├── migrations/     # Migrações do banco de dados
└── seeders/       # Seeders para dados iniciais

resources/
├── js/            # Arquivos JavaScript
├── sass/          # Arquivos SASS/CSS
└── views/         # Views Blade

public/            # Arquivos públicos
└── assets/        # Assets compilados
```

## Segurança

- Autenticação robusta
- Proteção contra CSRF
- Validação em múltiplas camadas
- Senhas hasheadas
- Proteção de rotas por middleware
- Logs de ações importantes

## Logs

O sistema mantém logs de:
- Ações administrativas
- Erros e exceções
- Tentativas de acesso não autorizado
- Modificações em dados críticos

## Manutenção

### Atualizações
1. Atualize o código
```bash
git pull origin main
```

2. Atualize as dependências
```bash
composer update
npm update
```

3. Execute as migrations
```bash
php artisan migrate
```

### Backup
- Configure backups automáticos do banco
- Mantenha cópias dos arquivos de upload
- Documente todas as modificações

## Debug e Solução de Problemas

### Logs
- Verifique `storage/logs/laravel.log`
- Use `php artisan log:clear` para limpar logs

### Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Documentação Adicional

- [Sistema de Usuários](docs/SISTEMA_USUARIOS.md)
- [Configurações](docs/CONFIGURACOES.md)
- [API](docs/API.md)

## Contribuição

1. Crie uma branch para sua feature
```bash
git checkout -b feature/nome-da-feature
```

2. Commit suas mudanças
```bash
git commit -m 'Adiciona nova feature'
```

3. Push para a branch
```bash
git push origin feature/nome-da-feature
```

4. Abra um Pull Request

## Licença

Este projeto está sob a licença [MIT](LICENSE).

---
Desenvolvido com ❤️ pela equipe ExpertFinancas
