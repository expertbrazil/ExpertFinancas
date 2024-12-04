# Configurações do Sistema

## Visão Geral

Este documento detalha as configurações disponíveis no ExpertFinancas e como gerenciá-las.

## Configurações do Sistema

### Ambiente (.env)

```env
# Configurações da Aplicação
APP_NAME=ExpertFinancas
APP_ENV=local|production
APP_DEBUG=true|false
APP_URL=http://localhost

# Banco de Dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expert_financas
DB_USERNAME=root
DB_PASSWORD=

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

# Upload de Arquivos
FILESYSTEM_DISK=local
```

## Permissões de Acesso

### Root
- Acesso total às configurações
- Pode modificar todas as configurações do sistema
- Gerencia configurações críticas

### Administrador
- Acesso parcial às configurações
- Pode modificar configurações não críticas
- Visualiza todas as configurações

### Cliente
- Sem acesso às configurações do sistema
- Pode apenas visualizar/editar suas próprias configurações

## Configurações por Módulo

### Usuários e Permissões
- Gerenciamento de papéis
- Políticas de senha
- Tempo de sessão
- Tentativas de login

### Email
- Configurações SMTP
- Templates de email
- Notificações automáticas

### Upload de Arquivos
- Tamanho máximo de arquivo
- Tipos permitidos
- Local de armazenamento

### Logs e Monitoramento
- Nível de log
- Rotação de logs
- Monitoramento de ações

## Backups

### Configuração de Backup
```php
// config/backup.php

return [
    'backup' => [
        'name' => 'expert_financas_backup',
        'source' => [
            'files' => [
                'include' => [
                    base_path(),
                ],
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],
            ],
            'databases' => [
                'mysql',
            ],
        ],
    ],
];
```

### Agendamento
- Backup diário do banco de dados
- Backup semanal dos arquivos
- Retenção de 30 dias

## Cache

### Configurações de Cache
```php
// config/cache.php

'default' => env('CACHE_DRIVER', 'file'),

'stores' => [
    'file' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/data'),
    ],
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
    ],
],
```

### Políticas de Cache
- Cache de consultas frequentes
- Cache de views
- Invalidação automática

## Segurança

### Headers HTTP
```php
// config/security.php

'headers' => [
    'X-Frame-Options' => 'SAMEORIGIN',
    'X-XSS-Protection' => '1; mode=block',
    'X-Content-Type-Options' => 'nosniff',
],
```

### CORS
```php
// config/cors.php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

## Manutenção

### Comandos Úteis
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Otimizar
php artisan optimize
php artisan route:cache
php artisan config:cache

# Manutenção
php artisan down
php artisan up
```

### Logs
- Localização: `storage/logs/`
- Rotação: diária
- Retenção: 14 dias

## Ambiente de Produção

### Checklist
1. Desativar debug mode
2. Configurar emails de produção
3. Configurar backups
4. Otimizar autoloader
5. Cachear configurações

### Otimizações
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Monitoramento

### Métricas
- Uso de CPU/Memória
- Tempo de resposta
- Erros/Exceções
- Acessos/Requisições

### Alertas
- Erros críticos
- Uso excessivo de recursos
- Tentativas de invasão
- Falhas de backup

## Resolução de Problemas

### Logs
- Verifique `storage/logs/laravel.log`
- Monitore logs do servidor web
- Verifique logs do MySQL

### Cache
- Limpe todos os caches
- Verifique permissões
- Monitore uso de memória

### Banco de Dados
- Verifique conexões
- Monitore queries lentas
- Otimize índices

---
*Última atualização: Janeiro 2024*
