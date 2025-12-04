<?php
/**
 * Episodes List Template Part
 *
 * Displays the episodes list for a SPECIFIC download group.
 * Each download button leads to its own separate page with only that group's episodes.
 *
 * @package Wave-Movies
 */

// Get group index from URL
$group_index = isset($_GET['group']) ? intval($_GET['group']) : 0;

// Get the specific download group
$group = wave_movies_get_download_group(get_the_ID(), $group_index);
$episodes = $group ? (isset($group['episodes']) ? $group['episodes'] : array()) : array();
$group_name = $group ? $group['name'] : __('Episodes', 'wave-movies');
$season_zip = $group && isset($group['season_zip']) ? $group['season_zip'] : '';

// Get all download groups for switching
$all_groups = wave_movies_get_download_groups(get_the_ID());
?>

<section class="wm-episodes">
    <div class="wm-container">
        <div class="wm-episodes__header wm-scroll-animate">
            <h1 class="wm-episodes__title wm-title-lg"><?php the_title(); ?></h1>
            <p class="wm-episodes__group-name" style="color: var(--wm-primary); font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">
                <?php echo esc_html($group_name); ?>
            </p>
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
            
            <!-- Season Zip Download - Below Episodes -->
            <?php if (!empty($season_zip)) : ?>
                <div class="wm-season-zip wm-scroll-animate" style="margin-top: 1.5rem;">
                    <a href="<?php echo esc_url(wave_movies_get_download_url($season_zip)); ?>" 
                       class="wm-season-zip__btn wm-tap-animate"
                       target="_blank"
                       rel="noopener noreferrer">
                        <div class="wm-season-zip__icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 8v13H3V8"></path>
                                <path d="M1 3h22v5H1z"></path>
                                <path d="M10 12h4"></path>
                            </svg>
                        </div>
                        <div class="wm-season-zip__content">
                            <span class="wm-season-zip__title"><?php _e('Season Zip', 'wave-movies'); ?></span>
                            <span class="wm-season-zip__desc"><?php _e('Download Complete Season', 'wave-movies'); ?></span>
                        </div>
                        <div class="wm-season-zip__download">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="wm-no-results">
                <p><?php _e('No episodes available yet. Check back soon!', 'wave-movies'); ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Other Quality Versions -->
        <?php if (count($all_groups) > 1) : ?>
            <div class="wm-other-qualities wm-scroll-animate" style="margin-top: 2rem; padding: 1.5rem; background: var(--wm-surface); border-radius: var(--wm-radius-lg); border: 1px solid var(--wm-border);">
                <h3 style="text-align: center; margin-bottom: 1rem; color: var(--wm-text-muted); font-size: 0.9rem; font-weight: 500;">
                    <?php _e('Other Qualities Available', 'wave-movies'); ?>
                </h3>
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center;">
                    <?php foreach ($all_groups as $idx => $other_group) : ?>
                        <?php if ($idx !== $group_index) : ?>
                            <a href="<?php echo esc_url(wave_movies_get_episodes_url(get_the_ID(), $idx)); ?>" 
                               class="wm-btn wm-btn--outline wm-tap-animate"
                               style="font-size: 0.875rem; padding: 0.5rem 1rem;">
                                <?php echo esc_html($other_group['name']); ?>
                                <span style="opacity: 0.7;">(<?php echo count($other_group['episodes']); ?> Eps)</span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
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
