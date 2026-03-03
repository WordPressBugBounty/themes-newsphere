<?php

/**
 * Option Panel
 *
 * @package Newsphere
 */

$default = newsphere_get_default_theme_options();
/*theme option panel info*/
require get_template_directory() . '/inc/customizer/frontpage-options.php';

// Add Theme Options Panel.
$wp_customize->add_panel('theme_option_panel',
    array(
        'title' => __('Theme Options', 'newsphere'),
        'priority' => 200,
        'capability' => 'edit_theme_options',
    )
);


// Preloader Section.
$wp_customize->add_section('site_preloader_settings',
    array(
        'title' => __('Preloader Options', 'newsphere'),
        'priority' => 4,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - preloader.
$wp_customize->add_setting('enable_site_preloader',
    array(
        'default' => $default['enable_site_preloader'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('enable_site_preloader',
    array(
        'label' => __('Enable preloader', 'newsphere'),
        'section' => 'site_preloader_settings',
        'type' => 'checkbox',
        'priority' => 10,
    )
);


/**
 * Header section
 *
 * @package Newsphere
 */

// Frontpage Section.
$wp_customize->add_section('header_options_settings',
    array(
        'title' => __('Header Options', 'newsphere'),
        'priority' => 49,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('show_date_section',
    array(
        'default' => $default['show_date_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);
$wp_customize->add_control('show_date_section',
    array(
        'label' => __('Show date on top header', 'newsphere'),
        'section' => 'header_options_settings',
        'type' => 'checkbox',
        'priority' => 10,
        //'active_callback' => 'newsphere_top_header_status'
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('show_social_menu_section',
    array(
        'default' => $default['show_social_menu_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_social_menu_section',
    array(
        'label' => __('Show social menu on top header', 'newsphere'),
        'section' => 'header_options_settings',
        'type' => 'checkbox',
        'priority' => 11,
        //'active_callback' => 'newsphere_top_header_status'
    )
);


// Setting - breadcrumb.
$wp_customize->add_setting('enable_breadcrumb',
    array(
        'default' => $default['enable_breadcrumb'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('enable_breadcrumb',
    array(
        'label' => __('Show breadcrumbs', 'newsphere'),
        'section' => 'site_layout_settings',
        'type' => 'checkbox',
        'priority' => 10,
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('select_breadcrumb_mode',
    array(
        'default'           => $default['select_breadcrumb_mode'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control( 'select_breadcrumb_mode',
    array(
        'label'       => __('Select Breadcrumbs', 'newsphere'),
        'description' => __("Please ensure that you have enabled the plugin's breadcrumbs before choosing other than Default", 'newsphere'),
        'section'     => 'site_layout_settings',
        'type'        => 'select',
        'choices'               => array(
            'default' => __( 'Default', 'newsphere' ),
            'yoast' => __( 'Yoast SEO', 'newsphere' ),
            'rankmath' => __( 'Rank Math', 'newsphere' ),
            'bcn' => __( 'NavXT', 'newsphere' ),
        ),
        'priority'    => 10,
        'active_callback' => 'newsphere_enable_breadcrumb_status'
    ));


/**
 * Sidebar options section
 *
 * @package newsphere
 */

// Sidebar Section.
$wp_customize->add_section('site_sidebar_settings',
    array(
        'title'      => __('Sidebar Settings', 'newsphere'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - frontpage_sticky_sidebar.
$wp_customize->add_setting('frontpage_sticky_sidebar',
    array(
        'default' => $default['frontpage_sticky_sidebar'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('frontpage_sticky_sidebar',
    array(
        'label' => __('Enable Sticky Sidebar', 'newsphere'),
        'section' => 'site_sidebar_settings',
        'type' => 'checkbox',
        'priority' => 11,
        'active_callback' => 'newsphere_frontpage_content_alignment_status'
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('frontpage_sticky_sidebar_position',
    array(
        'default'           => $default['frontpage_sticky_sidebar_position'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control( 'frontpage_sticky_sidebar_position',
    array(
        'label'       => __('Sidebar Sticky Position', 'newsphere'),
        'section'     => 'site_sidebar_settings',
        'type'        => 'select',
        'choices'               => array(
            'sidebar-sticky-top' => __( 'Top', 'newsphere' ),
            'sidebar-sticky-bottom' => __( 'Bottom', 'newsphere' ),
        ),
        'priority'    => 130,
        'active_callback' => 'newsphere_frontpage_sticky_sidebar_status'
    ));




/**
 * Layout options section
 *
 * @package Newsphere
 */

// Layout Section.
$wp_customize->add_section('site_layout_settings',
    array(
        'title' => __('Global Settings', 'newsphere'),
        'priority' => 9,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - sticky_header_option.
$wp_customize->add_setting('aft_language_switcher',
    array(
        'default' => $default['aft_language_switcher'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('aft_language_switcher',
    array(
        'label' => __('Language Switcher Shortcode', 'newsphere'),
        'section' => 'header_options_settings',
        'type' => 'text',
        'priority' => 130,
        //'active_callback' => 'newsphere_header_layout_status'
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('global_content_alignment',
    array(
        'default' => $default['global_content_alignment'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_content_alignment',
    array(
        'label' => __('Global Content Alignment', 'newsphere'),
        'section' => 'site_layout_settings',
        'type' => 'select',
        'choices' => array(
            'align-content-left' => __('Content - Primary sidebar', 'newsphere'),
            'align-content-right' => __('Primary sidebar - Content', 'newsphere'),
            'full-width-content' => __('Full width content', 'newsphere')
        ),
        'priority' => 130,
    ));

// Setting - global content alignment of news.
$wp_customize->add_setting('global_show_categories',
    array(
        'default' => $default['global_show_categories'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_show_categories',
    array(
        'label' => __('Post Categories', 'newsphere'),
        'section' => 'site_layout_settings',
        'type' => 'select',
        'choices' => array(
            'yes' => __('Show', 'newsphere'),
            'no' => __('Hide', 'newsphere'),

        ),
        'priority' => 130,
    ));


//========== comment count options ===============

// Global Section.
$wp_customize->add_section('site_comment_count_settings',
    array(
        'title' => __('Comment Count', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('global_show_comment_count',
    array(
        'default' => $default['global_show_comment_count'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_show_comment_count',
    array(
        'label' => __('Comment Count', 'newsphere'),
        'section' => 'site_comment_count_settings',
        'type' => 'select',
        'choices' => array(
            'yes' => __('Show', 'newsphere'),
            'no' => __('Hide', 'newsphere'),

        ),
        'priority' => 130,
    ));


// Setting - sticky_header_option.
$wp_customize->add_setting('global_hide_comment_count_in_list',
    array(
        'default' => $default['global_hide_comment_count_in_list'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);
$wp_customize->add_control('global_hide_comment_count_in_list',
    array(
        'label' => __('Hide Comment Count in List', 'newsphere'),
        'section' => 'site_comment_count_settings',
        'type' => 'checkbox',
        'priority' => 130,
        'active_callback' => 'newsphere_global_show_comment_count_status'
    )
);


//========== minutes read count options ===============

// Global Section.
$wp_customize->add_section('site_min_read_settings',
    array(
        'title' => __('Minutes Read Count', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('global_show_min_read',
    array(
        'default' => $default['global_show_min_read'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_show_min_read',
    array(
        'label' => __('Minutes Read Count', 'newsphere'),
        'section' => 'site_min_read_settings',
        'type' => 'select',
        'choices' => array(
            'yes' => __('Show', 'newsphere'),
            'no' => __('Hide', 'newsphere'),

        ),
        'priority' => 130,
    ));

// Setting - sticky_header_option.
$wp_customize->add_setting('global_show_min_read_number',
    array(
        'default' => $default['global_show_min_read_number'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control('global_show_min_read_number',
    array(
        'label' => __('Number of Words per Minute Read', 'newsphere'),
        'section' => 'site_min_read_settings',
        'type' => 'number',
        'priority' => 130,
        'active_callback' => 'newsphere_global_show_minutes_count_status'
    )
);

// Setting - sticky_header_option.
$wp_customize->add_setting('global_hide_min_read_in_list',
    array(
        'default' => $default['global_hide_min_read_in_list'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);
$wp_customize->add_control('global_hide_min_read_in_list',
    array(
        'label' => __('Hide Minutes Read Count in List', 'newsphere'),
        'section' => 'site_min_read_settings',
        'type' => 'checkbox',
        'priority' => 130,
        'active_callback' => 'newsphere_global_show_minutes_count_status'
    )
);


//========== date and author options ===============

// Global Section.
$wp_customize->add_section('site_post_date_author_settings',
    array(
        'title' => __('Date and Author', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('global_post_date_author_setting',
    array(
        'default' => $default['global_post_date_author_setting'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);


$wp_customize->add_control('global_post_date_author_setting',
    array(
        'label' => __('Date and Author', 'newsphere'),
        'section' => 'site_post_date_author_settings',
        'type' => 'select',
        'choices' => array(
            'show-date-author' => __('Show Date and Author', 'newsphere'),
            'show-date-only' => __('Show Date Only', 'newsphere'),
            'show-author-only' => __('Show Author Only', 'newsphere'),
            'hide-date-author' => __('Hide All', 'newsphere'),
        ),
        'priority' => 130,
    ));


// Setting - sticky_header_option.
$wp_customize->add_setting('global_hide_post_date_author_in_list',
    array(
        'default' => $default['global_hide_post_date_author_in_list'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);
$wp_customize->add_control('global_hide_post_date_author_in_list',
    array(
        'label' => __('Hide Date and Author in List', 'newsphere'),
        'section' => 'site_post_date_author_settings',
        'type' => 'checkbox',
        'priority' => 130,
        'active_callback' => 'newsphere_display_date_author_status'
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('global_date_display_setting',
    array(
        'default' => $default['global_date_display_setting'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_date_display_setting',
    array(
        'label' => __('Date Format', 'newsphere'),
        'section' => 'site_post_date_author_settings',
        'type' => 'select',
        'choices' => array(
            'theme-date' => __('Date Format by Theme', 'newsphere'),
            'default-date' => __('WordPress Default Date Format', 'newsphere'),

        ),
        'priority' => 130,
        'active_callback' => 'newsphere_display_date_status'
    ));

// Setting - global content alignment of news.
$wp_customize->add_setting('global_widget_excerpt_setting',
    array(
        'default' => $default['global_widget_excerpt_setting'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('global_widget_excerpt_setting',
    array(
        'label' => __('Widget Excerpt Mode', 'newsphere'),
        'section' => 'site_layout_settings',
        'type' => 'select',
        'choices' => array(
            'trimmed-content' => __('Trimmed Content', 'newsphere'),
            'default-excerpt' => __('Default Excerpt', 'newsphere'),

        ),
        'priority' => 130,
    ));



//========== single posts options ===============

// Single Section.
$wp_customize->add_section('site_single_posts_settings',
    array(
        'title' => __('Single Post', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - related posts.
$wp_customize->add_setting('single_show_featured_image',
    array(
        'default' => $default['single_show_featured_image'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('single_show_featured_image',
    array(
        'label' => __('Show on featured image', 'newsphere'),
        'section' => 'site_single_posts_settings',
        'type' => 'checkbox',
        'priority' => 100,
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('global_single_content_mode',
    array(
        'default'           => $default['global_single_content_mode'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control( 'global_single_content_mode',
    array(
        'label'       => __('Single Content mode', 'newsphere'),
        'description' => __('Select global single content mode', 'newsphere'),
        'section'     => 'site_single_posts_settings',
        'type'        => 'select',
        'choices'               => array(
            'single-content-mode-default' => __( 'Wide - Default', 'newsphere' ),
            'single-content-mode-boxed' => __( 'Boxed', 'newsphere' ),
        ),
        'priority'    => 130,
    ));


//========== related posts  options ===============

// Single Section.
$wp_customize->add_section('site_single_related_posts_settings',
    array(
        'title' => __('Related Posts', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - related posts.
$wp_customize->add_setting('single_show_related_posts',
    array(
        'default' => $default['single_show_related_posts'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('single_show_related_posts',
    array(
        'label' => __('Show on single posts', 'newsphere'),
        'section' => 'site_single_related_posts_settings',
        'type' => 'checkbox',
        'priority' => 100,
    )
);

// Setting - related posts.
$wp_customize->add_setting('single_related_posts_title',
    array(
        'default' => $default['single_related_posts_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('single_related_posts_title',
    array(
        'label' => __('Title', 'newsphere'),
        'section' => 'site_single_related_posts_settings',
        'type' => 'text',
        'priority' => 100,
        'active_callback' => 'newsphere_related_posts_status'
    )
);



/**
 * Archive options section
 *
 * @package Newsphere
 */

// Archive Section.
$wp_customize->add_section('site_archive_settings',
    array(
        'title' => __('Archive Settings', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - archive content view of news.
$wp_customize->add_setting('archive_image_alignment_list',
    array(
        'default' => $default['archive_image_alignment_list'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_select',
    )
);

$wp_customize->add_control('archive_image_alignment_list',
    array(
        'label' => __('Image alignment', 'newsphere'),
        'description' => __('Select image alignment for archive', 'newsphere'),
        'section' => 'site_archive_settings',
        'type' => 'select',
        'choices' => array(
            'archive-image-left' => __('Left', 'newsphere'),
            'archive-image-right' => __('Right', 'newsphere'),
            'archive-image-alternate' => __('Alternate', 'newsphere'),
        ),
        'priority' => 130,
        //'active_callback' => 'newsphere_archive_image_status'
    ));

//========== footer latest blog carousel options ===============

// Footer Section.
$wp_customize->add_section('frontpage_latest_posts_settings',
    array(
        'title' => __('You May Have Missed', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);
// Setting - latest blog carousel.
$wp_customize->add_setting('frontpage_show_latest_posts',
    array(
        'default' => $default['frontpage_show_latest_posts'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsphere_sanitize_checkbox',
    )
);

$wp_customize->add_control('frontpage_show_latest_posts',
    array(
        'label' => __('Show Latest Posts Section above Footer', 'newsphere'),
        'section' => 'frontpage_latest_posts_settings',
        'type' => 'checkbox',
        'priority' => 100,
    )
);


// Setting - featured_news_section_title.
$wp_customize->add_setting('frontpage_latest_posts_section_title',
    array(
        'default' => $default['frontpage_latest_posts_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control('frontpage_latest_posts_section_title',
    array(
        'label' => __('Posts Section Title', 'newsphere'),
        'section' => 'frontpage_latest_posts_settings',
        'type' => 'text',
        'priority' => 100,
        'active_callback' => 'newsphere_latest_news_section_status'

    )
);




//========== footer section options ===============
// Footer Section.
$wp_customize->add_section('site_footer_settings',
    array(
        'title' => __('Footer', 'newsphere'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('footer_copyright_text',
    array(
        'default' => $default['footer_copyright_text'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('footer_copyright_text',
    array(
        'label' => __('Copyright Text', 'newsphere'),
        'section' => 'site_footer_settings',
        'type' => 'text',
        'priority' => 100,
    )
);


