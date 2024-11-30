# Expert Finanças - Sistema de Gestão Financeira

## Sobre o Projeto

Expert Finanças é um sistema de gestão financeira desenvolvido em Laravel 10.x, projetado para oferecer uma solução robusta e escalável para gestão de produtos, serviços, clientes e finanças.

## Tecnologias Utilizadas

- PHP 8.1+
- Laravel 10.x
- MySQL/PostgreSQL
- Composer
- Node.js & NPM

## Arquitetura

O sistema utiliza uma arquitetura modular baseada em:

- Repository Pattern
- Service Layer
- Trait-based Utilities
- Event-Driven Architecture
- Cache Strategy
- Type Safety (Enums)

### Componentes Principais

1. **Repositories**
   - BaseRepository
   - ProdutoRepository
   - ClienteRepository
   - CategoriaRepository

2. **Services**
   - ProdutoService
   - ClienteService
   - CategoriaService

3. **Controllers**
   - ProdutoController
   - ClienteController
   - CategoriaController

4. **Enums**
   - TipoProduto
   - TipoServico
   - StatusGeral
   - StatusConta
   - StatusPedido
   - TipoCategoria

5. **Traits**
   - UploadTrait
   - MoneyTrait
   - DocumentValidationTrait
   - LogActivityTrait
   - NotificationTrait
   - SearchTrait
   - CacheTrait

## Funcionalidades

### Gestão de Produtos
- Cadastro e atualização de produtos
- Controle de estoque
- Categorização
- Upload de imagens
- Histórico de preços

### Gestão de Clientes
- Cadastro completo
- Validação de documentos
- Histórico de transações
- Categorização

### Gestão Financeira
- Controle de contas
- Fluxo de caixa
- Relatórios financeiros
- Histórico de transações

### Recursos Técnicos
- Cache inteligente
- Upload de arquivos
- Validações avançadas
- Logs de atividades
- Notificações multicanal
- Busca avançada

## Instalação

1. Clone o repositório:
```bash
git clone [url-do-repositorio]
```

2. Instale as dependências:
```bash
composer install
npm install
```

3. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure o banco de dados no arquivo .env:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expert_financas
DB_USERNAME=root
DB_PASSWORD=
```

5. Execute as migrações:
```bash
php artisan migrate --seed
```

6. Inicie o servidor:
```bash
php artisan serve
```

## Testes

O sistema possui testes unitários e de feature:

```bash
php artisan test
```

### Cobertura de Testes
- Services
- Controllers
- Repositories
- Events/Listeners

## Cache

O sistema utiliza uma estratégia de cache em múltiplas camadas:

1. **Cache de Produtos**
   - Lista de produtos
   - Detalhes do produto
   - Invalidação seletiva

2. **Cache de Categorias**
   - Hierarquia de categorias
   - Lista para selects
   - Invalidação em cascata

## Eventos e Listeners

### Produtos
- ProdutoEstoqueBaixo
- ProdutoPrecoAlterado

### Notificações
- NotificarEstoqueBaixo
- NotificarAlteracaoPreco

## Segurança

- Validação em múltiplas camadas
- Sanitização de inputs
- Proteção contra CSRF
- Autenticação robusta
- Autorização baseada em papéis

## Contribuição

1. Fork o projeto
2. Crie sua Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE.md para detalhes
