// ==========================================
// ONENAV - INTERACTIVE JAVASCRIPT
// ==========================================

/**
 * Initialize all functionality when DOM is loaded
 */
document.addEventListener('DOMContentLoaded', function() {
    initDarkMode();
    initSearchTabs();
    initSearch();
    initLikeButton();
    initCategoryFilters();
    initLoadMore();
    initSmoothScroll();
    console.log('OneNav initialized successfully! 🚀');
});

// ==========================================
// DARK MODE FUNCTIONALITY
// ==========================================

/**
 * Initialize dark mode toggle and restore saved preference
 */
function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');

    if (!darkModeToggle) return;

    // Check for saved dark mode preference
    const isDarkMode = localStorage.getItem('darkMode') === 'enabled';

    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        updateDarkModeIcon(darkModeToggle, true);
    }

    // Toggle dark mode on button click
    darkModeToggle.addEventListener('click', function() {
        const isCurrentlyDark = document.body.classList.contains('dark-mode');

        if (isCurrentlyDark) {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'disabled');
            updateDarkModeIcon(darkModeToggle, false);
        } else {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'enabled');
            updateDarkModeIcon(darkModeToggle, true);
        }

        // Add animation effect
        darkModeToggle.style.transform = 'scale(0.9)';
        setTimeout(() => {
            darkModeToggle.style.transform = 'scale(1)';
        }, 150);
    });
}

/**
 * Update dark mode toggle icon
 * @param {HTMLElement} button - The dark mode toggle button
 * @param {boolean} isDark - Whether dark mode is enabled
 */
function updateDarkModeIcon(button, isDark) {
    const icon = button.querySelector('i');
    if (icon) {
        icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
    }
}

// ==========================================
// SEARCH FUNCTIONALITY
// ==========================================

/**
 * Initialize search engine tab switching
 */
function initSearchTabs() {
    const searchTabs = document.querySelectorAll('.search-tab');

    searchTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            searchTabs.forEach(t => t.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Store selected search engine
            const engine = this.getAttribute('data-engine');
            localStorage.setItem('searchEngine', engine);

            // Add subtle animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
}

/**
 * Initialize search functionality
 */
function initSearch() {
    const searchBtn = document.getElementById('searchBtn');
    const searchInput = document.getElementById('searchInput');

    if (!searchBtn || !searchInput) return;

    // Handle search button click
    searchBtn.addEventListener('click', performSearch);

    // Handle Enter key press in search input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });
}

/**
 * Perform search based on selected engine
 */
function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput.value.trim();

    if (!query) {
        // Shake animation for empty search
        searchInput.style.animation = 'shake 0.5s';
        setTimeout(() => {
            searchInput.style.animation = '';
        }, 500);
        return;
    }

    const engine = localStorage.getItem('searchEngine') || 'baidu';
    const searchUrls = {
        'baidu': `https://www.baidu.com/s?wd=${encodeURIComponent(query)}`,
        'google': `https://www.google.com/search?q=${encodeURIComponent(query)}`,
        'bing': `https://www.bing.com/search?q=${encodeURIComponent(query)}`
    };

    // Open search in new tab
    window.open(searchUrls[engine], '_blank');
}

// Add shake animation keyframes dynamically
if (!document.getElementById('shake-animation')) {
    const style = document.createElement('style');
    style.id = 'shake-animation';
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
}

// ==========================================
// LIKE BUTTON FUNCTIONALITY (Post Page)
// ==========================================

/**
 * Initialize like button on post pages
 */
function initLikeButton() {
    const likeBtn = document.getElementById('likeBtn');
    const likeCount = document.getElementById('likeCount');

    if (!likeBtn || !likeCount) return;

    // Check if post is already liked
    const postId = window.location.pathname; // Use pathname as simple ID
    const isLiked = localStorage.getItem(`liked_${postId}`) === 'true';

    if (isLiked) {
        likeBtn.classList.add('liked');
    }

    likeBtn.addEventListener('click', function() {
        const currentlyLiked = this.classList.contains('liked');
        let count = parseInt(likeCount.textContent);

        if (currentlyLiked) {
            // Unlike
            this.classList.remove('liked');
            count--;
            localStorage.setItem(`liked_${postId}`, 'false');
        } else {
            // Like
            this.classList.add('liked');
            count++;
            localStorage.setItem(`liked_${postId}`, 'true');

            // Add heart animation
            createHeartAnimation(this);
        }

        likeCount.textContent = count;

        // Button animation
        this.style.transform = 'scale(1.2)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 200);
    });
}

/**
 * Create floating heart animation
 * @param {HTMLElement} button - The like button element
 */
function createHeartAnimation(button) {
    const heart = document.createElement('i');
    heart.className = 'fas fa-heart';
    heart.style.cssText = `
        position: absolute;
        color: #ff4757;
        font-size: 1.5rem;
        pointer-events: none;
        animation: floatHeart 1s ease-out forwards;
    `;

    button.style.position = 'relative';
    button.appendChild(heart);

    setTimeout(() => {
        heart.remove();
    }, 1000);
}

// Add float heart animation
if (!document.getElementById('float-heart-animation')) {
    const style = document.createElement('style');
    style.id = 'float-heart-animation';
    style.textContent = `
        @keyframes floatHeart {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-30px) scale(1.5);
            }
        }
    `;
    document.head.appendChild(style);
}

// ==========================================
// CATEGORY FILTERS (Tools & Blog Pages)
// ==========================================

/**
 * Initialize category filter functionality
 */
function initCategoryFilters() {
    const filters = document.querySelectorAll('.category-filter');
    const toolCards = document.querySelectorAll('.tool-card');

    if (filters.length === 0) return;

    filters.forEach(filter => {
        filter.addEventListener('click', function() {
            // Remove active class from all filters
            filters.forEach(f => f.classList.remove('active'));

            // Add active class to clicked filter
            this.classList.add('active');

            const category = this.getAttribute('data-category');

            // Filter cards
            if (category === 'all') {
                // Show all cards
                toolCards.forEach(card => {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease';
                });
            } else {
                // Filter by category
                toolCards.forEach(card => {
                    const cardCategories = card.getAttribute('data-category') || '';

                    if (cardCategories.includes(category)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }
        });
    });
}

// Add fadeIn animation
if (!document.getElementById('fade-in-animation')) {
    const style = document.createElement('style');
    style.id = 'fade-in-animation';
    style.textContent = `
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
}

// ==========================================
// LOAD MORE FUNCTIONALITY
// ==========================================

/**
 * Initialize "Load More" button
 */
function initLoadMore() {
    const loadMoreBtn = document.querySelector('.load-more-btn');

    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener('click', function() {
        // Add loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        this.disabled = true;

        // Simulate loading (replace with actual data fetching in production)
        setTimeout(() => {
            // Show success message
            this.innerHTML = '<i class="fas fa-check"></i> Loaded!';

            // Reset button after delay
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 1000);

            // In a real application, you would append new content here
            showNotification('More content loaded successfully!');
        }, 1500);
    });
}

// ==========================================
// SMOOTH SCROLL FUNCTIONALITY
// ==========================================

/**
 * Initialize smooth scrolling for anchor links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // Skip if href is just "#"
            if (href === '#') {
                e.preventDefault();
                return;
            }

            const target = document.querySelector(href);

            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ==========================================
// NOTIFICATION SYSTEM
// ==========================================

/**
 * Show notification toast
 * @param {string} message - The notification message
 * @param {string} type - The notification type (success, error, info)
 */
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        animation: slideIn 0.3s ease, slideOut 0.3s ease 2.7s;
        max-width: 300px;
    `;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        ${message}
    `;

    document.body.appendChild(notification);

    // Remove after animation
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Add notification animations
if (!document.getElementById('notification-animations')) {
    const style = document.createElement('style');
    style.id = 'notification-animations';
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// ==========================================
// CARD HOVER EFFECTS
// ==========================================

/**
 * Add enhanced hover effects to cards
 */
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.site-card, .tool-card, .article-card');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });
});

// ==========================================
// COMMENT FORM SUBMISSION
// ==========================================

/**
 * Handle comment form submission
 */
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.querySelector('.comment-form');

    if (!commentForm) return;

    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const textarea = this.querySelector('textarea');
        const comment = textarea.value.trim();

        if (!comment) {
            showNotification('Please write a comment first!', 'error');
            return;
        }

        // Show loading state
        const submitBtn = this.querySelector('button');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
        submitBtn.disabled = true;

        // Simulate submission (replace with actual API call in production)
        setTimeout(() => {
            showNotification('Comment posted successfully!', 'success');
            textarea.value = '';
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 1000);
    });
});

// ==========================================
// RESPONSIVE MENU (Mobile)
// ==========================================

/**
 * Handle responsive navigation menu on mobile
 */
document.addEventListener('DOMContentLoaded', function() {
    const navMenu = document.querySelector('.nav-menu');

    if (!navMenu) return;

    // Check if menu is overflowing on mobile
    function checkMenuOverflow() {
        if (window.innerWidth < 768) {
            navMenu.style.overflowX = 'auto';
        } else {
            navMenu.style.overflowX = 'visible';
        }
    }

    checkMenuOverflow();
    window.addEventListener('resize', checkMenuOverflow);
});

// ==========================================
// SCROLL TO TOP BUTTON
// ==========================================

/**
 * Show/hide scroll to top button based on scroll position
 */
document.addEventListener('DOMContentLoaded', function() {
    // Create scroll to top button
    const scrollBtn = document.createElement('button');
    scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--accent-color);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        transition: all 0.3s ease;
    `;

    document.body.appendChild(scrollBtn);

    // Show/hide button based on scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollBtn.style.display = 'flex';
        } else {
            scrollBtn.style.display = 'none';
        }
    });

    // Scroll to top on click
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Hover effect
    scrollBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1)';
    });

    scrollBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
});

// ==========================================
// LAZY LOADING IMAGES (Optional Enhancement)
// ==========================================

/**
 * Lazy load images for better performance
 */
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
});

// ==========================================
// UTILITY FUNCTIONS
// ==========================================

/**
 * Debounce function for performance optimization
 * @param {Function} func - The function to debounce
 * @param {number} wait - The delay in milliseconds
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Format number with K suffix
 * @param {number} num - The number to format
 * @returns {string} Formatted number
 */
function formatNumber(num) {
    if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
}

// ==========================================
// CONSOLE GREETING
// ==========================================

console.log('%c👋 Welcome to OneNav!', 'font-size: 20px; font-weight: bold; color: #7B61FF;');
console.log('%cBuilt with ❤️ using HTML, CSS, and JavaScript', 'font-size: 12px; color: #666;');
console.log('%cVisit our GitHub: https://github.com/onenav', 'font-size: 12px; color: #666;');
