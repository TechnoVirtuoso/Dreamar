<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

?>


<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action('woocommerce_before_single_product_summary');
    
    //var_dump(wp_get_attachment_url($product->get_image_id(), 'thumbnail'));


    // Structure for popup used in additional variation-images
    if ($product->is_type('variable')) {
        $variations = $product->get_available_variations();
    
        foreach ($variations as $variation) {
            $variation_id = $variation['variation_id'];
            $image_ids_string = get_post_meta($variation_id, '_wc_additional_variation_images', true);
            ?>
            <div class="add-var-img-slider add-var-slider-<?php echo esc_attr($variation_id); ?>">
                <span class="close-var-imgs">x</span>
                <div class="add-var-img-slider-inner">
                    <div class="inner-wrap">
                        <!-- Automatically generate the thumbnails container with data-attribute -->
                        <div class="var-thumbnails" data-variation-id="<?php echo esc_attr($variation_id); ?>">
                            <!-- Thumbnails will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>


    <div class="single-product-main" id="buy-now">
        
        <?php switch ($product->get_type()) {
            case "variable":
                $variations = $product->get_available_variations();
                foreach ($variations as $var_key => $variation) {
                    foreach ($variation['attributes'] as $key => $attribute_value) {
                        $attribute_name = str_replace('attribute_', '', $key);
                        $default_value = $product->get_variation_default_attribute($attribute_name);
                        if ($default_value == $attribute_value) {
                            $is_default_variation = true;
                        } else {
                            $is_default_variation = false;
                            break; // Stop this loop to start next main loop
                        }
                    }
                    if ($is_default_variation) {
                        $variations[$var_key]['selected'] = true;
                        break; // Stop the main loop
                    }
                }
                ?>

                <div class="product-summary">
                    <div class="main-image-wrap-mb">
                        <div class="product-details-wrap">
                            <div class="product-title"><?php echo $product->get_name(); ?></div>
                            <?php if ($product->get_sku()) { ?>
                                <div class="product-sku">Product SKU: <?php echo $product->get_sku(); ?></div>
                            <?php } ?>
                        </div>
                        <div class="main-image">
                            <img class="zoomed-image wp-post-image" src="<?php echo wp_get_attachment_url($product->get_image_id()) ?>" data-variation-id="<?php echo $product->get_id(); ?>" />
                        </div>
                    </div>
                    <div class="variations-wrap">
                        <div class="main-image-wrap">
                            <div class="product-details-wrap">
                                <div class="product-title"><?php echo $product->get_name(); ?></div>
                                <?php if ($product->get_sku()) { ?>
                                    <div class="product-sku">Product SKU: <?php echo $product->get_sku(); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="heading">Select your product</div>
						<div class="attributes">
							<?php 
							$attributes = $product->get_attributes();
                            
							foreach ($attributes as $attribute) {
								$attribute_name = $attribute['name'];
								$attribute_label = wc_attribute_label($attribute_name);
                                    
								if ($attribute['is_taxonomy']) {
									$attribute_terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'all'));
									if ($attribute_terms) { ?>
										<div class="attribute-section">
											<?php
											$first_term = reset($attribute_terms); // Get the first term for image URL
											$first_image_id = get_field('image', $first_term->taxonomy . '_' . $first_term->term_id);
											$first_image_url = wp_get_attachment_image_url($first_image_id, 'thumbnail');
											?>
											<div class="attr-details">
												<div class="attr-img">
													<img src="<?php echo $first_image_id; ?>" alt="">
												</div>
												<p class="attribute-name">SELECT <?php echo $attribute_label; ?></p>
												<div class="arrow">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="6 10 20 11.58" width = "10px" height ="6px" class="w-2 transition-transform duration-600 transform"><path d="M16 21.579c-.359 0-.717-.14-.99-.416l-8.6-8.734a1.438 1.438 0 010-2.012 1.384 1.384 0 011.98 0L16 18.145l7.609-7.728a1.385 1.385 0 011.98 0 1.438 1.438 0 010 2.012l-8.6 8.734a1.385 1.385 0 01-.99.416z" fill="#000" fill-rule="evenodd"></path></svg>
												</div>
											</div>
											<div class="attribute-values">
												<div class="attr-values-inner">
													<?php foreach ($attribute_terms as $term) {
														$image_id = get_field('image', $term->taxonomy . '_' . $term->term_id);
														$image_url = wp_get_attachment_image_url($image_id, 'thumbnail'); ?>
														<div class="variation-item" data-attribute="<?php echo strtolower($attribute_name); ?>" data-value="<?php echo esc_attr($term->slug); ?>" data-id="<?php echo esc_attr($term->term_id); ?>" data-group="<?php echo strtolower($attribute_label) ?>" data-productid="<?php echo $product->get_id(); ?>">
															<img src="<?php echo esc_url($image_id); ?>" alt="<?php echo esc_attr($term->name); ?>" />
															<span class="details"><?php echo esc_html($term->name); ?></span>
														</div>
													<?php } ?>
												</div>
											</div>
										</div>
									<?php }
								}
							} ?>
						</div>
                        <div class="reset-attributes">
                            <div class="reset-attributes-inner">
                                <svg width="25" height="25" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" class="w-4 flex-shrink-0 mr-1 fill-current"><g fill-rule="evenodd"><path d="M15.514 8.307c1.687 0 3.33.526 4.685 1.503l-2.158.298a.779.779 0 00-.736.823c.03.425.41.746.847.716h.11l3.693-.513a.796.796 0 00.521-.301.754.754 0 00.15-.571l-.528-3.592a.796.796 0 00-.902-.662.781.781 0 00-.68.877l.21 1.427c-3.376-2.168-7.794-2.017-11.006.377-3.211 2.394-4.51 6.504-3.237 10.24l1.282-1.247a7.54 7.54 0 011.556-6.501c1.508-1.825 3.787-2.882 6.193-2.874zM24.519 13.09l-1.282 1.246c.71 3.145-.669 6.386-3.453 8.126a8.094 8.094 0 01-9.033-.326l1.714-.236a.781.781 0 00.68-.878.796.796 0 00-.901-.662l-3.693.514a.796.796 0 00-.52.3.754.754 0 00-.15.572l.528 3.592c.055.379.387.66.78.662H9.3a.796.796 0 00.521-.301.754.754 0 00.15-.571L9.7 23.28c3.302 2.48 7.88 2.574 11.285.231 3.406-2.343 4.841-6.573 3.538-10.427l-.005.005z"></path></g></svg>
                                <p>Back to the initial version</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="main-image-wrap">
                        <div class="product-details-wrap">
                            <div class="product-title"><?php echo $product->get_name(); ?></div>
                            <?php if ($product->get_sku()) { ?>
                                <div class="product-sku">Product SKU: <?php echo $product->get_sku(); ?></div>
                            <?php } ?>
                        </div>
                        <div class="main-image">
                            <img class="zoomed-image wp-post-image" src="<?php echo wp_get_attachment_url($product->get_image_id()) ?>" data-variation-id="<?php echo $product->get_id(); ?>" />
                        </div>
                    </div>
                    <?php $custom_calc = get_field("custom_calculator"); ?>
                    <?php if ($custom_calc === "yes") { ?>
                        <div class="product-calculator">
                            <div class="notice">
                                <!-- TODO : Make Dynamic -->
                                Tiles are sold in minimum batch lots. All orders are calculated by converting the square metres requested and rounding up to arrive at the minimum batch lot(s) required to meet the request. Standard delivery times do not apply to orders over "100" cm.
                            </div>
                            <?php do_action('woocommerce_variable_custom_add_to_cart_form'); ?>
                            <div class="quantity-calculator">
                                <h3 class="heading">
                                    Quantity Calculator
                                </h3>
                                <div class="quantity-form">
                                    <div class="top-row">
                                        <div class="field-group">
                                            <label for="">Enter mq*</label>
                                            <input type="number" name="" id="">
                                        </div>
                                        <div class="field-group">
                                            <input type="checkbox" name="" id="">
                                            <label for="">+10% for contingency</label>
                                        </div>
                                    </div>
                                    <div class="bottom-row">
                                        <div class="field-group">
                                            <label for="">Boxes:</label>
                                            <div class="box-count">0</div>
                                        </div>
                                        <div class="field-group">
                                            <label for="">Mq</label>
                                            <div class="mq-count">0.00</div>
                                        </div>
                                    </div>
                                    <div class="totals">
                                        <div class="amount">
                                            5.745,60€
                                        </div>
                                        <label for="">/total including VAT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons-group">
                                <button class="custom-add-to-cart">
                                    Add to Basket
                                </button>
                                <button class="wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="6 7 20 18"><path d="M21.084 7c-2.127 0-3.827 1.6-4.884 2.659C15.12 8.609 13.389 7 11.266 7 8.158 7 6 9.166 6 12.273c0 6.745 8.93 12.304 9.325 12.528.43.265.977.265 1.408 0C17.11 24.568 26 18.983 26 12.277 25.969 9.021 24.1 7 21.084 7zm-5.106 16.698S7.3 18.381 7.3 12.273c0-2.36 1.55-3.955 3.934-3.955 2.385 0 4.503 3.076 4.947 3.076.444 0 2.5-3.076 4.885-3.076 2.384 0 3.552 1.595 3.552 3.955.018 6.05-8.641 11.425-8.641 11.425z" fill="#000" fill-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </div>
                    <?php } else if ($custom_calc === "no") { ?>
                        <div class="woocommerce-quantity-calculator">
                            <div class="price-inc-tax">
                                <p>8.485,00€ <span>/ including VAT</span></p>
                            </div>
                            <div class="product-calculator">
                                <?php do_action('woocommerce_variable_custom_add_to_cart_form'); ?>
                            </div>
                            <div class="quantity">
                                <p>QUANTITY</p>
                                <div class="q-c">
                                    <button class="minus">&#8722;</button>
                                    <?php
                                    // Get the product's default quantity value
                                    $input_value = isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : 1;
                                    woocommerce_quantity_input(array('input_value' => $input_value));
                                    ?>
                                    <button class="plus">+</button>
                                </div>
                            </div>
                            <div class="buttons-group">
                                <button class="custom-add-to-cart">
                                    Add to Basket
                                </button>
                                <button class="wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="6 7 20 18"><path d="M21.084 7c-2.127 0-3.827 1.6-4.884 2.659C15.12 8.609 13.389 7 11.266 7 8.158 7 6 9.166 6 12.273c0 6.745 8.93 12.304 9.325 12.528.43.265.977.265 1.408 0C17.11 24.568 26 18.983 26 12.277 25.969 9.021 24.1 7 21.084 7zm-5.106 16.698S7.3 18.381 7.3 12.273c0-2.36 1.55-3.955 3.934-3.955 2.385 0 4.503 3.076 4.947 3.076.444 0 2.5-3.076 4.885-3.076 2.384 0 3.552 1.595 3.552 3.955.018 6.05-8.641 11.425-8.641 11.425z" fill="#000" fill-rule="evenodd"></path></svg>
                                </button>
                            </div>
                            <div class="ship-time">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="5 5 22 22"><g transform="translate(5 5)" fill="none" fill-rule="evenodd"><circle stroke="#000" stroke-width="1.5" cx="11" cy="11" r="10.25"></circle><path d="M10.476 4.19c-.578 0-1.047.373-1.047.832v7.765c0 .46.469.832 1.047.832.579 0 1.048-.372 1.048-.832V5.022c0-.46-.47-.832-1.048-.832z" fill="#000"></path><path d="M14.981 11.394c-.253-.438-.77-.614-1.153-.393l-3.733.994c-.384.221-.49.756-.236 1.194.253.439.77.615 1.153.393l3.733-.993c.383-.221.49-.756.236-1.195z" fill="#000"></path></g></svg>
                                <p>Shipping in 11-16 weeks</p>
                            </div>
                            <div class="delivery">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="7 6 18 19"><g fill="none" fill-rule="evenodd"><path d="M5 5h22v22H5z"></path><path d="M5 5h22v22H5z"></path><g fill="#000" fill-rule="nonzero"><path d="M24.736 21.484l-4.255-4.33c-.433-.44-.893-.541-1.425-.541l-2.29 2.33c0 .541.1 1.018.532 1.45l4.256 4.33a.887.887 0 001.27 0l1.912-1.945a.925.925 0 000-1.294z"></path><path d="M20.192 13.521a.887.887 0 001.272 0l.64-.651 1.911 1.945a2.786 2.786 0 000-3.89l-2.551-2.596a.887.887 0 00-1.272 0l-.64.651V6.65c0-.569-.685-.872-1.09-.459l-2.29 2.33c-.406.413-.109 1.11.45 1.11h2.29l-.64.652a.925.925 0 000 1.293l.316.321-2.606 2.652-3.706-3.79v-.917c0-.247-.099-.477-.261-.65l-1.821-1.863a.887.887 0 00-1.271 0L7.643 8.63a.925.925 0 000 1.294l1.82 1.862a.884.884 0 00.64.266h.902l3.724 3.79-.767.779H12.79c-.477 0-.937.193-1.27.541l-4.256 4.33a.925.925 0 000 1.294l1.911 1.945a.887.887 0 001.271 0l4.256-4.33c.342-.349.532-.808.532-1.294v-1.183l4.643-4.725.315.321z"></path></g></g></svg>
                                <p>We offer delivery to floor other than ground floor / Assembly and installation services on <a href="#">request</a></p>
                            </div>
                            <div class="shipping-for">
                                <p>SHIPPING COSTS FOR USA</p>
                            </div>
                            <div class="total-price">
                                <span class="amount"></span>€<p> including VAT</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            break;
        }?>
    </div>
    <div class="wc-controls summary entry-summary">
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        //do_action( 'woocommerce_single_product_summary' );
        ?>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_single_product_summary.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    // do_action( 'woocommerce_after_single_product_summary' );
    ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<script>
<?php if ($product->get_type() == "variable") { ?>
    jQuery(document).ready(function($) {
    var values = [];
    $(document).on('click' , '.variation-item' , function() {
        var attribute = $(this).data('attribute');
        var value = $(this).data('value');
        var attribute_id = $(this).data('id');
        var group = $(this).data('group');
        var selector = $(this);
        var productid = $(this).data("productid");

         //Find the select field for the current attribute label
        var attributeLabel = $('.label label[for="' + attribute + '"]').text();
        var selectField = $('select[data-attribute_name="attribute_' + attribute + '"]');
        selectField.val(value).trigger('change');

        if (!selector.hasClass('selected')) {
            //console.log('output'); // Change 'output' to the actual output variable
            $('.variation-item[data-group="' + group + '"]').removeClass("selected");
            selector.addClass("selected");

            // Find the select field for the current attribute label
            // var attributeLabel = $('.label label[for="' + attribute + '"]').text();
            var selectField = $('select[data-attribute_name="attribute_' + attribute + '"]');
            selectField.val(value).change();
            var enabled_choices = [];
            $('.variations select option').each(function(){
                if($(this).val() != ""){
                    // console.log($(this).val());
                    enabled_choices.push($(this).val());
                } 
            })
            $('.variation-item').removeClass('disabled');
            $('.variation-item').each(function(){

                
                var value =  $(this).data('value');
                if(!enabled_choices.includes(value)){
                    $(this).addClass('disabled');
                }   
            })
            // console.log(enabled_choices);
        }
        
        values[attribute] = value;
        // console.log('values' + values);

        jQuery.ajax({
            type: "POST",
            url: "<?php echo admin_url('admin-ajax.php'); ?>",
            data: {
                action: "get_variant_image",
                attribute_values: values,
                product_id: productid,
            },
            success:function(output){
                //console.log(output);
            },
        })
    })
});


<?php } ?>


// Resets all attributes 
$(".reset-attributes").click(function(){
    $(".reset_variations").trigger("click");
    $(".variation-item").removeClass("selected");
    $(".variation-item").removeClass("disabled");
    $(this).dblclick();
})




// Function to get additional-images on post-image when clicked .... slick is activated when images are get 
jQuery(document).ready(function($) {
    $(document).on('click', '.main-image img.zoomed-image.slider-active', function() {
        let variation_id = $(this).data('variation-id');
        //console.log(variation_id);
        function loadVariationImages(variation_id, callback) {
        var data = {
            action: 'get_variation_images',
            variation_id: variation_id
        };
        $(".add-var-slider-"+variation_id).addClass("active");
        $.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {
            if (response.success) {
                callback(response.data.images);
                $('.var-thumbnails').slick({
                    dots: true,
                    draggable: true,
                    infinite: true,
                    arrow: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                });
            } else {
                console.log(response);
            }
        });
    }
        var $thumbnailsContainer = $('.var-thumbnails[data-variation-id="' + variation_id + '"]');
       // console.log($thumbnailsContainer);
        // Load images for the clicked variation ID
        loadVariationImages(variation_id, function(images) {
            $thumbnailsContainer.html(images);
        });

        // Hide other thumbnails and show for the clicked variation
        $('.var-thumbnails').hide();
        $thumbnailsContainer.show();
    });
});



// Clicks on variation-item to load post-image on first time click
$(document).ready(function() {
  var variationItem = $(".variation-item");
  var isClicked = false;

  if (variationItem.length > 0) {
    variationItem.on("click", function() {
      if (!isClicked) {
        isClicked = true;
        setTimeout(function() {
          variationItem.trigger("click");
        }, 5000); // 5 seconds in milliseconds
      }
    });
  }
});


// When additional variation image popup is closed ... it unslicks the slider
$(".close-var-imgs").click(function(){
    $(".add-var-img-slider").removeClass("active");
    $(".var-thumbnails").slick("unslick");
    $( ".close-zoomed" ).trigger( "click" );
})


// Checks if there are multiple attributes to show different functionality on single-product page
var numberOfDivs = $('.attributes .attribute-values').length;
//console.log('Number of child divs: ' + numberOfDivs);
if(numberOfDivs <= 1 ){
	$(".attributes").addClass("no-acc");
	$(".attr-details").css("display", "none");
}else{
	$(".attributes").addClass("acc");
}


// Attributes Accordion
$(document).ready(function(){
    $(".attributes.acc .attribute-section:eq(0)").addClass("active");
    $(".attributes.acc .attribute-section:eq(0) .attribute-values").slideDown();
	$(".attributes.acc .attribute-section:eq(0) .attr-details .arrow").addClass("active");
    
    $(".attributes.acc .attribute-section .attr-details").click(function(){
        var attributeSection = $(this).parents(".attribute-section");
        
        if(attributeSection.hasClass("active")){
            attributeSection.removeClass("active");
			$(".attributes.acc .attribute-section .attr-details .arrow").removeClass("active");
            attributeSection.find(".attribute-values").slideUp();
        }else{
            $(".attributes.acc .attribute-section").removeClass("active");
            $(".attributes.acc .attribute-values").slideUp();
            attributeSection.addClass("active");
			$(".attributes.acc .attribute-section .attr-details .arrow").removeClass("active");
			$(this).children(".arrow").addClass("active");
            attributeSection.find(".attribute-values").slideDown();
        }
    });
});


// Adds and Subtracts quantity when clicked on custom plus and minus button ... also update the price based on quantity
document.addEventListener('DOMContentLoaded', function() {
    var quantityInput = document.querySelector('.woocommerce-quantity-calculator input.qty');
    var plusButton = document.querySelector('.woocommerce-quantity-calculator .plus');
    var minusButton = document.querySelector('.woocommerce-quantity-calculator .minus');
    var totalPrice = document.querySelector('.woocommerce-quantity-calculator .total-price .amount');
    var variationItems = document.querySelectorAll('.variation-item');
    var customPlus = document.querySelectorAll(".q-c .quantity input");

    function updateTotalPrice() {
        var quantity = parseFloat(quantityInput.value);
        var price = parseFloat('<?php echo esc_js($product->get_price()); ?>');
        var total = (quantity * price).toFixed(2);
        totalPrice.textContent = total;
    }

    plusButton.addEventListener('click', function() {
        var quantity = parseFloat(quantityInput.value);
        var step = parseFloat(quantityInput.getAttribute('step'));
        var max = parseFloat(quantityInput.getAttribute('max'));

        if (!isNaN(max) && quantity + step > max) {
            return;
        }

        quantity += step;
        quantityInput.value = quantity;
        updateTotalPrice();
    });

    minusButton.addEventListener('click', function() {
        var quantity = parseFloat(quantityInput.value);
        var step = parseFloat(quantityInput.getAttribute('step'));
        var min = parseFloat(quantityInput.getAttribute('min'));

        if (!isNaN(min) && quantity - step < min) {
            return;
        }

        quantity -= step;
        quantityInput.value = quantity;
        updateTotalPrice();
    });

    quantityInput.addEventListener('change', function() {
        updateTotalPrice();
    });

    // Handle variation selection
    variationItems.forEach(function(variationItem) {
        variationItem.addEventListener('click', function() {
            var variationPrice = parseFloat(variationItem.getAttribute('data-price'));
            var quantity = parseFloat(quantityInput.value);
            var total = (quantity * variationPrice).toFixed(2);

            if (!isNaN(total)) {
                totalPrice.textContent = total;
            } else {
                totalPrice.textContent = '';
            }
        });
    });
});
</script>
