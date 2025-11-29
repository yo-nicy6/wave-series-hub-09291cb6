<?php
/**
 * Single Series Template
 *
 * Displays individual series with poster, description, screenshots, and episodes button.
 *
 * @package Wave-Movies
 */

get_header();

// Check if viewing episodes
$show_episodes = isset($_GET['episodes']) && $_GET['episodes'] == get_the_ID();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <?php if ($show_episodes) : ?>
        <!-- Episodes View -->
        <?php get_template_part('template-parts/episodes-list'); ?>
    <?php else : ?>
        <!-- Series Detail View -->
        <section class="wm-single-series">
            <div class="wm-container">
                <div class="wm-series-hero wm-scroll-animate">
                    <!-- Poster -->
                    <div class="wm-series-poster">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('wm-poster-large', array('alt' => get_the_title())); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder-poster.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                    </div>
                    
                    <!-- Info -->
                    <div class="wm-series-info">
                        <h1 class="wm-series-info__title"><?php the_title(); ?></h1>
                        
                        <!-- Meta Information -->
                        <div class="wm-series-meta" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
                            <?php
                            $year = get_post_meta(get_the_ID(), '_wm_year', true);
                            $rating = get_post_meta(get_the_ID(), '_wm_rating', true);
                            $status = get_post_meta(get_the_ID(), '_wm_status', true);
                            $episodes = wave_movies_get_episodes(get_the_ID());
                            ?>
                            
                            <?php if ($year) : ?>
                                <span class="wm-badge" style="background: var(--wm-surface); padding: 0.5rem 1rem; border-radius: var(--wm-radius-full); border: 1px solid var(--wm-border);">
                                    📅 <?php echo esc_html($year); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($rating) : ?>
                                <span class="wm-badge" style="background: var(--wm-surface); padding: 0.5rem 1rem; border-radius: var(--wm-radius-full); border: 1px solid var(--wm-border);">
                                    ⭐ <?php echo esc_html($rating); ?>/10
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($status) : ?>
                                <span class="wm-badge" style="background: var(--wm-primary); padding: 0.5rem 1rem; border-radius: var(--wm-radius-full);">
                                    <?php
                                    $status_labels = array(
                                        'ongoing' => __('Ongoing', 'wave-movies'),
                                        'completed' => __('Completed', 'wave-movies'),
                                        'upcoming' => __('Upcoming', 'wave-movies'),
                                    );
                                    echo esc_html($status_labels[$status] ?? $status);
                                    ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($episodes)) : ?>
                                <span class="wm-badge" style="background: var(--wm-surface); padding: 0.5rem 1rem; border-radius: var(--wm-radius-full); border: 1px solid var(--wm-border);">
                                    🎬 <?php printf(_n('%d Episode', '%d Episodes', count($episodes), 'wave-movies'), count($episodes)); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Genres -->
                        <?php
                        $genres = get_the_terms(get_the_ID(), 'genre');
                        if ($genres && !is_wp_error($genres)) : ?>
                            <div class="wm-genres" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                                <?php foreach ($genres as $genre) : ?>
                                    <a href="<?php echo esc_url(get_term_link($genre)); ?>" 
                                       class="wm-genre-tag" 
                                       style="background: var(--wm-surface-hover); padding: 0.25rem 0.75rem; border-radius: var(--wm-radius-full); font-size: 0.875rem; color: var(--wm-text-muted); transition: all var(--wm-transition-fast);">
                                        <?php echo esc_html($genre->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Description -->
                        <div class="wm-series-info__description">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                
                <!-- Screenshots Gallery -->
                <?php
                $screenshots = wave_movies_get_screenshots(get_the_ID());
                if (!empty($screenshots)) : ?>
                    <div class="wm-screenshots wm-scroll-animate">
                        <h2 class="wm-screenshots__title wm-title-md"><?php _e('Screenshots', 'wave-movies'); ?></h2>
                        <div class="wm-screenshots__grid wm-stagger">
                            <?php foreach ($screenshots as $attachment_id) : ?>
                                <div class="wm-screenshot">
                                    <?php echo wp_get_attachment_image($attachment_id, 'wm-screenshot', false, array('alt' => get_the_title() . ' screenshot')); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Download Groups Buttons (Below Screenshots) -->
                <?php 
                $download_groups = wave_movies_get_download_groups(get_the_ID());
                if (!empty($download_groups)) : 
                ?>
                    <div class="wm-download-section wm-scroll-animate" style="margin-top: 3rem; padding: 2rem; background: var(--wm-surface); border-radius: var(--wm-radius-lg); border: 1px solid var(--wm-border);">
                        <h2 class="wm-title-md" style="text-align: center; margin-bottom: 2rem;">
                            <?php _e('Download Links', 'wave-movies'); ?>
                        </h2>
                        <div class="wm-download-groups__list" style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <?php foreach ($download_groups as $index => $group) : ?>
                                <div class="wm-download-group-item wm-scroll-animate" style="text-align: center; padding: 1rem; background: var(--wm-background); border-radius: var(--wm-radius-md); border: 1px solid var(--wm-border);">
                                    <p class="wm-download-group-item__name" style="color: var(--wm-text); margin-bottom: 0.75rem; font-weight: 500; font-size: 1.1rem;">
                                        <?php echo esc_html($group['name']); ?>
                                        <span style="color: var(--wm-primary); font-weight: 600;">
                                            [<?php printf(_n('%d Ep', '%d Eps', count($group['episodes']), 'wave-movies'), count($group['episodes'])); ?>]
                                        </span>
                                    </p>
                                    <a href="<?php echo esc_url(wave_movies_get_episodes_url(get_the_ID(), $index)); ?>" 
                                       class="wm-btn wm-btn--download wm-tap-animate"
                                       style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--wm-primary); padding: 0.75rem 2rem; border-radius: var(--wm-radius-lg);">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                        <?php _e('Download Links', 'wave-movies'); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Back Button -->
                <div class="wm-mt-xl wm-text-center">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-btn--outline wm-tap-animate">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"></path>
                        </svg>
                        <?php _e('Back to Home', 'wave-movies'); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
<?php endwhile; endif; ?>

<?php get_footer(); ?>
