jQuery(function ($) {

  const lightbox = $('#lightbox');
  const imgEl = $('#lightbox-img');
  const titleEl = $('#lightbox-title');

  const btnPrev = $('#lightbox-prev');
  const btnNext = $('#lightbox-next');
  const btnClose = $('.lightbox-close');
  const overlay = $('.lightbox-overlay');

  let photos = [];
  let currentIndex = 0;

  // Fonction qui construit le tableau des photos
function buildPhotosArray() {
    photos = [];

    $('.photo-card-hover').each(function (index) {

        const img = $(this).closest('.photo-card').find('.photo-card-image img').attr('src');
        const reference = $(this).find('.hover-fullscreen').data('reference');
        const categorie = $(this).find('.hover-fullscreen').data('categorie');

        photos.push({
            src: img,
            reference: reference,
            categorie: categorie,
        });

        // Mise à jour de l'index
        $(this).find('.hover-fullscreen').attr('data-index', index);
    });
}

// Appel initial
buildPhotosArray();

//  OUVERTURE lightbox
$(document).on('click', '.hover-fullscreen', function (e) {
    e.preventDefault();
    e.stopPropagation();

    currentIndex = parseInt($(this).data('index'));
    updateLightbox();
    $('#lightbox').addClass('open');
});

//  Reconstruire après AJAX (load more + filtres)
$(document).ajaxSuccess(function (event, xhr, settings) {
    if (
        settings.data.includes("action=filter_photos") ||
        settings.data.includes("action=load_more_photos")
    ) {
        buildPhotosArray();
    }
});


  // FERMETURE
  function closeLightbox() {
    lightbox.removeClass('open');
  }

  btnClose.on('click', closeLightbox);
  overlay.on('click', closeLightbox);

  // NAVIGATION
  btnPrev.on('click', () => {
    currentIndex = (currentIndex - 1 + photos.length) % photos.length;
    updateLightbox();
  });

  btnNext.on('click', () => {
    currentIndex = (currentIndex + 1) % photos.length;
    updateLightbox();
  });

  // Mise à jour du contenu
  function updateLightbox() {
    imgEl.attr('src', photos[currentIndex].src);
    titleEl.html(`
      <div class="ref">${photos[currentIndex].reference}</div>
      <div class="cat">${photos[currentIndex].categorie}</div>
    `);
  }

});