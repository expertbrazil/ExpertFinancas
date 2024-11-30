# Documentação Técnica - Expert Finanças

## Arquitetura

### Repository Pattern

O sistema utiliza o Repository Pattern para abstrair e encapsular o acesso aos dados:

```php
interface BaseRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
```

### Service Layer

A camada de serviço contém toda a lógica de negócio:

```php
class ProdutoService
{
    use CacheTrait;
    
    public function criar(array $dados)
    public function atualizar($id, array $dados)
    public function excluir($id)
    public function atualizarEstoque($id, $quantidade, $operacao)
}
```

### Traits

#### CacheTrait
- Gerenciamento de cache
- Invalidação seletiva
- Cache em múltiplas camadas

#### UploadTrait
- Upload de arquivos
- Validação de tipos
- Processamento de imagens

#### MoneyTrait
- Formatação monetária
- Conversão de valores
- Cálculos financeiros

#### LogActivityTrait
- Registro de atividades
- Rastreamento de mudanças
- Auditoria

## Fluxo de Dados

### Produtos

1. Request → Controller
2. Controller → Service
3. Service → Repository
4. Repository → Database

### Cache

1. Check Cache
2. If exists: Return cached data
3. If not: Query database
4. Store in cache
5. Return data

## Eventos

### ProdutoEstoqueBaixo
Disparado quando:
- Estoque atinge nível mínimo
- Venda reduz estoque crítico

### ProdutoPrecoAlterado
Disparado quando:
- Preço é atualizado
- Promoção é aplicada

## Validações

### Produtos
- Nome único
- Preço > 0
- Estoque >= 0
- Categoria válida

### Categorias
- Nome único por nível
- Hierarquia válida
- Sem ciclos

## Banco de Dados

### Índices
- produtos(nome)
- produtos(sku)
- categorias(caminho)

### Relacionamentos
- produto -> categoria
- categoria -> categoria_pai

## API Endpoints

### Produtos
```
GET    /api/produtos
POST   /api/produtos
PUT    /api/produtos/{id}
DELETE /api/produtos/{id}
PATCH  /api/produtos/{id}/estoque
```

### Categorias
```
GET    /api/categorias
POST   /api/categorias
PUT    /api/categorias/{id}
DELETE /api/categorias/{id}
GET    /api/categorias/hierarquia
```

## Cache Keys

### Produtos
- produtos:lista
- produto:{id}
- produto:{id}:estoque
- categoria:{id}:produtos

### Categorias
- categorias:lista
- categorias:hierarquia
- categoria:{id}
- categoria:{id}:filhas

## Configuração

### Cache
```php
'cache' => [
    'produto' => [
        'ttl' => 3600,
        'tags' => ['produtos']
    ],
    'categoria' => [
        'ttl' => 7200,
        'tags' => ['categorias']
    ]
]
```

### Upload
```php
'upload' => [
    'produtos' => [
        'path' => 'produtos',
        'types' => ['jpg', 'png'],
        'max_size' => 2048
    ]
]
```

## Performance

### Otimizações
- Eager Loading
- Query Caching
- Index Usage
- N+1 Prevention

### Monitoramento
- Query Log
- Cache Hits/Misses
- Memory Usage
- Response Times

## Segurança

### Validação
- Input Sanitization
- CSRF Protection
- XSS Prevention
- SQL Injection Protection

### Autenticação
- Token Based
- Role Based Access
- Session Management
- Password Policies

## Manutenção

### Logs
- Error Logs
- Activity Logs
- Audit Trails
- Performance Metrics

### Backup
- Database Dumps
- File Storage
- Configuration
- Logs

## Desenvolvimento

### Padrões
- PSR-4 Autoloading
- PSR-12 Coding Style
- SOLID Principles
- DRY Principle

### Testes
- Unit Tests
- Feature Tests
- Integration Tests
- Performance Tests
