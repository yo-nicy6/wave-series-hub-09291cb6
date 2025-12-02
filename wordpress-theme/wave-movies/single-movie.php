<?php
/**
 * Single Movie Template
 *
 * @package Wave-Movies
 */

get_header();

// Get movie meta
$year = get_post_meta(get_the_ID(), '_wm_movie_year', true);
$rating = get_post_meta(get_the_ID(), '_wm_movie_rating', true);
$duration = get_post_meta(get_the_ID(), '_wm_movie_duration', true);
$screenshots = wave_movies_get_movie_screenshots(get_the_ID());
$downloads = wave_movies_get_movie_downloads(get_the_ID());

// Format duration
$duration_formatted = '';
if ($duration) {
    $hours = floor($duration / 60);
    $mins = $duration % 60;
    if ($hours > 0) {
        $duration_formatted = $hours . 'h ' . $mins . 'm';
    } else {
        $duration_formatted = $mins . ' min';
    }
}
?>

<section class="wm-single-series wm-single-movie">
    <div class="wm-container">
        <!-- Movie Hero Section -->
        <div class="wm-series-hero wm-scroll-animate">
            <div class="wm-series-poster">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('wm-poster-large'); ?>
                <?php else : ?>
                    <div class="wm-series-poster__placeholder">
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
            </div>
            
            <div class="wm-series-info">
                <span class="wm-badge wm-badge--movie"><?php _e('Movie', 'wave-movies'); ?></span>
                
                <h1 class="wm-series-info__title"><?php the_title(); ?></h1>
                
                <!-- Movie Meta -->
                <div class="wm-series-meta" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                    <?php if ($year) : ?>
                        <span class="wm-meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <?php echo esc_html($year); ?>
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($rating) : ?>
                        <span class="wm-meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                            <?php echo esc_html($rating); ?>/10
                        </span>
                    <?php endif; ?>
                    
                    <?php if ($duration_formatted) : ?>
                        <span class="wm-meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <?php echo esc_html($duration_formatted); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Description -->
                <div class="wm-series-info__description">
                    <?php the_content(); ?>
                </div>
                
                <!-- Download Buttons (Direct Links) -->
                <?php if (!empty($downloads)) : ?>
                    <div class="wm-download-section wm-scroll-animate" style="margin-top: 1.5rem; padding: 1.5rem; background: var(--wm-surface); border-radius: var(--wm-radius-lg); border: 1px solid var(--wm-border);">
                        <h3 style="text-align: center; margin-bottom: 1rem; color: var(--wm-primary); font-weight: 600;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 0.5rem;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            <?php _e('Download Movie', 'wave-movies'); ?>
                        </h3>
                        
                        <div class="wm-movie-downloads" style="display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center;">
                            <?php foreach ($downloads as $download) : ?>
                                <a href="<?php echo esc_url(wave_movies_get_download_url($download['link'])); ?>" 
                                   class="wm-btn wm-tap-animate"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   style="font-size: 0.95rem;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    <?php echo esc_html($download['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Screenshots Gallery -->
        <?php if (!empty($screenshots)) : ?>
            <div class="wm-screenshots wm-scroll-animate">
                <h2 class="wm-screenshots__title wm-title-md"><?php _e('Screenshots', 'wave-movies'); ?></h2>
                <div class="wm-screenshots__grid wm-stagger">
                    <?php foreach ($screenshots as $screenshot_id) : ?>
                        <div class="wm-screenshot-card">
                            <?php echo wp_get_attachment_image($screenshot_id, 'wm-screenshot'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Back Button -->
        <div class="wm-mt-xl wm-text-center">
            <a href="<?php echo get_post_type_archive_link('movie'); ?>" class="wm-btn wm-btn--outline wm-tap-animate">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                <?php _e('Back to Movies', 'wave-movies'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
