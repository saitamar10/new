# OneNav - Modüler Bileşen Sistemi

## 📋 Genel Bakış

OneNav teması artık tamamen modüler bir bileşen sistemine sahiptir. Tüm bileşenler WordPress Customizer üzerinden kolayca özelleştirilebilir.

## 🏗️ Yapı

### Template Parts

```
template-parts/
├── components/          # Tekrar kullanılabilir bileşenler
│   ├── hero-search.php        # Hero arama bölümü
│   ├── category-sidebar.php   # Kategori navigasyon sidebar
│   ├── card-site.php          # Site kartı
│   ├── card-news.php          # Haber kartı
│   ├── card-app.php           # Uygulama kartı
│   ├── card-ai-tool.php       # AI araç kartı
│   ├── card-ebook.php         # E-kitap kartı
│   └── card-gallery.php       # Galeri kartı
└── sections/            # İçerik bölümleri
    ├── section-sites.php      # Popüler siteler
    ├── section-news.php       # Haberler
    ├── section-apps.php       # Uygulamalar
    ├── section-ai-tools.php   # AI araçları
    ├── section-ebooks.php     # E-kitaplar
    └── section-gallery.php    # Galeriler
```

## 🎨 Tema Paneli Ayarları

### 1. Hero Bölümü (`onenav_hero_section`)
- ✅ Hero bölümünü göster/gizle
- ✏️ Başlık ve alt başlık düzenleme
- 🔍 Arama kutusu aktif/pasif
- 🔗 Hızlı kategori bağlantıları

### 2. Kategori Sidebar (`onenav_sidebar_section`)
- ✅ Sidebar göster/gizle
- ✏️ Sidebar başlığını özelleştir
- 📊 İstatistikleri göster/gizle

### 3. Bölüm Ayarları (`onenav_section_settings`)
Her bölüm için:
- ✏️ Özel başlık
- 🔢 Gösterilecek öğe sayısı
- ✅ Bölümü aktif/pasif

### 4. Layout Ayarları (`onenav_layout`)
- 📏 Grid sütun sayısı (3-6 sütun)
- 🔵 Kart köşe yuvarlama (0-50px)
- 📐 Kart arası boşluk (5-50px)

### 5. Dark Mode (`onenav_darkmode`)
- 🌙 Dark mode aktif/pasif
- 🔘 Dark mode değiştirme butonu

### 6. Genel Ayarlar (`onenav_general`)
- 🎨 Ana renk
- 🎨 İkincil renk

### 7. Header Ayarları (`onenav_header`)
- 📈 Trend bar göster/gizle
- 🔧 Trend kaynağı (Google/Yandex/Özel)

## 💻 Kullanım

### Ana Sayfada Bileşen Gösterme

```php
// Hero bölümünü göster
if (get_theme_mod('onenav_show_hero', true)) {
    get_template_part('template-parts/components/hero', 'search');
}

// Sidebar göster
if (get_theme_mod('onenav_show_category_sidebar', true)) {
    get_template_part('template-parts/components/category', 'sidebar');
}

// Siteler bölümünü göster
if (get_theme_mod('onenav_show_popular', true)) {
    get_template_part('template-parts/sections/section', 'sites');
}
```

### Bileşen Kartlarını Özelleştirme

Her kart bileşeni (`card-*.php`) kendi stiline sahiptir ve kolayca özelleştirilebilir:

```php
// Site kartı örneği
get_template_part('template-parts/components/card', 'site');
```

## 🎨 Stil Sistemi

### CSS Dosya Yapısı

```
assets/css/
├── components.css           # Tüm bileşen stilleri
├── dark-mode.css           # Dark mode stilleri
├── responsive-modern.css   # Modern responsive tasarım
├── responsive.css          # Eski responsive (opsiyonel)
└── admin.css              # Admin panel stilleri
```

### CSS Değişkenleri

```css
:root {
    --primary-color: #a855f7;
    --secondary-color: #ec4899;
    --dark-bg: #0f172a;
    --light-bg: #f8fafc;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --border-color: #e2e8f0;
    --radius: 12px;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
```

## 🌙 Dark Mode

Dark mode otomatik olarak kullanıcı tercihini localStorage'da saklar:

```javascript
// Dark mode'u programatik olarak değiştir
OneNav.toggleDarkMode();

// Mevcut temayı al
const theme = document.documentElement.getAttribute('data-theme');
```

## 📱 Responsive Tasarım

### Breakpoints

- **Desktop**: 1400px+
- **Tablet**: 768px - 1024px
- **Mobile Landscape**: 481px - 768px
- **Mobile Portrait**: ≤480px

### Grid Ayarları

Grid sütunları ekran boyutuna göre otomatik ayarlanır:
- Desktop: 4-6 sütun (customizer'dan ayarlanabilir)
- Tablet: 3 sütun
- Mobile: 2 sütun
- Small Mobile: 1 sütun

## 🔧 JavaScript API

### OneNav Nesnesi

```javascript
// Arama yap
OneNav.performSearch('keyword');

// Dark mode değiştir
OneNav.toggleDarkMode();

// Tıklama izle
OneNav.trackClick(postId);

// Kategori filtrele
OneNav.filterByCategory('category-slug');

// QR kod oluştur
OneNav.generateQRCode('url', callback);
```

## 🚀 Performans

### Optimizasyonlar

- ✅ Lazy loading için Intersection Observer
- ✅ Debounced search (300ms)
- ✅ CSS custom properties ile dinamik tema
- ✅ Minimal JavaScript (jQuery bağımlı)
- ✅ Optimize edilmiş görseller

## 📝 Bileşen Ekleme

Yeni bir bileşen eklemek için:

1. `template-parts/components/` veya `template-parts/sections/` klasörüne yeni PHP dosyası ekle
2. `includes/customizer-extended.php` içine ayarları ekle
3. `assets/css/components.css` içine stilleri ekle
4. `home.php` içinde çağır

Örnek:

```php
// template-parts/sections/section-custom.php
<?php
if (!defined('ABSPATH')) exit;
if (!get_theme_mod('onenav_show_custom', true)) return;
?>
<div class="section custom-section">
    <!-- İçerik -->
</div>
```

## 🎯 En İyi Uygulamalar

1. **Her bileşen bağımsız olmalı** - Diğer bileşenlere bağımlı olmamalı
2. **Customizer ayarlarını kullan** - Hardcode değil, theme_mod kullan
3. **Dark mode uyumlu** - Tüm renkler CSS değişkenleri ile
4. **Responsive öncelikli** - Mobile-first yaklaşım
5. **Performance odaklı** - Gereksiz yüklemeleri önle

## 📚 Dokümantasyon

- WordPress Customizer: Görünüm > Özelleştir
- Bileşen referansı: Bu dosya
- API dokümantasyonu: `/includes/api-endpoints.php`

## 🐛 Sorun Giderme

### Bileşen görünmüyor?
- Customizer'da bileşen aktif mi kontrol et
- `get_theme_mod()` değerini kontrol et
- Post type'da içerik var mı kontrol et

### Stiller uygulanmıyor?
- Cache temizle
- CSS dosyaları doğru enqueue edilmiş mi kontrol et
- Browser developer tools ile CSS yüklenmiş mi kontrol et

### Dark mode çalışmıyor?
- JavaScript consol'da hata var mı kontrol et
- localStorage desteklenmiş mi kontrol et
- `onenavData.showDarkModeToggle` true mu kontrol et

## 📞 Destek

Sorunlar için GitHub Issues: [Repository Issues](https://github.com)

---

**Version**: 1.0.0
**Last Updated**: 2025-11-04
**Author**: OneNav Team
