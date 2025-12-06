<?php
/**
 * Archive Series Template
 *
 * Displays all series in a grid layout.
 *
 * @package Thisy-World
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
?>

<section class="wm-section" aria-labelledby="archive-heading">
    <div class="wm-container">
        <!-- Breadcrumbs -->
        <?php thisy_world_breadcrumbs(); ?>
        
        <h1 id="archive-heading" class="wm-title-lg wm-text-center wm-mb-xl wm-scroll-animate">
            <?php _e('All Series', 'thisy-world'); ?>
        </h1>
        
        <?php if (have_posts()) : ?>
            <div class="wm-series-grid wm-stagger" role="list">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="wm-series-card wm-scroll-animate" role="listitem" itemscope itemtype="https://schema.org/TVSeries">
                        <a href="<?php the_permalink(); ?>" class="wm-series-card__link" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                        <div class="wm-series-card__poster">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title(), 'loading' => 'lazy', 'itemprop' => 'image')); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
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
                                    <span itemprop="datePublished"><?php echo esc_html($year); ?></span>
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
            <div class="wm-pagination wm-mt-xl" style="text-align: center;">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '&laquo; ' . __('Previous', 'thisy-world'),
                    'next_text' => __('Next', 'thisy-world') . ' &raquo;',
                ));
                ?>
            </div>
            
        <?php else : ?>
            <div class="wm-no-results">
                <p><?php _e('No series found.', 'thisy-world'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>