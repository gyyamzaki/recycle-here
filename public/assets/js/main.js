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

/* ============================================================
   Confirmação de exclusão de ponto
   ============================================================ */

const deleteModal =
    document.querySelector(
        '#delete-point-modal'
    );


if (deleteModal) {

    const deleteForms =
        document.querySelectorAll(
            '.delete-point-form'
        );


    const pointNameElement =
        document.querySelector(
            '#delete-point-name'
        );


    const cancelDeleteButton =
        document.querySelector(
            '#cancel-delete-button'
        );


    const confirmDeleteButton =
        document.querySelector(
            '#confirm-delete-button'
        );


    let pendingDeleteForm = null;


    deleteForms.forEach((form) => {

        form.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();


                pendingDeleteForm =
                    form;


                const pointName =
                    form.dataset.pointName
                    ?? 'este ponto de coleta';


                pointNameElement.textContent =
                    pointName;


                deleteModal.showModal();
            }
        );

    });


    cancelDeleteButton.addEventListener(
        'click',
        () => {

            pendingDeleteForm = null;

            deleteModal.close();
        }
    );


    confirmDeleteButton.addEventListener(
        'click',
        () => {

            if (!pendingDeleteForm) {
                return;
            }


            /*
             * requestSubmit() dispararia novamente
             * o evento submit e abriria o modal.
             *
             * submit() envia o formulário diretamente.
             */
            pendingDeleteForm.submit();
        }
    );


    /*
     * Se o usuário fechar com ESC,
     * abandonamos a exclusão.
     */
    deleteModal.addEventListener(
        'close',
        () => {

            pendingDeleteForm = null;
        }
    );


    /*
     * Clique fora da caixa fecha o modal.
     */
    deleteModal.addEventListener(
        'click',
        (event) => {

            if (event.target === deleteModal) {

                pendingDeleteForm = null;

                deleteModal.close();
            }
        }
    );
}