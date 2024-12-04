# API Documentation - ExpertFinancas

## Overview

The ExpertFinancas API provides programmatic access to financial management features. This document details the available endpoints, authentication methods, and examples of use.

## Authentication

### Bearer Token
```http
Authorization: Bearer {your-token}
```

### Obtaining a Token
```http
POST /api/auth/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "your-password"
}
```

Response:
```json
{
    "access_token": "your-token",
    "token_type": "Bearer",
    "expires_in": 3600
}
```

## Endpoints

### Users

#### List Users
```http
GET /api/users
Authorization: Bearer {token}
```

Response:
```json
{
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "role": "admin",
            "created_at": "2024-01-01T00:00:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 10,
        "per_page": 15
    }
}
```

#### Create User
```http
POST /api/users
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "secure-password",
    "role": "cliente"
}
```

#### Update User
```http
PUT /api/users/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "John Doe Updated",
    "email": "john.updated@example.com"
}
```

#### Delete User
```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

### Financial Records

#### List Records
```http
GET /api/records
Authorization: Bearer {token}
```

Response:
```json
{
    "data": [
        {
            "id": 1,
            "description": "Monthly Revenue",
            "amount": 5000.00,
            "type": "income",
            "date": "2024-01-01",
            "category": "sales"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 50,
        "per_page": 15
    }
}
```

#### Create Record
```http
POST /api/records
Authorization: Bearer {token}
Content-Type: application/json

{
    "description": "New Sale",
    "amount": 1000.00,
    "type": "income",
    "date": "2024-01-15",
    "category": "sales"
}
```

## Error Handling

### Error Response Format
```json
{
    "error": {
        "code": "ERROR_CODE",
        "message": "Human readable message",
        "details": {
            "field": ["Validation error message"]
        }
    }
}
```

### Common Error Codes
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `500`: Server Error

## Rate Limiting

- Rate limit: 60 requests per minute
- Headers included in response:
  - `X-RateLimit-Limit`
  - `X-RateLimit-Remaining`
  - `X-RateLimit-Reset`

## Pagination

### Query Parameters
- `page`: Page number
- `per_page`: Items per page (default: 15, max: 100)

### Response Format
```json
{
    "data": [],
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "per_page": 15,
        "to": 15,
        "total": 75
    },
    "links": {
        "first": "...",
        "last": "...",
        "prev": null,
        "next": "..."
    }
}
```

## Filtering

### Available Filters
- `date_from`: Start date
- `date_to`: End date
- `type`: Record type
- `category`: Record category

Example:
```http
GET /api/records?date_from=2024-01-01&type=income
```

## Sorting

### Query Parameter
`sort`: Field to sort by, prefixed with `-` for descending order

Example:
```http
GET /api/records?sort=-date
```

## Includes

### Query Parameter
`include`: Related resources to include

Example:
```http
GET /api/records?include=category,user
```

## Security

### CORS
Allowed origins and methods are configured in `config/cors.php`

### SSL
All API endpoints require HTTPS in production

### Input Validation
All inputs are validated according to strict rules:
- XSS protection
- SQL injection prevention
- Type validation
- Size limits

## Versioning

### Current Version
Current API version: v1

### Version Header
```http
Accept: application/vnd.expertfinancas.v1+json
```

## Testing

### Test Credentials
```json
{
    "email": "test@expertfinancas.com.br",
    "password": "test-password"
}
```

### Postman Collection
Download our Postman collection for easy testing:
[ExpertFinancas.postman_collection.json](../postman/ExpertFinancas.postman_collection.json)

## Support

### Contact
- Email: api@expertfinancas.com.br
- Documentation: https://docs.expertfinancas.com.br
- Status Page: https://status.expertfinancas.com.br

### Rate Limits
Contact support to request increased rate limits for production use.

---
*Last updated: January 2024*
