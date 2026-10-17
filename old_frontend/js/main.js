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

/* Página de detalhes do ponto */

const pointDetailsPage =
    document.querySelector(".point-details");


if (pointDetailsPage) {

    const params =
        new URLSearchParams(window.location.search);

    const pointId =
        params.get("id");


    const points = {

        "1": {
            name: "Cooperativa Recicla Sorocaba",
            region: "Centro - Sorocaba",
            street: "Rua Exemplo, 150",
            city: "Centro - Sorocaba, SP",

            materials: [
                "Papel",
                "Plástico",
                "Vidro"
            ],

            hours:
                "Segunda a sexta-feira, das 8h às 17h.",

            phone:
                "(15) 0000-0000",

            phoneLink:
                "+551500000000"
        },


        "2": {
            name: "Ecoponto Campolim",
            region: "Campolim - Sorocaba",
            street: "Avenida Exemplo, 250",
            city: "Campolim - Sorocaba, SP",

            materials: [
                "Eletrônicos",
                "Pilhas e baterias"
            ],

            hours:
                "Segunda a sábado, das 8h às 18h.",

            phone:
                "(15) 0000-0001",

            phoneLink:
                "+551500000001"
        },


        "3": {
            name: "Cooperativa Zona Norte",
            region: "Zona Norte - Sorocaba",
            street: "Rua Exemplo Norte, 300",
            city: "Zona Norte - Sorocaba, SP",

            materials: [
                "Vidro",
                "Metal"
            ],

            hours:
                "Segunda a sexta-feira, das 9h às 17h.",

            phone:
                "(15) 0000-0002",

            phoneLink:
                "+551500000002"
        }

    };


    const point =
        points[pointId];


    if (point) {

        const pointName =
            document.querySelector("#point-name");

        const pointRegion =
            document.querySelector("#point-region");

        const pointAddressStreet =
            document.querySelector("#point-address-street");

        const pointAddressCity =
            document.querySelector("#point-address-city");

        const pointMaterials =
            document.querySelector("#point-materials");

        const pointHours =
            document.querySelector("#point-hours");

        const pointPhone =
            document.querySelector("#point-phone");


        pointName.textContent =
            point.name;

        pointRegion.textContent =
            point.region;

        pointAddressStreet.textContent =
            point.street;

        pointAddressCity.textContent =
            point.city;

        pointHours.textContent =
            point.hours;

        pointPhone.textContent =
            point.phone;

        pointPhone.href =
            `tel:${point.phoneLink}`;


        pointMaterials.replaceChildren();


        point.materials.forEach(function (material) {

            const listItem =
                document.createElement("li");

            listItem.textContent =
                material;

            pointMaterials.appendChild(listItem);

        });


        document.title =
            `${point.name} | Recycle Here`;

    }
    else {

        const pointInformation =
            document.querySelector(".point-information");


        pointInformation.replaceChildren();


        const errorTitle =
            document.createElement("h1");

        errorTitle.textContent =
            "Ponto de coleta não encontrado";


        const errorMessage =
            document.createElement("p");

        errorMessage.textContent =
            "O ponto informado não existe ou não está disponível.";


        pointInformation.append(
            errorTitle,
            errorMessage
        );


        document.title =
            "Ponto não encontrado | Recycle Here";

    }

}