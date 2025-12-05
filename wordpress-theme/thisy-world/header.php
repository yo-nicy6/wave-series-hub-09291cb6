<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="wm-header">
    <div class="wm-container">
        <div class="wm-header__inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="wm-logo">
                <span class="wm-logo__icon">🎬</span>
                Thisy-<span>World</span>
            </a>
            
            <!-- Search Bar -->
            <div class="wm-search">
                <form class="wm-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                    <input type="search" 
                           class="wm-search__input" 
                           name="s" 
                           placeholder="<?php esc_attr_e('Search series & movies...', 'thisy-world'); ?>" 
                           value="<?php echo get_search_query(); ?>"
                           aria-label="<?php esc_attr_e('Search', 'thisy-world'); ?>">
                    <button type="submit" class="wm-search__btn wm-tap-animate" aria-label="<?php esc_attr_e('Search', 'thisy-world'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Feature Buttons -->
            <nav class="wm-features">
                <?php
                $about_page = get_page_by_path('about');
                if ($about_page) : ?>
                    <a href="<?php echo get_permalink($about_page->ID); ?>" class="wm-feature-btn wm-tap-animate">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                        <?php _e('About', 'thisy-world'); ?>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo get_post_type_archive_link('series'); ?>" class="wm-feature-btn wm-tap-animate">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                        <line x1="7" y1="2" x2="7" y2="22"></line>
                        <line x1="17" y1="2" x2="17" y2="22"></line>
                    </svg>
                    <?php _e('Series', 'thisy-world'); ?>
                </a>
                
                <a href="<?php echo get_post_type_archive_link('movie'); ?>" class="wm-feature-btn wm-tap-animate">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect>
                        <line x1="7" y1="2" x2="7" y2="22"></line>
                        <line x1="17" y1="2" x2="17" y2="22"></line>
                        <line x1="2" y1="12" x2="22" y2="12"></line>
                    </svg>
                    <?php _e('Movies', 'thisy-world'); ?>
                </a>
            </nav>
        </div>
    </div>
</header>

<main class="wm-main">