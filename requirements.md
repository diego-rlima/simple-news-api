# IDX - Teste de Nível

O objetivo deste teste É analisar o seu conhecimento em desenvolvimento de Restful APIs utilizando o framework Laravel.

## Instruções Gerais

*  Duplique este repositório (não faça um fork dele);
*  Faça seu teste;
*  Utilizar a versão mais recente do Laravel

## Features

### 1. Usuários

Criar endpoints para CRUD de usuários contemplando

* Nome
* Email
* Senha

## 2. Auth

Contemplando os seguintes endpoints:

* Endpoint de login para autenticação de usuário
* Endpoint para renovar token de usuário logado

#### Observação:

* O token deve expirar em 2 horas

### 3. Categorias
Criar endpoint de CRUD de Categorias contemplando:

- Nome da categoria
- Slug da categoria


### 4. Notícias

Criar endpoints de CRUD de Notícias contemplando:

* Titulo
* Slug
* Conteúdo
* Categorias
* Thumbnail
* Autor

#### Observações

* Noticia deve ter relacionamento N pra N;
* Ao remover uma categoria deve remover o relacionamento da mesma com qualquer noticia;
* Somente usuários logados podem remover/atualizar/cadastrar;
* No endpoint de listagem possibilitar filtragem por autor, categoria e uma busca por qualquer palavra dentro do conteúdo;
* No endpoint de visualização de notícia, permitir através do ID da notícia ou de seu slug.

## O que esperamos

* Código limpo;
* Comentários quando você achar necessário explicar uma decisão ou deixar informações importantes a respeito da especificação;
* Uma forma simples de rodar o código e realizar os testes;
* Uma forma simples de verificarmos as rotas dos endpoints e como consumi-los.

## Diferenciais

* Aplicar padrão de projetol
* Utilização de Swagger;
* Utilização de um GIT Flow;
* Utilização de uma Vagrant ou Docker.
