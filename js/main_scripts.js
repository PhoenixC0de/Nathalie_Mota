//gestion de la modal
document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("contact-modal");
    const closeBtn = document.querySelector(".close-modal");

    // OUVERTURE de la modale quand on clique sur "Contact"
    document.querySelectorAll(".open-contact-modal").forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            modal.style.display = "flex";  // important pour centrer
            modal.style.opacity = 1;
        });
    });

    // Fonction fadeOut pour faire disparaître la modal en douceur
    function fadeOut(element) {
        element.style.opacity = 1;

        const fade = setInterval(() => {
            element.style.opacity -= 0.05;

            if (element.style.opacity <= 0) {
                clearInterval(fade);
                element.style.display = "none";
            }
        }, 10);
    }

    // fermeture de la modal
    closeBtn.addEventListener("click", () => {
        fadeOut(modal);
    });

    // fermeture en cliquant en dehors
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            fadeOut(modal);
        }
    });

});
