(function($) {
    $(function() {
        // Custom var by project
        var btnAddToCart            = jQuery('.btn-cart');
        var optionsDiv              = jQuery('.required-entry.super-attribute-radiogroup');
        var productAddToCartForm    = new VarienForm('product_addtocart_form');
        var overlay                 = jQuery('#ph-addtocart-overlay');
        var popup                   = jQuery('#ph-addtocart-popup');
        var formId                  = jQuery('#product_addtocart_form');
        var addToCartUrl            = formId.attr('action');
        var summary                 = popup.find('.summary');
        var summaryAdded            = summary.find('.added');
        var loader                  = jQuery('.ph-loader');
        var headerMinicart          = jQuery('.header-minicart');

        btnAddToCart.on('click touch', function (e) {
            e.preventDefault();

            // If configurable product
            if(optionsDiv.length) {

                /** If no options selected */
                if(!jQuery('.required-entry.super-attribute-radiogroup .active').length) {
                    summaryAdded.html("Please, select an option");
                    overlay.show();
                    jQuery('.overlay-actions').hide();
                    jQuery('#ph-addtocart-popup').show();
                    return '';
                }
            }

            btnAddToCart.prop('disabled', true);
            loader.show();


            if (productAddToCartForm.validator.validate()) {

                jQuery.ajax({
                    url: addToCartUrl,
                    dataType: 'json',
                    data: formId.serialize() + '&action_from=catalog_product_view' ,
                    type: 'POST',
                    success: function(data) {
                        btnAddToCart.prop('disabled', false);
                        loader.hide();

                        if (data.success && data.success == true) {

                            // Append summary
                            summaryAdded.html(data.addedMsg);

                            // Update cart and count cart
                            headerMinicart.html(data.cartHtml);
                            headerMinicart.find('a.skip-cart').on('click touch',function (e) {
                                e.preventDefault();
                                jQuery('#header-cart').toggleClass('skip-active');
                            })

                            overlay.show();
                            popup.show();

                        } else {
                            summary.html(data.errorMsg);
                        }
                    },
                    error: function() {
                        btnAddToCart.prop('disabled', false);
                        loader.hide();
                        summary.html('An error occurred');

                        jQuery('.overlay-actions').hide();
                        overlay.show();
                        popup.show();
                    }
                });
                return '';
            }
            else {
                btnAddToCart.prop('disabled', false);
                loader.hide();
            }
        });

    });
})(jQuery);