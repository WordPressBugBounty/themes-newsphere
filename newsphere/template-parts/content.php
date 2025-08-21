<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Newsphere
 */

?>


<?php if (is_singular()) : ?>
    <div class="color-pad">
        <div class="entry-content read-details color-tp-pad no-color-pad">
            <?php
            the_content(sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'newsphere'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )); ?>
            <?PHP if (is_single()): ?>
                <div class="post-item-metadata entry-meta">
                    <?php newsphere_post_item_tag(); ?>
                </div>
            <?php endif; ?>
            <?php
            the_post_navigation( array(
                'prev_text' => sprintf(
                    /* translators: %s: Title of the previous post. */
                    '<span class="em-post-navigation">%s</span> %s',
                    esc_html__( 'Previous', 'newsphere' ),
                    '%title'
                ),
                'next_text' => sprintf(
                    /* translators: %s: Title of the next post. */
                    '<span class="em-post-navigation">%s</span> %s',
                    esc_html__( 'Next', 'newsphere' ),
                    '%title'
                ),
                /* translators: Hidden heading for the post navigation section. */
                'screen_reader_text' => esc_html__( 'Post navigation', 'newsphere' ),
            ) );
            ?>
            <?php wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'newsphere'),
                'after' => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->
    </div>
<?php else:

 do_action('newsphere_action_archive_layout');

endif;
