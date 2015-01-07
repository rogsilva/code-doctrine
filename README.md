Exemplo API REST com Silex e Doctrine
=================================


Este é um exemplo de uma api REST utilizando o micro-framework Silex e o Doctrine.

----------


Utilização
-------------

> **Instalação:**

> - Faça o clone do projeto.
> - Crie um banco de dados e faça a configuração de acesso no arquivo bootstrap.php.
> - Acesse a pasta bin do projeto e rode o comando "php doctrine orm:schema-tool:create".
> - Acesse a pasta public do projeto e rode o comando "php -S localhost:8000".

#### <i class="icon-refresh"></i> Rotas

> **Utilizando o método HTTP GET:**

> - /api/produtos - Seleciona todos os registros.
> - /api/produtos/{id} - Seleciona um único registro de acordo com o id passado.

> **Utilizando o método HTTP POST:**

> - /api/produtos - Adiciona um novo registro.

> **Utilizando o método HTTP PUT:**

> - /api/produtos/{id} - Altera um registro de acordo com o id passado.

> **Utilizando o método HTTP DELETE:**

> - /api/produtos/{id} - Remove um registro de acordo com o id passado.
