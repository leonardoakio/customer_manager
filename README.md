<div align='right'>
    <a href="./README.md">Inglês |</a>
    <a href="./PORTUGUESE.md">Português</a>
</div>

<div align='center'>
    <h1>Template</h1>
    <a href="https://www.linkedin.com/in/leonardo-akio/" target="_blank"><img src="https://img.shields.io/badge/LinkedIn%20-blue?style=flat&logo=linkedin&labelColor=blue" target="_blank"></a> 
    <img src="https://img.shields.io/badge/version-v0.1-blue"/>
    <img src="https://img.shields.io/github/contributors/akioleo/MoneyTransaction_v2"/>
    <img src="https://img.shields.io/github/stars/akioleo/MoneyTransaction_v2?style=sociale"/>
    <img src="https://img.shields.io/github/forks/akioleo/MoneyTransaction_v2?style=social"/>
</div>


## Compatibilidade
- PHP >= 8.1
- Laravel >= 10.22.0
- Composer >= 2.5.8

## Ambiente
- PHP 8.2.9
- Nginx 1.24.0
- PostgreSQL 16.1
- MongoDB 7.0
- Redis 7.2.0

### Como verificar as versões do container
#### Abrir o tinker do PHP dentro dentro do contexto da sua aplicação (container)
```
php artisan tinker
```
- Validar as versões **(PHP, Composer, Laravel)**
```
phpversion();   |  shell_exec('composer --version');  | app()->version();
```
- Validar conexão *PDO* com banco de dados
```
DB::connection()->getPDO();
```
- Buscar pelas ENVs da aplicação
```
var_dump($_ENV)
```
#### Raiz do projeto
- Validar versão do **REDIS** 
```
docker exec -it cliente-total_redis redis-cli
```
```
INFO SERVER
```
- Validar versão do **PostgreSQL** (raiz do projeto)
```
docker exec -it customer_manager_postgres psql -U root -d customer_manager -W
```
```
SELECT VERSION();
```
- Validar versão do **MongoDB** (raiz do projeto)
```
docker exec -it cliente-total_mongodb bash
```
```
mongod --version
```

## Iniciando o projeto
Criar o arquivo `.env` no projeto
```bash
php -r "copy('.env.example', '.env');"
```
Criar uma network (caso não esteja criada)
```bash
docker network create docker-net
```
Faça o build dos containeres no `docker-compose` no diretório raiz:
```bash
docker-compose up -d --build
```

### Serviços e Portas

| Container                   | Host Port | Container Port (Internal) |
| --------------------------- | --------- | ------------------------- |
| customer_manager_app        | `9501`    | `9501`                    |
| customer_manager_nginx      | `8080`    | `80`                      |
| customer_manager_postgres   | `5432`    | `5432`                    |
| customer_manager_mongodb    | `27017`   | `27017`                   |
| customer_manager_redis      | `6379`    | `6379`                    |
| customer_manager_metabase   | `3000`    | `3000`                    |

## Health
Endpoint que validam a saúde da aplicação e dos serviços:

- `http://localhost:8080/health`
- `http://localhost:8080/liveness`

## Documentação 
Endpoint da aplicação: `http://localhost:8080/documentation`

A documentação da API deve ser realizada no formato YAML e são armazenados no diretório `storage/api-docs` pelo nome `api-docs-v1.yml`

**Referências:**
- [Especificação OpenAPI - Swagger](https://swagger.io/specification/)
