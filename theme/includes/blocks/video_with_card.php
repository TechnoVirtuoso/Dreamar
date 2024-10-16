<div class="video_with_card">
    <div class="video">
          <div class="video-wrapper">
            <video loop autoplay muted src="<?php echo $block["video"] ?>">
            </video>
            <div class="poster">
              <div class="content">
                <div class="title"><?php echo $block["video_title"] ?></div>
                <div class="sub_title"><?php echo $block["video_sub_title"] ?></div>
                <div class="discover">
                  Discover More ->
                </div>
              </div>
            </div>
            <div class="progress-bar">
                    <span class="inner-progress"></span>
                </div>
          </div>
    </div>
    <div class="card-panel">
        <div class="card">
          <img src="<?php echo $block["card_image"] ?>" alt="">
          <div class="title"><?php echo $block["card_title"] ?></div>
          <div class="desc"><?php echo $block["card_description"] ?></div>
          <div class="button">
              <a href="<?php echo $block["button"]["url"] ?>"><?php echo $block["button"]["title"] ?></a>
          </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      var video = $(".video_with_card .video-wrapper video")[0]; // Access the first video element
      var innerProgress = $('.video_with_card .inner-progress');

      // Listen to the 'timeupdate' event of the video to track progress
      video.addEventListener('timeupdate', function() {
          // Calculate the progress percentage
          var progress = (video.currentTime / video.duration) * 100;
          innerProgress.css('width', progress + '%');
      });
  });
</script>