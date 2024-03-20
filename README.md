# Teste Coalize

Este é um projeto de teste da Coalize.

## Como Iniciar o Projeto

1. Intale o [Docker](https://www.docker.com/) e o [Docker Compose](https://docs.docker.com/compose/)
2. Faça o clone deste repositório numa máquina local

git clone https://github.com/pedrohscramos/coalize.git

1. Entre na pasta do projeto no seu terminal e rode o comando 

docker-compose up -d

## Especificções

### Rotas de acesso

- GET /produtos - Lista os produtos
- GET /clientes - Lista os clientes
- POST /produtos - Cadastra os produtos
  - Campos exigidos(nome, preco, foto, id_cliente)
- POST /clientes - cadastra os clientes
  - Campos exigidos(nome, cpf, cep, logradouro, numero, cidade, estado, complemento, foto, sexo)
- POST produtos/por-cliente - Busca produtos pelo nome do cliente
  - Campo esperado no post(nome)
- GET produtos/por-cliente-id/:num - Busca produtos pelo id do cliente

### Comando personalizado

- No terminal acesse: php Yii user/create  - Cria um novo usuário no banco de dados e retorna o access token
  - O sistema irá perguntar Nome, Login e Senha