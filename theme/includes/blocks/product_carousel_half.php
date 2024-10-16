<div class="product_carousel_half">
    <div class="product_carousel_half-wrapper">
        <div class="main" style="background-image: url('<?php echo $block["main_image"] ?>')"></div>
        <div class="half-slider">
            <div class="slider-header">
                <div class="heading"><?php echo $block["heading"] ?></div>
                <div class="sub-heading"><?php echo $block["sub_heading"] ?></div>
            </div>
            <div class="product_carousel_half_slider-wrapper">
                <div class="slider">
                    <?php foreach($block['products'] as $product){?>
                        <div class="slide-item">
                            <img src="<?php echo $product['image'] ?>" alt="">
                            <div class="info">
                                <div class="name"><?php echo $product['name'] ?></div>
                                <div class="price"><?php echo $product['price'] ?></div>
                                <div class="sub-heading"><?php echo $product['sub_heading'] ?></div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
            <div class="numbered-pagination">
                <div class="numbering">
                    <span class="current">1</span> /
                    <span class="all"><?php echo count($block['products']); ?></span> 
                </div>
                <div class="progress-bar">
                    <span class="inner-progress"></span>
                </div>
            </div>
            <div class="slider-button main_button">
                <a href="">Discover our full range of products</a>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(() => {
            var slider = jQuery('.product_carousel_half_slider-wrapper .slider');
            var elementWidth = $(".product_carousel_half_slider-wrapper").first().width();
            slider.css("max-width", `${elementWidth}px`);
            slider.slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                centerPadding: '100px',
                arrows: true,
                dots: false,
                centerMode: true,
                variableWidth: true,
                infinite: true,
                focusOnSelect: true,
                cssEase: 'linear',
                touchMove: true,
                prevArrow:'<button class="slick-prev"> < </button>',
                nextArrow:'<button class="slick-next"> > </button>',
            });

            jQuery(".product_carousel_half-wrapper .numbered-pagination .progress-bar .inner-progress")
                    .css("width", `${(1 / <?php echo count($block['products']); ?>) * 100}%`)
            
            slider.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
                //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
                var i = (currentSlide ? currentSlide : 0) + 1;
                jQuery(".product_carousel_half-wrapper .numbered-pagination .numbering .current")
                    .html(i);
                jQuery(".product_carousel_half-wrapper .numbered-pagination .progress-bar .inner-progress")
                    .css("width", `${(i / slick.slideCount) * 100}%`)
            });
    });
</script>