<?php

$filters = $filters ?? ['bairro' => '', 'material' => ''];
$errors = $errors ?? [];
$materials = $materials ?? [];
$points = $points ?? [];

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Encontre pontos de coleta e reciclagem em Sorocaba.">

    <title>Pontos de coleta | Recycle Here</title>

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

    <main class="points-page">

        <a class="back-link" href="/">
            Voltar para a página inicial
        </a>

        <header class="points-page-header">
            <h1>Pontos de coleta</h1>

            <p>
                Encontre locais adequados para descartar
                seus materiais em Sorocaba.
            </p>
        </header>

        <section
            class="points-search"
            aria-labelledby="points-search-title"
        >
            <h2 id="points-search-title">
                Pesquisar pontos
            </h2>

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
                        value="<?= htmlspecialchars(
                            $filters['bairro'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
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

                                <?php if (
                                    ($filters['material'] ?? '') ===
                                    $material->slug
                                ): ?>

                                    selected

                                <?php endif; ?>
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
                    Buscar
                </button>
            </form>

            <?php if (!empty($errors)): ?>

                <div
                    class="form-errors"
                    role="alert"
                >

                    <?php foreach ($errors as $error): ?>

                        <p>
                            <?= htmlspecialchars(
                                $error,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>
        </section>

        <section
            class="search-results"
            aria-labelledby="results-title"
        >
            <header class="section-header">
                <h2 id="results-title">
                    Resultados encontrados
                </h2>

                <p id="results-description">

                    <?php if (!empty($errors)): ?>

                        Corrija os filtros informados.

                    <?php elseif (count($points) === 0): ?>

                        Nenhum ponto foi encontrado
                        para os critérios informados.

                    <?php elseif (count($points) === 1): ?>

                        1 ponto encontrado.

                    <?php else: ?>

                        <?= count($points) ?>
                        pontos encontrados.

                    <?php endif; ?>

                </p>
            </header>

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


                        <a
                            href="/pontos/<?= (int) $point->id ?>"
                        >
                            Ver detalhes
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>
        </section>

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
