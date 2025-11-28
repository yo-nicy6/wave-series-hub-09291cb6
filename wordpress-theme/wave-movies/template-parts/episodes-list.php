<?php
/**
 * Episodes List Template Part
 *
 * Displays the episodes list with download links.
 *
 * @package Wave-Movies
 */

$episodes = wave_movies_get_episodes(get_the_ID());
?>

<section class="wm-episodes">
    <div class="wm-container">
        <div class="wm-episodes__header wm-scroll-animate">
            <h1 class="wm-episodes__title wm-title-lg"><?php the_title(); ?></h1>
            <p class="wm-episodes__subtitle">
                <?php printf(_n('%d Episode Available', '%d Episodes Available', count($episodes), 'wave-movies'), count($episodes)); ?>
            </p>
        </div>
        
        <?php if (!empty($episodes)) : ?>
            <div class="wm-episodes-list wm-stagger">
                <?php foreach ($episodes as $index => $episode) : ?>
                    <div class="wm-episode-item wm-scroll-animate">
                        <div class="wm-episode-item__info">
                            <div class="wm-episode-item__number">
                                <?php echo $index + 1; ?>
                            </div>
                            <div class="wm-episode-item__title">
                                <?php 
                                if (!empty($episode['title'])) {
                                    echo esc_html($episode['title']);
                                } else {
                                    printf(__('Episode %d', 'wave-movies'), $index + 1);
                                }
                                ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($episode['link'])) : ?>
                            <a href="<?php echo esc_url(wave_movies_get_download_url($episode['link'])); ?>" 
                               class="wm-episode-item__download wm-tap-animate"
                               target="_blank"
                               rel="noopener noreferrer">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                <?php _e('Download', 'wave-movies'); ?>
                            </a>
                        <?php else : ?>
                            <span class="wm-episode-item__download" style="opacity: 0.5; cursor: not-allowed;">
                                <?php _e('Coming Soon', 'wave-movies'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="wm-no-results">
                <p><?php _e('No episodes available yet. Check back soon!', 'wave-movies'); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Back to Series Button -->
        <div class="wm-mt-xl wm-text-center">
            <a href="<?php the_permalink(); ?>" class="wm-btn wm-btn--outline wm-tap-animate">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                <?php _e('Back to Series', 'wave-movies'); ?>
            </a>
        </div>
    </div>
</section>
