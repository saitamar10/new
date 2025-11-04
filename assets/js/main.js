/**
 * OneNav Main JavaScript
 */

(function($) {
    'use strict';

    const OneNav = {
        init: function() {
            this.setupEventListeners();
            this.loadTrendingKeywords();
            this.setupSearch();
            this.setupFilters();
            this.setupDarkMode();
            this.setupHeroSearch();
            this.setupCategoryFilter();
            this.setupAnimations();
        },

        setupEventListeners: function() {
            // Click tracking
            $(document).on('click', '.site-card a, .news-card a, .app-card a', function(e) {
                const postId = $(this).closest('[data-post-id]').data('post-id');
                if (postId) {
                    OneNav.trackClick(postId);
                }
            });

            // Filter buttons
            $(document).on('click', '.filter-tab', function() {
                $('.filter-tab').removeClass('active');
                $(this).addClass('active');
                const category = $(this).data('category');
                OneNav.filterByCategory(category);
            });

            // Responsive menu
            $(document).on('click', '.menu-toggle', function() {
                $('nav').toggleClass('active');
            });
        },

        setupSearch: function() {
            const searchInput = $('#site-search');
            let searchTimeout;

            searchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();

                if (query.length < 2) {
                    $('.search-results').hide();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    OneNav.performSearch(query);
                }, 300);
            });

            // Close search results on click outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-wrapper').length) {
                    $('.search-results').hide();
                }
            });
        },

        performSearch: function(query) {
            $.ajax({
                type: 'POST',
                url: onenavData.ajaxUrl,
                data: {
                    action: 'onenav_search',
                    search: query,
                    nonce: onenavData.nonce
                },
                success: function(response) {
                    if (response.success) {
                        OneNav.displaySearchResults(response.data);
                    }
                }
            });
        },

        displaySearchResults: function(results) {
            const resultsHtml = results.map(item => `
                <div class="search-result-item">
                    <a href="${item.url}">
                        <div class="search-result-title">${item.title}</div>
                        <div class="search-result-type">${item.type}</div>
                    </a>
                </div>
            `).join('');

            $('.search-results').html(resultsHtml).show();
        },

        setupFilters: function() {
            // Load categories and create filter tabs
            $.ajax({
                type: 'GET',
                url: `${onenavData.siteUrl}/wp-json/onenav/v1/categories`,
                success: function(categories) {
                    OneNav.renderFilterTabs(categories);
                }
            });
        },

        renderFilterTabs: function(categories) {
            const tabsHtml = categories.map(cat => `
                <button class="filter-tab" data-category="${cat.slug}">
                    ${cat.name} (${cat.count})
                </button>
            `).join('');

            $('.filter-tabs').html(tabsHtml);
        },

        filterByCategory: function(category) {
            const container = $('.sites-grid');
            container.addClass('loading');

            $.ajax({
                type: 'GET',
                url: `${onenavData.siteUrl}/wp-json/onenav/v1/sites/category/${category}`,
                success: function(sites) {
                    OneNav.renderSites(sites, container);
                    container.removeClass('loading');
                }
            });
        },

        renderSites: function(sites, container) {
            const sitesHtml = sites.map(site => `
                <div class="site-card" data-post-id="${site.id}">
                    <img src="${site.icon}" alt="${site.title}" class="site-icon">
                    <h3 class="site-title">${site.title}</h3>
                    <p class="site-category">${site.category}</p>
                    <div class="site-actions">
                        <a href="${site.url}" target="_blank" class="site-action-btn">🌐 Visit</a>
                        <button class="site-action-btn qr-btn" data-url="${site.url}">📱 QR</button>
                    </div>
                </div>
            `).join('');

            container.fadeOut(300, function() {
                $(this).html(sitesHtml).fadeIn(300);
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
                },
                error: function(err) {
                    console.log('Click tracking failed:', err);
                }
            });
        },

        loadTrendingKeywords: function() {
            $.ajax({
                type: 'GET',
                url: `${onenavData.siteUrl}/wp-json/onenav/v1/trending`,
                success: function(trending) {
                    OneNav.renderTrendingBar(trending);
                }
            });
        },

        renderTrendingBar: function(trending) {
            const trendingHtml = trending.map(item => `
                <div class="trending-item">
                    <span class="trending-badge">#${item.number}</span>
                    <a href="${item.trend_url}">${item.keyword}</a>
                </div>
            `).join('');

            $('.trending-bar').html('📈 Trending: ' + trendingHtml);
        },

        generateQRCode: function(text, callback) {
            $.ajax({
                type: 'GET',
                url: `${onenavData.siteUrl}/wp-json/onenav/v1/qrcode`,
                data: { text: text },
                success: function(response) {
                    callback(response.qr_url);
                }
            });
        },

        setupDarkMode: function() {
            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', currentTheme);

            // Create dark mode toggle button if enabled
            if (onenavData.showDarkModeToggle) {
                const toggleBtn = $('<button>')
                    .addClass('dark-mode-toggle')
                    .attr('title', 'Toggle Dark Mode')
                    .html(currentTheme === 'dark' ? '☀️' : '🌙')
                    .appendTo('body');

                toggleBtn.on('click', function() {
                    OneNav.toggleDarkMode();
                });
            }

            // If dark mode is enabled by default in customizer
            if (onenavData.darkMode && currentTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        },

        toggleDarkMode: function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Update toggle button icon
            $('.dark-mode-toggle').html(newTheme === 'dark' ? '☀️' : '🌙');
        },

        setupHeroSearch: function() {
            const heroSearchInput = $('#hero-search');
            let searchTimeout;

            heroSearchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();

                if (query.length < 2) {
                    $('.hero-search-results').hide();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    OneNav.performSearch(query, '.hero-search-results');
                }, 300);
            });

            // Search button click
            $('.hero-search-btn').on('click', function() {
                const query = heroSearchInput.val();
                if (query.length >= 2) {
                    window.location.href = `${onenavData.siteUrl}/?s=${encodeURIComponent(query)}`;
                }
            });

            // Enter key
            heroSearchInput.on('keypress', function(e) {
                if (e.which === 13) {
                    $('.hero-search-btn').click();
                }
            });
        },

        setupCategoryFilter: function() {
            // Handle category sidebar clicks with smooth loading
            $('.category-nav-item').on('click', function(e) {
                if ($(this).attr('href').includes('?category=')) {
                    e.preventDefault();
                    const category = $(this).data('category');

                    $('.category-nav-item').removeClass('active');
                    $(this).addClass('active');

                    // Add loading state
                    $('.main-content').addClass('loading');

                    // Update URL without reload
                    if (category) {
                        history.pushState(null, '', `?category=${category}`);
                    } else {
                        history.pushState(null, '', '/');
                    }

                    // Reload sections with new category
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            });
        },

        setupAnimations: function() {
            // Intersection Observer for scroll animations
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animated');
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                // Observe cards
                document.querySelectorAll('.card').forEach(card => {
                    observer.observe(card);
                });

                // Observe sections
                document.querySelectorAll('.section').forEach(section => {
                    observer.observe(section);
                });
            }

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Card hover effects
            $('.card').hover(
                function() {
                    $(this).addClass('hover');
                },
                function() {
                    $(this).removeClass('hover');
                }
            );
        },

        // Add click tracking with analytics
        trackClick: function(postId) {
            $.ajax({
                type: 'POST',
                url: onenavData.ajaxUrl,
                data: {
                    action: 'onenav_track_click',
                    site_id: postId,
                    nonce: onenavData.nonce
                },
                success: function(response) {
                    // Update click count in UI if element exists
                    const clickCountElement = $(`.card[data-post-id="${postId}"] .stat-text`);
                    if (clickCountElement.length) {
                        const currentCount = parseInt(clickCountElement.text().replace(/,/g, '')) || 0;
                        clickCountElement.text((currentCount + 1).toLocaleString());
                    }
                },
                error: function(err) {
                    console.log('Click tracking failed:', err);
                }
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        OneNav.init();

        // QR Code modal
        $(document).on('click', '.qr-btn', function(e) {
            e.preventDefault();
            const url = $(this).data('url');
            const siteTitle = $(this).closest('.site-card').find('.site-title').text();

            OneNav.generateQRCode(url, function(qrUrl) {
                const modal = `
                    <div class="modal-overlay">
                        <div class="modal-content">
                            <button class="modal-close">&times;</button>
                            <h3>${siteTitle}</h3>
                            <img src="${qrUrl}" alt="QR Code" style="max-width: 300px;">
                            <p>${url}</p>
                        </div>
                    </div>
                `;
                $('body').append(modal);
            });
        });

        // Close modal
        $(document).on('click', '.modal-close, .modal-overlay', function() {
            if ($(this).hasClass('modal-overlay') && !$(this).find('.modal-content').has(event.target).length) {
                return;
            }
            $('.modal-overlay').remove();
        });
    });

    window.OneNav = OneNav;

})(jQuery);
