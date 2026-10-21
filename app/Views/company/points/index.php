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
        content="Área da empresa para gerenciamento dos pontos de coleta no Recycle Here."
    >

    <title>
        Meus pontos | Recycle Here
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
            aria-label="Navegação da área da empresa"
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
                        href="/empresa/pontos"
                        aria-current="page"
                    >
                        Meus pontos
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
                Meus pontos de coleta
            </h1>


            <p>
                Empresa:

                <strong>
                    <?= htmlspecialchars(
                        $company->name,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </strong>
            </p>

        </header>



        <section
            class="search-results"
            aria-labelledby="company-points-title"
        >

            <header class="section-header">

                <h2 id="company-points-title">
                    Pontos cadastrados
                </h2>


                <p>
                    Gerencie os pontos de coleta
                    cadastrados pela sua empresa.
                </p>

            </header>


            <p>

                <a
                    class="button-primary"
                    href="/empresa/pontos/novo"
                >
                    Cadastrar novo ponto
                </a>

            </p>



            <?php if (empty($points)): ?>

                <p>
                    Sua empresa ainda não possui
                    pontos de coleta cadastrados.
                </p>


            <?php else: ?>


                <div class="collection-points-grid">


                    <?php foreach ($points as $point): ?>


                        <article class="collection-point-card">

                            <h3>

                                <?= htmlspecialchars(
                                    $point->name,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h3>


                            <p>

                                <strong>
                                    Localização:
                                </strong>

                                <br>

                                <?= htmlspecialchars(
                                    $point->neighborhood,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                -

                                <?= htmlspecialchars(
                                    $point->city,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>


                            <p>

                                <strong>
                                    Materiais aceitos:
                                </strong>

                                <br>

                                <?= htmlspecialchars(
                                    implode(
                                        ', ',
                                        $point->materials
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>



                            <div class="point-card-actions">


                                <a
                                    href="/pontos/<?= (int) $point->id ?>"
                                >
                                    Ver página pública
                                </a>


                                <a
                                    href="/empresa/pontos/<?= (int) $point->id ?>/editar"
                                >
                                    Editar
                                </a>


                                <form
                                    class="delete-point-form"
                                    action="/empresa/pontos/<?= (int) $point->id ?>/excluir"
                                    method="post"
                                    data-point-name="<?= htmlspecialchars(
                                        $point->name,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
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
                                        class="button-danger"
                                        type="submit"
                                    >
                                        Excluir
                                    </button>

                                </form>


                            </div>

                        </article>


                    <?php endforeach; ?>


                </div>


            <?php endif; ?>


        </section>

    </main>

    <dialog
        class="confirmation-modal"
        id="delete-point-modal"
        aria-labelledby="delete-modal-title"
        aria-describedby="delete-modal-description"
    >

        <div class="confirmation-modal-content">

            <div class="confirmation-modal-icon" aria-hidden="true">
                !
            </div>


            <h2 id="delete-modal-title">
                Excluir ponto de coleta?
            </h2>


            <p id="delete-modal-description">
                Você está prestes a excluir
                <strong id="delete-point-name"></strong>.
                Esta ação não poderá ser desfeita.
            </p>


            <div class="confirmation-modal-actions">

                <button
                    class="button-secondary"
                    id="cancel-delete-button"
                    type="button"
                >
                    Cancelar
                </button>


                <button
                    class="button-danger-filled"
                    id="confirm-delete-button"
                    type="button"
                >
                    Sim, excluir
                </button>

            </div>

        </div>

    </dialog>

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
                    <a href="/empresa/pontos">
                        Meus pontos
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