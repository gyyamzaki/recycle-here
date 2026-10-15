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
                        <option value="">Todos os materiais</option>
                        <option value="papel">Papel</option>
                        <option value="plastico">Plástico</option>
                        <option value="vidro">Vidro</option>
                        <option value="metal">Metal</option>
                        <option value="eletronicos">Eletrônicos</option>
                        <option value="pilhas-baterias">Pilhas e baterias</option>
                        <option value="oleo-usado">Óleo usado</option>
                    </select>
                </div>

                <button type="submit">
                    Buscar
                </button>
            </form>
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
                    Pontos disponíveis para sua pesquisa.
                </p>
            </header>

            <div class="collection-points-grid">

                <?php foreach ($points as $point): ?>

                    <article
                        class="collection-point-card"

                        data-bairro="<?= htmlspecialchars(
                            mb_strtolower($point->neighborhood),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"

                        data-materials="<?= htmlspecialchars(
                            implode(' ', $point->materialSlugs),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
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
                            href="/pontos/<?= $point->id ?>"
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
