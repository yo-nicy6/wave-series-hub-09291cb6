</main><!-- .wm-main -->

<footer class="wm-footer">
    <div class="wm-container">
        <div class="wm-footer__inner">
            <div class="wm-footer__logo">
                Thisy-<span>World</span>
            </div>
            
            <p class="wm-footer__text">
                <?php echo esc_html(get_theme_mod('wm_footer_text', __('© 2024 Thisy-World. All rights reserved. Your ultimate destination for series & movies downloads.', 'thisy-world'))); ?>
            </p>
            
            <div class="wm-footer__links">
                <?php
                $about_page = get_page_by_path('about');
                if ($about_page) : ?>
                    <a href="<?php echo get_permalink($about_page->ID); ?>"><?php _e('About', 'thisy-world'); ?></a>
                <?php endif; ?>
                
                <a href="<?php echo get_post_type_archive_link('series'); ?>"><?php _e('Series', 'thisy-world'); ?></a>
                <a href="<?php echo get_post_type_archive_link('movie'); ?>"><?php _e('Movies', 'thisy-world'); ?></a>
                <a href="<?php echo esc_url(home_url('/?s=')); ?>"><?php _e('Search', 'thisy-world'); ?></a>
            </div>
            
            <!-- Contact Information -->
            <div class="wm-footer__contact">
                <a href="mailto:yo.nixy116@gmail.com">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    yo.nixy116@gmail.com
                </a>
                <a href="https://t.me/Linex_1" target="_blank" rel="noopener noreferrer">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                    @Linex_1
                </a>
            </div>
            
            <!-- Website For Sale Notice -->
            <div class="wm-footer__sale">
                🏷️ <?php _e('This website is FOR SALE! Contact us if interested in buying.', 'thisy-world'); ?>
            </div>
        </div>
    </div>
</footer>

<!-- Theme Switcher (Professional Design) -->
<div class="wm-theme-switcher" id="wm-theme-switcher">
    <button class="wm-theme-switcher__btn" id="wm-theme-toggle" aria-label="<?php esc_attr_e('Switch Theme', 'thisy-world'); ?>">
        <svg class="wm-theme-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <span class="wm-theme-indicator"></span>
    </button>
    
    <div class="wm-theme-menu" id="wm-theme-menu">
        <div class="wm-theme-menu__header">
            <span><?php _e('Theme', 'thisy-world'); ?></span>
        </div>
        <div class="wm-theme-menu__options">
            <button class="wm-theme-option active" data-theme="red">
                <span class="wm-theme-swatch wm-theme-swatch--red"></span>
                <span class="wm-theme-label"><?php _e('Crimson', 'thisy-world'); ?></span>
                <svg class="wm-theme-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </button>
            <button class="wm-theme-option" data-theme="blue">
                <span class="wm-theme-swatch wm-theme-swatch--blue"></span>
                <span class="wm-theme-label"><?php _e('Ocean', 'thisy-world'); ?></span>
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