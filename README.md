# Recycle Here

Plataforma web desenvolvida como projeto acadêmico para facilitar a localização de pontos de coleta e reciclagem.

## Objetivo

O Recycle Here tem como objetivo auxiliar usuários a encontrar pontos de coleta de materiais recicláveis, inicialmente na cidade de Sorocaba, de acordo com a região e o tipo de material que desejam descartar.

## Funcionalidades

Nesta primeira etapa, o projeto permite:

- pesquisar pontos de coleta por bairro ou região;
- filtrar pontos de acordo com o material;
- visualizar informações detalhadas sobre os pontos de coleta;
- consultar diferentes tipos de materiais recicláveis;
- acessar páginas de cadastro e login para empresas e cooperativas;
- navegar pelo site em dispositivos móveis, tablets e computadores;
- receber uma mensagem de erro ao acessar um ponto de coleta inexistente.

## Tecnologias

Nesta primeira etapa foram utilizadas:

- HTML5;
- CSS3;
- JavaScript;
- Git;
- GitHub.

## Estrutura do projeto

    recycle-here/
    ├── assets/
    │   └── images/
    │
    ├── css/
    │   └── style.css
    │
    ├── docs/
    │   ├── evidencias/
    │   │   ├── compatibilidade/
    │   │   ├── git/
    │   │   ├── lighthouse/
    │   │   ├── responsividade/
    │   │   └── validacao/
    │   │
    │   └── registro-ia.md
    │
    ├── js/
    │   └── main.js
    │
    ├── cadastro.html
    ├── index.html
    ├── login.html
    ├── ponto.html
    ├── pontos.html
    ├── .gitignore
    └── README.md

## Como executar

O projeto não necessita da instalação de dependências externas.

### Opção 1 — Abrir diretamente no navegador

1. Faça o download ou clone este repositório.
2. Abra a pasta do projeto.
3. Abra o arquivo `index.html` em um navegador moderno.

### Opção 2 — Utilizar Live Server

Caso esteja utilizando o Visual Studio Code:

1. Abra a pasta do projeto no VS Code.
2. Instale a extensão Live Server.
3. Abra o arquivo `index.html`.
4. Clique em **Open with Live Server** ou **Go Live**.
5. O projeto será aberto em um endereço semelhante a `http://127.0.0.1:5500/index.html`.

## Navegadores testados

A aplicação foi testada nos seguintes navegadores:

- Google Chrome;
- Mozilla Firefox;
- Microsoft Edge.

## Validações realizadas

Durante o desenvolvimento da primeira etapa foram realizadas as seguintes verificações:

- validação dos arquivos HTML pelo W3C;
- validação do CSS pelo W3C;
- teste de navegação por teclado;
- teste de responsividade em mobile, tablet e desktop;
- teste de compatibilidade entre navegadores;
- auditoria utilizando Lighthouse.

### Resultados do Lighthouse

| Categoria | Resultado |
| --- | ---: |
| Performance | 100 |
| Accessibility | 96 |
| Best Practices | 100 |
| SEO | 100 |

Também foram obtidos:

- LCP: 1,0 s;
- CLS: 0;
- TBT: 0 ms.

## Uso de Inteligência Artificial

Ferramentas de inteligência artificial foram utilizadas como apoio durante o planejamento, desenvolvimento, revisão do código, documentação e geração de uma ilustração utilizada no projeto.

O uso dessas ferramentas foi registrado no arquivo `docs/registro-ia.md`.

## Limitações atuais

Nesta primeira etapa, o projeto utiliza somente tecnologias de front-end.

Os pontos de coleta apresentados utilizam dados de demonstração armazenados diretamente no HTML e JavaScript.

As páginas de cadastro e login representam apenas a interface visual e ainda não realizam autenticação ou armazenamento de informações.

Também não existe, nesta etapa:

- banco de dados;
- backend;
- autenticação real;
- integração com mapas;
- geolocalização;
- cálculo de distância até os pontos de coleta.

Essas funcionalidades estão previstas para etapas futuras do projeto.

## Status

**Etapa 1 concluída:** interface front-end desenvolvida, testada e documentada.