<?php

/**
 * List block part for displaying page content in page.php
 *
 * @package Newsphere
 */

?>

<div class="promotionspace enable-promotionspace">

  <?php if (is_active_sidebar('single-posts-advertisement-widgets')): ?>
    <div class="em-posts-promotions col col-ten">
      <?php dynamic_sidebar('single-posts-advertisement-widgets'); ?>
    </div>
  <?php endif; ?>
  <div class="af-reated-posts  col-ten">
    <?php
    global $post;
    $categories = get_the_category($post->ID);
    $related_section_title = esc_attr(newsphere_get_option('single_related_posts_title'));
    $number_of_related_posts = esc_attr(newsphere_get_option('single_number_of_related_posts'));

    if ($categories) {
      $cat_ids = array();
      foreach ($categories as $category) $cat_ids[] = $category->term_id;
      $args = array(
        'category__in' => $cat_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page' => $number_of_related_posts, // Number of related posts to display.
        'ignore_sticky_posts' => 1
      );
      $related_posts = new wp_query($args);

      if (!empty($related_posts)) { ?>
        <h2 class="widget-title header-after1">
          <span class="header-after">
            <?php echo esc_html($related_section_title);  ?>
          </span>
        </h2>
      <?php }
      ?>
      <div class="af-container-row clearfix">
        <?php
        while ($related_posts->have_posts()) {
          $related_posts->the_post();

          global $post;
          $aft_post_id = get_the_ID();
          $thumbnail_size = 'medium';
          if (!empty($url)) {
            $col_class = 'col-five';
          } else {
            $col_class = 'col-ten';
          }
        ?>
          <div class="col-3 float-l pad latest-posts-grid af-sec-post" data-mh="latest-posts-grid">
            <div class="read-single color-pad">
              <div class="read-img pos-rel read-bg-img">
                <a href="<?php echo esc_url(get_the_permalink($aft_post_id)); ?>" aria-label="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                  <?php if (has_post_thumbnail()):
                    the_post_thumbnail($thumbnail_size);
                  endif;
                  ?>
                </a>
                <span class="min-read-post-format">
                  <?php newsphere_post_format($aft_post_id); ?>
                  <?php newsphere_count_content_words($aft_post_id); ?>
                </span>

                <?php newsphere_get_comments_count($aft_post_id); ?>
              </div>
              <div class="read-details color-tp-pad no-color-pad">
                <div class="read-categories">
                  <?php newsphere_post_categories(); ?>
                </div>
                <div class="read-title">
                  <h3>
                    <a href="<?php echo esc_url(get_the_permalink($aft_post_id)); ?>"><?php echo esc_html(get_the_title($aft_post_id)); ?></a>
                  </h3>
                </div>
                <div class="entry-meta">
                  <?php newsphere_post_item_meta(); ?>
                </div>

              </div>
            </div>
          </div>
      <?php }
      }
      wp_reset_postdata();
      ?>
      </div>

  </div>
</div>