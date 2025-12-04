<?php
/**
 * Template Name: About Page
 *
 * @package Wave-Movies
 */

get_header();
?>

<section class="wm-about wm-section">
    <div class="wm-container">
        <h1 class="wm-about__title wm-title-xl wm-scroll-animate">
            <?php _e('About Wave-Movies', 'wave-movies'); ?>
        </h1>
        
        <div class="wm-about__content wm-scroll-animate">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; else : ?>
                <p><?php _e('Welcome to Wave-Movies! We are your premier destination for series downloads.', 'wave-movies'); ?></p>
                
                <p><?php _e('Our platform offers a vast collection of TV series with high-quality downloads and a user-friendly interface. Browse through our extensive library, find your favorite series, and enjoy seamless downloading experience.', 'wave-movies'); ?></p>
                
                <h3><?php _e('Features', 'wave-movies'); ?></h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Large collection of series', 'wave-movies'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('High-quality downloads', 'wave-movies'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Regular updates with new episodes', 'wave-movies'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Easy-to-use interface', 'wave-movies'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Mobile-friendly design', 'wave-movies'); ?></li>
                </ul>
                
                <h3><?php _e('Contact', 'wave-movies'); ?></h3>
                <p><?php _e('Have questions or suggestions? Feel free to reach out to us through our social media channels.', 'wave-movies'); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="wm-mt-xl wm-text-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-tap-animate">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <?php _e('Browse Series', 'wave-movies'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
