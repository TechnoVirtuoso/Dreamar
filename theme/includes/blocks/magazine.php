<div class="magazine">
    <div class="content">
        <div class="title"><?php echo $block["title"] ?></div>
        <div class="desc"><?php echo $block["description"] ?></div>
        <div class="main_button">
            <a href="">123</a>
        </div>
    </div>
    <div class="carousel">
            
            <?php
                if (isset($block['carousel'][0]["background"])) {
                    echo '<div class="background" style="background-image: url(' . $block['carousel'][0]["background"] . ')"></div>';
                }
           ?>
            <div class="magazine-slider">
                <?php foreach($block['carousel'] as $slide){?>
                    <div class="magazine-slide-item">
                        <div class="info">
                            <div class="title"><?php echo $slide['title'] ?></div>
                            <div class="desc"><?php echo $slide['description'] ?></div>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="numbered-pagination">
                <div class="numbering">
                    <span class="current">1</span> /
                    <span class="all"><?php echo count($block['carousel']); ?></span> 
                </div>
                <div class="progress-bar">
                    <span class="inner-progress"></span>
                </div>
                <div class="actions">
                    <div class="left"><-</div>
                    <div class="right">-></div>
                </div>
            </div>
    </div>
</div>

<script>
    var tempArray = <?php echo json_encode($block['carousel']); ?>;
    jQuery(document).ready(() => {
            var slider = $('.magazine .carousel .magazine-slider');
            slider.slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                centerPadding: '150px',
                arrows: true,
                dots: false,
                centerMode: true,
                variableWidth: true,
                infinite: true,
                focusOnSelect: true,
                cssEase: 'linear',
                touchMove: true,
                prevArrow: $(".magazine .carousel .numbered-pagination .actions .left"),
                nextArrow: $(".magazine .carousel .numbered-pagination .actions .right"),
            });
            jQuery(".magazine .carousel .numbered-pagination .progress-bar .inner-progress")
                    .css("transform", `scaleX(${(1 / <?php echo count($block['carousel']); ?>)})`)
            
            slider.on('init reInit afterChange', function(event, slick, currentSlide, nextSlide){
                //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
                var i = (currentSlide ? currentSlide : 0) + 1;
                jQuery(".magazine .carousel .numbered-pagination .numbering .current")
                    .html(i);
                jQuery(".magazine .carousel .numbered-pagination .progress-bar .inner-progress")
                    .css("transform", `scaleX(${(i / slick.slideCount)})`)

                $(".magazine .carousel .background")
                    .css("background-image", `url('${tempArray[i - 1]["background"]}')`)
            });
    });
</script>