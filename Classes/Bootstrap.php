<?php

namespace OXI_TABS_PLUGINS\Classes;

if (!defined('ABSPATH'))
    exit;

/**
 * Description of Bootstrap
 *
 * @author biplo
 */
use OXI_TABS_PLUGINS\Classes\Build_Api as Build_Api;

class Bootstrap {

    use \OXI_TABS_PLUGINS\Helper\Public_Helper;
    use \OXI_TABS_PLUGINS\Helper\Admin_helper;

    // instance container
    private static $instance = null;

    /**
     * Define $wpdb
     *
     * @since 3.1.0
     */
    public $database;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Shortcode loader
     *
     * @since 3.1.0
     * @access public
     */
    protected function Shortcode_loader() {
        add_shortcode('ctu_ultimate_oxi', [$this, 'tabs_shortcode']);
        new \OXI_TABS_PLUGINS\Modules\Visual_Composer();
        $Tabs_Widget = new \OXI_TABS_PLUGINS\Modules\Tabs_Widget();
        add_filter('widget_text', 'do_shortcode');
        add_action('widgets_init', array($Tabs_Widget, 'tabs_register_tabswidget'));
        add_filter('the_content', [$this, 'view_count_jquery']);
    }

    /**
     * Execute Shortcode
     *
     * @since 3.1.0
     * @access public
     */
    public function tabs_shortcode($atts) {
        extract(shortcode_atts(array('id' => ' ',), $atts));
        $styleid = $atts['id'];
        ob_start();
        $this->shortcode_render($styleid, 'user');
        return ob_get_clean();
    }

    public function User_Admin() {
        add_action('admin_menu', [$this, 'Admin_Menu']);
        add_action('admin_head', [$this, 'Tabs_Icon']);
        add_action('admin_init', array($this, 'redirect_on_activation'));
    }

    public function redirect_on_activation() {
        if (get_transient('oxi_tabs_activation_redirect')) :
            delete_transient('oxi_tabs_activation_redirect');
            if (is_network_admin() || isset($_GET['activate-multi'])) :
                return;
            endif;
            wp_safe_redirect(admin_url("admin.php?page=oxi-tabs-ultimate-welcome"));
        endif;
    }

    public function view_count_jquery($content) {
        if (!is_single()) :
            return $content; // Only on single posts
        endif;

        global $post;
        $id = $post->ID;

        $exclude_admins = apply_filters('oxi_view_count_exclude_admins', false);
        if ($exclude_admins === true) :
            $exclude_admins = 'edit_posts';
        endif;
        if ($exclude_admins && current_user_can($exclude_admins)) :
            return $content;
        endif;

        $count = get_post_meta($id, '_oxi_post_view_count', true);
        if ((int) $count) :
            update_post_meta($id, '_oxi_post_view_count', $count + 1);
        else :
            update_post_meta($id, '_oxi_post_view_count', 1);
        endif;

        remove_filter('the_content', [$this, 'view_count_jquery']);

        return $content;
    }

    public function Extension() {
        if (!function_exists('is_plugin_active')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        if (is_plugin_active('woocommerce/woocommerce.php')) :
            new \OXI_TABS_PLUGINS\Extension\WooCommerce\WooCommerce();
        endif;
    }

    public function __construct() {
        do_action('oxi-tabs-plugin/before_init');
        // Load translation
        add_action('init', array($this, 'i18n'));
        $this->Shortcode_loader();
        $this->Extension();
        new Build_Api();
        if (is_admin()) {
            $this->Admin_Filters();
            $this->User_Admin();
            $this->User_Reviews();
            if (isset($_GET['page']) && 'oxi-tabs-style-view' === $_GET['page']) {
                new \OXI_TABS_PLUGINS\Modules\Template();
            }
        }
    }

    /**
     * Load Textdomain
     *
     * @since 3.1.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain('oxi-tabs-plugin');
        $this->database = new \OXI_TABS_PLUGINS\Helper\Database();
    }

}
