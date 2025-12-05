<?php
/**
 * Search Results Template
 *
 * @package Thisy-World
 */

get_header();
?>

<section class="wm-search-page wm-section">
    <div class="wm-container">
        <div class="wm-search-page__header wm-scroll-animate">
            <h1 class="wm-title-lg">
                <?php printf(__('Search Results for: "%s"', 'thisy-world'), get_search_query()); ?>
            </h1>
        </div>
        
        <!-- Search Form -->
        <div class="wm-search wm-mt-lg wm-scroll-animate" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <form class="wm-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                <input type="search" 
                       class="wm-search__input" 
                       name="s" 
                       placeholder="<?php esc_attr_e('Search again...', 'thisy-world'); ?>" 
                       value="<?php echo get_search_query(); ?>">
                <button type="submit" class="wm-search__btn wm-tap-animate">
                    <?php _e('Search', 'thisy-world'); ?>
                </button>
            </form>
        </div>
        
        <!-- Search Results -->
        <div class="wm-search-results wm-mt-xl">
            <?php if (have_posts()) : ?>
                <p class="wm-text-center wm-text-muted wm-mb-lg wm-scroll-animate">
                    <?php printf(_n('%d result found', '%d results found', $wp_query->found_posts, 'thisy-world'), $wp_query->found_posts); ?>
                </p>
                
                <div class="wm-series-grid wm-stagger">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="wm-series-card wm-scroll-animate" onclick="window.location='<?php the_permalink(); ?>'">
                            <div class="wm-series-card__poster">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title())); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                
                                <div class="wm-series-card__overlay">
                                    <div class="wm-series-card__play">
                                        <svg viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="wm-series-card__content">
                                <h3 class="wm-series-card__title"><?php the_title(); ?></h3>
                                <div class="wm-series-card__meta">
                                    <?php
                                    $year = get_post_meta(get_the_ID(), '_wm_year', true);
                                    if ($year) echo '<span>' . esc_html($year) . '</span>';
                                    ?>
                                </div>
                            </div>
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
                <div class="wm-no-results wm-scroll-animate">
                    <p><?php _e('No series found matching your search. Try different keywords!', 'thisy-world'); ?></p>
                    
                    <div class="wm-mt-lg">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-tap-animate">
                            <?php _e('Browse All Series', 'thisy-world'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>