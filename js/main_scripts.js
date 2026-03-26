// --------------------------------------
// GESTION DE LA MODAL
// --------------------------------------
jQuery(document).ready(function($) {

    const modal = $('#contact-modal');          // La modale complète (overlay)
    const closeBtn = $('.close-modal');         // Bouton / icône de fermeture

    // Fonction fadeOut (fermeture progressive)
    function fadeOut(element) {
        element.css('opacity', 1);

        const fade = setInterval(() => {
            let currentOpacity = parseFloat(element.css('opacity'));
            element.css('opacity', currentOpacity - 0.1);

            if (currentOpacity <= 0) {
                clearInterval(fade);
                element.css('display', 'none');
                element.removeClass('open');
            }
        }, 10);
    }

    // --- OUVERTURE DE LA MODALE ---
    $('.open-contact-modal, .button-contact').on('click', function(e) {
        e.preventDefault(); // Empêche le lien du header de recharger la page

        const ref = $(this).data('ref') || '';
        $('#ref-photo').val(ref);

        modal.css({
            display: 'flex',
            opacity: 1
        }).addClass('open');
    });

    // --- FERMETURE AVEC LA CROIX ---
    closeBtn.on('click', function(e) {
        e.preventDefault();
        fadeOut(modal);
    });

    // --- FERMETURE EN CLIQUANT DANS LE VIDE (overlay) ---
    modal.on('click', function(e) {
        // si on clique directement sur l'overlay (et pas sur le contenu)
        if (e.target === this) {
            fadeOut(modal);
        }
    });

});


// --------------------------------------
// MENU MOBILE
// --------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.main-nav');
    const links = document.querySelectorAll('.main-nav a');

    if (!burger || !nav) return;

    burger.addEventListener('click', () => {
        burger.classList.toggle('active');
        nav.classList.toggle('open');
    });

    links.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('open');
            burger.classList.remove('active');
        });
    });
});

// --------------------------------------
// affichage de la miniature de l'image suivante dans la navigation dans single photo
// --------------------------------------
document.querySelectorAll('.nav-under').forEach(link => {
  link.addEventListener('mouseenter', () => {
    const img = link.dataset.preview;
    if (!img) return;

    const previewContainer = link
      .closest('.nav-next-preview')
      .querySelector('.nav-preview-hover');

    previewContainer.innerHTML = `<img src="${img}" alt="">`;
  });

  link.addEventListener('mouseleave', () => {
    const previewContainer = link
      .closest('.nav-next-preview')
      .querySelector('.nav-preview-hover');

    previewContainer.innerHTML = '';
  });
});
