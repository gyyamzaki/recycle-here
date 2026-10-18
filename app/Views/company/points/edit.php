<?php

$errors = $errors ?? [];
$old = $old ?? [];
$materials = $materials ?? [];

$selectedMaterials =
    $old['materials'] ?? [];

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
        content="Edição de ponto de coleta no Recycle Here."
    >

    <title>
        Editar ponto | Recycle Here
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
            aria-label="Navegação da área da empresa"
        >

            <ul class="nav-list">

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
                    <a
                        href="/empresa/pontos"
                        aria-current="page"
                    >
                        Meus pontos
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



    <main class="form-page">

        <a
            class="back-link"
            href="/empresa/pontos"
        >
            Voltar para meus pontos
        </a>


        <section
            class="form-section"
            aria-labelledby="edit-point-title"
        >

            <header class="section-header">

                <h1 id="edit-point-title">
                    Editar ponto de coleta
                </h1>

                <p>
                    Atualize os dados do local
                    e os materiais recebidos.
                </p>

            </header>



            <?php if (!empty($errors)): ?>

                <div
                    class="form-errors"
                    role="alert"
                    aria-live="polite"
                >

                    <strong>
                        Não foi possível atualizar o ponto.
                    </strong>

                    <ul>

                        <?php foreach ($errors as $error): ?>

                            <li>
                                <?= htmlspecialchars(
                                    $error,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </li>

                        <?php endforeach; ?>

                    </ul>

                </div>

            <?php endif; ?>



            <form
                action="/empresa/pontos/<?= (int) $pointId ?>/editar"
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


                <div class="form-group">

                    <label for="name">
                        Nome do ponto
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        maxlength="150"
                        value="<?= htmlspecialchars(
                            (string) ($old['name'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="street">
                        Rua
                    </label>

                    <input
                        type="text"
                        id="street"
                        name="street"
                        maxlength="180"
                        value="<?= htmlspecialchars(
                            (string) ($old['street'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="number">
                        Número
                    </label>

                    <input
                        type="text"
                        id="number"
                        name="number"
                        maxlength="20"
                        value="<?= htmlspecialchars(
                            (string) ($old['number'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="complement">
                        Complemento
                    </label>

                    <input
                        type="text"
                        id="complement"
                        name="complement"
                        maxlength="100"
                        value="<?= htmlspecialchars(
                            (string) ($old['complement'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="neighborhood">
                        Bairro
                    </label>

                    <input
                        type="text"
                        id="neighborhood"
                        name="neighborhood"
                        maxlength="100"
                        value="<?= htmlspecialchars(
                            (string) ($old['neighborhood'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="city">
                        Cidade
                    </label>

                    <input
                        type="text"
                        id="city"
                        name="city"
                        maxlength="100"
                        value="<?= htmlspecialchars(
                            (string) ($old['city'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="state">
                        Estado
                    </label>

                    <input
                        type="text"
                        id="state"
                        name="state"
                        maxlength="2"
                        value="<?= htmlspecialchars(
                            (string) ($old['state'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="zip_code">
                        CEP
                    </label>

                    <input
                        type="text"
                        id="zip_code"
                        name="zip_code"
                        inputmode="numeric"
                        maxlength="9"
                        value="<?= htmlspecialchars(
                            (string) ($old['zip_code'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="phone">
                        Telefone
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        maxlength="15"
                        value="<?= htmlspecialchars(
                            (string) ($old['phone'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>


                <div class="form-group">

                    <label for="opening_hours">
                        Horário de atendimento
                    </label>

                    <input
                        type="text"
                        id="opening_hours"
                        name="opening_hours"
                        maxlength="255"
                        value="<?= htmlspecialchars(
                            (string) ($old['opening_hours'] ?? ''),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        required
                    >

                </div>



                <fieldset class="materials-fieldset">

                    <legend>
                        Materiais aceitos
                    </legend>

                    <p>
                        Selecione todos os materiais
                        recebidos neste ponto.
                    </p>


                    <div class="checkbox-grid">

                        <?php foreach ($materials as $material): ?>

                            <label class="checkbox-option">

                                <input
                                    type="checkbox"
                                    name="materials[]"
                                    value="<?= (int) $material->id ?>"
                                    <?= in_array(
                                        (int) $material->id,
                                        $selectedMaterials,
                                        true
                                    )
                                        ? 'checked'
                                        : ''
                                    ?>
                                >

                                <span>
                                    <?= htmlspecialchars(
                                        $material->name,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                            </label>

                        <?php endforeach; ?>

                    </div>

                </fieldset>



                <div class="form-actions">

                    <button
                        class="button-primary"
                        type="submit"
                    >
                        Salvar alterações
                    </button>


                    <a
                        class="back-link"
                        href="/empresa/pontos"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

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
                    <a href="/pontos">
                        Pontos de coleta
                    </a>
                </li>

                <li>
                    <a href="/empresa/pontos">
                        Meus pontos
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