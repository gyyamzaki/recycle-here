<?php

$materials =
    $materials ?? [];

$featuredPoints =
    $featuredPoints ?? [];

$isCompanyLogged =
    $isCompanyLogged ?? false;

$isAdminLogged =
    $isAdminLogged ?? false;

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
        content="Recycle Here - Encontre pontos de coleta e reciclagem em Sorocaba."
    >

    <title>
        Recycle Here
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
                    <a
                        href="/"
                        aria-current="page"
                    >
                        Início
                    </a>
                </li>


                <li>
                    <a href="/#materiais">
                        Materiais
                    </a>
                </li>


                <li>
                    <a href="/#pontos">
                        Pontos de coleta
                    </a>
                </li>


                <li>
                    <a href="/#empresas">
                        Para empresas
                    </a>
                </li>


                <?php if ($isCompanyLogged): ?>

                    <li>
                        <a href="/empresa/pontos">
                            Meus pontos
                        </a>
                    </li>

                <?php elseif ($isAdminLogged): ?>

                    <li>
                        <a href="/admin">
                            Administração
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </nav>

    </header>



    <main id="inicio">


        <!-- HERO / PESQUISA -->

        <section
            class="hero"
            aria-labelledby="hero-title"
        >

            <h1 id="hero-title">
                Encontre onde reciclar em Sorocaba
            </h1>


            <p>
                Descubra pontos de coleta de acordo com sua região
                e com o material que deseja descartar.
            </p>


            <form
                class="search-form"
                action="/pontos"
                method="get"
            >

                <div class="form-group">

                    <label for="bairro">
                        Bairro ou região
                    </label>

                    <input
                        type="text"
                        id="bairro"
                        name="bairro"
                        placeholder="Ex.: Centro"
                        maxlength="100"
                    >

                </div>


                <div class="form-group">

                    <label for="material">
                        Material
                    </label>


                    <select
                        id="material"
                        name="material"
                    >

                        <option value="">
                            Todos os materiais
                        </option>


                        <?php foreach ($materials as $material): ?>

                            <option
                                value="<?= htmlspecialchars(
                                    $material->slug,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                            >

                                <?= htmlspecialchars(
                                    $material->name,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <button type="submit">
                    Buscar pontos
                </button>

            </form>

        </section>



        <!-- MATERIAIS -->

        <section
            class="materials-section"
            id="materiais"
            aria-labelledby="materials-title"
        >

            <header class="section-header">

                <h2 id="materials-title">
                    Materiais
                </h2>

                <p>
                    Consulte alguns dos principais tipos de materiais
                    e encontre locais adequados para o descarte.
                </p>

            </header>


            <figure class="materials-figure">

                <img
                    src="/assets/images/materiais-reciclaveis.png"
                    alt="Materiais recicláveis separados para descarte, como papel, plástico, vidro e metal"
                    width="1200"
                    height="675"
                    loading="lazy"
                >

                <figcaption>
                    A separação dos materiais facilita
                    o encaminhamento correto para reciclagem.
                </figcaption>

            </figure>



            <div class="materials-grid">

                <article
                    class="material-card material-paper"
                >

                    <h3>
                        Papel
                    </h3>

                    <p>
                        Papelão, folhas, jornais e outros
                        materiais de papel.
                    </p>

                </article>



                <article
                    class="material-card material-plastic"
                >

                    <h3>
                        Plástico
                    </h3>

                    <p>
                        Garrafas PET, embalagens,
                        frascos e outros plásticos.
                    </p>

                </article>



                <article
                    class="material-card material-glass"
                >

                    <h3>
                        Vidro
                    </h3>

                    <p>
                        Garrafas, potes e outros
                        recipientes de vidro reciclável.
                    </p>

                </article>



                <article
                    class="material-card material-metal"
                >

                    <h3>
                        Metal
                    </h3>

                    <p>
                        Latas, peças metálicas e
                        outros materiais de metal.
                    </p>

                </article>



                <article
                    class="material-card material-electronics"
                >

                    <h3>
                        Eletrônicos
                    </h3>

                    <p>
                        Celulares, computadores, cabos
                        e equipamentos eletrônicos.
                    </p>

                </article>



                <article
                    class="material-card material-batteries"
                >

                    <h3>
                        Pilhas e baterias
                    </h3>

                    <p>
                        Pilhas domésticas e diferentes
                        tipos de baterias usadas.
                    </p>

                </article>



                <article
                    class="material-card material-oil"
                >

                    <h3>
                        Óleo usado
                    </h3>

                    <p>
                        Óleo de cozinha usado que necessita
                        de descarte adequado.
                    </p>

                </article>

            </div>



            <aside
                class="recycling-tip"
                aria-labelledby="recycling-tip-title"
            >

                <h3 id="recycling-tip-title">
                    Antes de descartar
                </h3>

                <p>
                    Sempre que possível, mantenha os
                    materiais recicláveis limpos, secos
                    e separados antes de levá-los ao
                    ponto de coleta.
                </p>

            </aside>

        </section>



        <!-- PONTOS DE COLETA -->

        <section
            class="collection-point-section"
            id="pontos"
            aria-labelledby="collection-points-title"
        >

            <header class="section-header">

                <h2 id="collection-points-title">
                    Pontos de coleta
                </h2>

                <p>
                    Conheça alguns locais que recebem
                    materiais para reciclagem em Sorocaba.
                </p>

            </header>



            <div class="collection-points-grid">


                <?php if (empty($featuredPoints)): ?>


                    <p>
                        Nenhum ponto de coleta
                        está disponível no momento.
                    </p>


                <?php else: ?>


                    <?php foreach ($featuredPoints as $point): ?>


                        <article
                            class="collection-point-card"
                        >

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

                                <?= htmlspecialchars(
                                    implode(
                                        ', ',
                                        $point->materials
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>


                            <a
                                href="/pontos/<?= (int) $point->id ?>"
                            >
                                Ver detalhes
                            </a>

                        </article>


                    <?php endforeach; ?>


                <?php endif; ?>


            </div>


            <p>

                <a
                    class="button-primary"
                    href="/pontos"
                >
                    Ver todos os pontos
                </a>

            </p>

        </section>



        <!-- ÁREA DAS EMPRESAS -->

        <section
            class="companies-section"
            id="empresas"
            aria-labelledby="companies-title"
        >

            <header class="section-header">

                <h2 id="companies-title">
                    Você representa uma empresa
                    ou cooperativa?
                </h2>


                <?php if ($isCompanyLogged): ?>

                    <p>
                        Acesse sua área para cadastrar
                        e gerenciar seus pontos de coleta.
                    </p>


                <?php elseif ($isAdminLogged): ?>

                    <p>
                        Você está autenticado como
                        administrador do Recycle Here.
                    </p>


                <?php else: ?>

                    <p>
                        Cadastre sua empresa e informe
                        quais materiais seus pontos
                        de coleta recebem.
                    </p>

                <?php endif; ?>

            </header>



            <div class="companies-actions">


                <?php if ($isCompanyLogged): ?>


                    <a
                        class="button-primary-light"
                        href="/empresa/pontos"
                    >
                        Meus pontos
                    </a>


                <?php elseif ($isAdminLogged): ?>


                    <a
                        class="button-primary-light"
                        href="/admin"
                    >
                        Área administrativa
                    </a>


                <?php else: ?>


                    <a
                        class="button-primary-light"
                        href="/cadastro"
                    >
                        Cadastrar empresa
                    </a>


                    <a
                        class="button-secondary-light"
                        href="/login"
                    >
                        Área da empresa
                    </a>


                <?php endif; ?>


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
                    <a href="/#pontos">
                        Pontos de coleta
                    </a>
                </li>


                <li>
                    <a href="/#materiais">
                        Materiais
                    </a>
                </li>


                <li>
                    <a href="/#empresas">
                        Para empresas
                    </a>
                </li>


                <?php if ($isCompanyLogged): ?>

                    <li>
                        <a href="/empresa/pontos">
                            Meus pontos
                        </a>
                    </li>


                <?php elseif ($isAdminLogged): ?>

                    <li>
                        <a href="/admin">
                            Administração
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </nav>


        <p>
            Projeto acadêmico - 2026
        </p>

    </footer>



    <script src="/assets/js/main.js"></script>

</body>

</html>