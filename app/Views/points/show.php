<?php

/** @var App\Models\CollectionPoint $point */

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
        content="Informações sobre ponto de coleta no Recycle Here."
    >

    <title>
        <?= htmlspecialchars(
            $point->name,
            ENT_QUOTES,
            'UTF-8'
        ) ?>
        | Recycle Here
    </title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

    <header class="site-header">
        <a class="logo" href="/">Recycle Here</a>

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
                <li><a href="/">Início</a></li>
                <li><a href="/#materiais">Materiais</a></li>
                <li><a href="/pontos" aria-current="page">Pontos de coleta</a></li>
                <li><a href="/#empresas">Para empresas</a></li>
            </ul>
        </nav>
    </header>


    <main class="point-details">

        <a class="back-link" href="/pontos">
            Voltar aos pontos de coleta
        </a>

        <article class="point-information">

            <header class="point-header">
                <h1 id="point-name">
                    <?= htmlspecialchars(
                        $point->name,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </h1>

                <p id="point-region">

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
            </header>



            <section aria-labelledby="company-title">
                <h2 id="company-title">
                    Responsável pelo ponto
                </h2>

                <p>
                    <?= htmlspecialchars(
                        $point->companyName,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </p>
            </section>


            <section aria-labelledby="address-title">
                <h2 id="address-title">
                    Localização
                </h2>

                <address>

                    <span id="point-address-street">

                        <?= htmlspecialchars(
                            $point->street,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>,

                        <?= htmlspecialchars(
                            $point->number,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                        <?php if ($point->complement): ?>

                            -
                            <?= htmlspecialchars(
                                $point->complement,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        <?php endif; ?>

                    </span>

                    <br>

                    <span id="point-address-city">

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
                        ) ?>,

                        <?= htmlspecialchars(
                            $point->state,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </span>

                    <?php if (!empty($point->zipCode)): ?>

                        <br>

                        <span>
                            CEP:
                            <?= htmlspecialchars(
                                $point->zipCode,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>

                    <?php endif; ?>

                </address>
            </section>


            <section aria-labelledby="materials-accepted-title">
                <h2 id="materials-accepted-title">
                    Materiais aceitos
                </h2>

                <ul id="point-materials">

                    <?php foreach ($point->materials as $material): ?>

                        <li>
                            <?= htmlspecialchars(
                                $material,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>
            </section>


            <section aria-labelledby="opening-hours-title">
                <h2 id="opening-hours-title">
                    Horário de atendimento
                </h2>

                <p id="point-hours">

                    <?= htmlspecialchars(
                        $point->openingHours,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>

                </p>
            </section>


            <section aria-labelledby="contact-title">
                <h2 id="contact-title">
                    Contato
                </h2>

                <?php if ($point->phone): ?>

                <p>

                    Telefone:

                    <a
                        id="point-phone"

                        href="tel:<?= htmlspecialchars(
                            preg_replace(
                                '/\D/',
                                '',
                                $point->phone
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                        <?= htmlspecialchars(
                            $point->phone,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>

                    </a>

                </p>

            <?php else: ?>

                <p>
                    Telefone não informado.
                </p>

            <?php endif; ?>
            </section>

        </article>

    </main>


    <footer class="site-footer">
        <p>Recycle Here</p>

        <nav aria-label="Navegação do rodapé">
            <ul class="footer-nav">
                <li><a href="/">Início</a></li>
                <li><a href="/pontos">Pontos de coleta</a></li>
                <li><a href="/#materiais">Materiais</a></li>
                <li><a href="/#empresas">Para empresas</a></li>
            </ul>
        </nav>

        <p>Projeto acadêmico - 2026</p>
    </footer>


    <script src="/assets/js/main.js"></script>

</body>

</html>