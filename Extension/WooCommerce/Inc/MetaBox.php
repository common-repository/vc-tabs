<?php

	namespace OXI_TABS_PLUGINS\Extension\WooCommerce\Inc;

	trait MetaBox
	{

		public function custom_post_types ()
		{

			$labels = [
			  'name' => _x('Tabs', 'post type general name', OXI_TABS_TEXTDOMAIN),
			  'singular_name' => _x('Tab', 'post type singular name', OXI_TABS_TEXTDOMAIN),
			  'menu_name' => _x('Oxilab Woo Tabs', 'admin menu', OXI_TABS_TEXTDOMAIN),
			  'name_admin_bar' => _x('Tab', 'add new on admin bar', OXI_TABS_TEXTDOMAIN),
			  'add_new' => _x('Add New', OXI_TABS_WOOCOMMERCE_POST_TYPE, OXI_TABS_TEXTDOMAIN),
			  'add_new_item' => __('Add New Tab', OXI_TABS_TEXTDOMAIN),
			  'new_item' => __('New Tab', OXI_TABS_TEXTDOMAIN),
			  'edit_item' => __('Edit Tab', OXI_TABS_TEXTDOMAIN),
			  'view_item' => __('View Tab', OXI_TABS_TEXTDOMAIN),
			  'all_items' => __('Woo Tabs', OXI_TABS_TEXTDOMAIN),
			  'search_items' => __('Search Tabs', OXI_TABS_TEXTDOMAIN),
			  'parent_item_colon' => __('Parent Tabs:', OXI_TABS_TEXTDOMAIN),
			  'not_found' => __('No tabs found.', OXI_TABS_TEXTDOMAIN),
			  'not_found_in_trash' => __('No tabs found in Trash.', OXI_TABS_TEXTDOMAIN)
			];

			$args = [
			  'labels' => $labels,
			  'public' => false,
			  'publicly_queryable' => false,
			  'show_ui' => true,
			  'show_in_menu' => true,
			  'query_var' => false,
			  'capability_type' => 'post',
			  'has_archive' => false,
			  'hierarchical' => false,
			  'menu_icon' => 'dashicons-list-view',
			  'menu_position' => 57,
			  'supports' => ['title', 'editor']
			];

			register_post_type(OXI_TABS_WOOCOMMERCE_POST_TYPE, $args);
		}

		public function add_author_support_to_column ()
		{
			add_post_type_support('oxi_woo_tabs', 'author');
		}

		public function enqueue_scripts ()
		{

			$screen = get_current_screen();

			if ($screen->id == 'edit-oxi_woo_tabs') {
				wp_enqueue_style('select2', OXI_TABS_URL . 'Extension/WooCommerce/assets/css/select2.min.css', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('select2', OXI_TABS_URL . 'Extension/WooCommerce/assets/js/select2.min.js', ['jquery'], true, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('oxi_woo_tabs-script', OXI_TABS_URL . 'Extension/WooCommerce/assets/js/admin-script.js', ['jquery'], true, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_style('oxi_woo_tabs-css', OXI_TABS_URL . 'Extension/WooCommerce/assets/css/admin-style.css', false, OXI_TABS_PLUGIN_VERSION);

				wp_enqueue_style('bootstrap.min-css', OXI_TABS_URL . 'assets/backend/css/bootstrap.min.css', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('bootstrap.min', OXI_TABS_URL . 'assets/backend/js/bootstrap.min.js', false, OXI_TABS_PLUGIN_VERSION);

				wp_localize_script('oxi_woo_tabs-script', 'oxiwootabsultimate', [
				  'restapi' => esc_url_raw(get_rest_url() . 'oxiwootabsultimate/v1/'),
				  'nonce' => wp_create_nonce('wp_rest')
				]);
			}
			if ($screen->id == 'oxi_woo_tabs') {
				wp_enqueue_style('bootstrap.min-css', OXI_TABS_URL . 'assets/backend/css/bootstrap.min.css', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_style('font-awsome.min', OXI_TABS_URL . 'assets/frontend/css/font-awsome.min.css', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_style('fontawesome-iconpicker', OXI_TABS_URL . 'assets/backend/css/fontawesome-iconpicker.css', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('bootstrap.min', OXI_TABS_URL . 'assets/backend/js/bootstrap.min.js', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('fontawesome-iconpicker', OXI_TABS_URL . 'assets/backend/js/fontawesome-iconpicker.js', false, OXI_TABS_PLUGIN_VERSION);
				wp_enqueue_script('iconpicker', OXI_TABS_URL . 'Extension/WooCommerce/assets/js/iconpicker.js', ['jquery'], true, OXI_TABS_PLUGIN_VERSION);
			}


		}


		public function add_tab_meta_boxes ($post_type)
		{
			$screen = get_current_screen();

			if ($screen->id == 'oxi_woo_tabs') {


				$post_types = [OXI_TABS_WOOCOMMERCE_POST_TYPE];

				if (in_array($post_type, $post_types)) {
					add_meta_box(
					  OXI_TABS_WOOCOMMERCE_POST_TYPE . '_tab_icon',
					  __('Tab: Icon', OXI_TABS_TEXTDOMAIN),
					  [$this, 'render_meta_box_icon'],
					  $post_types,
					  'side',
					);
					add_meta_box(
					  OXI_TABS_WOOCOMMERCE_POST_TYPE . '_tab_callback',
					  __('Tab: Callback Function', OXI_TABS_TEXTDOMAIN),
					  [$this, 'render_meta_box_callback_function'],
					  $post_types,
					  'side',
					);
				}
			}
		}

	}
