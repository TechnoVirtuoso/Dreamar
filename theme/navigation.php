<?php 
    $contact = get_field("contact_us", "option");
    $login = get_field("login", "option");
    $cart = get_field("cart_page", "option");
    $normal_links = get_field("normal_links", "option");
?>

<header class = "header">
    <div class="header-container">
        <div class="header-top">
            <div class="header-top-left">
                <div class="location">
                    <p><?php echo get_field("location", "option"); ?></p>
                </div>
                <div class="language">
                    <p><?php echo get_field("language", "option"); ?></p>
                </div>
                <div class="contact-us">
                    <a href="<?php echo $contact['url']; ?>"><?php echo $contact['title']; ?></a>
                </div>
            </div>
            <div class="logo">
                <a class="logo-container" href = "#">
                    <img src="<?php echo get_field("logo", "option"); ?>" alt="">
                </a>
            </div>
            <div class="header-top-right">
                <div class="search">
                    <p><?php echo get_field("search", "option"); ?></p>
                </div>
                <div class="login">
                    <a href="<?php echo $login['url']; ?>"><?php echo $login['title']; ?></a>
                </div>
                <div class="cart">
                    <a href="<?php echo $cart['url']; ?>"><?php echo $cart['title']; ?></a>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="header-bottom-container">
                <?php foreach($normal_links as $links){ ?>
                    <div class="link">
                        <a href="<?php echo $links['links']['url']; ?>"><?php echo $links['links']['title']; ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<div class="nav-m">
  <span class="nav-m-close">
      <svg width="20" height="20" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"><g fill="#000" fill-rule="evenodd"><path d="M6.086 7.5L7.5 6.086 25.914 24.5 24.5 25.914z"></path><path d="M6.086 24.5L7.5 25.914 25.914 7.5 24.5 6.086z"></path></g></svg>
  </span>
  <div class="nav-m-container">
    <?php foreach($normal_links as $links){ ?>
      <div class="link-m">
        <a href="<?php echo $links['links']['url']; ?>"><?php echo $links['links']['title']; ?></a>
      </div>
    <?php } ?>
  </div>
</div>


<div class="header-m">
    <div class="header-m-container">
      <div class="menu">
          <svg width="20" height="20" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" class="menu-toggle__icon w-4 mr-1"><g fill="#000" fill-rule="evenodd"><path d="M26.25 7.75v1.5H5.75v-1.5zM26.25 15.25v1.5H5.75v-1.5zM26.25 22.25v1.5H5.75v-1.5z"></path></g></svg>
          Menu
       </div>
       <div class="header-m-logo">
          <a href = "#">
              <img src="<?php echo get_field("logo", "option"); ?>" alt="">
          </a>
       </div>
       <div class="header-m-r">
          <div class="search-m">
              <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="6.56 6.56 19.12 19.12" class="w-3 lg:w-2"><path d="M13.93 6.556a7.362 7.362 0 017.373 7.373c0 1.377-.424 2.74-1.175 3.912l-.18.267-.08.108 5.807 5.806-1.653 1.653-5.803-5.804-.105.08a7.126 7.126 0 01-3.508 1.32l-.35.025-.327.007a7.362 7.362 0 01-7.373-7.374 7.362 7.362 0 017.373-7.373zm-.152 2.222c-2.781 0-5 2.224-5 5s2.219 5 5 5 5-2.224 5-5-2.219-5-5-5z" fill="#000" fill-rule="evenodd"></path></svg>
          </div>
          <div class="cart">
            <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="4.5 6 23.01 20.75" class="w-3 lg:w-2 flex-shrink-0"><g fill="#000" fill-rule="evenodd"><path d="M23.594 11.25H8.406a2.75 2.75 0 00-2.731 2.433l-1.161 10a2.75 2.75 0 002.732 3.067h17.508l.177-.006a2.756 2.756 0 002.555-3.061l-1.16-10-.03-.186a2.757 2.757 0 00-2.702-2.247zm-15.188 1.5h15.188a1.25 1.25 0 011.226 1.007l.02.128 1.156 9.97a1.25 1.25 0 01-1.147 1.392l-.122.004-17.481-.001a1.25 1.25 0 01-1.242-1.394l1.16-10a1.25 1.25 0 011.242-1.106z"></path><path d="M16.24 6a.73.73 0 01.333.08C18.525 6.479 20 8.28 20 10.444v3.76l-.001.043c-.022.42-.354.754-.76.754-.42 0-.76-.357-.76-.797v-3.76l-.002-.07c-.033-1.456-1.11-2.642-2.476-2.767-1.368.125-2.445 1.31-2.478 2.767l-.001.07v3.76c0 .44-.34.797-.761.797-.406 0-.738-.334-.76-.754L12 14.203v-3.76c0-2.163 1.475-3.965 3.428-4.362A.718.718 0 0115.76 6c.08 0 .16.002.24.007.079-.005.158-.007.238-.007z"></path></g></svg>
          </div>
       </div>
    </div>
</div>
<script>

    $(function() {
        $(window).on("scroll", function() {
            if($(window).scrollTop() < 450) {
                $(".header").addClass("active");
            } else {
            $(".header").removeClass("active");
            }
        });
    });


    $(".menu").click(function(){
      $(".nav-m").addClass("active");
    })
    $(".nav-m-close").click(function(){
      $(".nav-m").removeClass("active");
    })



</script>