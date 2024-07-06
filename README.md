<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Teste de desenvolvimento em Yii2 Framework</h1>
    <br>
</p>

### DOCUMENTAÇÃO

- [Para iniciar](#para-iniciar-o-serviço)
- [Plataforma para execução do projeto](#plataforma-para-execução-do-projeto)
- [Linguagens utilizadas no desenvolvimento](#linguagem)
- [Instalação](#Instalação)
- [Banco de dados](#banco-de-dados)
- [Observações](#observações)

## Para iniciar o serviço 
Essas instruções farão com que você tenha uma cópia do projeto em execução na sua máquina local para fins de desenvolvimento e teste. Veja as notas de implantação sobre como instalar e rodar o sistema.

## Plataforma para execução do projeto

```Browser
Ferramenta cliente de API REST (Postman ou Insomnia)
```

## Linguagem

```php
PHP 7.1.33
YII 2.0.15
```

## Instalação

```Clonar o repositório
https://github.com/marisvaldo1/CadastroClientes.git

Acessar o diretório
cd CADASTROCLIENTES

Instalar Dependências do Composer
    pelo terminal executar 
        - composer install

Subir os Contêineres do Docker:
Com o Docker Desktop já em execução, utilize o comando abaixo para subir os contêineres definidos no docker-compose.yml.
docker-compose up -d --build

As seguintes pastas podem precisar de permissão para execução.
No terminal execute
    docker exec -it cadastroclientes_app_1 php chmod -R 777 runtime
    docker exec -it cadastroclientes_app_1 php chmod -R 777 web/assets
        
rodar as migrations para a criação das tabelas 
    docker exec -it cadastroclientes_app_1 php yii migrate

Criar um novo usuário para autenticação pela linha de comando
    docker exec -it cadastroclientes_app_1 php yii create-user/index "teste" "teste123" "Usuário de teste"

Criar um novo usuário pelo insomnia ou postman
Metodo: POST
    http://localhost:8000/v1/register
    {
      "login": "teste",
      "senha": "teste123",
      "nome": "Usuário de teste"
    }

Para obter o token do usuário criado (Usar no Heathers Content-Type - application/json)
http://localhost:8000/v1/login
{
  "login": "teste",
  "senha": "teste123",
}


```

## Banco de dados
</br>Tipo de servidor: PostgreSQL
As configurações do banco de dados estão no arquivo .env abaixo
<br>

```.env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=FirstDecision
DB_USERNAME=usuario
DB_PASSWORD=senha
```
