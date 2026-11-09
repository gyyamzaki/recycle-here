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
        content="Erro interno no Recycle Here."
    >

    <title>
        Erro interno | Recycle Here
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
            aria-label="Navegação principal"
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

            </ul>

        </nav>

    </header>



    <main class="simple-page">

        <section
            class="form-section"
            aria-labelledby="error-title"
        >

            <p>
                Erro 500
            </p>


            <h1 id="error-title">
                Ocorreu um erro interno
            </h1>


            <p>
                Não foi possível concluir sua solicitação.
                Tente novamente ou retorne para a
                página inicial.
            </p>


            <?php if (
                isset($debugMessage)
                &&
                $debugMessage !== null
            ): ?>

                <div class="form-errors">

                    <strong>
                        Ambiente de desenvolvimento:
                    </strong>


                    <p>

                        <?= htmlspecialchars(
                            $debugMessage,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </p>

                </div>

            <?php endif; ?>


            <div class="form-actions">

                <a
                    class="button-primary"
                    href="/"
                >
                    Voltar para o início
                </a>


                <a
                    class="back-link"
                    href="/pontos"
                >
                    Ver pontos de coleta
                </a>

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

            </ul>

        </nav>


        <p>
            Projeto acadêmico - 2026
        </p>

    </footer>


    <script src="/assets/js/main.js"></script>

</body>

</html>