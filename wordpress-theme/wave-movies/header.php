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
                Wave-<span>Movies</span>
            </a>
            
            <!-- Search Bar -->
            <div class="wm-search">
                <form class="wm-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
                    <input type="search" 
                           class="wm-search__input" 
                           name="s" 
                           placeholder="<?php esc_attr_e('Search series...', 'wave-movies'); ?>" 
                           value="<?php echo get_search_query(); ?>"
                           aria-label="<?php esc_attr_e('Search', 'wave-movies'); ?>">
                    <button type="submit" class="wm-search__btn wm-tap-animate">
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
                        <?php _e('About', 'wave-movies'); ?>
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo esc_url(add_query_arg('orderby', 'date', get_post_type_archive_link('series'))); ?>" class="wm-feature-btn wm-tap-animate">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <?php _e('Recent', 'wave-movies'); ?>
                </a>
                
                <a href="<?php echo esc_url(add_query_arg('orderby', 'views', get_post_type_archive_link('series'))); ?>" class="wm-feature-btn wm-tap-animate">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <?php _e('Most Viewed', 'wave-movies'); ?>
                </a>
            </nav>
        </div>
    </div>
</header>

<main class="wm-main">
