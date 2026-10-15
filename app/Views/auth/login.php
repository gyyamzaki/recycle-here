<?php

$errors = $errors ?? [];
$old = $old ?? $_POST;

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
        content="Área de acesso de empresas e cooperativas no Recycle Here."
    >

    <title>Área da empresa | Recycle Here</title>

    <link rel="stylesheet" href="/assets/css/style.css">
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
            aria-label="Navegação principal"
        >

            <ul class="nav-list">

                <li>
                    <a href="/">
                        Início
                    </a>
                </li>

                <li>
                    <a href="/#materiais">
                        Materiais
                    </a>
                </li>

                <li>
                    <a href="/pontos">
                        Pontos de coleta
                    </a>
                </li>

                <li>
                    <a href="/#empresas" aria-current="page">
                        Para empresas
                    </a>
                </li>

            </ul>

        </nav>

    </header>


    <main class="form-page">

        <a class="back-link" href="/">
            Voltar para a página inicial
        </a>

        <header class="form-page-header">
            <h1>Área da empresa</h1>

            <p>
                Acesse sua conta para gerenciar os dados da empresa
                e seus pontos de coleta.
            </p>
        </header>


        <section
            class="form-section"
            aria-labelledby="company-login-title"
        >

            <h2 id="company-login-title">
                Entrar
            </h2>

            <?php if (!empty($errors)): ?>

                <div
                    class="form-errors"
                    role="alert"
                    aria-live="polite"
                >

                    <?php foreach ($errors as $error): ?>

                        <p>
                            <?= htmlspecialchars(
                                (string) $error,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

            <form class="company-form" action="/login" method="post">

                <input
                    type="hidden"
                    name="_csrf"
                    value="<?= htmlspecialchars(
                        App\Core\Csrf::token(),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >

                <div class="form-group">
                    <label for="login-email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="login-email"
                        name="email"
                        autocomplete="email"
                        placeholder="empresa@exemplo.com"
                        value="<?= htmlspecialchars(
                            (string) ($old['email'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >
                </div>


                <div class="form-group">
                    <label for="login-password">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="login-password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >
                </div>


                <div class="form-actions">

                    <button
                        class="button-primary"
                        type="submit"
                    >
                        Entrar
                    </button>

                    <p class="form-login-link">
                        Ainda não possui cadastro?

                        <a href="/cadastro">
                            Cadastre sua empresa
                        </a>
                    </p>

                </div>

            </form>

        </section>

    </main>


    <footer class="site-footer">

        <p>Recycle Here</p>

        <nav aria-label="Navegação do rodapé">

            <ul class="footer-nav">

                <li>
                    <a href="/">
                        Início
                    </a>
                </li>

                <li>
                    <a href="/pontos">
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

            </ul>

        </nav>

        <p>Projeto acadêmico - 2026</p>

    </footer>


    <script src="/assets/js/main.js"></script>
</body>

</html>