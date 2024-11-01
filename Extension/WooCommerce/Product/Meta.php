<?php

namespace OXI_TABS_PLUGINS\Extension\WooCommerce\Product;

/**
 *
 * @author biplo
 */
trait Meta {

    public function enqueue_scripts_and_styles($hook) {
        global $post;
        global $wp_version;
        if ($hook === 'post-new.php' || $hook === 'post.php') {
            if (isset($post->post_type) && $post->post_type === 'product') {
                if (function_exists('wp_enqueue_editor')) {
                    wp_enqueue_editor();
                }
                wp_enqueue_style('oxilab_tabs_woo-styles', OXI_TABS_URL . 'assets/woocommerce/css/admin.css', false, OXI_TABS_PLUGIN_VERSION);
                wp_enqueue_script('oxilab_tabs_woo_admin', OXI_TABS_URL . 'assets/woocommerce/js/admin.js', false, OXI_TABS_PLUGIN_VERSION);
                wp_enqueue_style('font-awsome.min', OXI_TABS_URL . 'assets/frontend/css/font-awsome.min.css', false, OXI_TABS_PLUGIN_VERSION);
                wp_enqueue_style('fontawesome-iconpicker', OXI_TABS_URL . 'assets/backend/css/fontawesome-iconpicker.css', false, OXI_TABS_PLUGIN_VERSION);
                wp_enqueue_script('fontawesome-iconpicker', OXI_TABS_URL . 'assets/backend/js/fontawesome-iconpicker.js', false, OXI_TABS_PLUGIN_VERSION);
                wp_enqueue_script('iconpicker', OXI_TABS_URL . 'Extension/WooCommerce/assets/js/iconpicker.js', array('jquery'), true, OXI_TABS_PLUGIN_VERSION);
            }
        }
    }

    public function product_meta_fields_save($post_id) {
        //save the woo layouts

        $layouts = isset($_POST['_oxilab_tabs_woo_layouts']) ? esc_attr($_POST['_oxilab_tabs_woo_layouts']) : '';
        if ($layouts != '') :
            update_post_meta($post_id, '_oxilab_tabs_woo_layouts', $layouts);
        else :
            delete_post_meta($post_id, '_oxilab_tabs_woo_layouts');
        endif;
        $tab_data = [];
// save the woo data
        if (isset($_POST['_oxilab_tabs_woo_layouts_tab_title_'])) :
            $titles = $_POST['_oxilab_tabs_woo_layouts_tab_title_'];
            $icon = $_POST['_oxilab_tabs_woo_layouts_tab_icon_'];
            $prioritys = $_POST['_oxilab_tabs_woo_layouts_tab_priority_'];
            $contents = $_POST['_oxilab_tabs_woo_layouts_tab_content_'];
            $callback = $_POST['_oxilab_tabs_woo_layouts_tab_callback_'];

            foreach ($titles as $key => $value) {
                $tab_title = stripslashes($titles[$key]);
                $tab_icon = stripslashes($icon[$key]);
                $tab_priority = stripslashes($prioritys[$key]);
                $tab_callback = stripslashes($callback[$key]);
                $tab_content = stripslashes($contents[$key]);
                if (empty($tab_title) && empty($tab_priority)) :
                    return false;
                else :
                    $tab_data[$key] = [
                        'title' => $tab_title,
                        'icon' => $tab_icon,
                        'priority' => $tab_priority,
                        'callback' => $tab_callback,
                        'content' => $tab_content,
                    ];
                endif;
            }
        endif;
        if (count($tab_data) == 0) :
            delete_post_meta($post_id, '_oxilab_tabs_woo_data');
        else :
            $tab_data = array_values($tab_data);
            update_post_meta($post_id, '_oxilab_tabs_woo_data', $tab_data);
        endif;
    }

    public function add_product_panels() {
        global $post;
        $post_id = $post->ID;
        $new = new \OXI_TABS_PLUGINS\Modules\Shortcode();
        $get_style = $new->get_all_style();
        ?>
        <div id="oxilab_tabs_product_data" class="panel woocommerce_options_panel">
            <?php
            woocommerce_wp_select(array(
                'id' => '_oxilab_tabs_woo_layouts',
                'label' => __('Select Tabs Layots', OXI_TABS_TEXTDOMAIN),
                'description' => __('Select Layouts which ', OXI_TABS_TEXTDOMAIN),
                'desc_tip' => true,
                'options' => $get_style,
            ));
            $tabs = new \OXI_TABS_PLUGINS\Extension\WooCommerce\Admin();
            $tabs->render_html();
            ?>
        </div>
        <?php
    }

    public function add_postbox_tabs($tabs) {
        $tabs['oxilab_tabs'] = array(
            'label' => 'Oxilab Tabs',
            'target' => 'oxilab_tabs_product_data',
        );
        return $tabs;
    }

    public function oxilab_tabs_css_icon() {
        echo '<style>
	#woocommerce-product-data ul.wc-tabs li.oxilab_tabs_options.oxilab_tabs_tab a:before{
		content: "\f163";
	}
	</style>';
    }

}
