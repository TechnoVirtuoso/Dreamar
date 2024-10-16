<?php
  function get_blocks() {
    global $post;

    $fields = get_fields($post->ID);
    loop_blocks($fields);
  }

  function loop_blocks($blocks) {
    if (isset($blocks['blocks'])){
      if ($blocks['blocks']){
        foreach ($blocks['blocks'] as $key => $block) {
          switch ($block['acf_fc_layout']) {
            case 'global_block':
              if ($block['global_block']){
                $blocks = get_fields($block['global_block'][0]);
                loop_blocks($blocks);
              }
              break;
            case 'fullwidth_text':
              include 'blocks/fullwidth_text.php';
              break;
            case 'home_banner':
              include 'blocks/home_banner.php';
              break;
            case 'cta_block':
              include 'blocks/cta_block.php';
              break;
            case 'product_carousel_half':
              include 'blocks/product_carousel_half.php';
              break;
            case 'video_with_card':
              include 'blocks/video_with_card.php';
              break;
            case 'titles_section':
              include 'blocks/titles_section.php';
              break;
            case 'product_carousel':
              include 'blocks/product_carousel.php';
              break;
            case 'magazine':
              include 'blocks/magazine.php';
              break;
          }
        }
      }
    }
  }

?>