/**
 * Portfolio Carousel JavaScript
 * 
 * This script initializes Swiper instances for the Portfolio Carousel
 * while ensuring no conflicts with other Swiper instances on the page.
 */

(function($) {
    'use strict';

    // Create portfolio carousel namespace to avoid conflicts
    window.PortfolioCarousel = window.PortfolioCarousel || {};
    
    /**
     * Initialize Portfolio Carousel
     * 
     * @param {string} containerId - The ID of the carousel container
     * @param {object} options - Custom configuration options
     */
    PortfolioCarousel.init = function(containerId, options) {
        if (!containerId) return;
        
        // Default options
        var defaults = {
            thumbsPerView: 5,
            thumbsPerViewTablet: 4,
            thumbsPerViewMobile: 3,
            spaceBetween: 10,
            navigation: true
        };
        
        // Merge defaults with custom options
        var settings = $.extend({}, defaults, options);
        
        // Initialize the thumbnails slider
        var thumbsSwiper = new Swiper('#' + containerId + ' .portfolio-thumbs-swiper', {
            spaceBetween: settings.spaceBetween,
            slidesPerView: settings.thumbsPerView,
            freeMode: true,
            watchSlidesProgress: true,
            breakpoints: {
                // Mobile
                320: {
                    slidesPerView: settings.thumbsPerViewMobile,
                },
                // Tablet
                768: {
                    slidesPerView: settings.thumbsPerViewTablet,
                },
                // Desktop
                1024: {
                    slidesPerView: settings.thumbsPerView,
                }
            }
        });
        
        // Navigation options
        var navigationOptions = settings.navigation ? {
            nextEl: '#' + containerId + ' .swiper-button-next',
            prevEl: '#' + containerId + ' .swiper-button-prev',
        } : {};
        
        // Initialize the main slider
        var mainSwiper = new Swiper('#' + containerId + ' .portfolio-main-swiper', {
            spaceBetween: 0,
            navigation: navigationOptions,
            thumbs: {
                swiper: thumbsSwiper
            },
            // Make sure caption transitions match the slide transition
            on: {
                slideChangeTransitionStart: function() {
                    $('.portfolio-carousel-caption').addClass('transitioning');
                },
                slideChangeTransitionEnd: function() {
                    $('.portfolio-carousel-caption').removeClass('transitioning');
                }
            }
        });
        
        // Return the Swiper instances for external control
        return {
            main: mainSwiper,
            thumbs: thumbsSwiper
        };
    };
    
    // Auto-initialize carousels that are hard-coded in the page
    $(document).ready(function() {
        $('.portfolio-carousel-container').each(function() {
            var $this = $(this);
            var id = $this.attr('id');
            
            if (id) {
                var options = {
                    thumbsPerView: parseInt($this.data('thumbs-per-view') || 5, 10),
                    thumbsPerViewTablet: parseInt($this.data('thumbs-per-view-tablet') || 4, 10),
                    thumbsPerViewMobile: parseInt($this.data('thumbs-per-view-mobile') || 3, 10),
                    spaceBetween: parseInt($this.data('space-between') || 10, 10),
                    navigation: $this.data('navigation') !== 'false'
                };
                
                PortfolioCarousel.init(id, options);
            }
        });
    });
    
})(jQuery);
