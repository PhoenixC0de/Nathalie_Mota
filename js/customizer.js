/* global wp */

(function() {

    // Site title
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            const title = document.querySelector('.site-title a');
            if (title) {
                title.textContent = to;
            }
        });
    });

    // Site description
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            const desc = document.querySelector('.site-description');
            if (desc) {
                desc.textContent = to;
            }
        });
    });

    // Header text color
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {

            const elements = document.querySelectorAll('.site-title, .site-description');
            const links = document.querySelectorAll('.site-title a, .site-description');

            if (to === 'blank') {
                elements.forEach(el => {
                    el.style.clip = 'rect(1px, 1px, 1px, 1px)';
                    el.style.position = 'absolute';
                });
            } else {
                elements.forEach(el => {
                    el.style.clip = 'auto';
                    el.style.position = 'relative';
                });

                links.forEach(el => {
                    el.style.color = to;
                });
            }
        });
    });

})();

