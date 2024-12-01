# Expert Finanças

Sistema de gestão financeira desenvolvido com Laravel 10.x

## 🚀 Requisitos do Sistema

- PHP 8.3.9 ou superior
- MySQL 5.7 ou superior
- Node.js 22.11.0 ou superior
- npm 10.9.0 ou superior
- Composer 2.8.3 ou superior

## 📦 Instalação

### 1. Configuração do Ambiente Local (MAMP)

1. Instale o MAMP:
   - Baixe em: https://www.mamp.info/
   - Instale seguindo as instruções padrão
   - Inicie o MAMP e verifique se as luzes estão verdes

### 2. Configuração do Projeto

1. Clone o repositório:
   ```bash
   git clone [URL_DO_REPOSITORIO]
   cd ExpertFinancas
   ```

2. Configure o ambiente:
   ```bash
   cp .env.example .env
   ```

3. Configure o arquivo `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=8889
   DB_DATABASE=expert_financas
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

4. Instale as dependências:
   ```bash
   composer install
   npm install
   ```

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Importe o banco de dados:
   ```bash
   mysql -h localhost -P 8889 -u root -proot expert_financas < database/expert_financas.sql
   ```

### 3. Iniciando o Sistema

1. Inicie o servidor Laravel:
   ```bash
   php artisan serve
   ```

2. Em outro terminal, inicie o Vite:
   ```bash
   npm run dev
   ```

3. Acesse o sistema:
   - Frontend: http://localhost:5179
   - Backend: http://localhost:8000

## 🔐 Credenciais Padrão

- Email: root@expertfinancas.com.br
- Senha: Expert@2024

## 📚 Documentação Adicional

- [Laravel Documentation](https://laravel.com/docs/10.x)
- [MAMP Documentation](https://documentation.mamp.info/)

## 🛠️ Desenvolvimento

- Framework: Laravel 10.x
- Frontend: Bootstrap com Laravel UI
- Database: MySQL (via MAMP)
- Autenticação: Laravel's built-in authentication

## 🔒 Segurança

- Todas as senhas são hasheadas
- Sistema de roles implementado
- Proteção contra CSRF ativada

## 📝 Licença

Este projeto é propriedade da Expert Finanças.
