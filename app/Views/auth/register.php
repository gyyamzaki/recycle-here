<?php

$errors = $errors ?? [];
$old = $old ?? $_POST;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Cadastro de empresas e cooperativas no Recycle Here.">

    <title>Cadastro de empresa | Recycle Here</title>

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
                <li><a href="/">Início</a></li>
                <li><a href="/#materiais">Materiais</a></li>
                <li><a href="/pontos">Pontos de coleta</a></li>
                <li><a href="/#empresas" aria-current="page">Para empresas</a></li>

            </ul>

        </nav>

    </header>


    <main class="form-page">

        <a class="back-link" href="/">
            Voltar para a página inicial
        </a>

        <header class="form-page-header">
            <h1>Cadastro de empresa</h1>

            <p>
                Cadastre sua empresa ou cooperativa para gerenciar
                informações e pontos de coleta no Recycle Here.
            </p>
        </header>


        <section
            class="form-section"
            aria-labelledby="company-register-title"
        >

            <h2 id="company-register-title">
                Dados da empresa
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

            <form class="company-form" action="/cadastro" method="post">

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
                    <label for="company-name">
                        Nome da empresa ou cooperativa
                    </label>

                    <input
                        type="text"
                        id="company-name"
                        name="company_name"
                        autocomplete="organization"
                        maxlength="150"
                        value="<?= htmlspecialchars(
                            (string) ($old['company_name'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >
                </div>


                <div class="form-group">
                    <label for="company-cnpj">
                        CNPJ
                    </label>

                    <input
                        type="text"
                        id="company-cnpj"
                        name="cnpj"
                        inputmode="numeric"
                        placeholder="00.000.000/0000-00"
                        maxlength="18"
                        value="<?= htmlspecialchars(
                            (string) ($old['cnpj'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >
                </div>


                <div class="form-group">
                    <label for="company-email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="company-email"
                        name="email"
                        autocomplete="email"
                        placeholder="empresa@exemplo.com"
                        maxlength="180"
                        value="<?= htmlspecialchars(
                            (string) ($old['email'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >
                </div>


                <div class="form-group">
                    <label for="company-phone">
                        Telefone
                    </label>

                    <input
                        type="tel"
                        id="company-phone"
                        name="phone"
                        autocomplete="tel"
                        placeholder="(15) 00000-0000"
                        maxlength="15"
                        value="<?= htmlspecialchars(
                            (string) ($old['phone'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >
                </div>


                <div class="form-group">
                    <label for="company-password">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="company-password"
                        name="password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <small class="form-help">
                        Utilize pelo menos 8 caracteres.
                    </small>
                </div>


                <div class="form-group">
                    <label for="company-password-confirm">
                        Confirmar senha
                    </label>

                    <input
                        type="password"
                        id="company-password-confirm"
                        name="password_confirmation"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>


                <div class="form-actions">

                    <button
                        class="button-primary"
                        type="submit"
                    >
                        Cadastrar empresa
                    </button>

                    <p class="form-login-link">
                        Já possui cadastro?
                        <a href="/login">
                            Acesse a área da empresa
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