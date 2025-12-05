<?php
/**
 * Template Name: About Page
 *
 * @package Thisy-World
 */

get_header();
?>

<section class="wm-about wm-section">
    <div class="wm-container">
        <h1 class="wm-about__title wm-title-xl wm-scroll-animate">
            <?php _e('About Thisy-World', 'thisy-world'); ?>
        </h1>
        
        <div class="wm-about__content wm-scroll-animate">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; else : ?>
                <p><?php _e('Welcome to Thisy-World! We are your premier destination for series and movies downloads.', 'thisy-world'); ?></p>
                
                <p><?php _e('Our platform offers a vast collection of TV series and movies with high-quality downloads and a user-friendly interface. Browse through our extensive library, find your favorite content, and enjoy seamless downloading experience.', 'thisy-world'); ?></p>
                
                <h3><?php _e('Features', 'thisy-world'); ?></h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Large collection of series & movies', 'thisy-world'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('High-quality downloads', 'thisy-world'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Regular updates with new content', 'thisy-world'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Easy-to-use interface', 'thisy-world'); ?></li>
                    <li style="padding: 0.5rem 0;">✅ <?php _e('Mobile-friendly design', 'thisy-world'); ?></li>
                </ul>
            <?php endif; ?>
            
            <!-- Contact Section -->
            <div class="wm-about__contact">
                <h3><?php _e('Contact Us', 'thisy-world'); ?></h3>
                <p><?php _e('Have questions, suggestions, or business inquiries? Feel free to reach out!', 'thisy-world'); ?></p>
                
                <div class="wm-about__contact-links">
                    <a href="mailto:yo.nixy116@gmail.com" class="wm-about__contact-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        yo.nixy116@gmail.com
                    </a>
                    <a href="https://t.me/Linex_1" target="_blank" rel="noopener noreferrer" class="wm-about__contact-link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                        Telegram: @Linex_1
                    </a>
                </div>
            </div>
            
            <!-- Website For Sale Notice -->
            <div class="wm-about__sale-notice">
                <h3>🏷️ <?php _e('Website For Sale!', 'thisy-world'); ?></h3>
                <p><?php _e('Interested in buying this website? Contact us via email or Telegram for more information and pricing.', 'thisy-world'); ?></p>
            </div>
        </div>
        
        <div class="wm-mt-xl wm-text-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-tap-animate">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <?php _e('Browse Content', 'thisy-world'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>