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
                <div class="wm-search__wrapper">
                    <input type="search" 
                           class="wm-search__input" 
                           name="s" 
                           placeholder="<?php esc_attr_e('Search again...', 'thisy-world'); ?>" 
                           value="<?php echo get_search_query(); ?>">
                    <button type="submit" class="wm-search__btn wm-tap-animate">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <?php _e('Search', 'thisy-world'); ?>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Search Results -->
        <div class="wm-search-results wm-mt-xl">
            <?php if (have_posts()) : ?>
                <p class="wm-text-center wm-text-muted wm-mb-lg wm-scroll-animate">
                    <?php printf(_n('%d result found', '%d results found', $wp_query->found_posts, 'thisy-world'), $wp_query->found_posts); ?>
                </p>
                
                <div class="wm-series-grid wm-stagger">
                    <?php while (have_posts()) : the_post(); 
                        $post_type = get_post_type();
                        $is_movie = ($post_type === 'movie');
                    ?>
                        <article class="wm-series-card wm-scroll-animate" onclick="window.location='<?php the_permalink(); ?>'">
                            <div class="wm-series-card__poster">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title())); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                
                                <span class="wm-type-badge wm-type-badge--<?php echo $is_movie ? 'movie' : 'series'; ?>">
                                    <?php echo $is_movie ? __('Movie', 'thisy-world') : __('Series', 'thisy-world'); ?>
                                </span>
                                
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
                <!-- No Results Found - Enhanced Message -->
                <div class="wm-no-results-enhanced wm-scroll-animate">
                    <div class="wm-no-results-enhanced__icon">
                        <svg viewBox="0 0 24 24" width="80" height="80" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            <line x1="8" y1="8" x2="14" y2="14" stroke="var(--wm-primary)"></line>
                            <line x1="14" y1="8" x2="8" y2="14" stroke="var(--wm-primary)"></line>
                        </svg>
                    </div>
                    
                    <h2 class="wm-no-results-enhanced__title">
                        <?php _e('No Results Found', 'thisy-world'); ?>
                    </h2>
                    
                    <p class="wm-no-results-enhanced__query">
                        <?php printf(__('We couldn\'t find any movie or series matching "<strong>%s</strong>"', 'thisy-world'), esc_html(get_search_query())); ?>
                    </p>
                    
                    <div class="wm-no-results-enhanced__reasons">
                        <h3><?php _e('This could be because:', 'thisy-world'); ?></h3>
                        <ul>
                            <li><?php _e('The name might be spelled incorrectly', 'thisy-world'); ?></li>
                            <li><?php _e('This movie or series is not available in our database', 'thisy-world'); ?></li>
                            <li><?php _e('Try using the original title or an alternative name', 'thisy-world'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="wm-no-results-enhanced__suggestions">
                        <h3><?php _e('Suggestions:', 'thisy-world'); ?></h3>
                        <ul>
                            <li><?php _e('Check the spelling and try again', 'thisy-world'); ?></li>
                            <li><?php _e('Use fewer or different keywords', 'thisy-world'); ?></li>
                            <li><?php _e('Browse our homepage for available content', 'thisy-world'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="wm-no-results-enhanced__actions wm-mt-lg">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-btn--primary wm-tap-animate">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            <?php _e('Go to Homepage', 'thisy-world'); ?>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('search'))); ?>" class="wm-btn wm-btn--secondary wm-tap-animate">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <?php _e('Try Another Search', 'thisy-world'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
