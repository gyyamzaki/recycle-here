/* =========================================================
   MENU RESPONSIVO
   ========================================================= */

const menuButton = document.querySelector(".menu-button");
const siteNav = document.querySelector(".site-nav");


if (menuButton && siteNav) {

    menuButton.addEventListener("click", function () {

        const menuIsOpen =
            siteNav.classList.toggle("is-open");


        menuButton.setAttribute(
            "aria-expanded",
            String(menuIsOpen)
        );

    });


    const navLinks =
        siteNav.querySelectorAll(".nav-list a");


    navLinks.forEach(function (link) {

        link.addEventListener("click", function () {

            siteNav.classList.remove("is-open");


            menuButton.setAttribute(
                "aria-expanded",
                "false"
            );

        });

    });

}



/* =========================================================
   FILTRO DA PÁGINA DE PONTOS
   ========================================================= */

const pointsPage =
    document.querySelector(".points-page");


if (pointsPage) {

    /*
     * Os filtros continuam sendo recebidos pela URL.
     *
     * Exemplo:
     *
     * /pontos?bairro=Centro&material=papel
     */

    const params =
        new URLSearchParams(window.location.search);


    const bairro =
        (params.get("bairro") || "").trim();


    const material =
        (params.get("material") || "").trim();


    const bairroInput =
        document.querySelector("#bairro");


    const materialSelect =
        document.querySelector("#material");


    const resultsDescription =
        document.querySelector("#results-description");


    const pointCards =
        document.querySelectorAll(".collection-point-card");


    /*
     * Mantém os valores pesquisados dentro do formulário.
     */

    if (bairroInput) {
        bairroInput.value = bairro;
    }


    if (materialSelect) {
        materialSelect.value = material;
    }



    /*
     * Monta a descrição apresentada ao usuário.
     */

    let description =
        "Pontos disponíveis";


    if (
        material &&
        materialSelect &&
        materialSelect.value === material
    ) {

        const selectedOption =
            materialSelect.options[
                materialSelect.selectedIndex
            ];


        description +=
            ` que recebem ${selectedOption.text}`;

    }


    if (bairro) {

        description +=
            ` na região de ${bairro}`;

    }



    /*
     * Verifica quais cards correspondem à pesquisa.
     */

    let visiblePoints = 0;


    pointCards.forEach(function (card) {

        const cardBairro =
            (card.dataset.bairro || "")
                .toLowerCase();


        const cardMaterials =
            (card.dataset.materials || "")
                .split(" ");


        const matchesBairro =
            !bairro ||
            cardBairro.includes(
                bairro.toLowerCase()
            );


        const matchesMaterial =
            !material ||
            cardMaterials.includes(material);


        const shouldShow =
            matchesBairro &&
            matchesMaterial;


        card.hidden =
            !shouldShow;


        if (shouldShow) {
            visiblePoints++;
        }

    });



    /*
     * Informa quantos resultados foram encontrados.
     */

    if (resultsDescription) {

        if (visiblePoints === 0) {

            resultsDescription.textContent =
                "Nenhum ponto foi encontrado para os critérios informados.";

        } else {

            const pointText =
                visiblePoints === 1
                    ? "ponto encontrado"
                    : "pontos encontrados";


            resultsDescription.textContent =
                `${description}. ${visiblePoints} ${pointText}.`;

        }

    }

}