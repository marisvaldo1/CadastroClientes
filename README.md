<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Teste de desenvolvimento em PHP com Yii2 Framework</h1>
    <br>
</p>

### DOCUMENTAÇÃO

- [Para iniciar](#para-iniciar-o-serviço)
- [Plataforma para execução do projeto](#plataforma-para-execução-do-projeto)
- [Linguagen e framework](#Linguagen-e-framework)
- [Instalação](#Instalação)
- [Execução e Testes](#Execução-e-testes)
- [Banco de Dados](#Banco-de-dados)

## Para iniciar o serviço 
Essas instruções farão com que você tenha uma cópia do projeto em execução na sua máquina local para fins de desenvolvimento e teste. Veja as notas de implantação sobre como instalar e rodar o sistema.

## Plataforma para execução do projeto

```Browser
Ferramenta cliente de API REST (Postman ou Insomnia)
```

## Linguagen e framework

```php
PHP 7.1.33
YII 2.0.15
```

## Instalação

Clone o projeto

```bash
  git clone https://github.com/marisvaldo1/CadastroClientes.git
  cd CADASTROCLIENTES
```

Instale as dependências

```bash
  composer install
```

Subir os conainers do docker

```bash
  docker-compose up -d --build
```

Dar permissão nas pastas

```bash
  docker exec -it cadastroclientes_app_1 php chmod -R 777 runtime
  docker exec -it cadastroclientes_app_1 php chmod -R 777 web/assets
```

Rodar as Migrations

```bash
  docker exec -it cadastroclientes_app_1 php yii migrate
```

## Execução e testes

Criar um novo usuário para autenticação pela linha de comando

```php
docker exec -it cadastroclientes_app_1 php yii create-user/index "teste" "teste123" "Usuário de teste"
```
<br>

Criar um novo usuário pelo insomnia ou postman<br><br>
Metodo: POST

```php
http://localhost:8000/v1/register

JSON
{
  "login": "teste",
  "senha": "teste123",
  "nome": "Usuário de teste"
}
```
<br>

Obter o token e logar (Colocar no insomnia Heathers Content-Type e application/json)<br>
Metodo: POST

```php
http://localhost:8000/v1/login

JSON
{
  "login": "teste",
  "senha": "teste123",
}
```
<br>

Criar um novo Cliente<br>
Método: POST<br>
Usar o token obtido pelo login<br>

```php

http://localhost:8000/v1/clientes

JSON
{
    "nome": "Teste Cliente",
    "cpf": "40273598104",
    "cep": "12345678",
    "logradouro": "Rua Teste",
    "numero": 123,
    "cidade": "Cidade Teste",
    "estado": "Estado Teste",
    "complemento": "Complemento Teste",
    "sexo": "M",
    "foto": "url_da_foto"
}
```
<br>

Listar todos os clientes<br>
Método: GET<br>
Usar o token obtido pelo login<br>

```php
GET http://localhost:8000/v1/clientes
```
<br>

Listar um cliente específico<br>
Método: GET<br>
Usar o token obtido pelo login<br>

```php
http://localhost:8000/v1/clientes/1
```
<br>

Criar um produto<br>
Método: POST<br>
Usar o token obtido pelo login<br>

```php

http://localhost:8000/v1/produtos

JSON
{
    "nome": "Nome do Produto",
    "preco": 99.99,
    "cliente_id": 1,
    "foto": "url_da_foto_do_produto"
}
```
<br>

Listar todos os produtos<br>
Método: GET<br>
Usar o token obtido pelo login<br>

```php
http://localhost:8000/v1/produtos
```
<br>

Listar produtos de um determinado cliente<br>
Método: GET<br>
Usar o token obtido pelo login<br>

```php
http://localhost:8000/v1/produtos/cliente/2
```

## Banco de dados
MySql 8.0
```
