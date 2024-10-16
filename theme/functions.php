<?php 

define('INCLUDES_DIR', get_template_directory() . '/includes/');

include_once INCLUDES_DIR . 'general-wp-setup.php';
include_once INCLUDES_DIR . 'enqueue.php';
include_once INCLUDES_DIR . 'acf-sync.php';
include_once INCLUDES_DIR . 'getBlocks.php';
include_once INCLUDES_DIR . 'style-editor.php';
include_once INCLUDES_DIR . 'required-plugins.php';

add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    // add_theme_support( 'wc-product-gallery-zoom' );
    // add_theme_support( 'wc-product-gallery-lightbox' );
    // add_theme_support( 'wc-product-gallery-slider' );
} );


add_shortcode('product_variation_images', 'display_variation_images_shortcode');

function display_variation_images_shortcode() {
    ob_start(); // Start an output buffer.

    global $product;

    if ($product->is_type('variable')) {
        $variation_ids = $product->get_visible_children();
        $variation_images = array();

        foreach ($variation_ids as $variation_id) {
            $variation = wc_get_product($variation_id);
            $variation_images[$variation_id] = $variation->get_image();
        }

        if (!empty($variation_images)) {
            echo '<div class="variation-images">';
            foreach ($variation_images as $variation_id => $image) {
                echo '<div class="variation-image">' . $image . '</div>';
            }
            echo '</div>';
        }
    }

    return ob_get_clean(); // Return the contents of the output buffer.
}

add_action('woocommerce_variable_custom_add_to_cart_form', 'woocommerce_template_single_add_to_cart');

// change the breadcrumb on the product page
add_filter( 'woocommerce_get_breadcrumb', 'custom_breadcrumb', 20, 2 );
function custom_breadcrumb( $crumbs, $breadcrumb ) {

    // only on the single product page
    if ( ! is_product() ) {
        return $crumbs;
    }
    
    // gets the first element of the array "$crumbs"
    $new_crumbs[] = reset( $crumbs );
    // gets the last element of the array "$crumbs"
    $new_crumbs[] = end( $crumbs );

    return $new_crumbs;

}

function get_variation_image(){
    $attribute_values = $_REQUEST['attribute_values'];
    $product_id = $_REQUEST['product_id'];

    $product = wc_get_product($product_id);
    $product_variations = $product->get_available_variations();

    wp_send_json_success( array( 
        'product_id' => $attribute_values,
        'variations' => $product_variations,
    ), 200 );
}
add_action('wp_ajax_get_variant_image', 'get_variation_image');


if (isset($_POST['selected_values'])) {
    $selected_values = $_POST['selected_values'];
    $combined_values = implode(', ', $selected_values);

    // Modify the logic to retrieve the matched image URL based on the $combined_values
    // Example: $matched_image_url = get_matched_image_url($combined_values);

    $response = array('image_url' => $matched_image_url);
    echo json_encode($response);
}


// Enqueues custom-ajax.js to get variation-image
function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/custom-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax', 'custom_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function update_variable_product_image() {
    if (isset($_POST['variation_id'])) {
        $variation_id = intval($_POST['variation_id']);
        $variation = wc_get_product($variation_id);

        if ($variation && $variation->is_type('variation')) {
            $image_id = $variation->get_image_id();
            $image_src = wp_get_attachment_image_src($image_id, 'full');
            wp_send_json(array('image_src' => $image_src[0]));
        }
    }
    wp_send_json_error();
}
add_action('wp_ajax_update_variable_product_image', 'update_variable_product_image');
add_action('wp_ajax_nopriv_update_variable_product_image', 'update_variable_product_image');



// Gets additional variation-images for the product 
function get_variation_images() {
    // $variation_id = $_REQUEST['variation_id'];
    if (isset($_POST['variation_id']) && absint($_POST['variation_id'])) {
        $variation_id = absint($_POST['variation_id']);
        $image_ids_string = get_post_meta($variation_id, '_wc_additional_variation_images', true);
        $image_ids = explode(',', $image_ids_string);

        $images = '';

        if (!empty($image_ids)) {
            foreach ($image_ids as $image_id) {
                $image_url = wp_get_attachment_url($image_id);
                $images .= '<div class="var-add-imgs">';
                $images .= '<img src="' . esc_url($image_url) . '" alt="Variation Image" data-id="' . esc_attr($image_id) . '" data-variation-id="' . esc_attr($variation_id) . '">';
                $images .= '</div>';
            }
        }

        wp_send_json_success(array('images' => $images));
    }
     else {
        wp_send_json_error(array('message' => 'Invalid variation ID.'));
    }
}

add_action('wp_ajax_get_variation_images', 'get_variation_images');
add_action('wp_ajax_nopriv_get_variation_images', 'get_variation_images');
























