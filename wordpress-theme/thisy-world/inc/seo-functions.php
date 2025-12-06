<?php
/**
 * Thisy-World SEO Functions
 * 
 * Comprehensive SEO enhancements for better search engine visibility
 *
 * @package Thisy-World
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add SEO Meta Tags to Head
 */
function thisy_world_seo_meta_tags() {
    $site_name = get_bloginfo('name');
    $site_desc = get_bloginfo('description') ?: 'Your Ultimate Destination for Movies & Series Downloads';
    
    // Default values
    $meta_title = $site_name;
    $meta_description = $site_desc;
    $meta_image = get_template_directory_uri() . '/assets/images/og-default.jpg';
    $meta_url = home_url($_SERVER['REQUEST_URI']);
    $meta_type = 'website';
    
    // Single Series
    if (is_singular('series')) {
        global $post;
        $meta_title = get_the_title() . ' - ' . __('Download Series', 'thisy-world') . ' | ' . $site_name;
        $meta_description = wp_trim_words(get_the_excerpt() ?: get_the_content(), 25, '...');
        $meta_description .= ' ' . __('Download all episodes in HD quality.', 'thisy-world');
        $meta_type = 'video.tv_show';
        
        if (has_post_thumbnail()) {
            $meta_image = get_the_post_thumbnail_url($post->ID, 'wm-poster-large');
        }
    }
    
    // Single Movie
    if (is_singular('movie')) {
        global $post;
        $meta_title = get_the_title() . ' - ' . __('Download Movie', 'thisy-world') . ' | ' . $site_name;
        $meta_description = wp_trim_words(get_the_excerpt() ?: get_the_content(), 25, '...');
        $meta_description .= ' ' . __('Download in multiple qualities.', 'thisy-world');
        $meta_type = 'video.movie';
        
        if (has_post_thumbnail()) {
            $meta_image = get_the_post_thumbnail_url($post->ID, 'wm-poster-large');
        }
    }
    
    // Archive pages
    if (is_post_type_archive('series')) {
        $meta_title = __('All Series', 'thisy-world') . ' - ' . __('Download TV Shows', 'thisy-world') . ' | ' . $site_name;
        $meta_description = __('Browse and download all available TV series in HD quality. Free direct download links for your favorite shows.', 'thisy-world');
    }
    
    if (is_post_type_archive('movie')) {
        $meta_title = __('All Movies', 'thisy-world') . ' - ' . __('Download Films', 'thisy-world') . ' | ' . $site_name;
        $meta_description = __('Browse and download all available movies in HD quality. Free direct download links for latest films.', 'thisy-world');
    }
    
    // Search page
    if (is_search()) {
        $search_query = get_search_query();
        $meta_title = sprintf(__('Search Results for "%s"', 'thisy-world'), $search_query) . ' | ' . $site_name;
        $meta_description = sprintf(__('Search results for "%s". Find movies and series to download.', 'thisy-world'), $search_query);
    }
    
    // Home page
    if (is_front_page() || is_home()) {
        $meta_title = $site_name . ' - ' . $site_desc;
        $meta_description = __('Download your favorite movies and TV series in HD quality. Free direct download links, multiple quality options, and fast servers.', 'thisy-world');
    }
    
    // Clean description
    $meta_description = wp_strip_all_tags($meta_description);
    $meta_description = preg_replace('/\s+/', ' ', $meta_description);
    $meta_description = substr($meta_description, 0, 160);
    
    ?>
    <!-- SEO Meta Tags - Thisy-World -->
    <meta name="description" content="<?php echo esc_attr($meta_description); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?php echo esc_url($meta_url); ?>">
    
    <!-- Open Graph -->
    <meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
    <meta property="og:type" content="<?php echo esc_attr($meta_type); ?>">
    <meta property="og:title" content="<?php echo esc_attr($meta_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta property="og:url" content="<?php echo esc_url($meta_url); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:image" content="<?php echo esc_url($meta_image); ?>">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="900">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($meta_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($meta_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($meta_image); ?>">
    
    <?php
}
add_action('wp_head', 'thisy_world_seo_meta_tags', 1);

/**
 * JSON-LD Schema Markup for Series
 */
function thisy_world_series_schema() {
    if (!is_singular('series')) return;
    
    global $post;
    $year = get_post_meta($post->ID, '_wm_year', true);
    $rating = get_post_meta($post->ID, '_wm_rating', true);
    $status = get_post_meta($post->ID, '_wm_status', true);
    $episode_count = get_post_meta($post->ID, '_wm_episode_count', true);
    $genres = get_the_terms($post->ID, 'genre');
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'TVSeries',
        'name' => get_the_title(),
        'description' => wp_strip_all_tags(get_the_excerpt() ?: get_the_content()),
        'url' => get_permalink(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
    );
    
    if (has_post_thumbnail()) {
        $schema['image'] = get_the_post_thumbnail_url($post->ID, 'wm-poster-large');
    }
    
    if ($year) {
        $schema['startDate'] = $year . '-01-01';
    }
    
    if ($rating) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => floatval($rating),
            'bestRating' => 10,
            'worstRating' => 1,
            'ratingCount' => 1,
        );
    }
    
    if ($episode_count) {
        $schema['numberOfEpisodes'] = intval($episode_count);
    }
    
    if ($genres && !is_wp_error($genres)) {
        $schema['genre'] = array_map(function($genre) {
            return $genre->name;
        }, $genres);
    }
    
    if ($status === 'completed') {
        $schema['status'] = 'Ended';
    } elseif ($status === 'ongoing') {
        $schema['status'] = 'Running';
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_series_schema', 2);

/**
 * JSON-LD Schema Markup for Movies
 */
function thisy_world_movie_schema() {
    if (!is_singular('movie')) return;
    
    global $post;
    $year = get_post_meta($post->ID, '_wm_movie_year', true);
    $rating = get_post_meta($post->ID, '_wm_movie_rating', true);
    $duration = get_post_meta($post->ID, '_wm_movie_duration', true);
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Movie',
        'name' => get_the_title(),
        'description' => wp_strip_all_tags(get_the_excerpt() ?: get_the_content()),
        'url' => get_permalink(),
        'datePublished' => get_the_date('c'),
        'dateModified' => get_the_modified_date('c'),
    );
    
    if (has_post_thumbnail()) {
        $schema['image'] = get_the_post_thumbnail_url($post->ID, 'wm-poster-large');
    }
    
    if ($year) {
        $schema['dateCreated'] = $year . '-01-01';
    }
    
    if ($rating) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => floatval($rating),
            'bestRating' => 10,
            'worstRating' => 1,
            'ratingCount' => 1,
        );
    }
    
    if ($duration) {
        $schema['duration'] = 'PT' . intval($duration) . 'M';
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_movie_schema', 2);

/**
 * Website Schema Markup
 */
function thisy_world_website_schema() {
    if (!is_front_page()) return;
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url('/'),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}'),
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_website_schema', 2);

/**
 * Breadcrumb Schema
 */
function thisy_world_breadcrumb_schema() {
    $items = array();
    $position = 1;
    
    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => __('Home', 'thisy-world'),
        'item' => home_url('/'),
    );
    
    if (is_singular('series')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Series', 'thisy-world'),
            'item' => get_post_type_archive_link('series'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_singular('movie')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Movies', 'thisy-world'),
            'item' => get_post_type_archive_link('movie'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    } elseif (is_post_type_archive('series')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Series', 'thisy-world'),
            'item' => get_post_type_archive_link('series'),
        );
    } elseif (is_post_type_archive('movie')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Movies', 'thisy-world'),
            'item' => get_post_type_archive_link('movie'),
        );
    }
    
    if (count($items) < 2) return;
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_breadcrumb_schema', 2);

/**
 * Display Breadcrumbs HTML
 */
function thisy_world_breadcrumbs() {
    if (is_front_page()) return;
    
    $sep = '<span class="wm-breadcrumb-sep">/</span>';
    
    echo '<nav class="wm-breadcrumbs" aria-label="' . esc_attr__('Breadcrumb', 'thisy-world') . '">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'thisy-world') . '</a>';
    
    if (is_singular('series')) {
        echo $sep . '<a href="' . esc_url(get_post_type_archive_link('series')) . '">' . esc_html__('Series', 'thisy-world') . '</a>';
        echo $sep . '<span class="wm-breadcrumb-current">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_singular('movie')) {
        echo $sep . '<a href="' . esc_url(get_post_type_archive_link('movie')) . '">' . esc_html__('Movies', 'thisy-world') . '</a>';
        echo $sep . '<span class="wm-breadcrumb-current">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_post_type_archive('series')) {
        echo $sep . '<span class="wm-breadcrumb-current">' . esc_html__('All Series', 'thisy-world') . '</span>';
    } elseif (is_post_type_archive('movie')) {
        echo $sep . '<span class="wm-breadcrumb-current">' . esc_html__('All Movies', 'thisy-world') . '</span>';
    } elseif (is_search()) {
        echo $sep . '<span class="wm-breadcrumb-current">' . esc_html__('Search Results', 'thisy-world') . '</span>';
    }
    
    echo '</nav>';
}

/**
 * Add Preconnect for Performance
 */
function thisy_world_resource_hints($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'thisy_world_resource_hints', 10, 2);

/**
 * Optimize Title Tag
 */
function thisy_world_document_title_parts($title) {
    if (is_singular('series')) {
        $title['title'] = get_the_title() . ' - ' . __('Download Series', 'thisy-world');
    } elseif (is_singular('movie')) {
        $title['title'] = get_the_title() . ' - ' . __('Download Movie', 'thisy-world');
    } elseif (is_post_type_archive('series')) {
        $title['title'] = __('All Series - Download TV Shows', 'thisy-world');
    } elseif (is_post_type_archive('movie')) {
        $title['title'] = __('All Movies - Download Films', 'thisy-world');
    }
    return $title;
}
add_filter('document_title_parts', 'thisy_world_document_title_parts');

/**
 * Add noindex to utility pages
 */
function thisy_world_noindex_pages() {
    if (is_page('download') || is_404()) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    }
}
add_action('wp_head', 'thisy_world_noindex_pages', 1);

/**
 * Ping Search Engines on New Content
 */
function thisy_world_ping_search_engines($post_id) {
    $post_type = get_post_type($post_id);
    if (!in_array($post_type, array('series', 'movie'))) return;
    
    $sitemap_url = home_url('/sitemap_index.xml');
    
    // Ping Google
    wp_remote_get('https://www.google.com/ping?sitemap=' . urlencode($sitemap_url), array('blocking' => false));
    
    // Ping Bing
    wp_remote_get('https://www.bing.com/ping?sitemap=' . urlencode($sitemap_url), array('blocking' => false));
}
add_action('publish_series', 'thisy_world_ping_search_engines');
add_action('publish_movie', 'thisy_world_ping_search_engines');

/**
 * Add Focus Keywords Meta Box
 */
function thisy_world_add_seo_meta_box() {
    $screens = array('series', 'movie');
    foreach ($screens as $screen) {
        add_meta_box(
            'thisy_world_seo',
            __('SEO Settings', 'thisy-world'),
            'thisy_world_seo_meta_box_callback',
            $screen,
            'normal',
            'low'
        );
    }
}
add_action('add_meta_boxes', 'thisy_world_add_seo_meta_box');

function thisy_world_seo_meta_box_callback($post) {
    wp_nonce_field('thisy_world_seo_save', 'thisy_world_seo_nonce');
    $focus_keyword = get_post_meta($post->ID, '_thisy_focus_keyword', true);
    $custom_description = get_post_meta($post->ID, '_thisy_meta_description', true);
    ?>
    <p>
        <label for="thisy_focus_keyword"><strong><?php _e('Focus Keyword', 'thisy-world'); ?></strong></label><br>
        <input type="text" id="thisy_focus_keyword" name="thisy_focus_keyword" value="<?php echo esc_attr($focus_keyword); ?>" class="widefat" placeholder="<?php esc_attr_e('e.g., Breaking Bad download', 'thisy-world'); ?>">
        <span class="description"><?php _e('Primary keyword for this content', 'thisy-world'); ?></span>
    </p>
    <p>
        <label for="thisy_meta_description"><strong><?php _e('Custom Meta Description', 'thisy-world'); ?></strong></label><br>
        <textarea id="thisy_meta_description" name="thisy_meta_description" rows="3" class="widefat" placeholder="<?php esc_attr_e('Custom description for search engines (max 160 chars)', 'thisy-world'); ?>"><?php echo esc_textarea($custom_description); ?></textarea>
        <span class="description"><?php _e('Leave empty to auto-generate from excerpt', 'thisy-world'); ?></span>
    </p>
    <?php
}

function thisy_world_save_seo_meta($post_id) {
    if (!isset($_POST['thisy_world_seo_nonce']) || !wp_verify_nonce($_POST['thisy_world_seo_nonce'], 'thisy_world_seo_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    
    if (isset($_POST['thisy_focus_keyword'])) {
        update_post_meta($post_id, '_thisy_focus_keyword', sanitize_text_field($_POST['thisy_focus_keyword']));
    }
    if (isset($_POST['thisy_meta_description'])) {
        update_post_meta($post_id, '_thisy_meta_description', sanitize_textarea_field($_POST['thisy_meta_description']));
    }
}
add_action('save_post_series', 'thisy_world_save_seo_meta');
add_action('save_post_movie', 'thisy_world_save_seo_meta');

/**
 * Add ItemList Schema for Archives
 */
function thisy_world_archive_schema() {
    if (!is_post_type_archive(array('series', 'movie')) && !is_home()) return;
    
    global $wp_query;
    if (!$wp_query->have_posts()) return;
    
    $items = array();
    $position = 1;
    
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'url' => get_permalink(),
            'name' => get_the_title(),
        );
    }
    wp_reset_postdata();
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => $items,
        'numberOfItems' => count($items),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_archive_schema', 2);

/**
 * Add FAQ Schema Support (for About page)
 */
function thisy_world_faq_schema() {
    if (!is_page('about')) return;
    
    $faqs = array(
        array(
            'question' => __('How to download series?', 'thisy-world'),
            'answer' => __('Click on any series, choose your preferred quality, and download episodes directly.', 'thisy-world'),
        ),
        array(
            'question' => __('What video qualities are available?', 'thisy-world'),
            'answer' => __('We offer multiple qualities including 480p, 720p, and 1080p for most content.', 'thisy-world'),
        ),
        array(
            'question' => __('Is downloading free?', 'thisy-world'),
            'answer' => __('Yes, all downloads are completely free with no registration required.', 'thisy-world'),
        ),
    );
    
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(function($faq) {
            return array(
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ),
            );
        }, $faqs),
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'thisy_world_faq_schema', 2);
