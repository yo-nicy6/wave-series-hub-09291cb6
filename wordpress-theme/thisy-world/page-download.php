<?php
/**
 * Template Name: Download Redirect Page
 *
 * Handles download redirects with a styled countdown page.
 *
 * @package Wave-Movies
 */

get_header();

$download_link = isset($_GET['link']) ? esc_url(urldecode($_GET['link'])) : '';
$countdown = 5; // Seconds before redirect
?>

<section class="wm-download-page">
    <div class="wm-download-box wm-scroll-animate">
        <div class="wm-download-box__icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
        </div>
        
        <h1 class="wm-download-box__title wm-title-lg">
            <?php _e('Preparing Your Download', 'wave-movies'); ?>
        </h1>
        
        <p class="wm-download-box__text">
            <?php _e('Your download will start automatically in', 'wave-movies'); ?>
        </p>
        
        <div class="wm-download-box__countdown" id="wm-countdown">
            <?php echo $countdown; ?>
        </div>
        
        <?php if ($download_link) : ?>
            <p class="wm-download-box__text">
                <?php _e('If the download doesn\'t start,', 'wave-movies'); ?>
                <a href="<?php echo esc_url($download_link); ?>" id="wm-manual-download" style="color: var(--wm-primary);">
                    <?php _e('click here', 'wave-movies'); ?>
                </a>
            </p>
            
            <script>
            (function() {
                var countdown = <?php echo $countdown; ?>;
                var downloadLink = '<?php echo esc_js($download_link); ?>';
                var countdownEl = document.getElementById('wm-countdown');
                
                var timer = setInterval(function() {
                    countdown--;
                    countdownEl.textContent = countdown;
                    
                    if (countdown <= 0) {
                        clearInterval(timer);
                        countdownEl.textContent = '<?php _e('Redirecting...', 'wave-movies'); ?>';
                        window.location.href = downloadLink;
                    }
                }, 1000);
            })();
            </script>
        <?php else : ?>
            <p class="wm-download-box__text" style="color: var(--wm-primary);">
                <?php _e('Invalid download link. Please go back and try again.', 'wave-movies'); ?>
            </p>
        <?php endif; ?>
        
        <div class="wm-mt-lg">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-btn wm-btn--outline wm-tap-animate">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                <?php _e('Back to Home', 'wave-movies'); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
