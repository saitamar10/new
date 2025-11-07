/**
 * OneNav Theme JavaScript
 * Dark Mode + Likes + Interactions
 *
 * @package OneNav
 * @version 1.0.0
 */

(function($) {
    'use strict';

    const OneNavTheme = {
        /**
         * Initialize all theme functionality
         */
        init: function() {
            this.setupDarkMode();
            this.setupLikes();
            this.setupClickTracking();
            this.setupCardInteractions();
            this.setupSearchTabs();
            this.setupTableOfContents();
            console.log('OneNav Theme initialized');
        },

        /**
         * Dark Mode Functionality
         */
        setupDarkMode: function() {
            const self = this;

            // Check localStorage for saved preference
            const savedMode = localStorage.getItem('onenav_dark_mode');
            if (savedMode === 'enabled') {
                $('body').addClass('dark-mode');
            }

            // Create dark mode toggle button if it doesn't exist
            if ($('.dark-mode-toggle').length === 0) {
                const toggleHTML = `
                    <div class="dark-mode-toggle">
                        <button class="dark-mode-toggle__btn" title="Dark Mode">
                            <svg class="dark-mode-toggle__icon dark-mode-toggle__icon--sun" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 18a6 6 0 100-12 6 6 0 000 12z"/>
                                <path d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41m11.32-11.32l1.41-1.41"/>
                            </svg>
                            <svg class="dark-mode-toggle__icon dark-mode-toggle__icon--moon" width="24" height="24" fill="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                            </svg>
                        </button>
                    </div>
                `;
                $('body').append(toggleHTML);
            }

            // Update icon based on current mode
            this.updateDarkModeIcon();

            // Toggle dark mode on button click
            $(document).on('click', '.dark-mode-toggle__btn', function() {
                self.toggleDarkMode();
            });
        },

        toggleDarkMode: function() {
            $('body').toggleClass('dark-mode');

            // Save preference
            if ($('body').hasClass('dark-mode')) {
                localStorage.setItem('onenav_dark_mode', 'enabled');
            } else {
                localStorage.setItem('onenav_dark_mode', 'disabled');
            }

            this.updateDarkModeIcon();
        },

        updateDarkModeIcon: function() {
            if ($('body').hasClass('dark-mode')) {
                $('.dark-mode-toggle__icon--sun').hide();
                $('.dark-mode-toggle__icon--moon').show();
            } else {
                $('.dark-mode-toggle__icon--sun').show();
                $('.dark-mode-toggle__icon--moon').hide();
            }
        },

        /**
         * Likes Functionality
         */
        setupLikes: function() {
            const self = this;

            // Check localStorage for liked posts
            const likedPosts = JSON.parse(localStorage.getItem('onenav_liked_posts') || '[]');

            // Mark already liked posts
            likedPosts.forEach(function(postId) {
                $('.single-post__like-btn[data-post-id="' + postId + '"]').addClass('liked');
            });

            // Handle like button click (both old and new styles)
            $(document).on('click', '.single-post__like-btn, .like-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const postId = $btn.data('post-id') || $btn.data('post');

                self.toggleLike($btn, postId);
            });
        },

        toggleLike: function($btn, postId) {
            const $count = $btn.find('.single-post__like-count, .like-count');
            let currentCount = parseInt($count.text()) || 0;
            const isLiked = $btn.hasClass('liked');

            // Toggle UI immediately
            if (isLiked) {
                $btn.removeClass('liked');
                $count.text(Math.max(0, currentCount - 1));
                this.removeLikeFromStorage(postId);
            } else {
                $btn.addClass('liked');
                $count.text(currentCount + 1);
                this.addLikeToStorage(postId);
            }

            // Send AJAX request to update server-side count (support both endpoints)
            const ajaxUrl = (typeof ONENAV !== 'undefined') ? ONENAV.ajax : onenavData.ajaxUrl;
            const nonce = (typeof ONENAV !== 'undefined') ? ONENAV.nonce : onenavData.nonce;

            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: $btn.hasClass('like-btn') ? 'onenav_like' : 'onenav_toggle_like',
                    post_id: postId,
                    post: postId,
                    nonce: nonce,
                    is_liked: !isLiked
                },
                success: function(response) {
                    if (response.success) {
                        const newCount = response.data.count || response.data.likes;
                        if (newCount !== undefined) {
                            $count.text(newCount);
                        }
                    }
                },
                error: function() {
                    // Revert on error
                    if (isLiked) {
                        $btn.addClass('liked');
                        $count.text(currentCount);
                    } else {
                        $btn.removeClass('liked');
                        $count.text(Math.max(0, currentCount));
                    }
                }
            });
        },

        addLikeToStorage: function(postId) {
            let likedPosts = JSON.parse(localStorage.getItem('onenav_liked_posts') || '[]');
            if (!likedPosts.includes(postId)) {
                likedPosts.push(postId);
                localStorage.setItem('onenav_liked_posts', JSON.stringify(likedPosts));
            }
        },

        removeLikeFromStorage: function(postId) {
            let likedPosts = JSON.parse(localStorage.getItem('onenav_liked_posts') || '[]');
            likedPosts = likedPosts.filter(id => id !== postId);
            localStorage.setItem('onenav_liked_posts', JSON.stringify(likedPosts));
        },

        /**
         * Click Tracking for Cards
         */
        setupClickTracking: function() {
            // Track clicks on all cards
            $(document).on('click', '.site-card, .news-card, .ai-tool-card, .ebook-card, .app-card', function(e) {
                const postId = $(this).data('post-id');
                if (postId) {
                    OneNavTheme.trackClick(postId);
                }
            });
        },

        trackClick: function(postId) {
            $.ajax({
                type: 'POST',
                url: onenavData.ajaxUrl,
                data: {
                    action: 'onenav_track_click',
                    site_id: postId,
                    nonce: onenavData.nonce
                }
            });
        },

        /**
         * Card Interactions - Make all clickable
         */
        setupCardInteractions: function() {
            // Make entire card clickable
            $('.site-card, .news-card, .ai-tool-card, .ebook-card, .app-card, .archive-card').each(function() {
                const $card = $(this);
                const $primaryLink = $card.find('a').first();

                if ($primaryLink.length) {
                    $card.css('cursor', 'pointer');

                    $card.on('click', function(e) {
                        // Don't trigger if clicking on a button or link
                        if ($(e.target).is('button, a, .site-action-btn, .ebook-btn, .app-btn')) {
                            return;
                        }

                        const href = $primaryLink.attr('href');
                        const target = $primaryLink.attr('target');

                        if (href) {
                            if (target === '_blank') {
                                window.open(href, '_blank', 'noopener,noreferrer');
                            } else {
                                window.location.href = href;
                            }
                        }
                    });
                }
            });

            // Prevent double-click on links inside cards
            $('.site-card a, .news-card a, .ai-tool-card a, .ebook-card a, .app-card a').on('click', function(e) {
                e.stopPropagation();
            });
        },

        /**
         * Search Tabs Functionality
         */
        setupSearchTabs: function() {
            const $searchInput = $('#site-search');

            // Create search tabs if they don't exist
            if ($('.search-bar__tabs').length === 0 && $searchInput.length > 0) {
                const tabsHTML = `
                    <div class="search-bar__tabs">
                        <button class="search-bar__tab search-bar__tab--active" data-engine="site">Site</button>
                        <button class="search-bar__tab" data-engine="google">Google</button>
                        <button class="search-bar__tab" data-engine="bing">Bing</button>
                        <button class="search-bar__tab" data-engine="baidu">Baidu</button>
                    </div>
                `;
                $searchInput.closest('.search-wrapper, .search-bar').prepend(tabsHTML);
            }

            // Handle tab clicks
            $(document).on('click', '.search-bar__tab', function() {
                $('.search-bar__tab').removeClass('search-bar__tab--active');
                $(this).addClass('search-bar__tab--active');

                const engine = $(this).data('engine');
                $searchInput.data('search-engine', engine);
            });

            // Handle search submission
            $(document).on('submit', '.search-form, form[role="search"]', function(e) {
                const engine = $searchInput.data('search-engine') || 'site';
                const query = $searchInput.val();

                if (engine !== 'site' && query) {
                    e.preventDefault();

                    let searchUrl = '';
                    switch (engine) {
                        case 'google':
                            searchUrl = 'https://www.google.com/search?q=' + encodeURIComponent(query);
                            break;
                        case 'bing':
                            searchUrl = 'https://www.bing.com/search?q=' + encodeURIComponent(query);
                            break;
                        case 'baidu':
                            searchUrl = 'https://www.baidu.com/s?wd=' + encodeURIComponent(query);
                            break;
                    }

                    if (searchUrl) {
                        window.open(searchUrl, '_blank', 'noopener,noreferrer');
                    }
                }
            });
        },

        /**
         * Smooth Scroll
         */
        setupSmoothScroll: function() {
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 600);
                }
            });
        },

        /**
         * Lazy Load Images
         */
        setupLazyLoad: function() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const src = img.getAttribute('data-src');
                            if (src) {
                                img.src = src;
                                img.removeAttribute('data-src');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(function(img) {
                    imageObserver.observe(img);
                });
            }
        },

        /**
         * Table of Contents - Auto build from headings
         */
        setupTableOfContents: function() {
            const toc = document.querySelector('#toc');
            const content = document.querySelector('.single__content');

            if (!toc || !content) return;

            const heads = content.querySelectorAll('h2, h3');
            if (!heads.length) {
                toc.style.display = 'none';
                return;
            }

            const ul = document.createElement('ul');
            heads.forEach((h, idx) => {
                if (!h.id) {
                    h.id = 'sect-' + (idx + 1);
                }
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = '#' + h.id;
                a.textContent = h.textContent;
                li.appendChild(a);
                ul.appendChild(li);
            });

            toc.innerHTML = '<strong>İçindekiler</strong>';
            toc.appendChild(ul);
        },

        /**
         * Back to Top Button
         */
        setupBackToTop: function() {
            // Create button if it doesn't exist
            if ($('.back-to-top').length === 0) {
                $('body').append('<button class="back-to-top" style="display: none;">↑</button>');
            }

            $(window).on('scroll', function() {
                if ($(this).scrollTop() > 300) {
                    $('.back-to-top').fadeIn();
                } else {
                    $('.back-to-top').fadeOut();
                }
            });

            $('.back-to-top').on('click', function() {
                $('html, body').animate({ scrollTop: 0 }, 600);
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        OneNavTheme.init();
    });

    // Expose to global scope
    window.OneNavTheme = OneNavTheme;

})(jQuery);
