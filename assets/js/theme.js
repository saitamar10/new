/**
 * OneNav Theme JavaScript
 *
 * @package OneNav
 */

(function($) {
    'use strict';

    // ============================================
    // DARK MODE TOGGLE
    // ============================================

    function initDarkMode() {
        const darkModeToggle = $('#dark-mode-toggle');
        const body = $('body');

        // Check if dark mode was previously enabled
        const isDarkMode = localStorage.getItem('onenav_dark_mode') === 'enabled';

        // Check if dark mode is enabled by default from theme settings
        const defaultDarkMode = body.data('dark-mode') === '1';

        // Apply dark mode if enabled or if it's the default
        if (isDarkMode || (defaultDarkMode && localStorage.getItem('onenav_dark_mode') === null)) {
            body.addClass('dark-mode');
        }

        // Toggle dark mode on button click
        darkModeToggle.on('click', function() {
            body.toggleClass('dark-mode');

            // Save preference to localStorage
            if (body.hasClass('dark-mode')) {
                localStorage.setItem('onenav_dark_mode', 'enabled');
            } else {
                localStorage.setItem('onenav_dark_mode', 'disabled');
            }
        });
    }

    // ============================================
    // SEARCH FUNCTIONALITY
    // ============================================

    function initSearch() {
        const searchInput = $('#site-search');
        const searchResults = $('.search-results');
        let searchTimeout;

        searchInput.on('input', function() {
            const searchTerm = $(this).val();

            // Clear previous timeout
            clearTimeout(searchTimeout);

            if (searchTerm.length < 2) {
                searchResults.hide();
                return;
            }

            // Debounce search
            searchTimeout = setTimeout(function() {
                performSearch(searchTerm);
            }, 300);
        });

        // Hide search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-wrapper').length) {
                searchResults.hide();
            }
        });

        function performSearch(searchTerm) {
            $.ajax({
                url: onenavData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'onenav_search',
                    search: searchTerm,
                    nonce: onenavData.nonce
                },
                beforeSend: function() {
                    searchResults.html('<div style="padding: 20px; text-align: center;"><i class="fas fa-spinner fa-spin"></i> Aranıyor...</div>').show();
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '<div style="padding: 10px;">';
                        response.data.forEach(function(item) {
                            html += '<a href="' + item.url + '" style="display: block; padding: 15px; border-bottom: 1px solid #e2e8f0; text-decoration: none; color: inherit; transition: background 0.2s;">';
                            html += '<div style="font-weight: 600; margin-bottom: 5px; color: #1e293b;">' + item.title + '</div>';
                            html += '<div style="font-size: 13px; color: #64748b;">' + item.excerpt + '</div>';
                            html += '<div style="font-size: 12px; color: #a855f7; margin-top: 5px;"><i class="fas fa-tag"></i> ' + item.type + '</div>';
                            html += '</a>';
                        });
                        html += '</div>';
                        searchResults.html(html).show();
                    } else {
                        searchResults.html('<div style="padding: 20px; text-align: center; color: #64748b;"><i class="fas fa-info-circle"></i> Sonuç bulunamadı</div>').show();
                    }
                },
                error: function() {
                    searchResults.html('<div style="padding: 20px; text-align: center; color: #ef4444;"><i class="fas fa-exclamation-triangle"></i> Arama sırasında bir hata oluştu</div>').show();
                }
            });
        }
    }

    // ============================================
    // CLICK TRACKING
    // ============================================

    function initClickTracking() {
        $('.site-card, .ai-tool-card, .ebook-card, .app-card, .news-card').on('click', 'a', function() {
            const postId = $(this).closest('[data-post-id]').data('post-id');

            if (postId) {
                $.ajax({
                    url: onenavData.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'onenav_track_click',
                        site_id: postId,
                        nonce: onenavData.nonce
                    }
                });
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL
    // ============================================

    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));

            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
            }
        });
    }

    // ============================================
    // BACK TO TOP BUTTON
    // ============================================

    function initBackToTop() {
        // Create back to top button
        $('body').append('<button id="back-to-top" style="position: fixed; bottom: 30px; right: 30px; background: var(--primary-color); color: white; width: 50px; height: 50px; border-radius: 50%; border: none; font-size: 20px; cursor: pointer; display: none; z-index: 999; box-shadow: 0 4px 12px rgba(168, 85, 247, 0.4); transition: all 0.3s ease;"><i class="fas fa-arrow-up"></i></button>');

        const backToTop = $('#back-to-top');

        // Show/hide button on scroll
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTop.fadeIn();
            } else {
                backToTop.fadeOut();
            }
        });

        // Scroll to top on click
        backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 500);
        });

        // Hover effect
        backToTop.on('mouseenter', function() {
            $(this).css('transform', 'translateY(-5px)');
        }).on('mouseleave', function() {
            $(this).css('transform', 'translateY(0)');
        });
    }

    // ============================================
    // LAZY LOADING IMAGES
    // ============================================

    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img.lazy').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    // ============================================
    // TRENDING BAR AUTO-SCROLL
    // ============================================

    function initTrendingBar() {
        const trendingContent = $('.trending-content');

        // Fetch trending keywords via AJAX
        $.ajax({
            url: onenavData.ajaxUrl,
            type: 'POST',
            data: {
                action: 'onenav_get_trending',
                nonce: onenavData.nonce
            },
            success: function(response) {
                if (response.success && response.data) {
                    let html = '';
                    response.data.forEach(function(item, index) {
                        html += '<span class="trending-item">';
                        html += '<span class="trending-badge">#' + (index + 1) + '</span>';
                        html += '<a href="' + item.url + '" style="color: inherit; text-decoration: none;">' + item.title + '</a>';
                        html += '</span>';
                    });
                    trendingContent.html(html);
                } else {
                    trendingContent.html('<span>Son Haberler | Yapay Zeka Araçları | E-Kitaplar | Mobil Uygulamalar</span>');
                }
            },
            error: function() {
                trendingContent.html('<span>Son Haberler | Yapay Zeka Araçları | E-Kitaplar | Mobil Uygulamalar</span>');
            }
        });
    }

    // ============================================
    // LIKE BUTTON
    // ============================================

    function initLikeButton() {
        $('.like-btn').on('click', function(e) {
            e.preventDefault();

            const button = $(this);
            const postId = button.data('post-id');

            $.ajax({
                url: onenavData.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'onenav_like_post',
                    post_id: postId,
                    nonce: onenavData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        button.find('.like-count').text(response.data.likes);
                        button.addClass('liked');
                    }
                }
            });
        });
    }

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================

    function initKeyboardShortcuts() {
        $(document).on('keydown', function(e) {
            // Ctrl/Cmd + K for search focus
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                $('#site-search').focus();
            }

            // Ctrl/Cmd + D for dark mode toggle
            if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                e.preventDefault();
                $('#dark-mode-toggle').click();
            }
        });
    }

    // ============================================
    // INITIALIZE ALL FUNCTIONS
    // ============================================

    $(document).ready(function() {
        initDarkMode();
        initSearch();
        initClickTracking();
        initSmoothScroll();
        initBackToTop();
        initLazyLoading();
        initTrendingBar();
        initLikeButton();
        initKeyboardShortcuts();

        // Add fade-in animation to cards
        $('.site-card, .news-card, .app-card, .ebook-card, .ai-tool-card, .gallery-card').each(function(index) {
            $(this).css({
                'opacity': '0',
                'animation': 'fadeIn 0.5s ease forwards',
                'animation-delay': (index * 0.05) + 's'
            });
        });
    });

})(jQuery);
