<?php
if (!function_exists('newsphere_banner_trending_posts')):
  /**
   * Ticker Slider
   *
   * @since Newsphere 1.0.0
   *
   */
  function newsphere_banner_exclusive_posts()
  {

    if (false != newsphere_get_option('show_popular_tags_section')) : ?>
      <div class="aft-popular-tags">
        <div class="container-wrapper">
          <?php

          $show_popular_tags_title = newsphere_get_option('show_popular_tags_title');
          $select_popular_tags_mode = newsphere_get_option('select_popular_tags_mode');
          $number_of_popular_tags = newsphere_get_option('number_of_popular_tags');


          newsphere_list_popular_taxonomies($select_popular_tags_mode, $show_popular_tags_title, $number_of_popular_tags);


          ?>
        </div>
      </div>
    <?php endif; ?>
    <?php if (false != newsphere_get_option('show_flash_news_section')) :
      //$dir = '';
      //$em_ticker_news_mode = newsphere_get_option('select_flash_new_mode');
      $em_ticker_news_mode = 'aft-flash-slide left';
      $dir = 'left';
      if (is_rtl()) {
        $em_ticker_news_mode = 'aft-flash-slide right';
        $dir = 'right';
      }
    ?>
      <div class="banner-exclusive-posts-wrapper clearfix">

        <?php
        $category = newsphere_get_option('select_flash_news_category');
        $number_of_posts = newsphere_get_option('number_of_flash_news');
        $em_ticker_news_title = newsphere_get_option('flash_news_title');

        $all_posts = newsphere_get_posts($number_of_posts, $category);
        $show_trending = true;
        $count = 1;
        ?>

        <div class="container-wrapper">
          <div class="exclusive-posts">
            <div class="exclusive-now primary-color">
              <strong>
                <i class="fa fa-spin fa-circle-o-notch"></i>
                <?php if (!empty($em_ticker_news_title)): ?>
                  <span><?php echo esc_html($em_ticker_news_title); ?></span>
                <?php endif; ?>
              </strong>
            </div>
            <div class="exclusive-slides" dir="ltr">
              <?php
              if ($all_posts->have_posts()) : ?>
                <div class='marquee <?php echo esc_attr($em_ticker_news_mode); ?>' data-speed='80000'
                  data-gap='0' data-duplicated='true' data-direction="<?php echo esc_attr($dir); ?>">
                  <?php
                  while ($all_posts->have_posts()) : $all_posts->the_post();

                    $thumbnail_size = 'thumbnail';
                  ?>
                    <a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                      <?php if ($show_trending == true): ?>

                      <?php endif; ?>

                      <span class="circle-marq">
                        <span class="trending-no">
                          <?php echo sprintf(__('%s', 'newsphere'), $count); ?>
                        </span>
                        <?php if (has_post_thumbnail()):
                          the_post_thumbnail($thumbnail_size);
                        endif;
                        ?>
                      </span>

                      <?php the_title(); ?>
                    </a>
                <?php
                    $count++;
                  endwhile;
                endif;
                wp_reset_postdata();
                ?>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Excluive line END -->
<?php
    endif;
  }
endif;

add_action('newsphere_action_banner_exclusive_posts', 'newsphere_banner_exclusive_posts', 10);
