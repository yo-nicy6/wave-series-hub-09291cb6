/**
 * Wave-Movies Theme Animations & Interactions
 *
 * This file handles:
 * - Theme switching (Red/Blue/Purple) with localStorage persistence
 * - Floating draggable theme button
 * - Scroll-triggered animations
 * - Tap/click animations
 * - Hover effects enhancement
 *
 * @package Wave-Movies
 */

(function() {
    'use strict';

    // ====================
    // Theme Switcher
    // ====================
    
    const ThemeSwitcher = {
        storageKey: 'wm-theme',
        defaultTheme: 'red',
        
        init: function() {
            this.toggle = document.getElementById('wm-theme-toggle');
            this.menu = document.getElementById('wm-theme-menu');
            this.options = document.querySelectorAll('.wm-theme-option');
            this.switcher = document.getElementById('wm-theme-switcher');
            
            if (!this.toggle || !this.menu) return;
            
            // Load saved theme
            const savedTheme = localStorage.getItem(this.storageKey) || this.defaultTheme;
            this.setTheme(savedTheme);
            
            // Toggle menu
            this.toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.menu.classList.toggle('active');
                this.pulseAnimation();
            });
            
            // Theme options
            this.options.forEach(option => {
                option.addEventListener('click', () => {
                    const theme = option.dataset.theme;
                    this.setTheme(theme);
                    this.menu.classList.remove('active');
                });
            });
            
            // Close menu on outside click
            document.addEventListener('click', (e) => {
                if (!this.switcher.contains(e.target)) {
                    this.menu.classList.remove('active');
                }
            });
            
            // Initialize draggable
            this.initDraggable();
        },
        
        setTheme: function(theme) {
            // Only allow red or blue themes
            if (theme !== 'red' && theme !== 'blue') {
                theme = 'red';
            }
            
            // Add transition class for smooth animation
            document.documentElement.classList.add('wm-theme-transitioning');
            
            // Remove all theme attributes
            document.documentElement.removeAttribute('data-theme');
            
            // Set new theme (red is default, no attribute needed)
            if (theme !== 'red') {
                document.documentElement.setAttribute('data-theme', theme);
            }
            
            // Save to localStorage
            localStorage.setItem(this.storageKey, theme);
            
            // Update active state
            this.options.forEach(option => {
                option.classList.toggle('active', option.dataset.theme === theme);
            });
            
            // Remove transition class after animation completes
            setTimeout(() => {
                document.documentElement.classList.remove('wm-theme-transitioning');
            }, 400);
        },
        
        pulseAnimation: function() {
            this.toggle.style.animation = 'none';
            this.toggle.offsetHeight; // Trigger reflow
            this.toggle.style.animation = 'wm-pulse 0.5s ease';
        },
        
        initDraggable: function() {
            if (!this.switcher) return;
            
            let isDragging = false;
            let currentX;
            let currentY;
            let initialX;
            let initialY;
            let xOffset = 0;
            let yOffset = 0;
            
            // Load saved position
            const savedPos = localStorage.getItem('wm-theme-pos');
            if (savedPos) {
                const pos = JSON.parse(savedPos);
                xOffset = pos.x;
                yOffset = pos.y;
                this.setTranslate(xOffset, yOffset, this.switcher);
            }
            
            const dragStart = (e) => {
                if (e.type === 'touchstart') {
                    initialX = e.touches[0].clientX - xOffset;
                    initialY = e.touches[0].clientY - yOffset;
                } else {
                    initialX = e.clientX - xOffset;
                    initialY = e.clientY - yOffset;
                }
                
                if (e.target === this.toggle || this.toggle.contains(e.target)) {
                    isDragging = true;
                    this.switcher.style.cursor = 'grabbing';
                }
            };
            
            const drag = (e) => {
                if (isDragging) {
                    e.preventDefault();
                    
                    if (e.type === 'touchmove') {
                        currentX = e.touches[0].clientX - initialX;
                        currentY = e.touches[0].clientY - initialY;
                    } else {
                        currentX = e.clientX - initialX;
                        currentY = e.clientY - initialY;
                    }
                    
                    xOffset = currentX;
                    yOffset = currentY;
                    
                    this.setTranslate(currentX, currentY, this.switcher);
                }
            };
            
            const dragEnd = () => {
                if (isDragging) {
                    initialX = currentX;
                    initialY = currentY;
                    isDragging = false;
                    this.switcher.style.cursor = 'grab';
                    
                    // Save position
                    localStorage.setItem('wm-theme-pos', JSON.stringify({
                        x: xOffset,
                        y: yOffset
                    }));
                }
            };
            
            // Event listeners
            this.switcher.addEventListener('touchstart', dragStart, { passive: true });
            this.switcher.addEventListener('mousedown', dragStart);
            
            document.addEventListener('touchmove', drag, { passive: false });
            document.addEventListener('mousemove', drag);
            
            document.addEventListener('touchend', dragEnd);
            document.addEventListener('mouseup', dragEnd);
        },
        
        setTranslate: function(xPos, yPos, el) {
            el.style.transform = `translate(${xPos}px, ${yPos}px)`;
        }
    };

    // ====================
    // Scroll Animations
    // ====================
    
    const ScrollAnimations = {
        init: function() {
            this.elements = document.querySelectorAll('.wm-scroll-animate');
            
            if (this.elements.length === 0) return;
            
            // Check if IntersectionObserver is supported
            if ('IntersectionObserver' in window) {
                this.observer = new IntersectionObserver(
                    this.handleIntersection.bind(this),
                    {
                        root: null,
                        rootMargin: '0px 0px -50px 0px',
                        threshold: 0.1
                    }
                );
                
                this.elements.forEach(el => this.observer.observe(el));
            } else {
                // Fallback: show all elements
                this.elements.forEach(el => el.classList.add('wm-visible'));
            }
        },
        
        handleIntersection: function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('wm-visible');
                    this.observer.unobserve(entry.target);
                }
            });
        }
    };

    // ====================
    // Tap Animations
    // ====================
    
    const TapAnimations = {
        init: function() {
            const tapElements = document.querySelectorAll('.wm-tap-animate');
            
            tapElements.forEach(el => {
                el.addEventListener('mousedown', () => {
                    el.style.transform = 'scale(0.95)';
                });
                
                el.addEventListener('mouseup', () => {
                    el.style.transform = '';
                });
                
                el.addEventListener('mouseleave', () => {
                    el.style.transform = '';
                });
                
                // Touch events
                el.addEventListener('touchstart', () => {
                    el.style.transform = 'scale(0.95)';
                }, { passive: true });
                
                el.addEventListener('touchend', () => {
                    el.style.transform = '';
                });
            });
        }
    };

    // ====================
    // Card Hover Effects
    // ====================
    
    const CardEffects = {
        init: function() {
            const cards = document.querySelectorAll('.wm-series-card');
            
            cards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;
                    
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-8px) scale(1.02)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                });
            });
        }
    };

    // ====================
    // Smooth Scroll
    // ====================
    
    const SmoothScroll = {
        init: function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;
                    
                    e.preventDefault();
                    const target = document.querySelector(href);
                    
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }
    };

    // ====================
    // GSAP Ready Hooks
    // ====================
    
    // These hooks can be used if GSAP is loaded
    window.wmGSAPHooks = {
        // Hero animation hook
        animateHero: function(element) {
            if (typeof gsap !== 'undefined') {
                gsap.from(element, {
                    duration: 1,
                    y: 50,
                    opacity: 0,
                    ease: 'power3.out'
                });
            }
        },
        
        // Stagger animation hook
        animateStagger: function(elements, stagger = 0.1) {
            if (typeof gsap !== 'undefined') {
                gsap.from(elements, {
                    duration: 0.6,
                    y: 30,
                    opacity: 0,
                    stagger: stagger,
                    ease: 'power2.out'
                });
            }
        },
        
        // Card flip animation hook
        flipCard: function(element) {
            if (typeof gsap !== 'undefined') {
                gsap.to(element, {
                    duration: 0.6,
                    rotationY: 180,
                    ease: 'power2.inOut'
                });
            }
        }
    };

    // ====================
    // Initialize
    // ====================
    
    document.addEventListener('DOMContentLoaded', function() {
        ThemeSwitcher.init();
        ScrollAnimations.init();
        TapAnimations.init();
        CardEffects.init();
        SmoothScroll.init();
        
        console.log('Wave-Movies animations initialized');
    });

})();
