<?php
/**
 * Wave-Movies Theme Functions
 *
 * @package Wave-Movies
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function wave_movies_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Custom image sizes
    add_image_size('wm-poster', 400, 600, true);
    add_image_size('wm-poster-large', 600, 900, true);
    add_image_size('wm-screenshot', 800, 450, true);
    add_image_size('wm-card', 300, 450, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wave-movies'),
        'footer' => __('Footer Menu', 'wave-movies'),
    ));
}
add_action('after_setup_theme', 'wave_movies_setup');

/**
 * Enqueue Scripts and Styles
 */
function wave_movies_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'wave-movies-fonts',
        'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );
    
    // Main stylesheet
    wp_enqueue_style(
        'wave-movies-style',
        get_stylesheet_uri(),
        array('wave-movies-fonts'),
        wp_get_theme()->get('Version')
    );
    
    // Animations JavaScript
    wp_enqueue_script(
        'wave-movies-animations',
        get_template_directory_uri() . '/assets/js/animations.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
    
    // Pass data to JS
    wp_localize_script('wave-movies-animations', 'wmData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wm_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'wave_movies_scripts');

/**
 * Register Series Custom Post Type
 */
function wave_movies_register_series_cpt() {
    $labels = array(
        'name'               => _x('Series', 'post type general name', 'wave-movies'),
        'singular_name'      => _x('Series', 'post type singular name', 'wave-movies'),
        'menu_name'          => _x('Series', 'admin menu', 'wave-movies'),
        'add_new'            => _x('Add New', 'series', 'wave-movies'),
        'add_new_item'       => __('Add New Series', 'wave-movies'),
        'new_item'           => __('New Series', 'wave-movies'),
        'edit_item'          => __('Edit Series', 'wave-movies'),
        'view_item'          => __('View Series', 'wave-movies'),
        'all_items'          => __('All Series', 'wave-movies'),
        'search_items'       => __('Search Series', 'wave-movies'),
        'not_found'          => __('No series found.', 'wave-movies'),
        'not_found_in_trash' => __('No series found in Trash.', 'wave-movies'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'series'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('series', $args);
}
add_action('init', 'wave_movies_register_series_cpt');

/**
 * Register Series Taxonomy (Genres)
 */
function wave_movies_register_genre_taxonomy() {
    $labels = array(
        'name'              => _x('Genres', 'taxonomy general name', 'wave-movies'),
        'singular_name'     => _x('Genre', 'taxonomy singular name', 'wave-movies'),
        'search_items'      => __('Search Genres', 'wave-movies'),
        'all_items'         => __('All Genres', 'wave-movies'),
        'edit_item'         => __('Edit Genre', 'wave-movies'),
        'update_item'       => __('Update Genre', 'wave-movies'),
        'add_new_item'      => __('Add New Genre', 'wave-movies'),
        'new_item_name'     => __('New Genre Name', 'wave-movies'),
        'menu_name'         => __('Genres', 'wave-movies'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'genre'),
        'show_in_rest'      => true,
    );

    register_taxonomy('genre', array('series'), $args);
}
add_action('init', 'wave_movies_register_genre_taxonomy');

/**
 * Add Series Meta Boxes
 */
function wave_movies_add_series_meta_boxes() {
    add_meta_box(
        'wm_series_screenshots',
        __('Screenshots Gallery', 'wave-movies'),
        'wave_movies_screenshots_meta_box',
        'series',
        'normal',
        'high'
    );
    
    add_meta_box(
        'wm_series_episodes',
        __('Episodes & Download Links', 'wave-movies'),
        'wave_movies_episodes_meta_box',
        'series',
        'normal',
        'high'
    );
    
    add_meta_box(
        'wm_series_info',
        __('Series Information', 'wave-movies'),
        'wave_movies_info_meta_box',
        'series',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'wave_movies_add_series_meta_boxes');

/**
 * Screenshots Meta Box Callback
 */
function wave_movies_screenshots_meta_box($post) {
    wp_nonce_field('wm_screenshots_nonce', 'wm_screenshots_nonce_field');
    $screenshots = get_post_meta($post->ID, '_wm_screenshots', true);
    ?>
    <div class="wm-screenshots-uploader">
        <p><?php _e('Add screenshots for this series. Click "Add Screenshots" to upload or select images.', 'wave-movies'); ?></p>
        
        <div id="wm-screenshots-container" class="wm-screenshots-grid">
            <?php if (!empty($screenshots) && is_array($screenshots)) : ?>
                <?php foreach ($screenshots as $attachment_id) : ?>
                    <div class="wm-screenshot-item" data-id="<?php echo esc_attr($attachment_id); ?>">
                        <?php echo wp_get_attachment_image($attachment_id, 'thumbnail'); ?>
                        <button type="button" class="wm-remove-screenshot">&times;</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <input type="hidden" name="wm_screenshots" id="wm-screenshots-input" value="<?php echo esc_attr(is_array($screenshots) ? implode(',', $screenshots) : ''); ?>">
        
        <p>
            <button type="button" class="button button-primary" id="wm-add-screenshots">
                <?php _e('Add Screenshots', 'wave-movies'); ?>
            </button>
        </p>
    </div>
    
    <style>
        .wm-screenshots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            margin: 15px 0;
        }
        .wm-screenshot-item {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .wm-screenshot-item img {
            width: 100%;
            height: auto;
            display: block;
        }
        .wm-remove-screenshot {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var frame;
        
        $('#wm-add-screenshots').on('click', function(e) {
            e.preventDefault();
            
            if (frame) {
                frame.open();
                return;
            }
            
            frame = wp.media({
                title: '<?php _e('Select Screenshots', 'wave-movies'); ?>',
                button: { text: '<?php _e('Add Screenshots', 'wave-movies'); ?>' },
                multiple: true
            });
            
            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var ids = $('#wm-screenshots-input').val() ? $('#wm-screenshots-input').val().split(',') : [];
                
                attachments.forEach(function(attachment) {
                    if (ids.indexOf(attachment.id.toString()) === -1) {
                        ids.push(attachment.id);
                        var thumb = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        $('#wm-screenshots-container').append(
                            '<div class="wm-screenshot-item" data-id="' + attachment.id + '">' +
                            '<img src="' + thumb + '">' +
                            '<button type="button" class="wm-remove-screenshot">&times;</button>' +
                            '</div>'
                        );
                    }
                });
                
                $('#wm-screenshots-input').val(ids.join(','));
            });
            
            frame.open();
        });
        
        $(document).on('click', '.wm-remove-screenshot', function() {
            var item = $(this).closest('.wm-screenshot-item');
            var id = item.data('id').toString();
            var ids = $('#wm-screenshots-input').val().split(',').filter(function(i) { return i !== id; });
            $('#wm-screenshots-input').val(ids.join(','));
            item.remove();
        });
    });
    </script>
    <?php
}

/**
 * Episodes Meta Box Callback
 */
function wave_movies_episodes_meta_box($post) {
    wp_nonce_field('wm_episodes_nonce', 'wm_episodes_nonce_field');
    $episodes = get_post_meta($post->ID, '_wm_episodes', true);
    if (!is_array($episodes)) {
        $episodes = array();
    }
    ?>
    <div class="wm-episodes-manager">
        <p><?php _e('Add episodes with their download links. Each episode will appear on the episodes page.', 'wave-movies'); ?></p>
        
        <table class="widefat" id="wm-episodes-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th><?php _e('Episode Title', 'wave-movies'); ?></th>
                    <th><?php _e('Download Link', 'wave-movies'); ?></th>
                    <th style="width: 60px;"><?php _e('Actions', 'wave-movies'); ?></th>
                </tr>
            </thead>
            <tbody id="wm-episodes-body">
                <?php if (!empty($episodes)) : ?>
                    <?php foreach ($episodes as $index => $episode) : ?>
                        <tr class="wm-episode-row" data-index="<?php echo $index; ?>">
                            <td class="wm-episode-number"><?php echo $index + 1; ?></td>
                            <td>
                                <input type="text" 
                                       name="wm_episodes[<?php echo $index; ?>][title]" 
                                       value="<?php echo esc_attr($episode['title']); ?>" 
                                       placeholder="<?php _e('Episode title...', 'wave-movies'); ?>"
                                       class="regular-text">
                            </td>
                            <td>
                                <input type="url" 
                                       name="wm_episodes[<?php echo $index; ?>][link]" 
                                       value="<?php echo esc_url($episode['link']); ?>" 
                                       placeholder="https://..."
                                       class="regular-text">
                            </td>
                            <td>
                                <button type="button" class="button wm-remove-episode" title="<?php _e('Remove', 'wave-movies'); ?>">
                                    <span class="dashicons dashicons-trash"></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <p style="margin-top: 15px;">
            <button type="button" class="button button-primary" id="wm-add-episode">
                <span class="dashicons dashicons-plus-alt" style="vertical-align: middle;"></span>
                <?php _e('Add Episode', 'wave-movies'); ?>
            </button>
        </p>
    </div>
    
    <style>
        #wm-episodes-table { margin-top: 15px; }
        #wm-episodes-table input { width: 100%; }
        .wm-episode-number { text-align: center; font-weight: bold; }
        .wm-remove-episode .dashicons { color: #dc3545; }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var episodeIndex = <?php echo count($episodes); ?>;
        
        $('#wm-add-episode').on('click', function() {
            var row = '<tr class="wm-episode-row" data-index="' + episodeIndex + '">' +
                '<td class="wm-episode-number">' + (episodeIndex + 1) + '</td>' +
                '<td><input type="text" name="wm_episodes[' + episodeIndex + '][title]" placeholder="<?php _e('Episode title...', 'wave-movies'); ?>" class="regular-text"></td>' +
                '<td><input type="url" name="wm_episodes[' + episodeIndex + '][link]" placeholder="https://..." class="regular-text"></td>' +
                '<td><button type="button" class="button wm-remove-episode" title="<?php _e('Remove', 'wave-movies'); ?>"><span class="dashicons dashicons-trash"></span></button></td>' +
                '</tr>';
            
            $('#wm-episodes-body').append(row);
            episodeIndex++;
            updateNumbers();
        });
        
        $(document).on('click', '.wm-remove-episode', function() {
            $(this).closest('tr').remove();
            updateNumbers();
        });
        
        function updateNumbers() {
            $('#wm-episodes-body tr').each(function(i) {
                $(this).find('.wm-episode-number').text(i + 1);
            });
        }
    });
    </script>
    <?php
}

/**
 * Series Info Meta Box Callback
 */
function wave_movies_info_meta_box($post) {
    wp_nonce_field('wm_info_nonce', 'wm_info_nonce_field');
    $year = get_post_meta($post->ID, '_wm_year', true);
    $rating = get_post_meta($post->ID, '_wm_rating', true);
    $status = get_post_meta($post->ID, '_wm_status', true);
    ?>
    <p>
        <label for="wm_year"><strong><?php _e('Release Year', 'wave-movies'); ?></strong></label><br>
        <input type="number" id="wm_year" name="wm_year" value="<?php echo esc_attr($year); ?>" min="1900" max="2099" class="widefat">
    </p>
    
    <p>
        <label for="wm_rating"><strong><?php _e('Rating (1-10)', 'wave-movies'); ?></strong></label><br>
        <input type="number" id="wm_rating" name="wm_rating" value="<?php echo esc_attr($rating); ?>" min="1" max="10" step="0.1" class="widefat">
    </p>
    
    <p>
        <label for="wm_status"><strong><?php _e('Status', 'wave-movies'); ?></strong></label><br>
        <select id="wm_status" name="wm_status" class="widefat">
            <option value="ongoing" <?php selected($status, 'ongoing'); ?>><?php _e('Ongoing', 'wave-movies'); ?></option>
            <option value="completed" <?php selected($status, 'completed'); ?>><?php _e('Completed', 'wave-movies'); ?></option>
            <option value="upcoming" <?php selected($status, 'upcoming'); ?>><?php _e('Upcoming', 'wave-movies'); ?></option>
        </select>
    </p>
    <?php
}

/**
 * Save Series Meta Data
 */
function wave_movies_save_series_meta($post_id) {
    // Verify nonces
    if (!isset($_POST['wm_screenshots_nonce_field']) || !wp_verify_nonce($_POST['wm_screenshots_nonce_field'], 'wm_screenshots_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save screenshots
    if (isset($_POST['wm_screenshots'])) {
        $screenshots = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['wm_screenshots']))));
        update_post_meta($post_id, '_wm_screenshots', $screenshots);
    }
    
    // Save episodes
    if (isset($_POST['wm_episodes']) && is_array($_POST['wm_episodes'])) {
        $episodes = array();
        foreach ($_POST['wm_episodes'] as $episode) {
            if (!empty($episode['title']) || !empty($episode['link'])) {
                $episodes[] = array(
                    'title' => sanitize_text_field($episode['title']),
                    'link' => esc_url_raw($episode['link']),
                );
            }
        }
        update_post_meta($post_id, '_wm_episodes', $episodes);
    } else {
        delete_post_meta($post_id, '_wm_episodes');
    }
    
    // Save info fields
    if (isset($_POST['wm_year'])) {
        update_post_meta($post_id, '_wm_year', intval($_POST['wm_year']));
    }
    
    if (isset($_POST['wm_rating'])) {
        update_post_meta($post_id, '_wm_rating', floatval($_POST['wm_rating']));
    }
    
    if (isset($_POST['wm_status'])) {
        update_post_meta($post_id, '_wm_status', sanitize_text_field($_POST['wm_status']));
    }
}
add_action('save_post_series', 'wave_movies_save_series_meta');

/**
 * Auto-Create Required Pages on Theme Activation
 */
function wave_movies_create_pages() {
    // Pages to create
    $pages = array(
        array(
            'title' => __('Home', 'wave-movies'),
            'slug' => 'home',
            'template' => 'page-home.php',
        ),
        array(
            'title' => __('About', 'wave-movies'),
            'slug' => 'about',
            'template' => 'page-about.php',
            'content' => __('Welcome to Wave-Movies! We are your premier destination for series downloads. Our platform offers a vast collection of TV series with high-quality downloads and a user-friendly interface.', 'wave-movies'),
        ),
        array(
            'title' => __('Search', 'wave-movies'),
            'slug' => 'search',
            'template' => 'page-search.php',
        ),
        array(
            'title' => __('Download', 'wave-movies'),
            'slug' => 'download',
            'template' => 'page-download.php',
        ),
    );
    
    foreach ($pages as $page_data) {
        // Check if page exists
        $existing = get_page_by_path($page_data['slug']);
        
        if (!$existing) {
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => isset($page_data['content']) ? $page_data['content'] : '',
            ));
            
            if ($page_id && isset($page_data['template'])) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }
    
    // Set Home as front page
    $home_page = get_page_by_path('home');
    if ($home_page) {
        update_option('page_on_front', $home_page->ID);
        update_option('show_on_front', 'page');
    }
    
    // Create primary menu
    $menu_name = 'Wave Movies Main Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Add menu items
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Home', 'wave-movies'),
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish',
        ));
        
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Series', 'wave-movies'),
            'menu-item-url' => get_post_type_archive_link('series'),
            'menu-item-status' => 'publish',
        ));
        
        $about_page = get_page_by_path('about');
        if ($about_page) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => __('About', 'wave-movies'),
                'menu-item-object' => 'page',
                'menu-item-object-id' => $about_page->ID,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ));
        }
        
        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'wave_movies_create_pages');

/**
 * Add View Count Support
 */
function wave_movies_set_view_count($post_id) {
    $count_key = '_wm_view_count';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '1');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function wave_movies_track_views($post_id) {
    if (!is_single() || get_post_type() !== 'series') return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    wave_movies_set_view_count($post_id);
}
add_action('wp_head', 'wave_movies_track_views');

/**
 * Get Most Viewed Series
 */
function wave_movies_get_most_viewed($count = 10) {
    return new WP_Query(array(
        'post_type' => 'series',
        'posts_per_page' => $count,
        'meta_key' => '_wm_view_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    ));
}

/**
 * Get Recent Series
 */
function wave_movies_get_recent($count = 10) {
    return new WP_Query(array(
        'post_type' => 'series',
        'posts_per_page' => $count,
        'orderby' => 'date',
        'order' => 'DESC',
    ));
}

/**
 * Episodes Page URL Helper
 */
function wave_movies_get_episodes_url($series_id) {
    return add_query_arg('episodes', $series_id, get_permalink($series_id));
}

/**
 * Download Redirect URL Helper
 */
function wave_movies_get_download_url($link) {
    $download_page = get_page_by_path('download');
    if ($download_page) {
        return add_query_arg('link', urlencode($link), get_permalink($download_page->ID));
    }
    return $link;
}

/**
 * Search Series Only
 */
function wave_movies_search_filter($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $query->set('post_type', 'series');
    }
    return $query;
}
add_filter('pre_get_posts', 'wave_movies_search_filter');

/**
 * Add Admin Columns for Series
 */
function wave_movies_series_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['episodes'] = __('Episodes', 'wave-movies');
            $new_columns['views'] = __('Views', 'wave-movies');
        }
    }
    return $new_columns;
}
add_filter('manage_series_posts_columns', 'wave_movies_series_columns');

function wave_movies_series_column_content($column, $post_id) {
    switch ($column) {
        case 'episodes':
            $episodes = get_post_meta($post_id, '_wm_episodes', true);
            echo is_array($episodes) ? count($episodes) : 0;
            break;
        case 'views':
            echo intval(get_post_meta($post_id, '_wm_view_count', true));
            break;
    }
}
add_action('manage_series_posts_custom_column', 'wave_movies_series_column_content', 10, 2);

/**
 * Theme Customizer Settings
 */
function wave_movies_customize_register($wp_customize) {
    // Footer Section
    $wp_customize->add_section('wm_footer', array(
        'title' => __('Footer Settings', 'wave-movies'),
        'priority' => 120,
    ));
    
    $wp_customize->add_setting('wm_footer_text', array(
        'default' => __('© 2024 Wave-Movies. All rights reserved. Your ultimate destination for series downloads.', 'wave-movies'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('wm_footer_text', array(
        'label' => __('Footer Text', 'wave-movies'),
        'section' => 'wm_footer',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'wave_movies_customize_register');

/**
 * Helper function to get episodes for a series
 */
function wave_movies_get_episodes($series_id) {
    $episodes = get_post_meta($series_id, '_wm_episodes', true);
    return is_array($episodes) ? $episodes : array();
}

/**
 * Helper function to get screenshots for a series
 */
function wave_movies_get_screenshots($series_id) {
    $screenshots = get_post_meta($series_id, '_wm_screenshots', true);
    return is_array($screenshots) ? $screenshots : array();
}
