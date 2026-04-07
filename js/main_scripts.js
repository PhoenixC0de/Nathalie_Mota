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
// --------------------------------------
// chargement des photos supplémentaires dans la galerie
// --------------------------------------
jQuery(function ($) {

    let loading = false;

    $('#load-more').on('click', function () {

        if (loading) return;
        loading = true;

        let button = $(this);
        let page = parseInt(button.attr('data-page'));
        let max = parseInt(button.attr('data-max'));

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_more_photos',
                page: page + 1,
                order: document.querySelector('[data-filter="order"]')?.dataset.value || 'DESC'
            },
            success: function (response) {
              // Si aucune photo n'est renvoyée on cache le bouton
              if (!response || response.trim() === "") {
                  button.hide();
                  loading = false;
                  return;
              }

              // Sinon on ajoute les photos
              $('.photo-gallery').append(response);
              button.attr('data-page', page + 1);

              // Si on a atteint la dernière page on cache le bouton
              if (page + 1 >= max) {
                  button.hide();
              }

              loading = false;
          }

        });
    });
});

// --------------------------------------
// filtrage des photos dans la galerie (recuperation des filtres si ajouts dans le back-office)
// --------------------------------------
document.querySelectorAll('.custom-select').forEach(select => {

  const trigger = select.querySelector('.custom-select-trigger');
  const options = select.querySelector('.custom-options');
  const span = trigger.querySelector('span');

  trigger.addEventListener('click', () => {
    select.classList.toggle('open');
  });

  select.querySelectorAll('.custom-option').forEach(option => {
  option.addEventListener('click', () => {

    const value = option.dataset.value;

    // RESET : si on clique sur l'option vide
    if (value === "") {
      span.textContent = trigger.dataset.placeholder;
    } else {
      span.textContent = option.textContent;
    }

    select.dataset.value = value;
    select.classList.remove('open');

    // appel AJAX
    filterPhotos();
  });
});

  document.addEventListener('click', e => {
    if (!select.contains(e.target)) {
      select.classList.remove('open');
    }
  });

});

function filterPhotos() {

  let category = document.querySelector('[data-filter="category"]')?.dataset.value || '';
  let format   = document.querySelector('[data-filter="format"]')?.dataset.value || '';
  let order    = document.querySelector('[data-filter="order"]')?.dataset.value || '';
  // Un filtre est considéré comme actif si au moins un des critères est sélectionné
  if (category === '' && format === '' && order === '') {
    location.reload();
    return;
  }

  jQuery.ajax({
    url: ajax_params.ajax_url,
    type: 'POST',
    data: {
      action: 'filter_photos',
      category: category,
      format: format,
      order: order
    },
    success: function(response) {

    let data = JSON.parse(response);

    // Remplace la galerie
    jQuery('.photo-gallery').html(data.html);

    let button = jQuery('#load-more');

    // Si un filtre est actif → on masque le bouton
    if (category !== '' || format !== '') {
        button.hide();
        return;
    }

    // Si seulement tri → bouton toujours visible
    if (order !== '') {
        button.show();
        return;
}

    // Sinon → pagination normale
    button.attr('data-page', 1);
    button.attr('data-max', data.max);

    if (data.max > 1) {
        button.show();
    } else {
        button.hide();
    }
}

  });
}