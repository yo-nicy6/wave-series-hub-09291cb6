<?php
/**
 * The main template file (Home - Featured Content)
 *
 * @package Thisy-World
 */

get_header();

// Get featured movies and series (max 12), ordered by display order
$args = array(
    'post_type' => array('series', 'movie'),
    'posts_per_page' => 12,
    'meta_query' => array(
        array(
            'key' => '_wm_featured_home',
            'value' => '1',
            'compare' => '='
        )
    ),
    'meta_key' => '_wm_featured_order',
    'orderby' => array(
        'meta_value_num' => 'ASC',
        'date' => 'DESC'
    ),
);

$featured_query = new WP_Query($args);
?>

<section class="wm-section" aria-labelledby="featured-heading">
    <div class="wm-container">
        <h1 id="featured-heading" class="wm-title-lg wm-text-center wm-mb-xl wm-scroll-animate">
            <?php _e('Featured Movies & Series', 'thisy-world'); ?>
        </h1>
        
        <?php if ($featured_query->have_posts()) : ?>
            <div class="wm-series-grid wm-stagger" role="list">
                <?php while ($featured_query->have_posts()) : $featured_query->the_post(); 
                    $post_type = get_post_type();
                    $is_movie = ($post_type === 'movie');
                ?>
                    <article class="wm-series-card wm-scroll-animate" role="listitem" onclick="window.location='<?php the_permalink(); ?>'" itemscope itemtype="<?php echo $is_movie ? 'https://schema.org/Movie' : 'https://schema.org/TVSeries'; ?>">
                        <a href="<?php the_permalink(); ?>" class="wm-series-card__link" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="wm-series-card__poster">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title(), 'itemprop' => 'image', 'loading' => 'lazy')); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <?php endif; ?>
                            
                            <!-- Type Badge -->
                            <span class="wm-type-badge wm-type-badge--<?php echo $is_movie ? 'movie' : 'series'; ?>">
                                <?php echo $is_movie ? __('Movie', 'thisy-world') : __('Series', 'thisy-world'); ?>
                            </span>
                            
                            <div class="wm-series-card__overlay">
                                <div class="wm-series-card__play">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="wm-series-card__content">
                            <h3 class="wm-series-card__title" itemprop="name"><?php the_title(); ?></h3>
                            <div class="wm-series-card__meta">
                                <?php if ($is_movie) : 
                                    $year = get_post_meta(get_the_ID(), '_wm_movie_year', true);
                                    $duration = get_post_meta(get_the_ID(), '_wm_movie_duration', true);
                                ?>
                                    <?php if ($year) : ?>
                                        <span><?php echo esc_html($year); ?></span>
                                    <?php endif; ?>
                                    <?php if ($duration) : ?>
                                        <span> • <?php printf(__('%d min', 'thisy-world'), intval($duration)); ?></span>
                                    <?php endif; ?>
                                <?php else : 
                                    $year = get_post_meta(get_the_ID(), '_wm_year', true);
                                    $episode_count = get_post_meta(get_the_ID(), '_wm_episode_count', true);
                                ?>
                                    <?php if ($year) : ?>
                                        <span><?php echo esc_html($year); ?></span>
                                    <?php endif; ?>
                                    <?php if ($episode_count) : ?>
                                        <span> • <?php printf(_n('%d Episode', '%d Episodes', intval($episode_count), 'thisy-world'), intval($episode_count)); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <?php wp_reset_postdata(); ?>
            
        <?php else : ?>
            <div class="wm-no-results">
                <div class="wm-no-results__icon">
                    <span class="dashicons dashicons-star-empty" style="font-size:48px;width:48px;height:48px"></span>
                </div>
                <p><?php _e('No featured content yet.', 'thisy-world'); ?></p>
                <p class="wm-no-results__hint"><?php _e('To add movies or series to the homepage, edit them in the WordPress dashboard and check "Show on Homepage".', 'thisy-world'); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Search Prompt -->
        <div class="wm-search-prompt wm-mt-xl wm-scroll-animate">
            <h2><?php _e('Looking for more?', 'thisy-world'); ?></h2>
            <p><?php _e('Use the search to find all available movies and series.', 'thisy-world'); ?></p>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('search'))); ?>" class="wm-btn wm-btn--primary">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <?php _e('Search Movies & Series', 'thisy-world'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
