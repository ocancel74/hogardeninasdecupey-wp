/**
 * Custom JavaScript for Hogar de Niñas de Cupey
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Mobile Menu Toggle
        $('.menu-toggle').on('click', function() {
            $('body').toggleClass('mobile-menu-open');
        });
        
        // Smooth Scroll for Anchor Links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if(target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
        
        // Add Animation on Scroll
        $(window).on('scroll', function() {
            $('.animate-on-scroll').each(function() {
                var elementTop = $(this).offset().top;
                var viewportBottom = $(window).scrollTop() + $(window).height();
                
                if (elementTop < viewportBottom - 100) {
                    $(this).addClass('animated');
                }
            });
        });
        
        // Form Validation Enhancement
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).text('Enviando...');
        });
        
    });
    
})(jQuery);
