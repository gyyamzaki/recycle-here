<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Área administrativa do Recycle Here."
    >

    <title>
        Administração | Recycle Here
    </title>

    <link
        rel="stylesheet"
        href="/assets/css/style.css"
    >

</head>


<body>

    <header class="site-header">

        <a
            class="logo"
            href="/"
        >
            Recycle Here
        </a>


        <button
            class="menu-button"
            type="button"
            aria-expanded="false"
            aria-controls="main-navigation"
        >
            Menu
        </button>


        <nav
            class="site-nav"
            id="main-navigation"
            aria-label="Navegação administrativa"
        >

            <ul class="nav-list">

                <li>
                    <a href="/">
                        Início
                    </a>
                </li>


                <li>
                    <a href="/pontos">
                        Pontos de coleta
                    </a>
                </li>


                <li>
                    <a
                        href="/admin"
                        aria-current="page"
                    >
                        Administração
                    </a>
                </li>


                <li>

                    <form
                        class="nav-logout-form"
                        action="/logout"
                        method="post"
                    >

                        <input
                            type="hidden"
                            name="_csrf"
                            value="<?= htmlspecialchars(
                                App\Core\Csrf::token(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                        >


                        <button
                            class="nav-logout-button"
                            type="submit"
                        >
                            Sair
                        </button>

                    </form>

                </li>

            </ul>

        </nav>

    </header>



    <main class="points-page">

        <a
            class="back-link"
            href="/"
        >
            Voltar para a página inicial
        </a>


        <header class="points-page-header">

            <h1>
                Área administrativa
            </h1>


            <p>

                Olá,

                <strong>
                    <?= htmlspecialchars(
                        (string) ($user['name'] ?? 'Administrador'),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </strong>.

                Você está autenticado como administrador.

            </p>

        </header>



        <section
            class="search-results"
            aria-labelledby="admin-options-title"
        >

            <header class="section-header">

                <h2 id="admin-options-title">
                    Administração do sistema
                </h2>


                <p>
                    Esta área reúne as funcionalidades
                    exclusivas do administrador.
                </p>

            </header>


            <div class="collection-points-grid">


                <article class="collection-point-card">

                    <h3>
                        Empresas
                    </h3>

                    <p>
                        Gerenciamento das empresas
                        cadastradas na plataforma.
                    </p>

                    <p>
                        Funcionalidade administrativa
                        que será implementada na próxima etapa.
                    </p>

                </article>



                <article class="collection-point-card">

                    <h3>
                        Pontos de coleta
                    </h3>

                    <p>
                        Consulta administrativa dos pontos
                        cadastrados pelas empresas.
                    </p>

                    <a href="/pontos">
                        Ver pontos
                    </a>

                </article>



                <article class="collection-point-card">

                    <h3>
                        Sistema
                    </h3>

                    <p>
                        Área reservada para recursos
                        administrativos do Recycle Here.
                    </p>

                </article>


            </div>

        </section>

    </main>



    <footer class="site-footer">

        <p>
            Recycle Here
        </p>


        <nav
            aria-label="Navegação do rodapé"
        >

            <ul class="footer-nav">

                <li>
                    <a href="/">
                        Início
                    </a>
                </li>


                <li>
                    <a href="/pontos">
                        Pontos de coleta
                    </a>
                </li>


                <li>
                    <a href="/admin">
                        Administração
                    </a>
                </li>

            </ul>

        </nav>


        <p>
            Projeto acadêmico - 2026
        </p>

    </footer>


    <script src="/assets/js/main.js"></script>

</body>

</html>