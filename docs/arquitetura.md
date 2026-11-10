# Arquitetura do Recycle Here

## Visão geral

O Recycle Here foi implementado em PHP com organização em camadas inspirada em MVC. A separação busca impedir que regras de negócio, acesso a banco e interface fiquem concentrados nos mesmos arquivos.

Fluxo principal:

```text
Navegador / Cliente da API
          |
          v
    public/index.php
          |
          v
        Router
          |
          v
      Middleware
          |
          v
      Controller
          |
          v
       Service
          |
          v
     Repository
          |
          v
         PDO
          |
          v
      MariaDB
```

## Responsabilidade das camadas

### Interface

- `app/Views/`: páginas HTML renderizadas pelo backend.
- `public/assets/`: CSS, JavaScript e demais recursos públicos.
- `app/Controllers/Web/`: recebe requisições vindas das páginas web e seleciona a resposta/view adequada.

### Aplicação e regras de negócio

- `app/Services/`: coordena as regras de negócio e operações principais.
- `app/Validators/`: valida e normaliza entradas externas antes do uso pelas demais camadas.
- `app/Middlewares/`: autenticação, autorização e proteções aplicadas antes das ações protegidas.

### Dados

- `app/Repositories/`: concentra consultas SQL e persistência.
- `app/Models/`: representa os dados utilizados pela aplicação.
- `app/Core/Database.php`: fornece a conexão PDO configurada para o MariaDB.
- `database/`: migrations, seeds e o esquema SQL consolidado.

## Aplicação web e API

A aplicação web e a API REST utilizam os mesmos Services e Repositories. Dessa forma, as regras de negócio e o acesso ao banco não são duplicados.

```text
Web Controller ----\
                    > Service -> Repository -> PDO -> MariaDB
API Controller ----/
```

Os endpoints da API estão documentados em `docs/api.md`.

## Autenticação

O sistema utiliza sessão PHP. Após um login válido, a sessão armazena os dados necessários para identificar o usuário e seu perfil.

As senhas não são armazenadas em texto puro. O cadastro utiliza `password_hash()` e a autenticação utiliza `password_verify()`.

## Perfis

Existem dois perfis autenticados:

- `company`: representa uma empresa/cooperativa e administra apenas seus próprios pontos de coleta;
- `admin`: acessa o módulo administrativo e gerencia empresas e pontos por status.

Visitantes não possuem conta obrigatória e podem acessar a área pública e pesquisar pontos.

## Segurança

As principais medidas implementadas são:

- consultas parametrizadas por PDO;
- validação de todas as entradas relevantes no backend;
- escaping de saída HTML com `htmlspecialchars()`;
- tokens CSRF em operações que alteram estado;
- sessão regenerada após autenticação;
- middleware de autenticação e autorização por perfil;
- verificação de ownership para operações de empresas;
- tratamento padronizado de erros 403, 404 e 500;
- detalhes técnicos de erros controlados por `APP_DEBUG`;
- logs de autenticação, criação de entidade e erros internos.

## Logs

Os eventos obrigatórios são registrados em `storage/logs/app.log` durante a execução:

- `login_success`;
- `login_failed`;
- `collection_point_created`;
- `internal_error`.

Arquivos `.log` não são versionados no Git; a pasta é mantida por `.gitkeep`.
