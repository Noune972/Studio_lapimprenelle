import './stimulus_bootstrap.js';
import './styles/app.css';


/* =========================================================
   MENU MOBILE
========================================================= */

function initMobileMenu() {

    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIconOpen = document.getElementById('menu-icon-open');
    const menuIconClose = document.getElementById('menu-icon-close');

    if (!menuToggle || !mobileMenu) {
        return;
    }

    /*
     * Évite d'ajouter plusieurs fois le même listener
     * lorsque Turbo recharge une page.
     */
    if (menuToggle.dataset.menuInitialized === 'true') {
        return;
    }

    menuToggle.dataset.menuInitialized = 'true';


    menuToggle.addEventListener('click', () => {

        const isCurrentlyOpen =
            !mobileMenu.classList.contains('hidden');

        mobileMenu.classList.toggle('hidden');


        if (menuIconOpen) {
            menuIconOpen.classList.toggle('hidden');
        }

        if (menuIconClose) {
            menuIconClose.classList.toggle('hidden');
        }


        menuToggle.setAttribute(
            'aria-expanded',
            String(!isCurrentlyOpen)
        );

        menuToggle.setAttribute(
            'aria-label',
            isCurrentlyOpen
                ? 'Ouvrir le menu'
                : 'Fermer le menu'
        );

    });

}



/* =========================================================
   ANIMATIONS REVEAL
========================================================= */

function initReveal() {

    const revealItems =
        document.querySelectorAll('.reveal:not(.is-visible)');

    if (
        !('IntersectionObserver' in window) ||
        revealItems.length === 0
    ) {
        return;
    }


    const revealObserver = new IntersectionObserver(
        (entries) => {

            entries.forEach((entry) => {

                if (entry.isIntersecting) {

                    entry.target.classList.add('is-visible');

                    revealObserver.unobserve(entry.target);

                }

            });

        },
        {
            threshold: 0.15
        }
    );


    revealItems.forEach((item) => {

        revealObserver.observe(item);

    });

}



/* =========================================================
   INITIALISATION
========================================================= */

function initApp() {

    initMobileMenu();
    initReveal();

}


/*
 * Chargement classique
 */
document.addEventListener(
    'DOMContentLoaded',
    initApp
);


/*
 * Navigation Symfony UX Turbo
 */
document.addEventListener(
    'turbo:load',
    initApp
);