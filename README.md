# Recycle Here

Plataforma web desenvolvida como projeto acadêmico para facilitar a localização de pontos de coleta de materiais recicláveis e permitir o gerenciamento desses pontos por empresas e cooperativas.

## Objetivo

O Recycle Here tem como objetivo conectar usuários a pontos de coleta adequados para diferentes tipos de materiais recicláveis.

A aplicação permite que visitantes pesquisem locais de descarte e que empresas ou cooperativas cadastrem e gerenciem seus próprios pontos de coleta.

O projeto foi desenvolvido inicialmente com foco na cidade de Sorocaba, mas sua estrutura permite expansão para outras regiões.

## Funcionalidades

### Visitantes

- visualizar os pontos de coleta disponíveis;
- pesquisar pontos por bairro ou região;
- filtrar pontos pelo tipo de material;
- consultar informações detalhadas de cada ponto;
- consultar os materiais aceitos;
- utilizar o sistema sem necessidade de autenticação.

### Empresas e cooperativas

- realizar cadastro;
- realizar login e logout;
- acessar uma área protegida;
- cadastrar pontos de coleta;
- visualizar seus próprios pontos;
- editar seus pontos;
- excluir seus pontos;
- selecionar os materiais aceitos em cada local.

Uma empresa não pode editar ou excluir pontos pertencentes a outra empresa.

### Administrador

- acessar dashboard administrativo;
- visualizar empresas cadastradas;
- visualizar detalhes de empresas;
- ativar e desativar empresas;
- visualizar todos os pontos de coleta;
- visualizar detalhes dos pontos;
- ativar e desativar pontos de coleta.

O acesso às funcionalidades administrativas é restrito ao perfil `admin`.

## Arquitetura

O projeto utiliza uma arquitetura em camadas baseada no padrão MVC.

Fluxo simplificado:

```text
Browser / API
     ↓
Router
     ↓
Middleware
     ↓
Controller
     ↓
Validator
     ↓
Service
     ↓
Repository
     ↓
PDO
     ↓
MariaDB
```

Principais responsabilidades:

- **Controllers:** recebem as requisições e coordenam as respostas;
- **Middlewares:** controlam autenticação, autorização e CSRF;
- **Validators:** validam dados externos;
- **Services:** concentram regras de negócio;
- **Repositories:** realizam o acesso ao banco de dados;
- **Models:** representam as entidades da aplicação;
- **Views:** responsáveis pela interface HTML.

Mais detalhes estão disponíveis em `docs/arquitetura.md`.

## Tecnologias

- PHP 8.2;
- MariaDB;
- PDO;
- HTML5;
- CSS3;
- JavaScript;
- Composer;
- `vlucas/phpdotenv`;
- Git;
- GitHub.

## Banco de dados

O sistema utiliza MariaDB.

Principais tabelas:

- `users`;
- `companies`;
- `materials`;
- `collection_points`;
- `collection_point_material`.

Relações principais:

- um usuário do tipo empresa possui uma empresa;
- uma empresa pode possuir vários pontos de coleta;
- um ponto pode aceitar vários materiais;
- um material pode ser aceito por vários pontos.

A relação entre pontos e materiais é implementada pela tabela associativa `collection_point_material`.

O arquivo consolidado para criação da estrutura está disponível em:

```text
database/schema.sql
```

As migrations utilizadas durante o desenvolvimento também estão disponíveis em:

```text
database/migrations/
```

## Segurança

A aplicação implementa:

- autenticação baseada em sessão;
- regeneração de sessão após login;
- senhas armazenadas com `password_hash()`;
- autenticação com `password_verify()`;
- controle de acesso por perfil;
- controle de propriedade dos pontos de coleta;
- proteção CSRF;
- consultas parametrizadas com PDO;
- validação de entradas no backend;
- escape de saída HTML;
- páginas padronizadas de erro 403, 404 e 500;
- logs de eventos importantes;
- separação de detalhes técnicos conforme configuração de ambiente.

Foram realizados testes contra:

- SQL Injection;
- XSS refletido;
- CSRF;
- acesso sem autenticação;
- acesso utilizando perfil incorreto;
- tentativa de alteração de recurso pertencente a outra empresa.

As evidências e detalhes estão disponíveis em:

```text
docs/seguranca.md
docs/evidencias/
```

## API REST

O projeto também disponibiliza uma API REST.

Principais endpoints:

```text
POST   /api/auth/login
GET    /api/auth/me
POST   /api/auth/logout

GET    /api/materiais

GET    /api/pontos
GET    /api/pontos/{id}
POST   /api/pontos
PUT    /api/pontos/{id}
DELETE /api/pontos/{id}
```

Operações de leitura dos pontos são públicas.

Operações de criação, edição e exclusão exigem autenticação como empresa e seguem as regras de autorização e proteção CSRF.

A documentação completa está em:

```text
docs/api.md
```

## Testes automatizados

O projeto contém testes automatizados para regras de validação.

Os testes cobrem, entre outros casos:

- login válido e inválido;
- cadastro válido e inválido;
- cadastro de ponto válido;
- campos obrigatórios;
- materiais inválidos;
- CEP, telefone e UF inválidos;
- filtros de pesquisa;
- entradas maliciosas.

Para executar:

```powershell
C:\xampp\php\php.exe tests\run.php
```

Resultado validado:

```text
Tests:  10
Passed: 10
Failed: 0
```

## Estrutura principal

```text
recycle-here/
├── app/
│   ├── Controllers/
│   │   ├── Api/
│   │   └── Web/
│   ├── Core/
│   ├── Middlewares/
│   ├── Models/
│   ├── Repositories/
│   ├── Services/
│   ├── Validators/
│   └── Views/
│
├── config/
├── database/
│   ├── migrations/
│   ├── seeds/
│   └── schema.sql
│
├── docs/
│   ├── evidencias/
│   ├── api.md
│   ├── arquitetura.md
│   ├── matriz-permissoes.md
│   ├── registro-ia.md
│   └── seguranca.md
│
├── public/
│   ├── assets/
│   └── index.php
│
├── routes/
│   ├── api.php
│   └── web.php
│
├── storage/
│   └── logs/
│
├── tests/
├── .env.example
├── .gitignore
├── composer.json
├── composer.lock
└── README.md
```

## Como executar

### Requisitos

- PHP 8.2 ou superior;
- MariaDB;
- Composer.

O desenvolvimento foi realizado utilizando XAMPP no Windows.

### 1. Clonar o projeto

```powershell
git clone https://github.com/gyyamzaki/recycle-here.git
cd recycle-here
```

### 2. Instalar as dependências

```powershell
composer install
```

### 3. Criar o arquivo de ambiente

No Windows:

```powershell
Copy-Item .env.example .env
```

Depois ajuste as configurações de banco no `.env`, quando necessário.

Exemplo:

```env
APP_NAME="Recycle Here"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=recycle_here
DB_USERNAME=root
DB_PASSWORD=
DB_CHARSET=utf8mb4
```

O arquivo `.env` não é versionado.

### 4. Criar o banco

Abra o cliente MariaDB:

```powershell
C:\xampp\mysql\bin\mysql.exe --default-character-set=utf8mb4 -u root
```

Execute:

```sql
SOURCE C:/caminho/para/recycle-here/database/schema.sql;
```

### 5. Iniciar a aplicação

Na raiz do projeto:

```powershell
C:\xampp\php\php.exe -S localhost:8000 -t public public/index.php
```

Acesse:

```text
http://localhost:8000
```

## Logs

Os logs da aplicação são armazenados em:

```text
storage/logs/app.log
```

Entre os eventos registrados estão:

- login realizado com sucesso;
- tentativa de login inválida;
- criação de ponto de coleta;
- erros internos da aplicação.

Arquivos `.log` não são versionados.

## Documentação

A pasta `docs/` contém:

- documentação da arquitetura;
- documentação da API;
- matriz de permissões;
- documentação dos testes de segurança;
- evidências dos testes;
- registro de uso de inteligência artificial.

## Uso de Inteligência Artificial

Ferramentas de inteligência artificial foram utilizadas como apoio durante o planejamento, desenvolvimento, revisão de código, testes e documentação do projeto.

O uso dessas ferramentas está registrado em:

```text
docs/registro-ia.md
```

## Responsividade e acessibilidade

A interface utiliza abordagem responsiva e foi desenvolvida para funcionamento em dispositivos móveis, tablets e desktops.

Também foram utilizados:

- HTML semântico;
- navegação por teclado;
- atributos ARIA;
- estados de foco visíveis;
- textos alternativos para imagens.

## Status

**Projeto funcional:** frontend, backend, banco de dados, autenticação, autorização, CRUD, área administrativa, API REST, segurança, logs e testes automatizados implementados.