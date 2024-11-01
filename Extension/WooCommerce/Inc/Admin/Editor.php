<?php

namespace OXI_TABS_PLUGINS\Extension\WooCommerce\Inc\Admin;

/**
 *
 * @author biplo
 */
trait Editor {

    public function Editor() {



        $screen = get_current_screen();
        if ($screen->id == 'edit-oxi_woo_tabs') {
            ?>
            <div class="modal fade" id="oxi_woo_tabs_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  data-editor-url="<?php echo get_admin_url(); ?>">
                <div class="modal-dialog  modal-sm modal-dialog-centered" role="document">
                    <form action="" mathod="get" id="oxi_woo_tabsinput-form" >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><?php esc_html_e('Tabs Settings', OXI_TABS_TEXTDOMAIN); ?></h4>
                            </div>
                            <div class="modal-body">

                                <div class="shortcode-form-control shortcode-control-type-text">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Title:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <input type="text" name="title" class="oxi_woo_tabsinput-title" placeholder="Give Your Title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shortcode-form-control shortcode-control-type-title">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-priority"><?php esc_html_e('Tab Priority:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <input type="number" name="priority" class="oxi_woo_tabsinput-priority" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shortcode-form-control shortcode-control-type-text">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Conditions:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <div class="shortcode-form-control-input-select-wrapper">
                                                    <select name="condition" class="oxi_woo_tabs_c shortcode-addons-select-input ">
                                                        <option value="entire_site"><?php esc_html_e('Entire Product', OXI_TABS_TEXTDOMAIN); ?></option>
                                                        <option value="singular"><?php esc_html_e('Singular', OXI_TABS_TEXTDOMAIN); ?></option>
                                                        <option value="archive"><?php esc_html_e('Archive ', OXI_TABS_TEXTDOMAIN); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shortcode-form-control shortcode-control-type-text oxi_woo_tabs_singular_id-container">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Single Products:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <div class="shortcode-form-control-input-select-wrapper">
                                                    <select multiple name="singular_id[]" class="oxi_woo_tabs_singular_id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="shortcode-form-control shortcode-control-type-text oxi_woo_tabs_archive-container">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Product Type:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <div class="shortcode-form-control-input-select-wrapper">
                                                    <select name="archive" class="shortcode-addons-select-input oxi_woo_tabs_archive ">
                                                        <option value="products_cat"><?php esc_html_e('Products Category', OXI_TABS_TEXTDOMAIN); ?></option>
                                                        <option value="products_tags"><?php esc_html_e('Product Tags', OXI_TABS_TEXTDOMAIN); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="shortcode-form-control shortcode-control-type-text oxi_woo_tabs_archive_cat_id-container">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Category List:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <div class="shortcode-form-control-input-select-wrapper">
                                                    <select multiple name="archive_cat_id[]" class="oxi_woo_tabs_archive_cat_id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shortcode-form-control shortcode-control-type-text oxi_woo_tabs_archive_tags_id-container">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Tag List:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <div class="shortcode-form-control-input-select-wrapper">
                                                    <select multiple name="archive_tags_id[]" class="oxi_woo_tabs_archive_tags_id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="shortcode-form-control shortcode-control-type-switcher  shortcode-addons-control-loader">
                                    <div class="shortcode-form-control-content">
                                        <div class="shortcode-form-control-field">
                                            <label for="" class="shortcode-form-control-title"><?php esc_html_e('Activition:', OXI_TABS_TEXTDOMAIN); ?></label>
                                            <div class="shortcode-form-control-input-wrapper">
                                                <label class="shortcode-switcher">
                                                    <input type="checkbox" value="yes" name="activation" class="oxi_woo_tabsinput-activition">
                                                    <span data-on="Yes" data-off="No"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="post_author" value="<?php echo get_current_user_id(); ?>">
                                <input type="hidden" name="id" id="oxi-woo-tabs-id" value="0">
                                <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('wp_rest'); ?>" />
                                <button type="button" class="btn btn-info open-data-btn-editor"><?php esc_html_e('Edit Content', OXI_TABS_TEXTDOMAIN); ?></button>
                                <button type="submit" class="btn btn-success oxi-save-btn"><?php esc_html_e('Save changes', OXI_TABS_TEXTDOMAIN); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }

    public function render_meta_box_icon($post) {
        $post_id = $post->ID;
        wp_nonce_field('oxi_tabs_meta_box_icon', 'oxi_tabs_meta_box_icon_nonce');
        $meta_box_icon = get_post_meta($post_id, 'oxi_woo_tabs_icon', true);
        ?>
        Select Font Awesome Icon for this Tab
        <br>
        <br>
        <div class="form-group">
            <div class="input-group iconpicker-container">

                <input data-placement="bottomRight" class="form-control icp icp-auto iconpicker-element iconpicker-input oxi-admin-icon-selector" value="<?php echo esc_attr($meta_box_icon); ?>" type="text" name="oxi-woo-tab-icon">
                <span class="input-group-addon"><i class="<?php echo esc_attr($meta_box_icon); ?>"></i></span>
            </div>
        </div>
        <?php
    }

    public function render_meta_box_callback_function($post) {
        $post_id = $post->ID;
        wp_nonce_field('render_meta_box_callback_function', 'render_meta_box_callback_function_nonce');
        $callback = get_post_meta($post_id, 'oxi_woo_tabs_callback', true);
        ?>
        Add custom callback Function on this Tab. Blank will be render default format.
        <br>
        <br>
        <div class="form-group">
            <div class="input-group">
                <input  class="form-control" value="<?php echo esc_attr($callback); ?>" type="text" name="oxi-woo-tab-callback">

            </div>
        </div>
        <?php
    }

    /**
     * Check if we should use the filter
     */
    public function column($columns) {
        $date_column = $columns['date'];
        $author_column = $columns['author'];
        unset($columns['date']);
        unset($columns['author']);
        $columns['activation'] = esc_html__('Activation', OXI_TABS_TEXTDOMAIN);
        $columns['priority'] = esc_html__('Priority', OXI_TABS_TEXTDOMAIN);
        $columns['condition'] = esc_html__('Condition', OXI_TABS_TEXTDOMAIN);
        $columns['date'] = $date_column;
        $columns['author'] = $author_column;
        return $columns;
    }

    public function column_data($column, $post_id) {
        switch ($column) {
            case 'activation':
                $active = get_post_meta($post_id, 'oxi_woo_tabs_activation', true);

                echo ($active == 'yes') ?
                        ( '<span class="oxi-woo-tabs-status btn btn-success">' .
                        esc_html__('Active', OXI_TABS_TEXTDOMAIN) . '</span>' ) :
                        ( '<span class="oxi-woo-tabs-status-status btn btn-warning">'
                        . esc_html__('Inactive', OXI_TABS_TEXTDOMAIN) . '</span>' );

                break;

            case 'priority':
                $priority = get_post_meta($post_id, 'oxi_woo_tabs_priority', true);
                echo '<span class="oxi-woo-tabs-priority">' . esc_html__($priority, OXI_TABS_TEXTDOMAIN) . '</span>';
                break;

            case 'condition':

                $cond = get_post_meta($post_id, 'oxi_woo_tabs_condition', true);

                if ($cond == 'singular'):
                    $singular = get_post_meta($post_id, 'oxi_woo_tabs_singular_id', true);
                    if ($singular != '' && count($singular) > 0):
                        $rt = '';
                        foreach ($singular as $value) {
                            $rt .= 'Product > ' . esc_html(get_the_title($value)) . '<br> ';
                        }

                    else:
                        $rt = 'Invalid';
                    endif;
                elseif ($cond == 'archive'):

                    $archive = get_post_meta($post_id, 'oxi_woo_tabs_archive', true);
                    if ($archive == 'products_author'):
                        $products_author = get_post_meta($post_id, 'oxi_woo_tabs_products_author', true);
                        if ($products_author != '' && count($products_author) > 0):
                            $rt = '';
                            foreach ($products_author as $value) {

                                $user_info = get_userdata($value);
                                $rt .= $cond . ' > author > ' . esc_html($user_info->user_login) . '<br> ';
                            }

                        else:
                            $rt = 'Invalid';
                        endif;

                    elseif ($archive == 'products_cat'):

                        $products_cat = get_post_meta($post_id, 'oxi_woo_tabs_products_cat', true);
                        if ($products_cat != '' && count($products_cat) > 0):
                            $rt = '';
                            foreach ($products_cat as $value) {

                                $rt .= $cond . ' > Category > ' . esc_html(get_the_category_by_ID($value)) . '<br> ';
                            }

                        else:
                            $rt = 'Invalid';
                        endif;
                    elseif ($archive == 'products_tags'):

                        $products_tags = get_post_meta($post_id, 'oxi_woo_tabs_products_tags', true);
                        if ($products_tags != '' && count($products_tags) > 0):
                            $rt = '';
                            foreach ($products_tags as $value) {
                                $tag = get_term($value);

                                $rt .= $cond . ' > Tag > ' . esc_html($tag->name) . '<br> ';
                            }
                        else:
                            $rt = 'Invalid';
                        endif;
                    endif;
                else:
                    $rt = $cond;
                endif;
                echo ucwords(str_replace('_', ' ', $rt));
                break;
        }
    }

}
