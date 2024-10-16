<div class="titles_section">
    <div class="slider">
        <?php foreach($block['titles'] as $title){?>
            <div class="slide-item">
                <div class="poster" style="background-image: url('<?php echo $title['background'] ?>')">
                    <div class="content">
                        <div class="title"><?php echo $title['title'] ?></div>
                        <a href="<?php echo $title['button']["url"] ?>" class="link"><?php echo $title["button"]['title'] ?> -></a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

<script>
    jQuery(document).ready(() => {
        $('.titles_section .slider').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: true,
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
                        slidesToShow: 2,
                    }
                }
            ]
        });
    })
</script>