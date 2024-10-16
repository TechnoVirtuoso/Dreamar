<div class="product_carousel">
    <div class="head">
        <div class="left">
            <div class="title"><?php echo $block["title"] ?></div>
            <div class="desc"><?php echo $block["description"] ?></div>
        </div>
        <div class="right">
            <a href="<?php echo $block["button"]["url"] ?>">
                <?php echo $block["button"]["title"] ?> ->
            </a>
        </div>
    </div>
    <div class="product_carousel_slider-wrapper">
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
</div>

<script>
    jQuery(document).ready(() => {
            var slider = jQuery('.product_carousel_slider-wrapper .slider');
            slider.slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: true,
                dots: false,
                infinite: true,
                focusOnSelect: true,
                cssEase: 'linear',
                touchMove: true,
                prevArrow:'<button class="slick-prev"> < </button>',
                nextArrow:'<button class="slick-next"> > </button>',
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 3,
                        }
                    }
                ]
            });
    });
</script>