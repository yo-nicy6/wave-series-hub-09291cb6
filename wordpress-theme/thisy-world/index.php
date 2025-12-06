<?php
/**
 * The main template file (Home / Series Grid)
 *
 * @package Thisy-World
 */

get_header();

// Get series query
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';

$args = array(
    'post_type' => 'series',
    'posts_per_page' => 12,
    'paged' => $paged,
);

// Handle sorting
if ($orderby === 'views') {
    $args['meta_key'] = '_wm_view_count';
    $args['orderby'] = 'meta_value_num';
    $args['order'] = 'DESC';
} else {
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
}

$series_query = new WP_Query($args);
?>

<section class="wm-section" aria-labelledby="series-heading">
    <div class="wm-container">
        <!-- Breadcrumbs -->
        <?php if (!is_front_page()) thisy_world_breadcrumbs(); ?>
        
        <?php if ($orderby === 'views') : ?>
            <h1 id="series-heading" class="wm-title-lg wm-text-center wm-mb-xl wm-scroll-animate">
                <?php _e('Most Viewed Series', 'thisy-world'); ?>
            </h1>
        <?php elseif ($orderby === 'date') : ?>
            <h1 id="series-heading" class="wm-title-lg wm-text-center wm-mb-xl wm-scroll-animate">
                <?php _e('Recent Series', 'thisy-world'); ?>
            </h1>
        <?php else : ?>
            <h1 id="series-heading" class="wm-title-lg wm-text-center wm-mb-xl wm-scroll-animate">
                <?php _e('All Series', 'thisy-world'); ?>
            </h1>
        <?php endif; ?>
        
        <?php if ($series_query->have_posts()) : ?>
            <div class="wm-series-grid wm-stagger" role="list">
                <?php while ($series_query->have_posts()) : $series_query->the_post(); ?>
                    <article class="wm-series-card wm-scroll-animate" role="listitem" onclick="window.location='<?php the_permalink(); ?>'" itemscope itemtype="https://schema.org/TVSeries">
                        <a href="<?php the_permalink(); ?>" class="wm-series-card__link" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="wm-series-card__poster">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title(), 'itemprop' => 'image', 'loading' => 'lazy')); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <?php endif; ?>
                            
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
                                <?php
                                $year = get_post_meta(get_the_ID(), '_wm_year', true);
                                $episode_count = get_post_meta(get_the_ID(), '_wm_episode_count', true);
                                ?>
                                <?php if ($year) : ?>
                                    <span><?php echo esc_html($year); ?></span>
                                <?php endif; ?>
                                <?php if ($episode_count) : ?>
                                    <span> • <?php printf(_n('%d Episode', '%d Episodes', intval($episode_count), 'thisy-world'), intval($episode_count)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <div class="wm-pagination wm-mt-xl">
                <?php
                echo paginate_links(array(
                    'total' => $series_query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => '&laquo; ' . __('Previous', 'thisy-world'),
                    'next_text' => __('Next', 'thisy-world') . ' &raquo;',
                ));
                ?>
            </div>
            
            <?php wp_reset_postdata(); ?>
            
        <?php else : ?>
            <div class="wm-no-results">
                <p><?php _e('No series found. Add your first series from the admin dashboard!', 'thisy-world'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>