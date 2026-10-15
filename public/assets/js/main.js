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
