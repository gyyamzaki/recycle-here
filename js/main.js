const menuButton = document.querySelector(".menu-button");
const siteNav = document.querySelector(".site-nav");


if (menuButton && siteNav) {

    menuButton.addEventListener("click", function () {

        const menuIsOpen =
            siteNav.classList.toggle("is-open");

        menuButton.setAttribute(
            "aria-expanded",
            menuIsOpen
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



/* Página de resultados */

const pointsPage =
    document.querySelector(".points-page");


if (pointsPage) {

    // Lê os parâmetros enviados pela URL
    const params =
        new URLSearchParams(window.location.search);

    const bairro =
        params.get("bairro");

    const material =
        params.get("material");


    // Elementos da página
    const bairroInput =
        document.querySelector("#bairro");

    const materialSelect =
        document.querySelector("#material");

    const resultsDescription =
        document.querySelector("#results-description");

    const pointCards =
        document.querySelectorAll(".collection-point-card");


    // Preenche novamente o campo de bairro
    if (bairro && bairroInput) {
        bairroInput.value = bairro;
    }


    // Preenche novamente o select de material
    if (material && materialSelect) {
        materialSelect.value = material;
    }


    // Cria a descrição da pesquisa
    let description = "Pontos disponíveis";


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


    // Conta quantos pontos continuam visíveis
    let visiblePoints = 0;


    // Percorre cada card
    pointCards.forEach(function (card) {

        const cardBairro =
            card.dataset.bairro || "";

        const cardMaterials =
            (card.dataset.materials || "").split(" ");


        const matchesBairro =
            !bairro ||
            cardBairro.includes(
                bairro.toLowerCase()
            );


        const matchesMaterial =
            !material ||
            cardMaterials.includes(material);


        const shouldShow =
            matchesBairro && matchesMaterial;


        card.hidden = !shouldShow;


        if (shouldShow) {
            visiblePoints++;
        }

    });


    // Atualiza o texto dos resultados
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
