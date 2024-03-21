# Teste Coalize

Este é um projeto de teste da Coalize.

## Como Iniciar o Projeto

1. Intale o [Docker](https://www.docker.com/) e o [Docker Compose](https://docs.docker.com/compose/)
2. Faça o clone deste repositório numa máquina local

git clone https://github.com/pedrohscramos/coalize.git

3. Entre na pasta do projeto no seu terminal e rode o comando 

docker-compose up -d

4. No seu terminal execute o comando para identificar o ID do container PHP

docker container ls

5. Com o ID em mãos, execute o comando para acessar o bash do container

docker exec -it <container_id> bash

6. Já dentro do bash do container, execute o comando para criar Novo usuário e senha. O retorno será uma mensagem de sucesso e um access_token que será utilizado para autorizar as chamadas das rotas da API

php yii user/create

## Especificções

O acesso às rotas será através do endereço http://localhos:8080/<nome_da_rota>

### Rotas de acesso

- GET /produtos - Lista os produtos
- GET /clientes - Lista os clientes
- POST /produtos - Cadastra os produtos
  - Campos exigidos(nome, preco, foto, id_cliente)
- POST /clientes - cadastra os clientes
  - Campos exigidos(nome, cpf, cep, logradouro, numero, cidade, estado, complemento, foto, sexo)
- POST produtos/por-cliente - Busca produtos pelo nome do cliente
  - Campo esperado no post(nome)
- GET produtos/por-cliente-id/:num - Busca produtos pelo id do cliente(onde :num é o id do cliente)

### Comando personalizado

- No terminal acesse: php Yii user/create  - Cria um novo usuário no banco de dados e retorna o access token
  - O sistema irá perguntar Nome, Login e Senha