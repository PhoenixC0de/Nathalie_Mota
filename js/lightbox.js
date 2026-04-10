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

  // Récupère toutes les photos de la galerie
  $('.photo-card-hover').each(function (index) {
    const img =$(this).closest('.photo-card').find('.photo-card-image img').attr('src');
    const reference = $(this).find('.hover-fullscreen').data('reference');
    const categorie = $(this).find('.hover-fullscreen').data('categorie');

    //on stocke les infos dans un tableau pour la lightbox
    photos.push({
      src: img,
      reference: reference,
      categorie: categorie,
    });
    $(this).find('.hover-fullscreen').attr('data-index', index);

    // Ajoute l’index sur l’icône fullscreen
    $(this).find('.hover-fullscreen').attr('data-index', index);
  });

  // OUVERTURE
  $('.hover-fullscreen').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        currentIndex = parseInt($(this).data('index'));

        console.log("OPEN LIGHTBOX INDEX =", currentIndex);

        updateLightbox();

        $('#lightbox').addClass('open');
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