// --------------------------------------
// GESTION DE LA MODAL
// --------------------------------------
jQuery(document).ready(function($) {

    const modal = $('#contact-modal');
    const closeBtn = $('.close-modal');
    

    // Préremplissage de la référence
    $('.open-contact-modal, .button-contact').on('click', function () {
      const ref = $(this).data('ref');

    // Remplit le champ REF.PHOTO
    $('#ref-photo').val(ref);

    // OUVERTURE de la modale
    $('.open-contact-modal, .button-contact').on('click', function(e) {
        e.preventDefault();

    // Ouvre la modal
    $('#contact-modal').addClass('open');
});

    // Affichage de la modal
    modal.css({
        display: 'flex',
        opacity: 1
    });
    });

    // Fonction fadeOut
    function fadeOut(element) {
        element.css('opacity', 1);

        const fade = setInterval(() => {
            let currentOpacity = parseFloat(element.css('opacity'));
            element.css('opacity', currentOpacity - 0.05);

            if (currentOpacity <= 0) {
                clearInterval(fade);
                element.css('display', 'none');
            }
        }, 10);
    }

    // FERMETURE via la croix
    closeBtn.on('click', function() {
        fadeOut(modal);
    });

    // FERMETURE en cliquant en dehors
    modal.on('click', function(e) {
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
//affichage de la miniature de l'image suivante dans la navigation dans single photo
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

