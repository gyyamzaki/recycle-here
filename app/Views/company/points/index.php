<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
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

        <a class="logo" href="/">
            Recycle Here
        </a>

        <nav
            class="site-nav"
            aria-label="Área da empresa"
        >

            <ul class="nav-list">

                <li>
                    <a href="/empresa/pontos">
                        Meus pontos
                    </a>
                </li>

                <li>

                    <form
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
                            type="submit"
                            class="button-secondary"
                        >
                            Sair
                        </button>

                    </form>

                </li>

            </ul>

        </nav>

    </header>


    <main class="points-page">

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


        <section>

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

                    <?php foreach (
                        $points as $point
                    ): ?>

                        <article
                            class="collection-point-card"
                        >

                            <h2>
                                <?= htmlspecialchars(
                                    $point->name,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </h2>


                            <p>

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

                                <a
                                    href="/empresa/pontos/<?= (int) $point->id ?>/editar"
                                >
                                    Editar
                                </a>

                            </p>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>

    </main>


    <script src="/assets/js/main.js"></script>

</body>

</html>