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
     * Évite plusieurs initialisations avec Turbo.
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

    if (revealItems.length === 0) {
        return;
    }


    /*
     * Si IntersectionObserver n'est pas disponible,
     * on affiche directement les éléments.
     */
    if (!('IntersectionObserver' in window)) {

        revealItems.forEach((item) => {
            item.classList.add('is-visible');
        });

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
   SLIDER "MON ACCOMPAGNEMENT"
========================================================= */

function initAboutSlider() {

    const slider = document.getElementById('about-slider');

    /*
     * Le slider n'existe pas sur cette page.
     */
    if (!slider) {
        return;
    }


    /*
     * Évite plusieurs initialisations avec Turbo.
     */
    if (slider.dataset.sliderInitialized === 'true') {
        return;
    }

    slider.dataset.sliderInitialized = 'true';


    /* ---------------------------------------------------------
       ÉLÉMENTS
    --------------------------------------------------------- */

    const slides =
        Array.from(slider.querySelectorAll('.tempo-slide'));

    const dots =
        Array.from(slider.querySelectorAll('[data-slider-dot]'));

    const prevButton =
        slider.querySelector('#about-slider-prev');

    const nextButton =
        slider.querySelector('#about-slider-next');

    const toggleButton =
        slider.querySelector('#about-slider-toggle');

    const counter =
        slider.querySelector('#about-current-slide');

    const toggleIcon =
        slider.querySelector('#about-slider-toggle-icon');

    const toggleText =
        slider.querySelector('#about-slider-toggle-text');


    if (slides.length === 0) {
        return;
    }


    /* ---------------------------------------------------------
       ÉTAT DU SLIDER
    --------------------------------------------------------- */

    let currentSlide = 0;

    let timer = null;

    let isPlaying = true;

    /*
     * Temps entre deux slides :
     * 7000 = 7 secondes
     */
    const autoplayDelay = 7000;



    /* =========================================================
       AFFICHER UNE SLIDE
    ========================================================= */

    function showSlide(index) {

        /*
         * Retour au début après la dernière slide.
         */
        if (index >= slides.length) {
            index = 0;
        }


        /*
         * Retour à la dernière slide lorsqu'on recule
         * depuis la première.
         */
        if (index < 0) {
            index = slides.length - 1;
        }


        currentSlide = index;


        /* -----------------------------------------------------
           AFFICHAGE DES SLIDES
        ----------------------------------------------------- */

        slides.forEach((slide, slideIndex) => {

            if (slideIndex === currentSlide) {

                slide.classList.remove('hidden');


                /*
                 * Animation légère.
                 */
                slide.style.opacity = '0';
                slide.style.transform = 'translateX(18px)';


                requestAnimationFrame(() => {

                    slide.style.transition =
                        'opacity 450ms ease, transform 450ms ease';

                    slide.style.opacity = '1';
                    slide.style.transform = 'translateX(0)';

                });

            } else {

                slide.classList.add('hidden');

                slide.style.opacity = '';
                slide.style.transform = '';

            }

        });



        /* -----------------------------------------------------
           MISE À JOUR DES POINTS
        ----------------------------------------------------- */

        dots.forEach((dot, dotIndex) => {

            if (dotIndex === currentSlide) {

                dot.style.width = '24px';
                dot.style.backgroundColor = '#B85C38';

            } else {

                dot.style.width = '10px';
                dot.style.backgroundColor = '#D9C8A9';

            }

        });



        /* -----------------------------------------------------
           COMPTEUR 01 — 06
        ----------------------------------------------------- */

        if (counter) {

            counter.textContent =
                String(currentSlide + 1).padStart(2, '0');

        }

    }



    /* =========================================================
       SLIDE SUIVANTE
    ========================================================= */

    function nextSlide() {

        showSlide(currentSlide + 1);

    }



    /* =========================================================
       SLIDE PRÉCÉDENTE
    ========================================================= */

    function previousSlide() {

        showSlide(currentSlide - 1);

    }



    /* =========================================================
       ARRÊTER LE TIMER
    ========================================================= */

    function stopAutoplay() {

        if (timer !== null) {

            clearInterval(timer);

            timer = null;

        }

    }



    /* =========================================================
       DÉMARRER LE TIMER
    ========================================================= */

    function startAutoplay() {

        stopAutoplay();


        if (!isPlaying) {
            return;
        }


        timer = window.setInterval(() => {

            nextSlide();

        }, autoplayDelay);

    }



    /* =========================================================
       FLÈCHE DROITE
    ========================================================= */

    if (nextButton) {

        nextButton.addEventListener('click', () => {

            nextSlide();

            /*
             * On recommence les 7 secondes après
             * une action manuelle.
             */
            startAutoplay();

        });

    }



    /* =========================================================
       FLÈCHE GAUCHE
    ========================================================= */

    if (prevButton) {

        prevButton.addEventListener('click', () => {

            previousSlide();

            startAutoplay();

        });

    }



    /* =========================================================
       POINTS DE NAVIGATION
    ========================================================= */

    dots.forEach((dot) => {

        dot.addEventListener('click', () => {

            const index =
                Number(dot.dataset.sliderDot);


            if (!Number.isInteger(index)) {
                return;
            }


            showSlide(index);

            startAutoplay();

        });

    });



    /* =========================================================
       PLAY / PAUSE
    ========================================================= */

    if (toggleButton) {

        toggleButton.addEventListener('click', () => {

            isPlaying = !isPlaying;


            /*
             * PLAY
             */
            if (isPlaying) {

                if (toggleIcon) {
                    toggleIcon.textContent = 'Ⅱ';
                }

                if (toggleText) {
                    toggleText.textContent =
                        'Lecture automatique';
                }

                toggleButton.setAttribute(
                    'aria-label',
                    'Mettre le slider en pause'
                );

                startAutoplay();

            }


            /*
             * PAUSE
             */
            else {

                if (toggleIcon) {
                    toggleIcon.textContent = '▶';
                }

                if (toggleText) {
                    toggleText.textContent =
                        'Lecture en pause';
                }

                toggleButton.setAttribute(
                    'aria-label',
                    'Relancer le slider'
                );

                stopAutoplay();

            }

        });

    }



    /* =========================================================
       SWIPE MOBILE
    ========================================================= */

    let touchStartX = 0;


    slider.addEventListener(
        'touchstart',
        (event) => {

            if (!event.changedTouches.length) {
                return;
            }

            touchStartX =
                event.changedTouches[0].clientX;

        },
        {
            passive: true
        }
    );


    slider.addEventListener(
        'touchend',
        (event) => {

            if (!event.changedTouches.length) {
                return;
            }


            const touchEndX =
                event.changedTouches[0].clientX;


            const distance =
                touchStartX - touchEndX;


            /*
             * Mouvement trop petit :
             * ce n'est pas considéré comme un swipe.
             */
            if (Math.abs(distance) < 50) {
                return;
            }


            /*
             * Swipe vers la gauche
             */
            if (distance > 0) {

                nextSlide();

            }


            /*
             * Swipe vers la droite
             */
            else {

                previousSlide();

            }


            startAutoplay();

        },
        {
            passive: true
        }
    );



    /* =========================================================
       CLAVIER
       ← et →
    ========================================================= */

    slider.addEventListener('keydown', (event) => {

        if (event.key === 'ArrowRight') {

            nextSlide();

            startAutoplay();

        }


        if (event.key === 'ArrowLeft') {

            previousSlide();

            startAutoplay();

        }

    });



    /* =========================================================
       ACCESSIBILITÉ
       PREFERS REDUCED MOTION
    ========================================================= */

    const reducedMotion =
        window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        );


    if (reducedMotion.matches) {

        isPlaying = false;


        if (toggleIcon) {
            toggleIcon.textContent = '▶';
        }


        if (toggleText) {
            toggleText.textContent =
                'Lecture en pause';
        }


        if (toggleButton) {

            toggleButton.setAttribute(
                'aria-label',
                'Relancer le slider'
            );

        }

    }



    /* =========================================================
       INITIALISATION
    ========================================================= */

    showSlide(0);


    if (isPlaying) {

        startAutoplay();

    }

}



/* =========================================================
   INITIALISATION GLOBALE
========================================================= */

function initApp() {

    initMobileMenu();

    initReveal();

    initAboutSlider();

}



/* =========================================================
   CHARGEMENT CLASSIQUE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    initApp
);



/* =========================================================
   SYMFONY UX TURBO
========================================================= */

document.addEventListener(
    'turbo:load',
    initApp
);