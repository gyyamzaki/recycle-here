<?php

$companies =
    $companies ?? [];

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
        Empresas | Administração
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
                <a
                    href="/admin/empresas"
                    aria-current="page"
                >
                    Empresas
                </a>
            </li>

            <li>
                <a href="/admin/pontos">
                    Pontos
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



<main class="admin-page">

    <a
        class="back-link"
        href="/admin"
    >
        Voltar ao dashboard
    </a>


    <header class="admin-page-header">

        <h1>
            Empresas cadastradas
        </h1>

        <p>
            Consulte todas as empresas
            e cooperativas cadastradas.
        </p>

    </header>


    <?php if (empty($companies)): ?>

        <div class="admin-empty-state">

            <h2>
                Nenhuma empresa cadastrada
            </h2>

        </div>

    <?php else: ?>


        <div class="admin-company-cards">

            <?php foreach (
                $companies
                as $company
            ): ?>

                <article class="admin-company-card">

                    <header>

                        <h2>

                            <?= htmlspecialchars(
                                $company['name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </h2>


                        <?php if (
                            (int) $company['active']
                            ===
                            1
                        ): ?>

                            <span
                                class="
                                    status-badge
                                    status-active
                                "
                            >
                                Ativa
                            </span>

                        <?php else: ?>

                            <span
                                class="
                                    status-badge
                                    status-inactive
                                "
                            >
                                Inativa
                            </span>

                        <?php endif; ?>

                    </header>


                    <dl>

                        <div>

                            <dt>
                                CNPJ
                            </dt>

                            <dd>

                                <?= htmlspecialchars(
                                    $company['cnpj'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </dd>

                        </div>


                        <div>

                            <dt>
                                E-mail
                            </dt>

                            <dd>

                                <?= htmlspecialchars(
                                    $company['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </dd>

                        </div>


                        <div>

                            <dt>
                                Pontos
                            </dt>

                            <dd>

                                <?= (int)
                                    $company['point_count']
                                ?>

                            </dd>

                        </div>

                    </dl>


                    <a
                        class="button-primary"
                        href="/admin/empresas/<?= (int) $company['id'] ?>"
                    >
                        Ver empresa
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