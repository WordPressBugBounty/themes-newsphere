<?php
defined('ABSPATH') or die('No script kiddies please!'); // prevent direct access
if (!class_exists('AF_themes_info')) {
  class AF_themes_info
  {
    /**
     * Version
     *
     * @var string $version Class version.
     *
     * @since 1.0.0
     */
    private $version = '1.0.1';
    const templatespare_old_version = '2.3.0';

    /**
     * Theme name.
     *
     * @var string $theme_name Theme name.
     *
     * @since 1.0.0
     */
    private $theme_name;

    private $current_user_name;
    private $theme_version;
    private $menu_name;
    private $page_name;
    private $page_slug;

    /**
     * Theme slug.
     *
     * @var string $theme_slug Theme slug.
     *
     * @since 1.0.0
     */
    private $theme_slug;

    function __construct()
    {
      $theme = wp_get_theme();
      $this->theme_name = $theme->get('Name');
      $this->theme_version = $theme->get('Version');
      $this->theme_slug    = $theme->get_template();
      $this->menu_name     = isset($this->config['menu_name']) ? $this->config['menu_name'] : $this->theme_name;
      $this->page_name     = isset($this->config['page_name']) ? $this->config['page_name'] : $this->theme_name;
      $this->page_slug     = $this->theme_slug;
      add_action('admin_menu', array($this, 'newsphere_register_info_page'));
      add_action('admin_enqueue_scripts', array($this, 'newsphere_register_backend_scripts'));
      add_action('init', array($this, 'newsphere_load_files'));
      add_filter('admin_body_class', array($this, 'newsphere_body_classes'));
      add_action('admin_head', array($this, 'newsphere_make_upgrade_link_external'));

      $current_user = wp_get_current_user();
      $this->current_user_name = $current_user->user_login;
    }


    function newsphere_make_upgrade_link_external() {
      ?>
      <script type="text/javascript">
        jQuery(document).ready( function($) {   
            $('#aft-upgrade-menu-item').parent().attr('target','_blank');               
        });
    </script>
      <?php
  }

    function newsphere_body_classes($classes)
    {
      $classes = explode(' ', $classes);
      $classes = array_merge($classes, [
        'aft-admin-dashboard-notice'
      ]);
      if (is_admin() && isset($_GET['page'])) {

        $page = sanitize_text_field($_GET['page']);
        if ($page === 'aft-block-patterns' || $page === 'aft-template-kits' || $page === $this->theme_slug || $page === 'explore-more') {

          $classes = array_merge($classes, [
            'aft-theme-admin-menu-dashboard'
          ]);
        }
      }
      return implode(' ', array_unique($classes));
    }
    public function newsphere_register_info_page()
    {

      //Add info page.

      $starter_template_slug = 'aft-block-patterns';
      $template_kits_slug = 'aft-template-kits';
      $starter_sites_order = 2;
      $afthemes_icon = 'data:image/svg+xml;base64,CgkJCTxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCgkJCXdpZHRoPSI0MDUuMDAwMDAwcHQiIGhlaWdodD0iNDAyLjAwMDAwMHB0IiB2aWV3Qm94PSIwIDAgNDA1LjAwMDAwMCA0MDIuMDAwMDAwIgoJCQlwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWlkWU1pZCBtZWV0Ij4KCQkgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCw0MDIuMDAwMDAwKSBzY2FsZSgwLjEwMDAwMCwtMC4xMDAwMDApIgoJCSAgIGZpbGw9IiMwMDAwMDAiIHN0cm9rZT0ibm9uZSI+CgkJICAgPHBhdGggZD0iTTE4MDggMzc3NSBjLTMzMiAtNDUgLTY1MSAtMTg4IC05MTcgLTQxMCAtMjkyIC0yNDMgLTUxMSAtNjEwIC01OTAKCQkgICAtOTkwIC0zNiAtMTcxIC01MSAtNDAwIC0zMyAtNDk5IGw3IC0zOCA2MCA4OCBjMTEwIDE2MyAyMjQgMjY4IDM3OCAzNDkgMjcxCgkJICAgMTQzIDU5OCAxNDkgODgwIDE3IDExOSAtNTYgMTk5IC0xMTMgMjkyIC0yMDYgMTIzIC0xMjQgMjA3IC0yNzEgMjU3IC00NTQgMjEKCQkgICAtNzQgMjIgLTEwNCAyNyAtNjc3IDYgLTY0NCA1IC02MzAgNTcgLTY3NiA1NSAtNDggMTY0IC02NSAyMjIgLTM1IDM3IDE5IDc4CgkJICAgNjUgOTMgMTAxIDggMjMgMTEgMzM1IDkgMTI2MSAtMSAxMTE2IDAgMTIzNyAxNSAxMjk1IDc2IDI5MiAzNzAgNDYwIDY2NCAzNzkKCQkgICA0MCAtMTIgNzYgLTE4IDgwIC0xNCAxMSAxMiAtMTUyIDE1NSAtMjU4IDIyNiAtMTcxIDExNCAtMzM5IDE4OSAtNTQ2IDI0MwoJCSAgIC0yMDUgNTMgLTQ4MyA2OSAtNjk3IDQweiIvPgoJCSAgIDxwYXRoIGQ9Ik0yOTQ1IDI5NjQgYy00NSAtMjMgLTc2IC01NSAtOTYgLTk5IC0xNyAtMzcgLTE5IC03NiAtMTkgLTU4MiBsMAoJCSAgIC01NDMgMjM1IDAgYzI1NiAwIDI3MiAtMyAzMTQgLTU2IDI4IC0zNiA0MyAtOTYgMzUgLTE0MSAtOSAtNDcgLTY2IC0xMTAgLTExMgoJCSAgIC0xMjMgLTIxIC01IC0xMzMgLTEwIC0yNDkgLTEwIGwtMjEzIDAgMCAtNTA1IDAgLTUwNSA1OCAyOSBjMzIgMTYgOTkgNTYgMTQ4CgkJICAgOTAgNDE4IDI3OSA2OTMgNzQ2IDc1NSAxMjgxIDI1IDIyMiAtMiA1MTcgLTY3IDcxNCAtNDYgMTM5IC0xNDQgMzQ2IC0xNjUgMzQ2CgkJICAgLTQgMCAtMyAtMTcgMiAtMzcgNSAtMjEgOSAtNjUgOSAtOTkgMCAtNTcgLTIgLTYzIC0zNyAtOTcgLTQ0IC00NSAtOTYgLTYxCgkJICAgLTE1MyAtNDggLTg4IDIwIC0xMTkgNjEgLTE1MSAxOTkgLTE3IDc4IC0yNyAxMDEgLTU3IDEzNCAtMTkgMjIgLTQ4IDQ2IC02MwoJCSAgIDU0IC0zNyAxOSAtMTM2IDE4IC0xNzQgLTJ6Ii8+CgkJICAgPHBhdGggZD0iTTEwOTAgMjA1OSBjLTIzMyAtMjMgLTQ0OSAtMTgxIC01NDEgLTM5NyAtNTEgLTExNyAtNjYgLTMxNCAtMzQKCQkgICAtNDM3IDQ5IC0xOTEgMTgyIC0zNTUgMzU1IC00MzggMTEyIC01NCAxNzggLTY5IDMwNCAtNjggMjcyIDAgNTAwIDE0NCA2MTEKCQkgICAzODYgNDcgMTAxIDYwIDE2NSA2MCAyOTAgLTEgMTg3IC02NCAzNDIgLTE5MCA0NzAgLTE0NyAxNTAgLTM0MSAyMTYgLTU2NSAxOTR6Ii8+CgkJICAgPHBhdGggZD0iTTE3ODEgNjAwIGMtMTE5IC04OSAtMjQ3IC0xNDggLTQxNSAtMTkwIGwtMTA5IC0yNyA2OSAtMzIgYzIwMCAtOTQKCQkgICA1NDQgLTE3NSA1NDQgLTEyOSAwIDIxIC0zMSA0MDMgLTMzIDQxMSAtMSA0IC0yNiAtMTEgLTU2IC0zM3oiLz4KCQkgICA8L2c+CgkJICAgPC9zdmc+Cg==';

      add_menu_page(
        $this->menu_name, // Page Title.
        $this->menu_name, // Menu Title.
        'edit_posts', // Capability.
        'newsphere', // Menu slug.
        array($this, 'newsphere_render_page'), // Action.
        $afthemes_icon,
        30
      );

      // Our getting started page.
      add_submenu_page(
        'newsphere', // Parent slug.
        __('Dashboard', 'newsphere'), // Page title.
        __('Dashboard', 'newsphere'), // Menu title.
        'manage_options', // Capability.
        'newsphere', // Menu slug.
        array($this, 'newsphere_render_page'), // Callback function.
        // $get_started_order
      );


      // Our getting started page.
      add_submenu_page(
        'newsphere', // Parent slug.
        __('Customize', 'newsphere'), // Page title.
        __('Customize', 'newsphere'), // Menu title.
        'manage_options', // Capability.
        'customize.php'
        //[$this,'newsphere_customize_link'] // Callback function.

      );


      // Our getting started page.
      add_submenu_page(
        'newsphere', // Parent slug.
        __('Starter Sites', 'newsphere'), // Page title.
        __('Starter Sites', 'newsphere'), // Menu title.
        'manage_options', // Capability.
        'starter-sites', // Menu slug.
        array($this, 'newsphere_render_starter_sites'), // Callback function.
        // $starter_sites_order
      );

      add_submenu_page(
        'newsphere', // Parent slug.
        __('Elementor Kits', 'newsphere'), // Page title.
        __('Elementor Kits', 'newsphere'), // Menu title.
        'manage_options', // Capability.
        $template_kits_slug, // Menu slug.
        array($this, 'newsphere_render_templates_kits'), // Callback function.
        // $starter_sites_order
      );

      add_submenu_page(
        'newsphere', // Parent slug.
        __('Block Patterns', 'newsphere'), // Page title.
        __('Block Patterns', 'newsphere'), // Menu title.
        'manage_options', // Capability.
        $starter_template_slug, // Menu slug.
        array($this, 'newsphere_render_starter_templates'), // Callback function.
        // $starter_sites_order
      );
     


      // Our getting started page.
      add_submenu_page(
        'newsphere', // Parent slug.
        __('Upgrade to Pro', 'newsphere'), // Page title.
        '<span id="aft-upgrade-menu-item">' . __('Upgrade Now', 'newsphere') . '</span>', // Menu title.
        'manage_options', // Capability.
        esc_url('https://afthemes.com/products/newsphere-pro/') // Menu slug.

      );
    }

    public function newsphere_render_page()
    { ?>
      <div id="af-theme-dashboard"></div>
      <?php }

    public function newsphere_render_starter_sites()
    {

      $newsphere_templatespare_installed = newsphere_get_plugin_file('templatespare');
      $newsphere_templatespare_verison = '';

      if (!empty($newsphere_templatespare_installed)) {
        $newsphere_templatespare_info = get_plugin_data(WP_PLUGIN_DIR . '/' . $newsphere_templatespare_installed);
        $newsphere_templatespare_verison = $newsphere_templatespare_info['Version'];
      }

      $newsphere_templatespare_active = is_plugin_active('templatespare/templatespare.php');
      $install = [];
      $activate = [];
      if ($newsphere_templatespare_installed == null) {
        $install[] = 'templatespare';
      }

      if ($newsphere_templatespare_active == false && $newsphere_templatespare_installed != null) {
        $activate[] = 'templatespare';
      }
      $plugin_update = 'false';
      if (!empty($newsphere_templatespare_verison) && $newsphere_templatespare_verison < self::templatespare_old_version) {
        $plugin_update = 'true';
      }

      if (($newsphere_templatespare_installed && $newsphere_templatespare_active) && $plugin_update == 'false') {
      ?>
        <div id="newsphere-starter-sites-lists"></div>
      <?php
      } else {
        wp_enqueue_style('templatespare');
        $message = '';

        if (!empty($newsphere_templatespare_verison) && $newsphere_templatespare_active && $newsphere_templatespare_verison < self::templatespare_old_version) {
          $class = admin_url('plugins.php');

          $message = __('The Templatespare plugin should be updated to the latest version', 'newsphere');
        } else {
          $class = 'false';
          $message = __('Import a Starter Site, Personalize, and Live it in 3 Easy Steps!', 'newsphere');
        }
      ?>
        <div id="templatespare-plugin-install-activate" data-class=<?php echo $class; ?>
          current-theme=<?php echo esc_attr($this->theme_slug) ?> install=<?php echo json_encode($install); ?>
          activate=<?php echo json_encode($activate); ?> data-plugin-page='<?php echo $this->page_slug; ?>'
          message='<?php echo $message; ?>' ispro=''></div>
      <?php
      }
    }

    public function newsphere_render_starter_templates()
    {

      $newsphere_blockspare_installed = newsphere_get_plugin_file('blockspare-pro');
      $install = [];
      $activate = [];
      $newsphere_blockspare_verison = '';
      $newsphere_check_blockspare = $this->newsphere_check_blockspare_free_pro_activated();
      $newsphere_blockspare_status = 'free';
      if (!empty($newsphere_blockspare_installed) && $newsphere_check_blockspare == 'pro') {
        $newsphere_blockspare_status = 'pro';
        $newsphere_blockspare_old_version = '4.1.3';
        $newsphere_blockspare_pro_info = get_plugin_data(WP_PLUGIN_DIR . '/' . $newsphere_blockspare_installed);
        $newsphere_blockspare_verison = $newsphere_blockspare_pro_info['Version'];
        $newsphere_blockspare_active = is_plugin_active($newsphere_blockspare_installed);

        if ($newsphere_blockspare_active == false && $newsphere_blockspare_installed != null) {
          $activate[] = 'blockspare-pro';
        }
      } else {

        $newsphere_blockspare_installed = newsphere_get_plugin_file('blockspare');
        $newsphere_blockspare_old_version = '3.1.0';

        if (!empty($newsphere_blockspare_installed)) {
          $newsphere_blockspare_info = get_plugin_data(WP_PLUGIN_DIR . '/' . $newsphere_blockspare_installed);
          $newsphere_blockspare_verison = $newsphere_blockspare_info['Version'];
          $newsphere_blockspare_active = is_plugin_active('blockspare/blockspare.php');

          if ($newsphere_blockspare_active == false && $newsphere_blockspare_installed != null) {
            $activate = ['blockspare'];
          }
        } else {
          if ($newsphere_blockspare_installed == null) {
            $install = ['blockspare'];
          }
        }
      }

      $plugin_update = 'false';
      if (!empty($newsphere_blockspare_verison) && $newsphere_blockspare_verison < $newsphere_blockspare_old_version) {
        $plugin_update = 'true';
      }

      if (($newsphere_blockspare_installed && $newsphere_blockspare_active) && $plugin_update == 'false') {

      ?>
        <div id="bs-dashboard"></div>


      <?php
      } else {
        $message = '';
        wp_enqueue_style('templatespare');
        if (!empty($newsphere_blockspare_verison) && $newsphere_blockspare_active && $newsphere_blockspare_verison < $newsphere_blockspare_old_version) {
          $class = admin_url('plugins.php');

          $message = sprintf(
            __('Blockspare plugin version should be more than %s.', 'newsphere'),
            $newsphere_blockspare_old_version
          );
        } else {
          $class = 'false';
          $message = __('One-click Demo Import, Block Editor Ready, No Code Required! Built with Blockspare.', 'newsphere');
        }

      ?>
        <div id="templatespare-plugin-install-activate" data-class="<?php echo $class; ?>" current-theme='blockspare'
          install=<?php echo json_encode($install); ?> activate=<?php echo json_encode($activate); ?> data-plugin-page="aft-block-patterns"
          message='<?php echo $message; ?>' isPro='<?php echo esc_attr($newsphere_blockspare_status); ?>'></div>
<?php
      }
    }

    public function newsphere_render_templates_kits()
    {
      $install = [];
      $activate = [];
      $newsphere_elespare_installed = newsphere_get_plugin_file('elespare-pro');
      $newsphere_elementor_pro_installed = newsphere_get_plugin_file('elementor-pro');
      $newsphere_elementor_installed = newsphere_get_plugin_file('elementor');

      if ($newsphere_elementor_pro_installed) {
        $activate[] = 'elementor-pro';
      }
      if ($newsphere_elementor_installed) {
        $activate[] = 'elementor';
      } else {
        $install[] = 'elementor';
      }

      $newsphere_elespare_verison = '';
      $newsphere_check_elespare = $this->newsphere_check_elespare_free_pro_activated();
      $newsphere_elespare_status = 'free';
      if (!empty($newsphere_elespare_installed) && $newsphere_check_elespare == 'pro') {
        $newsphere_elespare_status = 'pro';
        $newsphere_elespare_old_version = '2.5.0';
        $newsphere_elespare_pro_info = get_plugin_data(WP_PLUGIN_DIR . '/' . $newsphere_elespare_installed);
        $newsphere_elespare_verison = $newsphere_elespare_pro_info['Version'];
        $newsphere_elespare_active = is_plugin_active($newsphere_elespare_installed);

        if ($newsphere_elespare_active == false && $newsphere_elespare_installed != null) {
          $activate[] = 'elespare-pro';
        }
      } else {

        $newsphere_elespare_installed = newsphere_get_plugin_file('elespare');
        $newsphere_elespare_old_version = '3.1.0';

        if (!empty($newsphere_elespare_installed)) {
          $newsphere_elespare_info = get_plugin_data(WP_PLUGIN_DIR . '/' . $newsphere_elespare_installed);
          $newsphere_elespare_verison = $newsphere_elespare_info['Version'];
          $newsphere_elespare_active = is_plugin_active('elespare/elespare.php');

          if ($newsphere_elespare_active == false && $newsphere_elespare_installed != null) {
            $activate[] = 'elespare';
          }
        } else {
          if ($newsphere_elespare_installed == null) {
            $install[] = 'elespare';
          }
        }
      }

      $plugin_update = 'false';
      if (!empty($newsphere_elespare_verison) && $newsphere_elespare_verison < $newsphere_elespare_old_version) {
        $plugin_update = 'true';
      }

      if (($newsphere_elespare_installed && $newsphere_elespare_active) && $plugin_update == 'false' && is_plugin_active($newsphere_elementor_installed)) {
        echo '<div id="elespare-demo-list"></div>';
      } else {
        wp_enqueue_style('templatespare');
        $message = (!empty($newsphere_elespare_verison) && $newsphere_elespare_active && $newsphere_elespare_verison < $newsphere_elespare_old_version)
          ? sprintf(__('Elespare plugin version should be more than %s.', 'newsphere'), $newsphere_elespare_old_version)
          : __('One-click Import, Header/Footer Builder, Multilingual Support! Powered by Elespare.', 'newsphere');
        $class = (!empty($newsphere_elespare_verison) && $newsphere_elespare_active && $newsphere_elespare_verison < $newsphere_elespare_old_version)
          ? admin_url('plugins.php')
          : 'false';
        echo '<div id="templatespare-plugin-install-activate" data-class="' . esc_attr($class) . '" current-theme="elespare" install="' . esc_attr(json_encode($install)) . '" activate="' . esc_attr(json_encode($activate)) . '" data-plugin-page="aft-template-kits" message="' . esc_attr($message) . '" isPro="' . esc_attr($newsphere_elespare_status) . '"></div>';
      }
    }


    function newsphere_register_backend_scripts()
    {
      // Get the last modified time of the file.
      $newsphere_file_modified_time = filemtime(get_template_directory() . '/admin-dashboard/dist/admin_dashboard.build.js');

      // Append the modified time as a timestamp to the version.
      $newsphere_version_with_timestamp = '4.7.5' . $newsphere_file_modified_time;

      wp_enqueue_style('plugin-installer-style', get_template_directory_uri() . '/admin-dashboard/dist/style-admin_dashboard.css', '', $newsphere_version_with_timestamp, 'all');
      wp_register_style('templatespare', get_template_directory_uri() . '/admin-dashboard/dist/blocks.editor.build.css', '', $newsphere_version_with_timestamp, 'all');
      wp_enqueue_script(
        'aftheme-dashboard', // Handle.
        get_template_directory_uri() . '/admin-dashboard/dist/admin_dashboard.build.js',
        array('react', 'react-dom', 'wp-api-fetch', 'wp-element'), // Dependencies, defined above.
        '1.0.0',
        true
      );

      $changelog = $this->newsphere_get_latest_changelog();
      $dahboard_path = get_template_directory_uri() . '/admin-dashboard/plugin-imgs';
      $siteUrl = site_url();
      $theme = wp_get_theme();

      $newsphere_templatespare_installed = newsphere_check_file_extension('templatespare/templatespare.php');
      $newsphere_templatespare_active = is_plugin_active('templatespare/templatespare.php');

      if ($newsphere_templatespare_installed && $newsphere_templatespare_active) {
        $has_plugins = true;
      } else {
        $has_plugins = false;
      }

      $aft_get_starter_plugins = $this->newsphere_get_plugins_list_data();

      wp_localize_script(
        'aftheme-dashboard',
        'afDashboardData',
        [
          'customizer_url' => admin_url('/customize.php?autofocus'),
          'changelog' => $changelog,
          'dahboard_path' => $dahboard_path,
          'siteUrl' => $siteUrl,
          'aflogoUrl' => get_template_directory_uri(),
          "themeUrl" => (! is_child_theme()) ? get_template_directory_uri() : get_stylesheet_directory_uri(),
          "themeName" => $this->theme_name,
          "themeVesrion" => $this->theme_version,
          "currentUser" => $this->current_user_name,
          'has_templatespare' => $has_plugins,
          'templatespare_install' => $newsphere_templatespare_installed ? [] : json_encode(['templatespare']),
          'templatespare_active' => $newsphere_templatespare_active ? [] : json_encode(['templatespare']),
          'admindashboarddata' => $aft_get_starter_plugins,
          'theme_img' => get_template_directory_uri() . '/admin-dashboard/assets/images/theme.png',
          'externalUrl' => 'https://raw.githubusercontent.com/afthemes/elespare-demo-data/master/free',
          'starter_sites' => get_template_directory_uri() . '/admin-dashboard/assets/images/starter-sites.jpg',
          'block_patterns' => get_template_directory_uri() . '/admin-dashboard/assets/images/block-patterns.jpg',
          'template_kits' => get_template_directory_uri() . '/admin-dashboard/assets/images/template-kits.jpg',

        ]
      );

      wp_enqueue_script('plugin-installer', get_template_directory_uri() . '/admin-dashboard/dist/plugin_installer.build.js', array('jquery', 'aftheme-dashboard'));
      wp_enqueue_script('templatespare-installer', get_template_directory_uri() . '/admin-dashboard/dist/templatespare_plugin.build.js', array('jquery', 'aftheme-dashboard'));
      wp_localize_script('plugin-installer', 'aft_installer_localize', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'admin_nonce' => wp_create_nonce('aft_installer_nonce'),
        'install_now' => __('Are you sure you want to install this plugin?', 'newsphere'),
        'install_btn' => __('Install Now', 'newsphere'),
        'activate_btn' => __('Activate', 'newsphere'),
        'installed_btn' => __('Activated', 'newsphere')
      ));
    }

    function newsphere_get_latest_changelog()
    {
      $readme = null;
      $access_type = get_filesystem_method();

      if ($access_type === 'direct') {
        $creds = request_filesystem_credentials(
          site_url() . '/wp-admin/',
          '',
          false,
          false,
          []
        );

        if (WP_Filesystem($creds)) {
          global $wp_filesystem;

          $readme = $wp_filesystem->get_contents(
            get_template_directory() . '/changelog.txt'
          );
        }

        $newchangelog = str_replace("###", "", $readme);
        $newchangelog = str_replace("Changes:", "", $newchangelog);
        $newchangelog = str_replace("*", "", $newchangelog);

        $newchangelogs = explode("###", $newchangelog);

        $changelog = '';


        foreach (array_filter($newchangelogs) as $key => $val) {

          if (!empty($val)) {
            $changelog .= $val;
          }
        }
      }


      return $changelog;
    }

    public function newsphere_load_files()
    {
      require_once  get_template_directory() . '/admin-dashboard/rest-api/api-request.php';
      require_once  get_template_directory() . '/admin-dashboard/rest-api/class-admin-notice.php';
      require_once  get_template_directory() . '/admin-dashboard/rest-api/class-ajaxcall.php';
    }

    public function newsphere_get_plugins_list_data()
    {

      $plugins = apply_filters('aft_plugins_for_starter_sites', array("blockspare", "templatespare"));
      $newsphere_templatespare_subtitle = '';

      $activate_plugins = [];
      $install_plugin = [];
      $blocksapre_pro = 'blockspare-pro';
      $is_blockspare_pro = newsphere_get_plugin_file($blocksapre_pro);
      $check_blockspare = $this->newsphere_check_blockspare_free_pro_activated();

      if ($check_blockspare == 'pro' && $is_blockspare_pro != null) {
        unset($plugins[array_search('blockspare', $plugins)]);
        array_push($plugins, $blocksapre_pro);
      }

      if (!empty($plugins)) {
        foreach ($plugins as $key => $plugin) {

          $main_plugin_file = newsphere_get_plugin_file($plugin); // Get main plugin file

          if (!empty($main_plugin_file)) {

            if (!is_plugin_active($main_plugin_file)) {

              $btn_class = 'aft-bulk-active-plugin-installer';
              $newsphere_templatespare_url = '#';
              $activate_plugins[] = $plugin;
            }
          } else {
            $install_plugin[$key] = $plugin;
            $btn_class = 'aft-bulk-plugin-installer';
            $newsphere_templatespare_url = "#";
          }
        }
      }

      if (empty($activate_plugins) && empty($install_plugin)) {
        $btn_class = '';
        $newsphere_templatespare_url = site_url() . '/wp-admin/admin.php?page=newsphere';
        //$newsphere_templatespare_subtitle = __( 'The "Get Started" action will install/activate the AF Companion and Blockspare plugins for Starter Sites and Templates.', 'newsphere' );
        $newsphere_templatespare_title = __('Get Starter Sites', 'newsphere');
      } else {

        $btn_class = 'aft-bulk-active-plugin-installer';
        $newsphere_templatespare_url = '#';
        $newsphere_templatespare_title = __('Get Started', 'newsphere');
        $newsphere_templatespare_subtitle = __('The "Get Started" action will install/activate the Templatespare and Blockspare plugins for Starter Sites and Templates.', 'newsphere');
      }

      return array(
        'templatespare_title' => $newsphere_templatespare_title,
        'templatespare_subtitle' => $newsphere_templatespare_subtitle,
        'activate_plugins' => json_encode($activate_plugins),
        'install_plugin' => json_encode($install_plugin),
        'btn_class' => $btn_class,
        'templatespare_url' => $newsphere_templatespare_url,

      );
    }

    public function newsphere_check_blockspare_free_pro_activated()
    {
      $newsphere_blockspare_pro_installed = newsphere_get_plugin_file('blockspare-pro');
      $newsphere_blockspare_free_installed = newsphere_get_plugin_file('blockspare');

      if (!empty($newsphere_blockspare_free_installed) && is_plugin_active($newsphere_blockspare_free_installed)) {
        $flag = 'free';
      } elseif (!empty($newsphere_blockspare_pro_installed) && !is_plugin_active($newsphere_blockspare_pro_installed)) {
        $flag = 'pro';
      } elseif (!empty($newsphere_blockspare_pro_installed) && is_plugin_active($newsphere_blockspare_pro_installed)) {
        $flag = 'pro';
      } else {
        $flag = 'free';
      }
      return $flag;
    }

    public function newsphere_check_elespare_free_pro_activated()
    {
      $newsphere_elespare_pro_installed = newsphere_get_plugin_file('elespare-pro');
      $newsphere_elespare_free_installed = newsphere_get_plugin_file('elespare');

      if (!empty($newsphere_elespare_free_installed) && is_plugin_active($newsphere_elespare_free_installed)) {
        $flag = 'free';
      } elseif (!empty($newsphere_elespare_pro_installed) && !is_plugin_active($newsphere_elespare_pro_installed)) {
        $flag = 'pro';
      } elseif (!empty($newsphere_elespare_pro_installed) && is_plugin_active($newsphere_elespare_pro_installed)) {
        $flag = 'pro';
      } else {
        $flag = 'free';
      }
      return $flag;
    }
  }

  $aft_dashboard = new AF_themes_info;
}
