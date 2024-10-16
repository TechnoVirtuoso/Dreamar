<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product; 
get_header( 'shop' ); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); 
		define("CURR_URL" ,  home_url( add_query_arg( NULL, NULL ) ));
		  $current_url =  home_url( add_query_arg( NULL, NULL ) );
		?>
		<?php 
			$banner_links = get_field("banner_links");
		?>

		<!-- for fixed header on scroll -->
		<div class="header-scroll">
			<div class="header-scroll-container">
			<?php if($banner_links['buy_now']){ ?>
				<div class="buy-now">
					<a href="<?php echo CURR_URL . '#buy-now'; ?>">Buy Now</a>
				</div>
			<?php } ?>
			<?php if($banner_links['buy_now']){ ?>
				<div class="technical-details">
					<a href="<?php echo CURR_URL . '#technical-details'; ?>">Technical Details</a>
				</div>
			<?php } ?>
			<?php if($banner_links['product_description']){ ?>
				<div class="product-description">
					<a href="<?php echo CURR_URL . '#product-description'; ?>">Product Description</a>
				</div>
			<?php } ?>
			</div>
		</div>

		<div class="banner">
			<?php echo get_post_gallery( get_the_ID(), false ); ?>
			<img src="<?php echo get_field("banner_image"); ?>" alt="">
			<div class="banner-container">
				<div class="banner-inner">
					<?php 
						echo woocommerce_breadcrumb();
					?>
					<h1><?php echo $product->name; ?></h1>
					<div class="banner-links">
						<div class="pb">
							<p><?php echo get_field("product_by"); ?></p>
						</div>
						<div class="ban-link">
							<?php 
								$banner_links = get_field("banner_links");
							?>
							<?php if($banner_links['buy_now']){ ?>
								<div class="buy-now ban-sl">
									<a href="<?php echo CURR_URL . '#buy-now'; ?>"><?php echo $banner_links['buy_now']['title']; ?></a>
								</div>
							<?php } ?>
							<?php if($banner_links['buy_now']){ ?>
								<div class="technical-details ban-sl">
									<a href="<?php echo CURR_URL . '#technical-details'; ?>"><?php echo $banner_links['technical_details']['title']; ?></a>
								</div>
							<?php } ?>
							<?php if($banner_links['product_description']){ ?>
								<div class="product-description ban-sl">
									<a href="<?php echo CURR_URL . '#product-description'; ?>"><?php echo $banner_links['product_description']['title']; ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php wc_get_template_part( 'content', 'single-product' ); ?>
		<div class="downloads">
			<div class="current-slide-index"></div>	
			<div class="downloads-container">
				<div class="heading">
					<h4>Downloads</h4>
				</div>
				<div class="subtext">
					<p>Log in to access a range of useful resources designed to help your planning.</p>
				</div>
				<div class="downloadables">
					<?php foreach(get_field("downloads") as $downloads){ ?>
						<div class="single-download">
							<?php if(is_user_logged_in()){ ?>
								<a href="#" download>
									<div class="icon">
										<img src="<?php echo $downloads['icon']; ?>" alt="">
									</div>
									<div class="title">
										<p><?php echo $downloads['title']; ?></p>
									</div>
								</a>
							<?php }else{ ?>
								<a href="#">
									<div class="icon">
										<img src="<?php echo $downloads['icon']; ?>" alt="">
									</div>
									<div class="title">
										<p><?php echo $downloads['title']; ?></p>
									</div>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		
		<!-- Gallery Slider Section -->
		<div class="gallery-slider" >
			<?php $gallery_images = get_field("gallery_slider"); 
			?>
			<div class="gallery-slider-container">
				<?php foreach($gallery_images as $image){ ?>
					<div class="g-img">
						<img src="<?php echo $image['images']; ?>" alt="">
					</div>
				<?php } ?>
			</div>
		</div>


		<!-- Gallery Slider Popup -->
		<div class="gallery-popup">
			<span class="g-popup-close">
				x
			</span>
			<div class="gallery-popup-container">
				<div id="p-left">

				</div>
				<div id="p-right">

				</div>
				<div class="gallery-popup-inner">
					<?php $gallery_images = get_field("gallery_slider"); 
					?>
					<?php foreach($gallery_images as $image){ ?>
						<div class="g-popup-img">
							<img src="<?php echo $image['images']; ?>" alt="">
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="slider-counter">
				<span id="count"></span> / <span id="total-slides"></span>
			</div>
		</div>
		<div id="gpopup-cursor-right">

		</div>
		<div id="gpopup-cursor-left">
			
		</div>


		<div class="contact-links">
			<div class="contact-links-container">
				<h2>Need help deciding?</h2>
				<div class="contact-links-inner">
					<?php foreach(get_field("contact_links") as $links){ ?>
						<div class="link">
							<a href="<?php echo $links['link']; ?>">
								<div class="icon">
									<img src="<?php echo $links['link_icon']; ?>" alt="">
								</div>
								<div class="link-title">
									<p><?php echo $links['link_title']; ?></p>
								</div>
								<div class="link-subtext">
									<p><?php echo $links['link_subtext']; ?></p>
								</div>
							</a>
						</div>
					<?php } ?>
					<div class="link">
						<a href="">
							<div class="icon">
								<img src="<?php echo "/wp-content/uploads/2023/07/Frame-7.png"; ?>" alt="">
							</div>
							<div class="link-title">
								<p>Share</p>
							</div>
							<div class="link-subtext">
								<p>Follow us on social media and share our inspiring images, ideas and latest products with other designer lovers.</p>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>



		<div class="product-details" id="technical-details">
			<div class="product-details-container">
				<div class="left-col">
					<div class="data-sheet">
						<h4>View Product Details</h4>
						<button>DATA SHEET</button>
					</div>
					<div class="catalogs">
						<h4>View catalogue Walls & Floors</h4>
						<a href="<?php echo get_field("catalogue_file") ?>" target = "__blank">DOWNLOAD WALLS & FLOORS</a>
					</div>
					<div class="product-image">
						<img src="<?php echo wp_get_attachment_url( $product->get_image_id() ) ?>" />
					</div>
				</div>
				<div class="right-col">
					<?php foreach(get_field("faqs") as $faq){ ?>
						<div class="faq">
							<p class="title">
								<?php echo $faq['title']; ?>
								<span class="plus-minus">
									<span class="plus">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="5.06 4.94 22.04 22.04" ><g fill="#000" fill-rule="evenodd"><path d="M15.086 5.944h2v20.041h-2z"></path><path d="M6.065 14.964v2h20.042v-2z"></path></g></svg>
									</span>
									<span class="minus">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="5.06 4.94 22.04 22.04"><path d="M6.065 14.964v2h20.042v-2z" fill="#000" fill-rule="evenodd"></path></svg>
									</span>	
								</span>
							</p>
							<span class="subtext"><?php echo $faq['subtext']; ?></span>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>



		<div class="p-full-img">
			<div class="p-full-img-container">
				<img class="p-f-img" src="" alt="">
			</div>
		</div>



		<?php 
		 if(get_field("blurb_description")){
		$blurb = (get_field("blurb_description_heading")); ?>
		<div id="product-description" class="blurb-description">
			<div class="blurb-description-container">
				<div class="heading">
					<h4><?php echo $blurb['heading']; ?></h4>
				</div>
				<div class="subheading">
					<p><?php echo $blurb['subheading']; ?></p>
				</div>
				<div class="blurbs">
					<?php foreach(get_field("blurb_description") as $bl){ ?>
						<div class="single-blurb">
							<div class="image">
								<img src="<?php echo $bl['image']; ?>" alt="">
							</div>
							<div class="text">
								<?php echo $bl['text']; ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>



		<div class="upsell-products">
			<div class="upsells-product-container">
				<h2>An extra touch of style</h2>
				<p>A selection of products our design team think you'll love</p>
				<div class="up">
					<?php  
					$upsells = $product->get_upsells();

					foreach ($upsells as $upsell_id) { 
						$upsell_product = wc_get_product($upsell_id);
						if ($upsell_product) { 
							?>
							<div class="u-prods">
								<div class="u-prods-container">
									<a href="<?php echo esc_url(get_permalink($upsell_id)); ?>">
										<?php
											$upsell_image_url = wp_get_attachment_image_url(get_post_thumbnail_id($upsell_id), 'full');
										?>
										<div class="u-fi-container">
											<img src="<?php echo esc_url($upsell_image_url); ?>" alt="<?php echo esc_attr($upsell_product->get_name()); ?>">
										</div>
										<div class="u-content">
											<p class="u-name"><?php echo esc_html($upsell_product->get_name()); ?></p>
											<p class="u-price"><?php echo wc_price($upsell_product->get_price()); ?></p>
										</div>
									</a>
								</div>
							</div>
							<?php
						} 
					}
					?>
				</div>
			</div>
		</div>



		<?php if($product->get_description()){ ?>
			<div class="product-description">
				<div class="product-description-container">
					<p class= "title" >Product Description</p>
					<?php echo $product->get_description(); ?>
				</div>
			</div>
		<?php } ?>


	<?php if(get_field("other_stones")){ ?>
		<div class="other-stones">
			<div class="other-stones-container">
				<h2>Other Available Stones</h2>
				<div class="stones">
					<div class="stones-container">
						<?php $stones = get_field("other_stones");
							foreach($stones as $stone){
								$featured_image_url = get_the_post_thumbnail_url($stone->ID);
								$title = get_the_title($stone->ID);
								$permalink = get_permalink($stone->ID);
								?>
								<div class="stone">
									<a href="<?php echo $permalink; ?>">
										<div class="img-container">
											<img src="<?php echo $featured_image_url; ?>" alt="">
										</div>
										<div class="stone-name">
											<p><?php echo $title; ?></p>
										</div>
									</a>
								</div>
							<?php }
						?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if(get_field("other_textures")){ ?>
		<div class="other-stones">
			<div class="other-stones-container">
				<h2>Other Available Textures</h2>
				<div class="stones">
					<div class="stones-container">
						<?php $stones = get_field("other_textures");
							foreach($stones as $stone){
								$featured_image_url = get_the_post_thumbnail_url($stone->ID);
								$title = get_the_title($stone->ID);
								$permalink = get_permalink($stone->ID);
								?>
								<div class="stone">
									<a href="<?php echo $permalink; ?>">
										<div class="img-container">
											<img src="<?php echo $featured_image_url; ?>" alt="">
										</div>
										<div class="stone-name">
											<p><?php echo $title; ?></p>
										</div>
									</a>
								</div>
							<?php }
						?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>


		<?php $compare = get_field("comparable_products"); ?>
		<?php if($compare){ ?>
			<div class="compare">
				<div class="compare-container">
					<h4>Compare</h4>
					<div class="cmp-products">
						<?php 
							foreach ($compare as $cmp) { 
								$product = wc_get_product($cmp->ID); ?>
							<div class="cmp-single-prod">
								<div class="img">
									<?php 
										$thumbnail_id = $product->get_image_id();
										$image_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail'); 
									?>
									<img src="<?php echo $image_url ?>" alt="<?php echo $product->get_name() ?>">
								</div>
								<div class="details">
									<p class="name">
										<?php echo $product->get_name(); ?>
									</p>
									<p class="price">
										<?php echo $product->get_price_html(); ?>
									</p>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>

		<!-- Custom Gallery Cursor -->
		<div id="custom-cursor">Gallery</div>
		<div class="close-zoomed">
			x
		</div>




		<script>
			$('.gallery-slider-container').slick({
				dots: false,
				infinite: false,
				arrow: true,
				slidesToShow: 5,
				slidesToScroll: 1,
				nextArrow: "<button class='slick-next'> <svg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 20 13'><path d='M6 15.417h15.744l-3.977-3.89L19.333 10 26 16.5 19.333 23l-1.566-1.527 3.977-3.89H6z' fill-rule='evenodd' fill='#fff'></path></svg></button>",
				prevArrow: "<button class='slick-prev'> <svg width='20' height='13' viewBox='0 0 20 13' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M20 7.583L4.256 7.583L8.233 11.473L6.667 13L0 6.5L6.667 0L8.233 1.527L4.256 5.417L20 5.417V7.583Z' fill='white'/></svg></button>",
				responsive: [
					{
					breakpoint: 991,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					}
					},
					{
					breakpoint: 576,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
					}
					// You can unslick at a given breakpoint now by adding:
					// settings: "unslick"
					// instead of a settings object
				]
			});



	    // Checks slider images count
		$(document).ready(function() {
            var slider = $('.your-slider-class');
            var totalSlides = $('.g-popup-img').length;

            // Update the counter and total slides on DOM load
            $('#count').text("1");
            $("#total-slides").text(totalSlides);

            // Handle the "Next" button click
            $('.slick-next').click(function() {
                var counter = parseInt($('#count').text());
                if (counter < totalSlides) {
                    $('#count').text(counter + 1);
                }
            });

            // Handle the "Previous" button click
            $('.slick-prev').click(function() {
                var counter = parseInt($('#count').text());
                if (counter > 1) {
                    $('#count').text(counter - 1);
                }
            });

        });


		$window = $(window);
		$slick_slider = $('.cmp-products');
		settings = {
			dots: false,
			slidesToShow: 2,
			speed: 500,
			arrows: false,
			responsive: [
				{
					breakpoint: 99999,
					settings: 'unslick'
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow: 2,
						slidesToScroll: 1,
						dots: true,
					}
				},
				{
					breakpoint: 639,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1,
						dots: true,
					}
				}
			],
		};
		$slick_slider.slick(settings);

		$window.on('resize', function() {
		if ($window.width() > 991) {
			if ($slick_slider.hasClass('slick-initialized'))
			$slick_slider.slick('unslick');
			return
		}
		if ( ! $slick_slider.hasClass('slick-initialized'))
			return $slick_slider.slick(settings);
		});

		$('.gallery-popup-inner').slick({
			dots: false,
			infinite: false,
			arrow: true,
			speed: 500,
			fade: true,
			cssEase: 'linear',
			slidesToShow: 1,
			slidesToScroll: 1,
		});

		$(document).ready(function() {
			var headerScroll = $(".header-scroll");
			var scrollThreshold = 0.2 * window.innerHeight;

			$(window).on("scroll", function() {
				if ($(this).scrollTop() >= scrollThreshold) {
					headerScroll.addClass("active");
				} else {
					headerScroll.removeClass("active");
				}
			});
		});

		$('.stones-container').slick({
			dots: false,
			infinite: false,
			arrow: true,
			slidesToShow: 6,
			nextArrow: "<button class='slick-next'> <svg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 20 13'><path d='M6 15.417h15.744l-3.977-3.89L19.333 10 26 16.5 19.333 23l-1.566-1.527 3.977-3.89H6z' fill-rule='evenodd' fill='#fff'></path></svg></button>",
			prevArrow: "<button class='slick-prev'> <svg width='20' height='13' viewBox='0 0 20 13' fill='none' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' clip-rule='evenodd' d='M20 7.583L4.256 7.583L8.233 11.473L6.667 13L0 6.5L6.667 0L8.233 1.527L4.256 5.417L20 5.417V7.583Z' fill='white'/></svg></button>",
			slidesToScroll: 1,
			responsive: [
				{
				breakpoint: 991,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 2
				}
				},
				{
				breakpoint: 576,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
				},
				{
				breakpoint: 400,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
				}
			]
		});

		// Faq section Accordion
		$(".right-col .faq .title").click(function(){
			if($(this).parent().hasClass('active')){
				$(this).parent().find(".subtext").slideUp();
				$(this).parent().find(".subtext").removeClass("active");
				$(this).parent().removeClass("active");	
				
			}else{
				$('.right-col .faq .subtext').slideUp();
				$('.right-col .faq').removeClass('active');

				$(this).siblings(".subtext").slideDown();
				$(this).siblings(".subtext").addClass("active");
				$(this).parent().addClass("active");
				
			}
			
		})

		// Popups 
		$(".p-full-img").click(function(){
			$(".gallery-popup").addClass("active");
		})


		$(".gallery-popup").click(function(){
			if($(".g-popup-img").hasClass(".slick-current")){
				let test = $(this).index();
			}
		})
		$(".banner").click(function(){
			$(".gallery-popup").addClass("active");
		})
		$(".g-popup-close").click(function(){
			$(".gallery-popup").removeClass("active");
		})
		$(".blurbs .single-blurb .image img").click(function(){
			$(".gallery-popup").addClass("active");
		})


		// Prevents popup to be opened when clicked on banner links
		$('.ban-link a').on('click', function(event) {
			event.stopPropagation(); // Prevent the click from bubbling up to the parent div and triggering the popup
			// Perform the redirection to the link's URL
			window.location.href = $(this).attr('href');
		});


		// Custom Cursor
		$(document).ready(function() {
		const customCursor = $('#custom-cursor');

		// Function to show the custom cursor and position it at the actual cursor
		function showCustomCursor(e) {
			customCursor.css({
			'display': 'block',
			'top': e.clientY + 'px',
			'left': e.clientX + 'px'
			});
		}

		// Function to hide the custom cursor
		function hideCustomCursor() {
			customCursor.css('display', 'none');
		}

		// Add event listeners for mouseenter and mouseleave on the banner div
		$('.banner').on('mouseenter', function() {
			$(document).on('mousemove', updateCustomCursorPosition);
		}).on('mouseleave', function() {
			hideCustomCursor();
			$(document).off('mousemove', updateCustomCursorPosition);
		});

		$('.zoomed-image').on('mouseenter', function() {
			$(document).on('mousemove', updateCustomCursorPosition);
		}).on('mouseleave', function() {
			hideCustomCursor();
			$(document).off('mousemove', updateCustomCursorPosition);
		});

		$('.g-img').on('mouseenter', function() {
			$(document).on('mousemove', updateCustomCursorPosition);
		}).on('mouseleave', function() {
			hideCustomCursor();
			$(document).off('mousemove', updateCustomCursorPosition);
		});

		$('.p-full-img').on('mouseenter', function() {
			$(document).on('mousemove', updateCustomCursorPosition);
		}).on('mouseleave', function() {
			hideCustomCursor();
			$(document).off('mousemove', updateCustomCursorPosition);
		});

		$('.blurbs .single-blurb .image img').on('mouseenter', function() {
			$(document).on('mousemove', updateCustomCursorPosition);
		}).on('mouseleave', function() {
			hideCustomCursor();
			$(document).off('mousemove', updateCustomCursorPosition);
		});


		$('.ban-link').on('mouseenter', function() {
			customCursor.css('display', 'none');
		});

		// Function to update the custom cursor position at each animation frame
		function updateCustomCursorPosition(e) {
			requestAnimationFrame(function() {
			showCustomCursor(e);
			});
		}
		});






		$(document).ready(function() {
			// Find the second image within the gallery popup
			let secondImage = $(".gallery-popup-inner .g-popup-img:eq(1) img").attr("src");
			$(".p-f-img").attr("src", secondImage);
		});



		$(".zoomed-image").click(function(){
			$(".product .images").addClass("active");
			$(".close-zoomed").addClass("active");
		})
		$(".close-zoomed").click(function(){
			$(this).removeClass("active");
			$(".product .images").removeClass("active");
		})

		$(".g-img").click(function(){
			$(".gallery-popup").addClass("active");
		})

		document.addEventListener('DOMContentLoaded', function () {
		const h1Element = document.querySelector('h1');
		const maxTranslateY = 90; // Maximum translation value in pixels

		// Function to handle the scroll event
		function handleScroll() {
			// Calculate the translateY value based on scroll position
			const scrollY = window.scrollY;
			var translateY = -scrollY / 5; // Adjust the divisor to control the speed of the animation

			// Limit the translateY value to the maximum value
			translateY = Math.min(translateY, maxTranslateY);

			// Apply the transform property to move the h1 element upwards
			h1Element.style.transform = `translateY(${translateY}px)`;
		}

		// Attach the scroll event listener to call the handleScroll function
		window.addEventListener('scroll', handleScroll);
		});

		</script>
	<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		  do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		// do_action( 'woocommerce_sidebar' );
	?>
	

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
