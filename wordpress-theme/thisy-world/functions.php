<?php
/**
 * Thisy-World Theme Functions
 *
 * @package Thisy-World
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load SEO Functions
require_once get_template_directory() . '/inc/seo-functions.php';

/**
 * Theme Setup
 */
function thisy_world_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    
    add_image_size('wm-poster', 400, 600, true);
    add_image_size('wm-poster-large', 600, 900, true);
    add_image_size('wm-screenshot', 800, 450, true);
    add_image_size('wm-card', 300, 450, true);
    
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'thisy-world'),
        'footer' => __('Footer Menu', 'thisy-world'),
    ));
}
add_action('after_setup_theme', 'thisy_world_setup');

/**
 * Enqueue Scripts and Styles
 */
function thisy_world_scripts() {
    wp_enqueue_style('thisy-world-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('thisy-world-style', get_stylesheet_uri(), array('thisy-world-fonts'), wp_get_theme()->get('Version'));
    wp_enqueue_script('thisy-world-animations', get_template_directory_uri() . '/assets/js/animations.js', array(), wp_get_theme()->get('Version'), true);
    wp_localize_script('thisy-world-animations', 'wmData', array('ajaxUrl' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('wm_nonce')));
}
add_action('wp_enqueue_scripts', 'thisy_world_scripts');

/**
 * Register Series Custom Post Type
 */
function thisy_world_register_series_cpt() {
    $labels = array(
        'name' => _x('Series', 'post type general name', 'thisy-world'),
        'singular_name' => _x('Series', 'post type singular name', 'thisy-world'),
        'menu_name' => _x('Series', 'admin menu', 'thisy-world'),
        'add_new' => _x('Add New', 'series', 'thisy-world'),
        'add_new_item' => __('Add New Series', 'thisy-world'),
        'new_item' => __('New Series', 'thisy-world'),
        'edit_item' => __('Edit Series', 'thisy-world'),
        'view_item' => __('View Series', 'thisy-world'),
        'all_items' => __('All Series', 'thisy-world'),
        'search_items' => __('Search Series', 'thisy-world'),
        'not_found' => __('No series found.', 'thisy-world'),
        'not_found_in_trash' => __('No series found in Trash.', 'thisy-world'),
    );
    $args = array(
        'labels' => $labels, 'public' => true, 'publicly_queryable' => true, 'show_ui' => true,
        'show_in_menu' => true, 'query_var' => true, 'rewrite' => array('slug' => 'series'),
        'capability_type' => 'post', 'has_archive' => true, 'hierarchical' => false,
        'menu_position' => 5, 'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), 'show_in_rest' => true,
    );
    register_post_type('series', $args);
}
add_action('init', 'thisy_world_register_series_cpt');

/**
 * Register Genre Taxonomy
 */
function thisy_world_register_genre_taxonomy() {
    $labels = array(
        'name' => _x('Genres', 'taxonomy general name', 'thisy-world'),
        'singular_name' => _x('Genre', 'taxonomy singular name', 'thisy-world'),
        'search_items' => __('Search Genres', 'thisy-world'),
        'all_items' => __('All Genres', 'thisy-world'),
        'edit_item' => __('Edit Genre', 'thisy-world'),
        'update_item' => __('Update Genre', 'thisy-world'),
        'add_new_item' => __('Add New Genre', 'thisy-world'),
        'new_item_name' => __('New Genre Name', 'thisy-world'),
        'menu_name' => __('Genres', 'thisy-world'),
    );
    $args = array('hierarchical' => true, 'labels' => $labels, 'show_ui' => true, 'show_admin_column' => true, 'query_var' => true, 'rewrite' => array('slug' => 'genre'), 'show_in_rest' => true);
    register_taxonomy('genre', array('series'), $args);
}
add_action('init', 'thisy_world_register_genre_taxonomy');

/**
 * Add Series Meta Boxes
 */
function thisy_world_add_series_meta_boxes() {
    add_meta_box('wm_series_screenshots', __('Screenshots Gallery', 'thisy-world'), 'thisy_world_screenshots_meta_box', 'series', 'normal', 'high');
    add_meta_box('wm_series_episodes', __('Episodes & Download Links', 'thisy-world'), 'thisy_world_episodes_meta_box', 'series', 'normal', 'high');
    add_meta_box('wm_series_info', __('Series Information', 'thisy-world'), 'thisy_world_info_meta_box', 'series', 'side', 'default');
}
add_action('add_meta_boxes', 'thisy_world_add_series_meta_boxes');

/**
 * Screenshots Meta Box
 */
function thisy_world_screenshots_meta_box($post) {
    wp_nonce_field('wm_screenshots_nonce', 'wm_screenshots_nonce_field');
    $screenshots = get_post_meta($post->ID, '_wm_screenshots', true);
    ?>
    <div class="wm-screenshots-uploader">
        <p><?php _e('Add screenshots for this series.', 'thisy-world'); ?></p>
        <div id="wm-screenshots-container" class="wm-screenshots-grid">
            <?php if (!empty($screenshots) && is_array($screenshots)) : foreach ($screenshots as $attachment_id) : ?>
                <div class="wm-screenshot-item" data-id="<?php echo esc_attr($attachment_id); ?>">
                    <?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?>
                    <button type="button" class="wm-remove-screenshot">&times;</button>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <input type="hidden" name="wm_screenshots" id="wm-screenshots-input" value="<?php echo esc_attr(is_array($screenshots) ? implode(',', $screenshots) : ''); ?>">
        <p><button type="button" class="button button-primary" id="wm-add-screenshots"><?php _e('Add Screenshots', 'thisy-world'); ?></button></p>
    </div>
    <style>.wm-screenshots-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px;margin:15px 0}.wm-screenshot-item{position:relative;border:1px solid #ddd;border-radius:4px;overflow:hidden}.wm-screenshot-item img{width:100%;height:auto;display:block}.wm-remove-screenshot{position:absolute;top:5px;right:5px;background:#dc3545;color:white;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:16px;line-height:1}</style>
    <script>jQuery(document).ready(function($){var frame;$('#wm-add-screenshots').on('click',function(e){e.preventDefault();if(frame){frame.open();return}frame=wp.media({title:'<?php _e('Select Screenshots','thisy-world');?>',button:{text:'<?php _e('Add Screenshots','thisy-world');?>'},multiple:true});frame.on('select',function(){var attachments=frame.state().get('selection').toJSON();var ids=$('#wm-screenshots-input').val()?$('#wm-screenshots-input').val().split(','):[];attachments.forEach(function(attachment){if(ids.indexOf(attachment.id.toString())===-1){ids.push(attachment.id);var thumb=attachment.sizes.thumbnail?attachment.sizes.thumbnail.url:attachment.url;$('#wm-screenshots-container').append('<div class="wm-screenshot-item" data-id="'+attachment.id+'"><img src="'+thumb+'"><button type="button" class="wm-remove-screenshot">&times;</button></div>')}});$('#wm-screenshots-input').val(ids.join(','))});frame.open()});$(document).on('click','.wm-remove-screenshot',function(){var item=$(this).closest('.wm-screenshot-item');var id=item.data('id').toString();var ids=$('#wm-screenshots-input').val().split(',').filter(function(i){return i!==id});$('#wm-screenshots-input').val(ids.join(','));item.remove()})});</script>
    <?php
}

/**
 * Episodes Meta Box
 */
function thisy_world_episodes_meta_box($post) {
    wp_nonce_field('wm_episodes_nonce', 'wm_episodes_nonce_field');
    $download_groups = get_post_meta($post->ID, '_wm_download_groups', true);
    if (!is_array($download_groups)) $download_groups = array();
    ?>
    <div class="wm-download-groups-manager">
        <p><?php _e('Add download groups (e.g., different quality versions like 480p, 720p, 1080p).', 'thisy-world'); ?></p>
        <div id="wm-download-groups-container">
            <?php if (!empty($download_groups)) : foreach ($download_groups as $group_index => $group) : ?>
                <div class="wm-download-group" data-group-index="<?php echo $group_index; ?>">
                    <div class="wm-download-group__header">
                        <span class="dashicons dashicons-menu wm-drag-handle"></span>
                        <input type="text" name="wm_download_groups[<?php echo $group_index; ?>][name]" value="<?php echo esc_attr($group['name']); ?>" placeholder="<?php _e('e.g., 480p [250MB/E]', 'thisy-world'); ?>" class="wm-group-name regular-text">
                        <button type="button" class="button wm-toggle-group"><span class="dashicons dashicons-arrow-down-alt2"></span></button>
                        <button type="button" class="button wm-remove-group"><span class="dashicons dashicons-trash"></span></button>
                    </div>
                    <div class="wm-download-group__episodes">
                        <div class="wm-season-zip-field" style="margin-bottom:15px;padding:12px;background:#e8f5e9;border:1px solid #4caf50;border-radius:4px">
                            <label style="display:block;margin-bottom:5px;font-weight:600;color:#2e7d32"><span class="dashicons dashicons-archive"></span> <?php _e('Season Zip Link (Optional)', 'thisy-world'); ?></label>
                            <input type="url" name="wm_download_groups[<?php echo $group_index; ?>][season_zip]" value="<?php echo esc_url(isset($group['season_zip']) ? $group['season_zip'] : ''); ?>" placeholder="https://..." class="regular-text" style="width:100%">
                        </div>
                        <table class="widefat wm-episodes-table"><thead><tr><th style="width:40px">#</th><th><?php _e('Episode Title', 'thisy-world'); ?></th><th><?php _e('Download Link', 'thisy-world'); ?></th><th style="width:50px"><?php _e('Del', 'thisy-world'); ?></th></tr></thead>
                        <tbody class="wm-episodes-body">
                            <?php if (!empty($group['episodes']) && is_array($group['episodes'])) : foreach ($group['episodes'] as $ep_index => $episode) : ?>
                                <tr class="wm-episode-row"><td class="wm-episode-number"><?php echo $ep_index + 1; ?></td>
                                <td><input type="text" name="wm_download_groups[<?php echo $group_index; ?>][episodes][<?php echo $ep_index; ?>][title]" value="<?php echo esc_attr($episode['title']); ?>" placeholder="<?php _e('Episode title...', 'thisy-world'); ?>" class="regular-text"></td>
                                <td><input type="url" name="wm_download_groups[<?php echo $group_index; ?>][episodes][<?php echo $ep_index; ?>][link]" value="<?php echo esc_url($episode['link']); ?>" placeholder="https://..." class="regular-text"></td>
                                <td><button type="button" class="button wm-remove-episode"><span class="dashicons dashicons-no-alt"></span></button></td></tr>
                            <?php endforeach; endif; ?>
                        </tbody></table>
                        <p><button type="button" class="button wm-add-episode"><span class="dashicons dashicons-plus-alt2"></span> <?php _e('Add Episode', 'thisy-world'); ?></button></p>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <p style="margin-top:20px"><button type="button" class="button button-primary button-hero" id="wm-add-download-group"><span class="dashicons dashicons-plus-alt"></span> <?php _e('Add Download Group', 'thisy-world'); ?></button></p>
    </div>
    <style>.wm-download-groups-manager{padding:10px 0}.wm-download-group{background:#f9f9f9;border:1px solid #ddd;border-radius:4px;margin-bottom:15px}.wm-download-group__header{display:flex;align-items:center;gap:10px;padding:10px 15px;background:#fff;border-bottom:1px solid #ddd}.wm-drag-handle{cursor:grab;color:#999}.wm-group-name{flex:1;font-weight:600}.wm-download-group__episodes{padding:15px}.wm-download-group__episodes.collapsed{display:none}.wm-episodes-table input{width:100%}.wm-episode-number{text-align:center;font-weight:bold;color:#666}.wm-remove-group .dashicons,.wm-remove-episode .dashicons{color:#dc3545}.wm-toggle-group .dashicons{transition:transform .2s}.wm-download-group.collapsed .wm-toggle-group .dashicons{transform:rotate(-90deg)}</style>
    <script>jQuery(document).ready(function($){var groupIndex=<?php echo count($download_groups);?>;$('#wm-add-download-group').on('click',function(){var groupHtml='<div class="wm-download-group" data-group-index="'+groupIndex+'"><div class="wm-download-group__header"><span class="dashicons dashicons-menu wm-drag-handle"></span><input type="text" name="wm_download_groups['+groupIndex+'][name]" placeholder="<?php _e('e.g., 480p [250MB/E]','thisy-world');?>" class="wm-group-name regular-text"><button type="button" class="button wm-toggle-group"><span class="dashicons dashicons-arrow-down-alt2"></span></button><button type="button" class="button wm-remove-group"><span class="dashicons dashicons-trash"></span></button></div><div class="wm-download-group__episodes"><div class="wm-season-zip-field" style="margin-bottom:15px;padding:12px;background:#e8f5e9;border:1px solid #4caf50;border-radius:4px"><label style="display:block;margin-bottom:5px;font-weight:600;color:#2e7d32"><span class="dashicons dashicons-archive"></span> <?php _e('Season Zip Link (Optional)','thisy-world');?></label><input type="url" name="wm_download_groups['+groupIndex+'][season_zip]" placeholder="https://..." class="regular-text" style="width:100%"></div><table class="widefat wm-episodes-table"><thead><tr><th style="width:40px">#</th><th><?php _e('Episode Title','thisy-world');?></th><th><?php _e('Download Link','thisy-world');?></th><th style="width:50px"><?php _e('Del','thisy-world');?></th></tr></thead><tbody class="wm-episodes-body"></tbody></table><p><button type="button" class="button wm-add-episode"><span class="dashicons dashicons-plus-alt2"></span> <?php _e('Add Episode','thisy-world');?></button></p></div></div>';$('#wm-download-groups-container').append(groupHtml);groupIndex++});$(document).on('click','.wm-toggle-group',function(){var group=$(this).closest('.wm-download-group');group.toggleClass('collapsed');group.find('.wm-download-group__episodes').toggleClass('collapsed')});$(document).on('click','.wm-remove-group',function(){if(confirm('<?php _e('Remove this download group?','thisy-world');?>')){$(this).closest('.wm-download-group').remove()}});$(document).on('click','.wm-add-episode',function(){var group=$(this).closest('.wm-download-group');var gIndex=group.data('group-index');var tbody=group.find('.wm-episodes-body');var epIndex=tbody.find('tr').length;var episodeRow='<tr class="wm-episode-row"><td class="wm-episode-number">'+(epIndex+1)+'</td><td><input type="text" name="wm_download_groups['+gIndex+'][episodes]['+epIndex+'][title]" placeholder="<?php _e('Episode title...','thisy-world');?>" class="regular-text"></td><td><input type="url" name="wm_download_groups['+gIndex+'][episodes]['+epIndex+'][link]" placeholder="https://..." class="regular-text"></td><td><button type="button" class="button wm-remove-episode"><span class="dashicons dashicons-no-alt"></span></button></td></tr>';tbody.append(episodeRow)});$(document).on('click','.wm-remove-episode',function(){var tbody=$(this).closest('tbody');$(this).closest('tr').remove();tbody.find('tr').each(function(i){$(this).find('.wm-episode-number').text(i+1)})})});</script>
    <?php
}

/**
 * Series Info Meta Box
 */
function thisy_world_info_meta_box($post) {
    wp_nonce_field('wm_info_nonce', 'wm_info_nonce_field');
    $year = get_post_meta($post->ID, '_wm_year', true);
    $rating = get_post_meta($post->ID, '_wm_rating', true);
    $status = get_post_meta($post->ID, '_wm_status', true);
    $episode_count = get_post_meta($post->ID, '_wm_episode_count', true);
    $featured = get_post_meta($post->ID, '_wm_featured_home', true);
    ?>
    <p style="background:#fff3cd;padding:12px;border:1px solid #ffc107;border-radius:4px;margin-bottom:15px">
        <label for="wm_featured_home" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:600;color:#856404">
            <input type="checkbox" id="wm_featured_home" name="wm_featured_home" value="1" <?php checked($featured, '1'); ?> style="width:18px;height:18px">
            <span class="dashicons dashicons-star-filled" style="color:#ffc107"></span>
            <?php _e('Show on Homepage', 'thisy-world'); ?>
        </label>
        <span class="description" style="display:block;margin-top:5px;font-size:11px"><?php _e('Check to display this series on the homepage (max 12 items)', 'thisy-world'); ?></span>
    </p>
    <p><label for="wm_year"><strong><?php _e('Release Year', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_year" name="wm_year" value="<?php echo esc_attr($year); ?>" min="1900" max="2099" class="widefat"></p>
    <p><label for="wm_rating"><strong><?php _e('Rating (1-10)', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_rating" name="wm_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="10" step="0.1" class="widefat"></p>
    <p><label for="wm_status"><strong><?php _e('Status', 'thisy-world'); ?></strong></label><br><select id="wm_status" name="wm_status" class="widefat"><option value="ongoing" <?php selected($status, 'ongoing'); ?>><?php _e('Ongoing', 'thisy-world'); ?></option><option value="completed" <?php selected($status, 'completed'); ?>><?php _e('Completed', 'thisy-world'); ?></option><option value="upcoming" <?php selected($status, 'upcoming'); ?>><?php _e('Upcoming', 'thisy-world'); ?></option></select></p>
    <p><label for="wm_episode_count"><strong><?php _e('Total Episodes (Display)', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_episode_count" name="wm_episode_count" value="<?php echo esc_attr($episode_count); ?>" min="0" class="widefat"><span class="description"><?php _e('Number of episodes to display on cards', 'thisy-world'); ?></span></p>
    <?php
}

/**
 * Save Series Meta Data
 */
function thisy_world_save_series_meta($post_id) {
    if (!isset($_POST['wm_screenshots_nonce_field']) || !wp_verify_nonce($_POST['wm_screenshots_nonce_field'], 'wm_screenshots_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['wm_screenshots'])) {
        $screenshots = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['wm_screenshots']))));
        update_post_meta($post_id, '_wm_screenshots', $screenshots);
    }
    if (isset($_POST['wm_download_groups']) && is_array($_POST['wm_download_groups'])) {
        $download_groups = array();
        foreach ($_POST['wm_download_groups'] as $group) {
            if (!empty($group['name'])) {
                $episodes = array();
                if (!empty($group['episodes']) && is_array($group['episodes'])) {
                    foreach ($group['episodes'] as $episode) {
                        if (!empty($episode['title']) || !empty($episode['link'])) {
                            $episodes[] = array('title' => sanitize_text_field($episode['title']), 'link' => esc_url_raw($episode['link']));
                        }
                    }
                }
                $download_groups[] = array('name' => sanitize_text_field($group['name']), 'season_zip' => isset($group['season_zip']) ? esc_url_raw($group['season_zip']) : '', 'episodes' => $episodes);
            }
        }
        update_post_meta($post_id, '_wm_download_groups', $download_groups);
    } else { delete_post_meta($post_id, '_wm_download_groups'); }
    if (isset($_POST['wm_year'])) update_post_meta($post_id, '_wm_year', intval($_POST['wm_year']));
    if (isset($_POST['wm_rating'])) update_post_meta($post_id, '_wm_rating', floatval($_POST['wm_rating']));
    if (isset($_POST['wm_status'])) update_post_meta($post_id, '_wm_status', sanitize_text_field($_POST['wm_status']));
    if (isset($_POST['wm_episode_count'])) update_post_meta($post_id, '_wm_episode_count', intval($_POST['wm_episode_count']));
    // Featured on Homepage
    if (isset($_POST['wm_featured_home'])) {
        update_post_meta($post_id, '_wm_featured_home', '1');
    } else {
        delete_post_meta($post_id, '_wm_featured_home');
    }
}
add_action('save_post_series', 'thisy_world_save_series_meta');

/**
 * Auto-Create Required Pages
 */
function thisy_world_create_pages() {
    $pages = array(
        array('title' => __('Home', 'thisy-world'), 'slug' => 'home', 'template' => 'page-home.php'),
        array('title' => __('About', 'thisy-world'), 'slug' => 'about', 'template' => 'page-about.php', 'content' => __('Welcome to Thisy-World!', 'thisy-world')),
        array('title' => __('Search', 'thisy-world'), 'slug' => 'search', 'template' => 'page-search.php'),
        array('title' => __('Download', 'thisy-world'), 'slug' => 'download', 'template' => 'page-download.php'),
    );
    foreach ($pages as $page_data) {
        $existing = get_page_by_path($page_data['slug']);
        if (!$existing) {
            $page_id = wp_insert_post(array('post_title' => $page_data['title'], 'post_name' => $page_data['slug'], 'post_status' => 'publish', 'post_type' => 'page', 'post_content' => isset($page_data['content']) ? $page_data['content'] : ''));
            if ($page_id && isset($page_data['template'])) update_post_meta($page_id, '_wp_page_template', $page_data['template']);
        }
    }
    $home_page = get_page_by_path('home');
    if ($home_page) { update_option('page_on_front', $home_page->ID); update_option('show_on_front', 'page'); }
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'thisy_world_create_pages');

/**
 * View Count Support
 */
function thisy_world_set_view_count($post_id) {
    $count = get_post_meta($post_id, '_wm_view_count', true);
    if ($count == '') { delete_post_meta($post_id, '_wm_view_count'); add_post_meta($post_id, '_wm_view_count', '1'); }
    else { $count++; update_post_meta($post_id, '_wm_view_count', $count); }
}
function thisy_world_track_views($post_id) {
    if (!is_single() || get_post_type() !== 'series') return;
    if (empty($post_id)) { global $post; $post_id = $post->ID; }
    thisy_world_set_view_count($post_id);
}
add_action('wp_head', 'thisy_world_track_views');

/**
 * Helper Functions
 */
function thisy_world_get_episodes_url($series_id, $group_index = 0) { return add_query_arg('group', $group_index, get_permalink($series_id)); }
function thisy_world_get_download_url($link) { $download_page = get_page_by_path('download'); if ($download_page) { return add_query_arg('link', urlencode($link), get_permalink($download_page->ID)); } return $link; }
function thisy_world_get_download_groups($series_id) { $groups = get_post_meta($series_id, '_wm_download_groups', true); return is_array($groups) ? $groups : array(); }
function thisy_world_get_download_group($series_id, $group_index) { $groups = thisy_world_get_download_groups($series_id); return isset($groups[$group_index]) ? $groups[$group_index] : null; }
function thisy_world_get_screenshots($series_id) { $screenshots = get_post_meta($series_id, '_wm_screenshots', true); return is_array($screenshots) ? $screenshots : array(); }

/**
 * Search Filter - Include both series and movies
 */
function thisy_world_search_filter($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) { $query->set('post_type', array('series', 'movie')); }
    return $query;
}
add_filter('pre_get_posts', 'thisy_world_search_filter');

/**
 * Register Movies Custom Post Type
 */
function thisy_world_register_movies_cpt() {
    $labels = array(
        'name' => _x('Movies', 'post type general name', 'thisy-world'),
        'singular_name' => _x('Movie', 'post type singular name', 'thisy-world'),
        'menu_name' => _x('Movies', 'admin menu', 'thisy-world'),
        'add_new' => _x('Add New', 'movie', 'thisy-world'),
        'add_new_item' => __('Add New Movie', 'thisy-world'),
        'new_item' => __('New Movie', 'thisy-world'),
        'edit_item' => __('Edit Movie', 'thisy-world'),
        'view_item' => __('View Movie', 'thisy-world'),
        'all_items' => __('All Movies', 'thisy-world'),
        'search_items' => __('Search Movies', 'thisy-world'),
        'not_found' => __('No movies found.', 'thisy-world'),
        'not_found_in_trash' => __('No movies found in Trash.', 'thisy-world'),
    );
    $args = array('labels' => $labels, 'public' => true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_menu' => true, 'query_var' => true, 'rewrite' => array('slug' => 'movies'), 'capability_type' => 'post', 'has_archive' => true, 'hierarchical' => false, 'menu_position' => 6, 'menu_icon' => 'dashicons-video-alt2', 'supports' => array('title', 'editor', 'thumbnail', 'excerpt'), 'show_in_rest' => true);
    register_post_type('movie', $args);
}
add_action('init', 'thisy_world_register_movies_cpt');

/**
 * Add Movies Meta Boxes
 */
function thisy_world_add_movie_meta_boxes() {
    add_meta_box('wm_movie_screenshots', __('Screenshots Gallery', 'thisy-world'), 'thisy_world_movie_screenshots_meta_box', 'movie', 'normal', 'high');
    add_meta_box('wm_movie_downloads', __('Download Links', 'thisy-world'), 'thisy_world_movie_downloads_meta_box', 'movie', 'normal', 'high');
    add_meta_box('wm_movie_info', __('Movie Information', 'thisy-world'), 'thisy_world_movie_info_meta_box', 'movie', 'side', 'default');
}
add_action('add_meta_boxes', 'thisy_world_add_movie_meta_boxes');

function thisy_world_movie_screenshots_meta_box($post) {
    wp_nonce_field('wm_movie_screenshots_nonce', 'wm_movie_screenshots_nonce_field');
    $screenshots = get_post_meta($post->ID, '_wm_movie_screenshots', true);
    ?>
    <div class="wm-screenshots-uploader">
        <p><?php _e('Add screenshots for this movie.', 'thisy-world'); ?></p>
        <div id="wm-movie-screenshots-container" class="wm-screenshots-grid">
            <?php if (!empty($screenshots) && is_array($screenshots)) : foreach ($screenshots as $attachment_id) : ?>
                <div class="wm-screenshot-item" data-id="<?php echo esc_attr($attachment_id); ?>"><?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?><button type="button" class="wm-remove-screenshot">&times;</button></div>
            <?php endforeach; endif; ?>
        </div>
        <input type="hidden" name="wm_movie_screenshots" id="wm-movie-screenshots-input" value="<?php echo esc_attr(is_array($screenshots) ? implode(',', $screenshots) : ''); ?>">
        <p><button type="button" class="button button-primary" id="wm-add-movie-screenshots"><?php _e('Add Screenshots', 'thisy-world'); ?></button></p>
    </div>
    <script>jQuery(document).ready(function($){var frame;$('#wm-add-movie-screenshots').on('click',function(e){e.preventDefault();if(frame){frame.open();return}frame=wp.media({title:'<?php _e('Select Screenshots','thisy-world');?>',button:{text:'<?php _e('Add Screenshots','thisy-world');?>'},multiple:true});frame.on('select',function(){var attachments=frame.state().get('selection').toJSON();var ids=$('#wm-movie-screenshots-input').val()?$('#wm-movie-screenshots-input').val().split(','):[];attachments.forEach(function(attachment){if(ids.indexOf(attachment.id.toString())===-1){ids.push(attachment.id);var thumb=attachment.sizes.thumbnail?attachment.sizes.thumbnail.url:attachment.url;$('#wm-movie-screenshots-container').append('<div class="wm-screenshot-item" data-id="'+attachment.id+'"><img src="'+thumb+'"><button type="button" class="wm-remove-screenshot">&times;</button></div>')}});$('#wm-movie-screenshots-input').val(ids.join(','))});frame.open()});$(document).on('click','#wm-movie-screenshots-container .wm-remove-screenshot',function(){var item=$(this).closest('.wm-screenshot-item');var id=item.data('id').toString();var ids=$('#wm-movie-screenshots-input').val().split(',').filter(function(i){return i!==id});$('#wm-movie-screenshots-input').val(ids.join(','));item.remove()})});</script>
    <?php
}

function thisy_world_movie_downloads_meta_box($post) {
    wp_nonce_field('wm_movie_downloads_nonce', 'wm_movie_downloads_nonce_field');
    $download_links = get_post_meta($post->ID, '_wm_movie_downloads', true);
    if (!is_array($download_links)) $download_links = array();
    ?>
    <div class="wm-movie-downloads-manager">
        <p><?php _e('Add download links for different qualities.', 'thisy-world'); ?></p>
        <div id="wm-movie-downloads-container">
            <?php if (!empty($download_links)) : foreach ($download_links as $index => $link_data) : ?>
                <div class="wm-movie-download-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center">
                    <input type="text" name="wm_movie_downloads[<?php echo $index; ?>][name]" value="<?php echo esc_attr($link_data['name']); ?>" placeholder="<?php _e('e.g., 480p [400MB]', 'thisy-world'); ?>" class="regular-text" style="flex:1">
                    <input type="url" name="wm_movie_downloads[<?php echo $index; ?>][link]" value="<?php echo esc_url($link_data['link']); ?>" placeholder="https://..." class="regular-text" style="flex:2">
                    <button type="button" class="button wm-remove-movie-download"><span class="dashicons dashicons-trash" style="color:#dc3545"></span></button>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <p style="margin-top:15px"><button type="button" class="button button-primary" id="wm-add-movie-download"><span class="dashicons dashicons-plus-alt2"></span> <?php _e('Add Download Link', 'thisy-world'); ?></button></p>
    </div>
    <script>jQuery(document).ready(function($){var downloadIndex=<?php echo count($download_links);?>;$('#wm-add-movie-download').on('click',function(){var rowHtml='<div class="wm-movie-download-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center"><input type="text" name="wm_movie_downloads['+downloadIndex+'][name]" placeholder="<?php _e('e.g., 480p [400MB]','thisy-world');?>" class="regular-text" style="flex:1"><input type="url" name="wm_movie_downloads['+downloadIndex+'][link]" placeholder="https://..." class="regular-text" style="flex:2"><button type="button" class="button wm-remove-movie-download"><span class="dashicons dashicons-trash" style="color:#dc3545"></span></button></div>';$('#wm-movie-downloads-container').append(rowHtml);downloadIndex++});$(document).on('click','.wm-remove-movie-download',function(){$(this).closest('.wm-movie-download-row').remove()})});</script>
    <?php
}

function thisy_world_movie_info_meta_box($post) {
    wp_nonce_field('wm_movie_info_nonce', 'wm_movie_info_nonce_field');
    $year = get_post_meta($post->ID, '_wm_movie_year', true);
    $rating = get_post_meta($post->ID, '_wm_movie_rating', true);
    $duration = get_post_meta($post->ID, '_wm_movie_duration', true);
    $featured = get_post_meta($post->ID, '_wm_featured_home', true);
    ?>
    <p style="background:#fff3cd;padding:12px;border:1px solid #ffc107;border-radius:4px;margin-bottom:15px">
        <label for="wm_movie_featured_home" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:600;color:#856404">
            <input type="checkbox" id="wm_movie_featured_home" name="wm_movie_featured_home" value="1" <?php checked($featured, '1'); ?> style="width:18px;height:18px">
            <span class="dashicons dashicons-star-filled" style="color:#ffc107"></span>
            <?php _e('Show on Homepage', 'thisy-world'); ?>
        </label>
        <span class="description" style="display:block;margin-top:5px;font-size:11px"><?php _e('Check to display this movie on the homepage (max 12 items)', 'thisy-world'); ?></span>
    </p>
    <p><label for="wm_movie_year"><strong><?php _e('Release Year', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_movie_year" name="wm_movie_year" value="<?php echo esc_attr($year); ?>" min="1900" max="2099" class="widefat"></p>
    <p><label for="wm_movie_rating"><strong><?php _e('Rating (1-10)', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_movie_rating" name="wm_movie_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="10" step="0.1" class="widefat"></p>
    <p><label for="wm_movie_duration"><strong><?php _e('Duration (minutes)', 'thisy-world'); ?></strong></label><br><input type="number" id="wm_movie_duration" name="wm_movie_duration" value="<?php echo esc_attr($duration); ?>" min="1" class="widefat"><span class="description"><?php _e('e.g., 120 for 2 hours', 'thisy-world'); ?></span></p>
    <?php
}

function thisy_world_save_movie_meta($post_id) {
    if (!isset($_POST['wm_movie_screenshots_nonce_field']) || !wp_verify_nonce($_POST['wm_movie_screenshots_nonce_field'], 'wm_movie_screenshots_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['wm_movie_screenshots'])) { $screenshots = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['wm_movie_screenshots'])))); update_post_meta($post_id, '_wm_movie_screenshots', $screenshots); }
    if (isset($_POST['wm_movie_downloads']) && is_array($_POST['wm_movie_downloads'])) { $download_links = array(); foreach ($_POST['wm_movie_downloads'] as $link_data) { if (!empty($link_data['name']) && !empty($link_data['link'])) { $download_links[] = array('name' => sanitize_text_field($link_data['name']), 'link' => esc_url_raw($link_data['link'])); } } update_post_meta($post_id, '_wm_movie_downloads', $download_links); } else { delete_post_meta($post_id, '_wm_movie_downloads'); }
    if (isset($_POST['wm_movie_year'])) update_post_meta($post_id, '_wm_movie_year', intval($_POST['wm_movie_year']));
    if (isset($_POST['wm_movie_rating'])) update_post_meta($post_id, '_wm_movie_rating', floatval($_POST['wm_movie_rating']));
    if (isset($_POST['wm_movie_duration'])) update_post_meta($post_id, '_wm_movie_duration', intval($_POST['wm_movie_duration']));
    // Featured on Homepage
    if (isset($_POST['wm_movie_featured_home'])) {
        update_post_meta($post_id, '_wm_featured_home', '1');
    } else {
        delete_post_meta($post_id, '_wm_featured_home');
    }
}
add_action('save_post_movie', 'thisy_world_save_movie_meta');

function thisy_world_get_movie_downloads($movie_id) { $downloads = get_post_meta($movie_id, '_wm_movie_downloads', true); return is_array($downloads) ? $downloads : array(); }
function thisy_world_get_movie_screenshots($movie_id) { $screenshots = get_post_meta($movie_id, '_wm_movie_screenshots', true); return is_array($screenshots) ? $screenshots : array(); }

/**
 * Live Search AJAX Handler
 */
function thisy_world_live_search() {
    // Verify nonce
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'wm_live_search')) {
        wp_send_json(array('success' => false, 'message' => 'Invalid request'));
        exit;
    }
    
    $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    
    if (empty($search_query) || strlen($search_query) < 2) {
        wp_send_json(array('success' => false, 'results' => array()));
        exit;
    }
    
    $args = array(
        'post_type' => array('series', 'movie'),
        'posts_per_page' => 10,
        's' => $search_query,
        'post_status' => 'publish',
    );
    
    $query = new WP_Query($args);
    $results = array();
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_type = get_post_type();
            $is_movie = ($post_type === 'movie');
            
            $year = $is_movie 
                ? get_post_meta(get_the_ID(), '_wm_movie_year', true) 
                : get_post_meta(get_the_ID(), '_wm_year', true);
            
            $thumbnail = '';
            if (has_post_thumbnail()) {
                $thumbnail = '<img src="' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')) . '" alt="' . esc_attr(get_the_title()) . '">';
            }
            
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'type' => $post_type,
                'type_label' => $is_movie ? __('Movie', 'thisy-world') : __('Series', 'thisy-world'),
                'year' => $year,
                'thumbnail' => $thumbnail,
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json(array(
        'success' => true,
        'results' => array_slice($results, 0, 5),
        'total' => $query->found_posts,
    ));
    exit;
}
add_action('wp_ajax_wm_live_search', 'thisy_world_live_search');
add_action('wp_ajax_nopriv_wm_live_search', 'thisy_world_live_search');