# Testes e evidências de segurança

Este documento registra os testes manuais realizados durante a validação final do Recycle Here.

## 1. SQL Injection

Foram enviados filtros contendo o payload:

```text
' OR 1=1 --
```

### Bairro

Resultado observado: lista vazia (`count = 0`). O payload foi tratado como texto e não alterou a consulta SQL.

### Material

Resultado observado: HTTP 400 com mensagem de filtro inválido.

Conclusão: a tentativa não foi interpretada como parte da consulta. O sistema combina validação de entrada e consultas parametrizadas.

## 2. XSS refletido

Payload utilizado na interface de pesquisa:

```html
<script>alert('XSS')</script>
```

Resultado observado: o conteúdo foi exibido como texto no campo e nenhum JavaScript foi executado. O print está em `docs/evidencias/xss-refletido.png`.

## 3. CSRF

Foi realizada uma requisição autenticada de criação de ponto pela API sem o cabeçalho `X-CSRF-Token`.

Resultado observado:

```json
{"error":{"status":403,"message":"Token CSRF inválido ou ausente."}}
```

Conclusão: operações de escrita protegidas são recusadas sem token válido.

## 4. Acesso não autenticado

Testes pela interface:

- visitante acessando `/empresa/pontos`: redirecionado para `/login`;
- visitante acessando `/admin`: redirecionado para `/login`.

## 5. Controle por perfil

Testes pela interface:

- usuário `company` acessando `/admin`: HTTP 403;
- usuário `admin` acessando `/empresa/pontos`: HTTP 403.

## 6. Ownership

Uma empresa autenticada tentou excluir pela API o ponto de ID 1, pertencente a outra empresa.

Resultado observado:

```json
{"error":{"status":404,"message":"Ponto de coleta não encontrado."}}
```

Conclusão: a empresa não consegue alterar nem excluir recursos que não lhe pertencem.

## 7. Testes automatizados

O runner localizado em `tests/run.php` executou 10 testes automatizados de validação e regras de entrada.

Resultado:

```text
Tests:  10
Passed: 10
Failed: 0
```

O print está em `docs/evidencias/testes-automatizados.png`.

## Evidências em texto

Os retornos de terminal utilizados durante os testes de SQL Injection, CSRF e ownership foram consolidados em `docs/evidencias/seguranca-terminal.txt`.
