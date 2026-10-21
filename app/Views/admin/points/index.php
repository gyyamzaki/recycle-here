<?php

$points =
    $points ?? [];

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pontos | Administração
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
                <a href="/admin">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/admin/empresas">
                    Empresas
                </a>
            </li>

            <li>
                <a
                    href="/admin/pontos"
                    aria-current="page"
                >
                    Pontos
                </a>
            </li>

        </ul>

    </nav>

</header>



<main class="admin-page">

    <a
        class="back-link"
        href="/admin"
    >
        Voltar ao dashboard
    </a>


    <header class="admin-page-header">

        <h1>
            Pontos de coleta
        </h1>

        <p>
            Consulte todos os pontos
            cadastrados pelas empresas.
        </p>

    </header>



    <?php if (empty($points)): ?>

        <div class="admin-empty-state">

            <h2>
                Nenhum ponto cadastrado
            </h2>

        </div>

    <?php else: ?>


        <div class="admin-company-cards">

            <?php foreach (
                $points
                as $point
            ): ?>

                <article class="admin-company-card">

                    <header>

                        <h2>

                            <?= htmlspecialchars(
                                $point['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </h2>


                        <?php if (
                            (int) $point['active']
                            ===
                            1
                        ): ?>

                            <span
                                class="
                                    status-badge
                                    status-active
                                "
                            >
                                Ativo
                            </span>

                        <?php else: ?>

                            <span
                                class="
                                    status-badge
                                    status-inactive
                                "
                            >
                                Inativo
                            </span>

                        <?php endif; ?>

                    </header>


                    <dl>

                        <div>

                            <dt>
                                Empresa
                            </dt>

                            <dd>

                                <?= htmlspecialchars(
                                    $point['company_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </dd>

                        </div>


                        <div>

                            <dt>
                                Localização
                            </dt>

                            <dd>

                                <?= htmlspecialchars(
                                    $point['neighborhood'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                                -

                                <?= htmlspecialchars(
                                    $point['city'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </dd>

                        </div>

                    </dl>


                    <a
                        class="button-primary"
                        href="/admin/pontos/<?= (int) $point['id'] ?>"
                    >
                        Ver ponto
                    </a>

                </article>

            <?php endforeach; ?>

        </div>


    <?php endif; ?>

</main>


<footer class="site-footer">

    <p>
        Recycle Here
    </p>

    <p>
        Projeto acadêmico - 2026
    </p>

</footer>


<script src="/assets/js/main.js"></script>

</body>

</html>