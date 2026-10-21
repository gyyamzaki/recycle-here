<?php

$isActive =
    (int) $point['active']
    ===
    1;

$companyActive =
    (int) $point['company_active']
    ===
    1;

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
            $point['name'],
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
        href="/admin/pontos"
    >
        Voltar para pontos
    </a>


    <section class="admin-detail">

        <header class="admin-detail-header">

            <div>

                <p class="admin-eyebrow">
                    Ponto de coleta
                </p>


                <h1>

                    <?= htmlspecialchars(
                        $point['name'],
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



        <dl class="admin-detail-list">

            <div>

                <dt>
                    Empresa responsável
                </dt>

                <dd>

                    <a
                        href="/admin/empresas/<?= (int) $point['company_id'] ?>"
                    >

                        <?= htmlspecialchars(
                            $point['company_name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </a>

                </dd>

            </div>


            <div>

                <dt>
                    Endereço
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $point['street'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>,

                    <?= htmlspecialchars(
                        $point['number'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>


            <div>

                <dt>
                    Bairro
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $point['neighborhood'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>


            <div>

                <dt>
                    Cidade
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $point['city'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                    -

                    <?= htmlspecialchars(
                        $point['state'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>


            <div>

                <dt>
                    Materiais
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $point['materials']
                        ?: 'Nenhum material informado',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>


            <div>

                <dt>
                    Horário
                </dt>

                <dd>

                    <?= htmlspecialchars(
                        $point['opening_hours'],
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
                        $point['phone']
                        ?: 'Não informado',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </dd>

            </div>

        </dl>



        <?php if (
            !$companyActive
            &&
            !$isActive
        ): ?>

            <p class="admin-warning">

                A empresa responsável está inativa.
                Reative a empresa antes de tentar
                ativar este ponto.

            </p>

        <?php endif; ?>



        <form
            class="admin-status-action"
            action="/admin/pontos/<?= (int) $point['id'] ?>/status"
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
                    Desativar ponto
                </button>

            <?php else: ?>

                <button
                    class="button-primary"
                    type="submit"
                    <?= !$companyActive
                        ? 'disabled'
                        : ''
                    ?>
                >
                    Ativar ponto
                </button>

            <?php endif; ?>

        </form>


        <p>

            <a
                href="/pontos/<?= (int) $point['id'] ?>"
            >
                Abrir página pública
            </a>

        </p>

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
