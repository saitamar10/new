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
