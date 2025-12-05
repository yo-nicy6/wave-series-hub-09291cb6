<?php
/**
 * Archive Movies Template
 *
 * @package Thisy-World
 */

get_header();
?>

<section class="wm-archive wm-section">
    <div class="wm-container">
        <div class="wm-archive-header wm-scroll-animate">
            <h1 class="wm-title-xl"><?php _e('All Movies', 'thisy-world'); ?></h1>
            <p class="wm-archive-subtitle"><?php _e('Browse our complete movie collection', 'thisy-world'); ?></p>
        </div>
        
        <?php if (have_posts()) : ?>
            <div class="wm-series-grid wm-stagger">
                <?php while (have_posts()) : the_post(); 
                    $year = get_post_meta(get_the_ID(), '_wm_movie_year', true);
                    $rating = get_post_meta(get_the_ID(), '_wm_movie_rating', true);
                    $duration = get_post_meta(get_the_ID(), '_wm_movie_duration', true);
                    
                    // Format duration
                    $duration_formatted = '';
                    if ($duration) {
                        $hours = floor($duration / 60);
                        $mins = $duration % 60;
                        if ($hours > 0) {
                            $duration_formatted = $hours . 'h ' . $mins . 'm';
                        } else {
                            $duration_formatted = $mins . 'm';
                        }
                    }
                ?>
                    <a href="<?php the_permalink(); ?>" class="wm-series-card wm-scroll-animate">
                        <div class="wm-series-card__poster">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('wm-poster'); ?>
                            <?php else : ?>
                                <div class="wm-series-card__placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                                        <line x1="7" y1="2" x2="7" y2="22"></line>
                                        <line x1="17" y1="2" x2="17" y2="22"></line>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <line x1="2" y1="7" x2="7" y2="7"></line>
                                        <line x1="2" y1="17" x2="7" y2="17"></line>
                                        <line x1="17" y1="17" x2="22" y2="17"></line>
                                        <line x1="17" y1="7" x2="22" y2="7"></line>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <div class="wm-series-card__overlay">
                                <div class="wm-series-card__play">
                                    <svg viewBox="0 0 24 24">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                </div>
                            </div>
                            <span class="wm-badge wm-badge--movie" style="position: absolute; top: 8px; left: 8px; font-size: 0.7rem; padding: 0.25rem 0.5rem;">
                                <?php _e('Movie', 'thisy-world'); ?>
                            </span>
                        </div>
                        <div class="wm-series-card__content">
                            <h3 class="wm-series-card__title"><?php the_title(); ?></h3>
                            <p class="wm-series-card__meta">
                                <?php if ($year) echo esc_html($year); ?>
                                <?php if ($year && $duration_formatted) echo ' • '; ?>
                                <?php if ($duration_formatted) echo esc_html($duration_formatted); ?>
                            </p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <div class="wm-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"></path></svg>',
                    'next_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"></path></svg>',
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="wm-no-results">
                <p><?php _e('No movies found. Check back soon!', 'thisy-world'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>