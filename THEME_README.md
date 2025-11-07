# OneNav Pro WordPress Theme

Production-ready WordPress theme inspired by OneNav with comprehensive features, custom post types, widgets, and TGMPA support.

## Features

### Core Features
- ✅ **8 Tabbed Theme Settings Panel** (Genel, Anasayfa, Yazılar, Araçlar & Kaynaklar, E-Kitap, Arama, Görünüm, SEO & Optimizasyon)
- ✅ **Custom Post Types**: Site, Resource, Ebook, Video, News, App, Gallery, AI Tool, Marketplace
- ✅ **Custom Taxonomies**: Site Category, Tool Category, Resource Category, Video Category
- ✅ **Search with Engine Tabs** (Site/Google/Bing/Baidu)
- ✅ **Front-end Submission** (logged-in users can submit sites/resources)
- ✅ **Dark Mode** with localStorage persistence
- ✅ **Custom Widgets**: Popular Sites, Stats
- ✅ **Template Parts**: Card components for Post, Site, Ebook, Video
- ✅ **Helper Functions**: Views counter, breadcrumbs, related posts, time ago
- ✅ **TGMPA Integration** for plugin recommendations
- ✅ **Responsive Design** (mobile-first)
- ✅ **BEM CSS Naming Convention**
- ✅ **SEO Optimized** with Schema markup
- ✅ **Performance Optimized** with lazy loading

### Custom Post Types

1. **Site** - Directory listings with external URLs
2. **Resource** - Downloadable resources
3. **Ebook** - Digital books with ISBN, cover, price
4. **Video** - Video content with duration, thumbnails
5. **News** - News articles
6. **App** - Mobile applications
7. **Gallery** - Image galleries
8. **AI Tool** - AI tools and services
9. **Marketplace** - Products

### Theme Settings (8 Tabs)

#### 1. Genel (General)
- Site Logo & Favicon upload
- Primary & Secondary colors
- Footer text

#### 2. Anasayfa (Homepage)
- Hero background image
- Section titles (Popular Sites, E-Books, etc.)
- Layout settings (columns: 3-6)

#### 3. Yazılar (Posts)
- Post layout (sidebar/fullwidth)
- Like button toggle
- Author box toggle

#### 4. Araçlar & Kaynaklar (Tools & Resources)
- Filter tab labels (CSV)
- Max columns
- Load more button text

#### 5. E-Kitap (E-book)
- Buy button text
- Download button text
- Related books title

#### 6. Arama (Search)
- Default search tab (Site/Google/Bing/Baidu)
- Login required for local search toggle

#### 7. Görünüm (Appearance)
- Dark mode enable
- Dark mode colors (background, text)
- Language selection

#### 8. SEO & Optimizasyon
- Title pattern (%title%, %sitename%, %sep%)
- Description pattern (%excerpt%, %title%)
- Noindex CPTs selection
- Dequeue emojis/embeds
- Image size cleanup

## Installation

### 1. Upload Theme
```bash
# Upload the theme folder to wp-content/themes/
wp-content/themes/onenav-pro/
```

### 2. Install TGMPA Class (Optional)
To enable plugin recommendations:
1. Download TGM Plugin Activation from http://tgmpluginactivation.com/
2. Save `class-tgm-plugin-activation.php` to `/inc/` directory
3. The theme will automatically detect and use it

### 3. Activate Theme
1. Go to **Appearance → Themes**
2. Activate "OneNav Pro"
3. Go to **Appearance → Theme Settings** to configure

### 4. Recommended Plugins (via TGMPA)
- **Advanced Custom Fields** (for enhanced custom fields)
- **Kirki Customizer Framework** (for advanced customizer options)
- **WP-Optimize** (optional, for performance)
- **Regenerate Thumbnails** (optional, after activating theme)

### 5. Configure Theme
Navigate to **Appearance → Theme Settings** and configure all 8 tabs according to your needs.

## File Structure

```
onenav-pro/
├── style.css                 # Theme header & base styles
├── functions.php             # Theme functions & hooks
├── header.php                # Site header
├── footer.php                # Site footer
├── index.php                 # Main template
├── home.php                  # Homepage template
├── single.php                # Single post template
├── archive.php               # Archive template
├── search.php                # Search with tabs
├── sidebar.php               # Sidebar widget area
├── page-tools.php            # Tools/resources listing
├── page-ebook.php            # Ebook details/list
├── page-submit.php           # Front-end submission
├── screenshot.png            # Theme screenshot
│
├── assets/
│   ├── css/
│   │   ├── theme.css         # Main theme styles (BEM)
│   │   ├── responsive.css    # Responsive styles
│   │   └── admin.css         # Admin styles
│   └── js/
│       ├── theme.js          # Main theme JS
│       └── main.js           # Additional JS
│
├── template-parts/
│   ├── card-post.php         # Post card component
│   ├── card-site.php         # Site/tool card
│   ├── card-ebook.php        # Ebook card
│   └── card-video.php        # Video card
│
├── inc/
│   ├── helpers.php           # Helper functions
│   ├── tgmpa-config.php      # TGMPA configuration
│   └── widgets/
│       ├── widget-popular-sites.php
│       └── widget-stats.php
│
└── includes/
    ├── post-types.php        # CPT & taxonomies
    ├── theme-options.php     # 8-tab settings
    ├── customizer.php        # Customizer settings
    ├── api-endpoints.php     # REST API endpoints
    └── trend-sync.php        # Trending sync

```

## Usage

### Adding Custom Post Types

#### Add a Site/Tool
1. Go to **Sites → Add New**
2. Enter title, description
3. Add site URL and icon in "Site Details" meta box
4. Select categories and tags
5. Publish

#### Add an E-book
1. Go to **E-Books → Add New**
2. Upload cover image as featured image
3. Enter ISBN, price in meta boxes
4. Add ebook file URL
5. Publish

### Using Widgets

#### Add Popular Sites Widget
1. Go to **Appearance → Widgets**
2. Find "OneNav: Popular Sites"
3. Drag to "Primary Sidebar"
4. Configure title and number of sites
5. Save

#### Add Stats Widget
1. Go to **Appearance → Widgets**
2. Find "OneNav: Stats"
3. Drag to sidebar
4. Select which stats to display
5. Save

### Front-end Submission

Users can submit sites/resources from the submission page:
1. Create a page
2. Select template: "Submit Site/Resource"
3. Publish
4. Share the URL with users

Submissions will be saved as "pending" and require admin approval.

### Search Functionality

The search page supports multiple search engines:
- **Site**: Local WordPress search
- **Google**: External Google search
- **Bing**: External Bing search
- **Baidu**: External Baidu search

Configure the default tab in **Theme Settings → Arama**.

### Dark Mode

Dark mode is automatically available with a floating toggle button. Settings:
- **Enable/Disable**: Theme Settings → Görünüm
- **Colors**: Customize dark mode colors
- **Persistence**: User preference saved in localStorage

## Customization

### Custom CSS Variables

The theme uses CSS variables for easy customization:

```css
:root {
    --color-primary: #a855f7;
    --color-secondary: #ec4899;
    --bg-light: #f8fafc;
    --text-primary: #1e293b;
    --radius-md: 12px;
    --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
}
```

### BEM Naming Convention

The theme follows BEM (Block Element Modifier) naming:
```css
.card { }                    /* Block */
.card__title { }             /* Element */
.card--featured { }          /* Modifier */
```

### Helper Functions

Available helper functions:

```php
// Get theme option
onenav_get_option('option_key', 'default');

// Set post views
onenav_set_post_views($post_id);

// Get post views
onenav_get_post_views($post_id);

// Display breadcrumbs
echo onenav_breadcrumbs();

// Get related posts
$related = onenav_get_related_posts($post_id, 6);

// Get popular posts
$popular = onenav_get_popular_posts(5, 'site');

// Time ago
echo onenav_time_ago(get_the_date('Y-m-d H:i:s'));

// Reading time
echo onenav_reading_time();

// Social share buttons
echo onenav_social_share_buttons();

// Schema markup
echo onenav_schema_markup();
```

## Requirements

- **WordPress**: 6.5 or higher
- **PHP**: 7.4 or higher
- **MySQL**: 5.6 or higher

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Performance

- Lazy loading for images
- Optimized asset loading
- Minimal HTTP requests
- CDN-ready
- Caching-friendly

## Security

- Nonce verification on all forms
- Capability checks
- Input sanitization
- Output escaping
- XSS protection
- SQL injection prevention

## Changelog

### Version 1.0.0
- Initial release
- 8-tab theme settings panel
- 9 custom post types
- Search with engine tabs
- Front-end submission
- Dark mode support
- Custom widgets
- Template parts
- Helper functions
- TGMPA integration
- BEM CSS
- SEO optimization
- Performance optimization

## Support

For support, feature requests, or bug reports:
- Create an issue on GitHub
- Check documentation
- Contact theme author

## License

GPL v2 or later
https://www.gnu.org/licenses/gpl-2.0.html

## Credits

- Theme Framework: WordPress
- Icons: Dashicons
- CSS Variables: Modern CSS
- JavaScript: jQuery

---

**OneNav Pro** - Production-ready WordPress theme for directories, resources, and content aggregation.
