# Matriz de permissões

| Recurso / ação | Visitante | Company | Admin |
|---|:---:|:---:|:---:|
| Página inicial e páginas públicas | Sim | Sim | Sim |
| Pesquisar pontos de coleta | Sim | Sim | Sim |
| Consultar endpoints públicos da API | Sim | Sim | Sim |
| Login | Sim | Sim | Sim |
| Cadastro de empresa | Sim | - | - |
| Listar os próprios pontos | Não | Sim | Não |
| Criar ponto de coleta | Não | Sim | Não |
| Editar ponto da própria empresa | Não | Sim | Não |
| Excluir ponto da própria empresa | Não | Sim | Não |
| Editar/excluir ponto de outra empresa | Não | Não | Não |
| Acessar `/admin` | Não | Não | Sim |
| Listar empresas no módulo administrativo | Não | Não | Sim |
| Ativar/desativar empresa | Não | Não | Sim |
| Listar todos os pontos no módulo administrativo | Não | Não | Sim |
| Ativar/desativar ponto pelo módulo administrativo | Não | Não | Sim |

## Comportamento de proteção

- visitante em rota autenticada: redirecionado para `/login`;
- usuário autenticado com perfil incorreto: HTTP 403;
- empresa tentando acessar ponto pertencente a outra empresa: recurso tratado como não encontrado (HTTP 404);
- operações protegidas da API sem autenticação ou autorização adequada são rejeitadas;
- operações de escrita da API exigem token CSRF válido.
