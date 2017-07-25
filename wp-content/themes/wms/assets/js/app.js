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
});
