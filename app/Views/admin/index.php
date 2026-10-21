<?php

$stats =
    $stats ?? [];

$companies =
    $companies ?? [];

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

    <meta
        name="description"
        content="Painel administrativo do Recycle Here."
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
                <a href="/">
                    Início
                </a>
            </li>

            <li>
                <a href="/admin/empresas">
                    Empresas
                </a>
            </li>

            <li>
                <a href="/admin/pontos">
                    Pontos
                </a>
            </li>

            <li>
                <a
                    href="/admin"
                    aria-current="page"
                >
                    Dashboard
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


    <header class="admin-page-header">

        <p class="admin-eyebrow">
            Administração
        </p>


        <h1>
            Painel administrativo
        </h1>


        <p>

            Olá,

            <strong>
                <?= htmlspecialchars(
                    (string) (
                        $user['name']
                        ??
                        'Administrador'
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </strong>.

            Aqui você acompanha o funcionamento
            do Recycle Here.

        </p>

    </header>



    <section
        class="admin-summary"
        aria-label="Resumo do sistema"
    >

        <article class="admin-summary-card">

            <span class="admin-summary-label">
                Empresas
            </span>

            <strong class="admin-summary-value">
                <?= (int) (
                    $stats['total_companies']
                    ??
                    0
                ) ?>
            </strong>

            <span class="admin-summary-description">
                cadastradas
            </span>

        </article>


        <article class="admin-summary-card">

            <span class="admin-summary-label">
                Empresas ativas
            </span>

            <strong class="admin-summary-value">
                <?= (int) (
                    $stats['active_companies']
                    ??
                    0
                ) ?>
            </strong>

            <span class="admin-summary-description">
                liberadas
            </span>

        </article>


        <article class="admin-summary-card">

            <span class="admin-summary-label">
                Pontos
            </span>

            <strong class="admin-summary-value">
                <?= (int) (
                    $stats['total_points']
                    ??
                    0
                ) ?>
            </strong>

            <span class="admin-summary-description">
                cadastrados
            </span>

        </article>


        <article class="admin-summary-card">

            <span class="admin-summary-label">
                Pontos ativos
            </span>

            <strong class="admin-summary-value">
                <?= (int) (
                    $stats['active_points']
                    ??
                    0
                ) ?>
            </strong>

            <span class="admin-summary-description">
                publicados
            </span>

        </article>

    </section>



    <div class="admin-dashboard-links">

        <a
            class="admin-dashboard-link"
            href="/admin/empresas"
        >

            <strong>
                Gerenciar empresas
            </strong>

            <span>
                Consultar empresas, dados,
                pontos e status.
            </span>

        </a>


        <a
            class="admin-dashboard-link"
            href="/admin/pontos"
        >

            <strong>
                Gerenciar pontos
            </strong>

            <span>
                Consultar todos os pontos
                e controlar sua disponibilidade.
            </span>

        </a>

    </div>



    <section class="admin-section">

        <header class="section-header">

            <h2>
                Empresas
            </h2>

            <p>
                Prévia das empresas cadastradas.
            </p>

        </header>


        <?php if (empty($companies)): ?>

            <p>
                Nenhuma empresa cadastrada.
            </p>

        <?php else: ?>

            <div class="admin-list">

                <?php foreach (
                    $companies
                    as $company
                ): ?>

                    <article class="admin-list-card">

                        <div>

                            <h3>

                                <?= htmlspecialchars(
                                    $company['name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h3>

                            <p>

                                <?= htmlspecialchars(
                                    $company['email'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>

                        </div>


                        <a
                            href="/admin/empresas/<?= (int) $company['id'] ?>"
                        >
                            Ver detalhes
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <p>

            <a
                class="button-primary"
                href="/admin/empresas"
            >
                Ver todas as empresas
            </a>

        </p>

    </section>



    <section class="admin-section">

        <header class="section-header">

            <h2>
                Pontos de coleta
            </h2>

            <p>
                Prévia dos pontos cadastrados.
            </p>

        </header>


        <?php if (empty($points)): ?>

            <p>
                Nenhum ponto cadastrado.
            </p>

        <?php else: ?>

            <div class="admin-list">

                <?php foreach (
                    $points
                    as $point
                ): ?>

                    <article class="admin-list-card">

                        <div>

                            <h3>

                                <?= htmlspecialchars(
                                    $point['name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h3>

                            <p>

                                <?= htmlspecialchars(
                                    $point['company_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>

                        </div>


                        <a
                            href="/admin/pontos/<?= (int) $point['id'] ?>"
                        >
                            Ver detalhes
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>


        <p>

            <a
                class="button-primary"
                href="/admin/pontos"
            >
                Ver todos os pontos
            </a>

        </p>

    </section>

</main>



<footer class="site-footer">

    <p>
        Recycle Here
    </p>

    <nav aria-label="Navegação do rodapé">

        <ul class="footer-nav">

            <li>
                <a href="/">
                    Início
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