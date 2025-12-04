<?php
/**
 * Template Name: Search Page
 *
 * @package Wave-Movies
 */

get_header();
?>

<section class="wm-search-page wm-section">
    <div class="wm-container">
        <div class="wm-search-page__header wm-scroll-animate">
            <h1 class="wm-title-lg"><?php _e('Search Series', 'wave-movies'); ?></h1>
        </div>
        
        <div class="wm-search wm-mt-lg wm-scroll-animate" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <form class="wm-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                <input type="search" 
                       class="wm-search__input" 
                       name="s" 
                       placeholder="<?php esc_attr_e('Type to search...', 'wave-movies'); ?>" 
                       value="<?php echo get_search_query(); ?>"
                       autofocus>
                <button type="submit" class="wm-search__btn wm-tap-animate">
                    <?php _e('Search', 'wave-movies'); ?>
                </button>
            </form>
        </div>
        
        <!-- Popular/Recent Series -->
        <div class="wm-search-results wm-mt-xl">
            <h2 class="wm-title-md wm-text-center wm-mb-lg wm-scroll-animate">
                <?php _e('Popular Series', 'wave-movies'); ?>
            </h2>
            
            <?php
            $popular = wave_movies_get_most_viewed(6);
            if ($popular->have_posts()) : ?>
                <div class="wm-series-grid wm-stagger">
                    <?php while ($popular->have_posts()) : $popular->the_post(); ?>
                        <article class="wm-series-card wm-scroll-animate" onclick="window.location='<?php the_permalink(); ?>'">
                            <div class="wm-series-card__poster">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title())); ?>
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
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="wm-no-results">
                    <p><?php _e('No series available yet.', 'wave-movies'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
