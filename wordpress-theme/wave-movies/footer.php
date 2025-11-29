</main><!-- .wm-main -->

<footer class="wm-footer">
    <div class="wm-container">
        <div class="wm-footer__inner">
            <div class="wm-footer__logo">
                Wave-<span>Movies</span>
            </div>
            
            <p class="wm-footer__text">
                <?php echo esc_html(get_theme_mod('wm_footer_text', __('© 2024 Wave-Movies. All rights reserved. Your ultimate destination for series downloads.', 'wave-movies'))); ?>
            </p>
            
            <div class="wm-footer__links">
                <?php
                $about_page = get_page_by_path('about');
                if ($about_page) : ?>
                    <a href="<?php echo get_permalink($about_page->ID); ?>"><?php _e('About', 'wave-movies'); ?></a>
                <?php endif; ?>
                
                <a href="<?php echo get_post_type_archive_link('series'); ?>"><?php _e('Series', 'wave-movies'); ?></a>
                <a href="<?php echo esc_url(home_url('/?s=')); ?>"><?php _e('Search', 'wave-movies'); ?></a>
            </div>
        </div>
    </div>
</footer>

<!-- Theme Switcher (Professional Design) -->
<div class="wm-theme-switcher" id="wm-theme-switcher">
    <button class="wm-theme-switcher__btn" id="wm-theme-toggle" aria-label="<?php esc_attr_e('Switch Theme', 'wave-movies'); ?>">
        <svg class="wm-theme-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <span class="wm-theme-indicator"></span>
    </button>
    
    <div class="wm-theme-menu" id="wm-theme-menu">
        <div class="wm-theme-menu__header">
            <span><?php _e('Theme', 'wave-movies'); ?></span>
        </div>
        <div class="wm-theme-menu__options">
            <button class="wm-theme-option active" data-theme="red">
                <span class="wm-theme-swatch wm-theme-swatch--red"></span>
                <span class="wm-theme-label"><?php _e('Crimson', 'wave-movies'); ?></span>
                <svg class="wm-theme-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </button>
            <button class="wm-theme-option" data-theme="blue">
                <span class="wm-theme-swatch wm-theme-swatch--blue"></span>
                <span class="wm-theme-label"><?php _e('Ocean', 'wave-movies'); ?></span>
                <svg class="wm-theme-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </button>
            <button class="wm-theme-option" data-theme="purple">
                <span class="wm-theme-swatch wm-theme-swatch--purple"></span>
                <span class="wm-theme-label"><?php _e('Violet', 'wave-movies'); ?></span>
                <svg class="wm-theme-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </button>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
