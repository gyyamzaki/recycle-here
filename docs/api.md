# Recycle Here API

Base local: `http://localhost:8000/api`

A API usa JSON e reutiliza a autenticação por sessão do sistema. Operações de escrita em pontos exigem usuário com perfil `company` e token CSRF.

## Formato de sucesso

```json
{
  "data": {}
}
```

Listagens podem incluir `meta`.

## Formato de erro

```json
{
  "error": {
    "status": 400,
    "message": "Mensagem do erro.",
    "details": {}
  }
}
```

`details` aparece apenas quando existem erros adicionais de validação.

## Autenticação

### POST /api/auth/login

Corpo:

```json
{
  "email": "teste@recyclehere.local",
  "password": "Teste123!"
}
```

Resposta 200:

```json
{
  "data": {
    "user": {
      "id": 2,
      "name": "Empresa Teste",
      "email": "teste@recyclehere.local",
      "role": "company"
    },
    "csrf_token": "TOKEN"
  }
}
```

A sessão é mantida pelo cookie PHP. O `csrf_token` deve ser enviado nas operações de escrita pelo header `X-CSRF-Token`.

Erros principais: 400 dados inválidos; 401 credenciais inválidas.

### GET /api/auth/me

Exige sessão autenticada. Retorna o usuário atual e um token CSRF válido.

Erros principais: 401 sem autenticação.

### POST /api/auth/logout

Exige sessão autenticada e header `X-CSRF-Token`.

Erros principais: 401 sem autenticação; 403 CSRF inválido.

## Materiais

### GET /api/materiais

Público. Lista os materiais ativos e seus IDs, utilizados em `materials` no cadastro e edição de pontos.

Resposta 200:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Papel",
      "slug": "papel"
    }
  ],
  "meta": {
    "count": 1
  }
}
```

## Pontos de coleta

### GET /api/pontos

Público. Lista os pontos ativos de empresas ativas.

Filtros opcionais:

- `bairro`: bairro ou região, até 100 caracteres.
- `material`: slug do material.

Exemplo: `GET /api/pontos?bairro=Centro&material=papel`

### GET /api/pontos/{id}

Público. Retorna um ponto ativo pelo ID.

Erros principais: 404 ponto inexistente/inativo.

### POST /api/pontos

Exige sessão `company` e `X-CSRF-Token`.

Corpo:

```json
{
  "name": "Ecoponto API",
  "street": "Rua Exemplo",
  "number": "100",
  "complement": "",
  "neighborhood": "Centro",
  "city": "Sorocaba",
  "state": "SP",
  "zip_code": "18000000",
  "phone": "15999999999",
  "opening_hours": "Segunda a sexta, 08h às 17h",
  "materials": [1, 2]
}
```

Resposta: 201.

Erros principais: 400 JSON/dados inválidos; 401 sem autenticação; 403 perfil incorreto, empresa inativa ou CSRF inválido.

### PUT /api/pontos/{id}

Exige sessão `company`, propriedade do ponto e `X-CSRF-Token`.

O corpo utiliza os mesmos campos do POST. A atualização é completa.

Erros principais: 400 dados inválidos; 401 sem autenticação; 403 perfil/CSRF; 404 ponto inexistente ou pertencente a outra empresa.

### DELETE /api/pontos/{id}

Exige sessão `company`, propriedade do ponto e `X-CSRF-Token`.

Resposta 200:

```json
{
  "data": {
    "id": 10,
    "deleted": true,
    "message": "Ponto de coleta excluído com sucesso."
  }
}
```

Erros principais: 401 sem autenticação; 403 perfil/CSRF; 404 ponto inexistente ou pertencente a outra empresa.

## Códigos HTTP utilizados

- 200: operação realizada com sucesso.
- 201: recurso criado.
- 400: entrada ou filtros inválidos.
- 401: autenticação necessária ou credenciais inválidas.
- 403: usuário autenticado sem permissão ou CSRF inválido.
- 404: recurso/endpoint não encontrado.
- 500: erro interno inesperado.
