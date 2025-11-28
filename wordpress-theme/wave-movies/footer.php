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

<!-- Theme Switcher -->
<div class="wm-theme-switcher" id="wm-theme-switcher">
    <button class="wm-theme-switcher__btn wm-tap-animate" id="wm-theme-toggle" aria-label="<?php esc_attr_e('Switch Theme', 'wave-movies'); ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="5"></circle>
            <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"></path>
        </svg>
    </button>
    
    <div class="wm-theme-menu" id="wm-theme-menu">
        <button class="wm-theme-option active" data-theme="red">
            <span class="wm-theme-swatch wm-theme-swatch--red"></span>
            <?php _e('Red / Black', 'wave-movies'); ?>
        </button>
        <button class="wm-theme-option" data-theme="blue">
            <span class="wm-theme-swatch wm-theme-swatch--blue"></span>
            <?php _e('Blue / Dark', 'wave-movies'); ?>
        </button>
        <button class="wm-theme-option" data-theme="purple">
            <span class="wm-theme-swatch wm-theme-swatch--purple"></span>
            <?php _e('Purple / Dark', 'wave-movies'); ?>
        </button>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
