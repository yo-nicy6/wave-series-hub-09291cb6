<?php
/**
 * Template Name: Search Page
 *
 * @package Thisy-World
 */

get_header();
?>

<section class="wm-search-page wm-section">
    <div class="wm-container">
        <div class="wm-search-page__header wm-scroll-animate">
            <h1 class="wm-title-lg"><?php _e('Search Movies & Series', 'thisy-world'); ?></h1>
            <p class="wm-text-muted wm-mt-sm"><?php _e('Start typing to find your favorite movies and series', 'thisy-world'); ?></p>
        </div>
        
        <div class="wm-search wm-mt-lg wm-scroll-animate" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <form class="wm-search__form" action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search" id="wm-live-search-form">
                <div class="wm-search__wrapper">
                    <input type="search" 
                           class="wm-search__input" 
                           name="s" 
                           id="wm-live-search-input"
                           placeholder="<?php esc_attr_e('Type movie or series name...', 'thisy-world'); ?>" 
                           value="<?php echo get_search_query(); ?>"
                           autocomplete="off"
                           autofocus>
                    <div class="wm-search__loading" id="wm-search-loading" style="display:none;">
                        <span class="wm-spinner"></span>
                    </div>
                    <button type="submit" class="wm-search__btn wm-tap-animate">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <?php _e('Search', 'thisy-world'); ?>
                    </button>
                </div>
                
                <!-- Live Search Results Dropdown -->
                <div class="wm-live-results" id="wm-live-results" style="display:none;"></div>
            </form>
        </div>
        
        <!-- Popular/Recent Content -->
        <div class="wm-search-results wm-mt-xl" id="wm-default-results">
            <h2 class="wm-title-md wm-text-center wm-mb-lg wm-scroll-animate">
                <?php _e('Popular Movies & Series', 'thisy-world'); ?>
            </h2>
            
            <?php
            // Get popular movies and series
            $popular = new WP_Query(array(
                'post_type' => array('series', 'movie'),
                'posts_per_page' => 6,
                'meta_key' => '_wm_view_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));
            
            if ($popular->have_posts()) : ?>
                <div class="wm-series-grid wm-stagger">
                    <?php while ($popular->have_posts()) : $popular->the_post(); 
                        $post_type = get_post_type();
                        $is_movie = ($post_type === 'movie');
                    ?>
                        <article class="wm-series-card wm-scroll-animate" onclick="window.location='<?php the_permalink(); ?>'">
                            <div class="wm-series-card__poster">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('wm-poster', array('alt' => get_the_title())); ?>
                                <?php endif; ?>
                                
                                <span class="wm-type-badge wm-type-badge--<?php echo $is_movie ? 'movie' : 'series'; ?>">
                                    <?php echo $is_movie ? __('Movie', 'thisy-world') : __('Series', 'thisy-world'); ?>
                                </span>
                                
                                <div class="wm-series-card__overlay">
                                    <div class="wm-series-card__play">
                                        <svg viewBox="0 0 24 24">
                                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="wm-series-card__content">
                                <h3 class="wm-series-card__title"><?php the_title(); ?></h3>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="wm-no-results">
                    <p><?php _e('No content available yet.', 'thisy-world'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Live Search Script -->
<script>
(function() {
    const searchInput = document.getElementById('wm-live-search-input');
    const liveResults = document.getElementById('wm-live-results');
    const loading = document.getElementById('wm-search-loading');
    const defaultResults = document.getElementById('wm-default-results');
    let searchTimeout = null;
    
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            liveResults.style.display = 'none';
            defaultResults.style.display = 'block';
            return;
        }
        
        loading.style.display = 'flex';
        
        searchTimeout = setTimeout(function() {
            fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=wm_live_search&s=' + encodeURIComponent(query) + '&nonce=<?php echo wp_create_nonce('wm_live_search'); ?>')
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';
                    
                    if (data.success && data.results.length > 0) {
                        let html = '<div class="wm-live-results__list">';
                        data.results.forEach(function(item) {
                            html += '<a href="' + item.url + '" class="wm-live-results__item">';
                            html += '<div class="wm-live-results__thumb">' + (item.thumbnail || '<div class="wm-live-results__placeholder"></div>') + '</div>';
                            html += '<div class="wm-live-results__info">';
                            html += '<span class="wm-live-results__title">' + item.title + '</span>';
                            html += '<span class="wm-live-results__type wm-live-results__type--' + item.type + '">' + item.type_label + '</span>';
                            if (item.year) html += '<span class="wm-live-results__year">' + item.year + '</span>';
                            html += '</div>';
                            html += '</a>';
                        });
                        html += '</div>';
                        
                        if (data.total > 5) {
                            html += '<a href="<?php echo home_url('/?s='); ?>' + encodeURIComponent(query) + '" class="wm-live-results__more">';
                            html += '<?php _e('View all', 'thisy-world'); ?> ' + data.total + ' <?php _e('results', 'thisy-world'); ?> →';
                            html += '</a>';
                        }
                        
                        liveResults.innerHTML = html;
                        liveResults.style.display = 'block';
                        defaultResults.style.display = 'none';
                    } else {
                        liveResults.innerHTML = '<div class="wm-live-results__empty">' +
                            '<div class="wm-live-results__empty-icon">🔍</div>' +
                            '<p class="wm-live-results__empty-title"><?php _e('No results found', 'thisy-world'); ?></p>' +
                            '<p class="wm-live-results__empty-hint"><?php _e('Check the spelling or try a different name.', 'thisy-world'); ?></p>' +
                            '<p class="wm-live-results__empty-hint"><?php _e('This movie or series may not exist in our database yet.', 'thisy-world'); ?></p>' +
                            '</div>';
                        liveResults.style.display = 'block';
                        defaultResults.style.display = 'none';
                    }
                })
                .catch(function() {
                    loading.style.display = 'none';
                });
        }, 300);
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.wm-search__form')) {
            liveResults.style.display = 'none';
        }
    });
    
    // Show dropdown again when focusing on input
    searchInput.addEventListener('focus', function() {
        if (this.value.trim().length >= 2) {
            liveResults.style.display = 'block';
        }
    });
})();
</script>

<?php get_footer(); ?>
