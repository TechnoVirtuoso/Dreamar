<div class="home-banner">
    <div class="inner">
        <div class="home-slider-wrap">
            <?php foreach($block['images'] as $image){?>
                <div class="slide-item">
                    <img src="<?php echo $image['image']['url']?>" alt="">
                </div>
            <?php }?>
        </div>
        <div class="slider-bottom-bar">
            <div class="text-wrap">
                <div class="heading"><?php echo $block['heading']; ?></div>
                <div class="sub-heading"><?php echo $block['subheading']?></div>
            </div>
            <div class="slider-controls">
                <div class="numbered-pagination">1 / <?php echo count($block['images']);?></div>
                <div class="progress-bar">
                    <span class="inner-progress"></span>
                </div>
                <div class="arrow-pagination"></div>
            </div>
        </div>
    </div>
</div>

<script>
    var time = 3000;
    var slider = jQuery('.home-slider-wrap');
    jQuery(document).ready(function(){
        slider.slick({
            slidesPerShow: 1,
            slidesPerScroll:1,
            arrows:true,
            fade:true,
            pauseOnHover:false,
            autoplay:true,
            autoplaySpeed:time,
            appendArrows: jQuery('.slider-bottom-bar .arrow-pagination'),
            prevArrow: "<button class='dr-arrow dr-prev'><svg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 20 13'><path d='M6 15.417h15.744l-3.977-3.89L19.333 10 26 16.5 19.333 23l-1.566-1.527 3.977-3.89H6z' fill-rule='evenodd' fill='white'></path></svg></button>",
            nextArrow: "<button class='dr-arrow dr-next'><svg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 20 13'><path d='M6 15.417h15.744l-3.977-3.89L19.333 10 26 16.5 19.333 23l-1.566-1.527 3.977-3.89H6z' fill-rule='evenodd' fill='white'></path></svg></button>",
        })
        slider.on('beforeChange', function(e,slick){
            progressBar();
        })
        progressBar();
        function progressBar(){
            jQuery('.slider-controls .progress-bar .inner-progress').removeAttr('style').removeClass('active');
            setTimeout(function(){
                jQuery('.slider-controls .progress-bar .inner-progress').css('transition-duration', (time/1000) + 's').addClass('active');
            }, 100)
        }
        slider.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            jQuery(".slider-controls .numbered-pagination").html('<span>'+ i + '</span> / <span>' + slick.slideCount + '</span>' );
        });
    });
    
</script>