jQuery(document).ready(function($) {
    var original_image_url = $('img.wp-post-image').attr('src'); // Store the original image URL
    var main_image = $('img.wp-post-image'); // Cache the main image element


    $('.variations_form').on('click', '.reset_variations', function() {
        $('img.wp-post-image').attr('src', original_image_url); // Reset the image to the original
    });

    function updateProductImage() {
        var variation_id = $('input[name="variation_id"]').val();
        var data = {
            action: 'update_variable_product_image',
            variation_id: variation_id,
        };
        $.post(custom_ajax_object.ajax_url, data, function(response) {
            if (response && response.image_src) {
                main_image.attr('src', response.image_src); // Update the main image URL
                main_image.data('variation-id', variation_id); // Update the data-variation-id attribute
                main_image.addClass('slider-active');
            }
        });
    }

    $('.variations_form').on('change', '.variations select', function() {
        updateProductImage();
    });

    $('.variations_form').on('click', '.clear_attributes', function() {
        updateProductImage();
        $('select.variation-select').val('').change(); // Clear attribute selections
        $('img.wp-post-image').attr('src', original_image_url); // Reset the image to the original
    });

});


