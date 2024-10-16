<?php 

?>
    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <a href="<?php echo get_site_url(); ?>"><img src="<?php echo get_field("footer_logo", "option"); ?>" alt=""></a>
            </div>
            <div class="footer-links">
                <div class="address">
                    <p><?php echo get_field("contact_details", "option"); ?></p>
                </div>
                <div class="c-links">
                    <p>Customer Care :</p>
                    <div class="c-links-container">
                        <?php foreach(get_field("customer_care_links", "option") as $links){ ?>
                            <a href="<?php echo $links['link']['url']; ?>"><?php echo $links['link']['title']; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="socials">
                <p>Follow Us</p>
                <div class="socials-container">
                    <?php foreach(get_field("social_links", "option") as $links){ ?>
                        <a href="<?php echo $links['link']; ?>">
                            <img src="<?php echo $links['icon']; ?>" alt="">
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="news-letter">
            <p class="nl-popup">Subscribe to our newsletter</p>
        </div>
    </footer>


    <section class="newsletter">
        <div class="newsletter-container">
            <h2>Be the first to know about new arrivals, special editions and exclusive collaborations.</h2>
            <h2 class="nl-popup">Subscribe to our newsletter</h2>
        </div>
    </section>
    <div class="newsletter-popup">
        <div class="nl-popup-container">
            <span class="popup-close" >x</span>
            <div class="nl-popup-inner">
                <h2>We promise not to bombard your inbox, but we will send you inspiring content related to the world of Salvatori and design in general.
                </h2>
                <?php echo gravity_form(1, true) ?>
            </div>
        </div>
    </div>
    <script>
        $(".nl-popup").click(function(){
            $(".newsletter-popup").addClass("active");
        })
        $(".popup-close").click(function(){
            $(".newsletter-popup").removeClass("active");
        })
    </script>
    </div><!-- closing all div -->
    

    <?php wp_footer(); ?>
	</body>
</html>
