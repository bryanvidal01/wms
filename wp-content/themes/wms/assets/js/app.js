jQuery(document).ready(function(){
    // Filter Catalogue
    jQuery('.filter_catalog_view input[type="checkbox"]').click(function(){
        jQuery('.filter_catalog_view').submit();
    })

    // lightbox
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

    // Slider
    jQuery('.slider-bullets').owlCarousel({
        items:1,
        autoplay: true,
        autoplayHoverPause: true,
        fluidSpeed: 400,
        smartSpeed: 800,
    });

    jQuery('.info-popin').click(function(event){
        event.preventDefault();
        jQuery('.popin-reservation').fadeIn(300);
    });

    jQuery('.popin-reservation .close-button').click(function(){
        jQuery('.popin-reservation').fadeOut(300);
    });

    jQuery('.form-achat').submit(function(){
        var el = jQuery(this);
        var error = 0;

        event.preventDefault();
        el.find('input[type="text"]').each(function(event){
            inputEl = jQuery(this);
            if(inputEl.val() == ''){
                error++;
            }
        });

        if(error != 0){
            el.find('.error').html(error + ' champs ne sont pas encore remplis');
        }
    });
});
