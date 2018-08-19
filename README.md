# webscrapping

Projeto para gerar um array de dados de salários mínimos, extraídos de do site Guia Trabalhista<br>
para exemplificar o uso da biblioteca Guzzle na implementação de webscrapper

## Utilizando o docker:
Esteja na raiz do projeto e execute:
```shell
docker-compose up -d
docker-compose exec php-fpm bash
```
Após subir o ambiente, execute:
```shell
php index.php #versão estruturada simplificada
```
ou
```shell
php index_oo.php #versão orientada a objetos simplificada
```