<?php

$isActive =
    (int) $company['active'] === 1
    &&
    (int) $company['user_active'] === 1;

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
        <?= htmlspecialchars(
            $company['name'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
        | Administração
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
                <a href="/admin/pontos">
                    Pontos
                </a>
            </li>

        </ul>

    </nav>

</header>



<main class="admin-page">

    <a
        class="back-link"
        href="/admin/empresas"
    >
        Voltar para empresas
    </a>


    <section class="admin-detail">

        <header class="admin-detail-header">

            <div>

                <p class="admin-eyebrow">
                    Empresa
                </p>


                <h1>

                    <?= htmlspecialchars(
                        $company['name'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </h1>

            </div>


            <?php if ($isActive): ?>

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



        <dl class="admin-detail-list">

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
                    Telefone
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $company['phone']
                        ?: 'Não informado',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>


            <div>

                <dt>
                    Pontos cadastrados
                </dt>

                <dd>
                    <?= (int)
                        $company['point_count']
                    ?>
                </dd>

            </div>


            <div>

                <dt>
                    Pontos ativos
                </dt>

                <dd>
                    <?= (int)
                        $company[
                            'active_point_count'
                        ]
                    ?>
                </dd>

            </div>

        </dl>



        <div class="admin-status-action">

            <form
                action="/admin/empresas/<?= (int) $company['id'] ?>/status"
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


                <input
                    type="hidden"
                    name="active"
                    value="<?= $isActive
                        ? '0'
                        : '1'
                    ?>"
                >


                <?php if ($isActive): ?>

                    <button
                        class="button-danger"
                        type="submit"
                    >
                        Desativar empresa
                    </button>

                <?php else: ?>

                    <button
                        class="button-primary"
                        type="submit"
                    >
                        Ativar empresa
                    </button>

                <?php endif; ?>

            </form>

        </div>


        <?php if (!$isActive): ?>

            <p class="admin-warning">

                Ao reativar uma empresa,
                os pontos que foram desativados
                não são reativados automaticamente.
                Eles podem ser liberados individualmente
                pelo administrador.

            </p>

        <?php endif; ?>


    </section>



    <section class="admin-section">

        <header class="section-header">

            <h2>
                Pontos da empresa
            </h2>

        </header>


        <?php if (empty($points)): ?>

            <p>
                Esta empresa ainda não possui pontos.
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

                            </p>

                        </div>


                        <a
                            href="/admin/pontos/<?= (int) $point['id'] ?>"
                        >
                            Ver ponto
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

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