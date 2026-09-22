const menuButton = document.querySelector(".menu-button");
const siteNav = document.querySelector(".site-nav");

menuButton.addEventListener("click", function () {
    const menuIsOpen = siteNav.classList.toggle("is-open");

    menuButton.setAttribute("aria-expanded", menuIsOpen);
});