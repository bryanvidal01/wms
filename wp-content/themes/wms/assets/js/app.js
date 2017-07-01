jQuery(document).ready(function(){
    // Filter Catalogue
    jQuery('.filter_catalog_view input[type="checkbox"]').click(function(){
        jQuery('.filter_catalog_view').submit();
    })
});
