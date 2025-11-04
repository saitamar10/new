# OneNav - Modern Navigation Portal WordPress Theme

## 📋 Genel Bakış

OneNav, kapsamlı bir navigasyon portalı teması olarak tasarlanmış WordPress temasıdır. Site linkileri, haberler, mobil uygulamalar, e-kitaplar, galerileri, AI araçları ve marketplace'i tek platformda yönetmenizi sağlar.

## ✨ Özellikler

### 🎯 Ana Fonksiyonlar
- ✅ **Dinamik Site Yönetimi** - Custom post type ile site ekleme
- ✅ **Haber Portalı** - Haberleri yönetin ve otomatik NewsAPI entegrasyonu
- ✅ **Mobil Uygulamalar** - iOS ve Android uygulamalarını listeleyin
- ✅ **E-Kitap Kütüphanesi** - PDF, EPUB, MOBI formatlarını destekle
- ✅ **Foto Galeriler** - Resim koleksiyonlarını yönetin
- ✅ **AI Araçları** - ChatGPT, Claude, Copilot gibi araçları listeleyin
- ✅ **Marketplace** - Dijital ürün satışı

### 🔧 Teknik Özellikler
- ✅ **REST API Endpoints** - Tüm veriler API üzerinden erişilebilir
- ✅ **Trend Takibi** - Google Trends / Yandex Trends / Özel Trendler
- ✅ **QR Kod Generator** - Otomatik QR kod oluşturma (QRServer API)
- ✅ **Canlı Arama** - AJAX ile gerçek zamanlı arama
- ✅ **Kategori Filtreleme** - Siteler kategoriye göre filtreleme
- ✅ **İstatistik Takibi** - Tıklama sayılarını kayıt
- ✅ **WP Customizer** - Tema özelleştirme paneli
- ✅ **Responsive Design** - Mobil uyumlu tasarım

## 📦 Kurulum

### 1. Dosyaları Yükleyin

Aşağıdaki dosyaları `/wp-content/themes/onenav/` klasöründe oluşturun:

```
onenav/
├── style.css
├── functions.php
├── index.php
├── home.php
├── header.php
├── footer.php
├── includes/
│   ├── post-types.php
│   ├── customizer.php
│   ├── api-endpoints.php
│   ├── trend-sync.php
│   └── widgets.php
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   ├── responsive.css
│   │   └── admin.css
│   ├── js/
│   │   ├── main.js
│   │   ├── search.js
│   │   ├── trends.js
│   │   ├── api-handler.js
│   │   └── admin.js
│   └── images/
```

### 2. Temayı Aktif Edin

WordPress Admin Panel > Görünüm > Temalar > OneNav temasını aktif edin.

### 3. Ayarları Yapılandırın

**WordPress Admin Panel > Özelleştir (Customizer)**

#### Genel Ayarlar
- Ana renk: #a855f7 (Purple)
- İkincil renk: #ec4899 (Pink)

#### Header Ayarları
- Trend Bar: Açık/Kapalı
- Trend Kaynağı: Google / Yandex / Özel

#### API Ayarları
- NewsAPI Anahtarı (isteğe bağlı): https://newsapi.org
- QR Kod Boyutu: 200px (varsayılan)

## 🚀 Başlarken

### 1. Kategoriler Oluşturun

Admin Panel > Siteler > Kategoriler

Örnek kategoriler:
- Sosyal Ağlar
- Habercilik
- E-Ticaret
- Tasarım
- Yazılımcı Araçları
- Oyunlar
- Eğitim

### 2. Siteler Ekleyin

Admin Panel > Siteler > Yeni Ekle

Gerekli alanlar:
- Başlık: Site adı
- Açıklama: Kısa tanım
- Site URL: https://example.com
- Icon URL: Logo/ikon resmi
- Kategori: İlgili kategoriyi seç

### 3. Haberler Ekleyin

Admin Panel > Haberler > Yeni Ekle

Haberler otomatik olarak NewsAPI'den de çekilebilir (API anahtarı gerekli).

### 4. Uygulamalar Ekleyin

Admin Panel > Mobil Uygulamalar > Yeni Ekle

Alanlar:
- Başlık: Uygulama adı
- iOS Link: App Store URL
- Android Link: Google Play URL
- Fiyat: Ücret (0 = Ücretsiz)

### 5. E-Kitaplar Ekleyin

Admin Panel > E-Kitaplar > Yeni Ekle

Alanlar:
- Başlık: Kitap adı
- File URL: PDF/EPUB/MOBI dosya
- Dosya Tipi: PDF / EPUB / MOBI

### 6. AI Araçları Ekleyin

Admin Panel > AI Araçları > Yeni Ekle

Alanlar:
- Başlık: Tool adı (ChatGPT, Claude, vb)
- Tool URL: https://...
- Özellikler: Virgülle ayrılmış liste

## 🔌 API Endpoints

### REST API Kullanımı

Base URL: `https://yoursite.com/wp-json/onenav/v1/`

#### Arama
```
GET /search?q=wordpress
```

#### Kategorilere göre siteler
```
GET /sites/category/sosyal-aglar?limit=12
```

#### Popüler Siteler
```
GET /sites/popular?limit=12
```

#### Trendler
```
GET /trending
```

#### QR Kod
```
GET /qrcode?text=https://example.com&size=200
```

#### Haberler
```
GET /news?limit=6&page=1
```

#### Uygulamalar
```
GET /apps?limit=12
```

#### AI Araçları
```
GET /ai-tools?limit=12
```

#### E-Kitaplar
```
GET /ebooks?limit=12
```

## 🎨 Özelleştirme

### Renk Şeması

`style.css` dosyasında CSS değişkenleri:

```css
:root {
    --primary-color: #a855f7;
    --secondary-color: #ec4899;
    --dark-bg: #0f172a;
    --light-bg: #f8fafc;
    --text-dark: #1e293b;
    --text-light: #64748b;
}
```

### Responsive Tasarım

- Desktop: 1400px
- Tablet: 768px
- Mobile: 480px

### Grid Düzenleri

- Sites Grid: 280px minimum
- News Grid: 300px minimum
- Apps Grid: 250px minimum
- Gallery Grid: 200px minimum

## 🛠️ Geliştirici Notları

### Hook'lar

```php
// Site eklendiğinde
do_action('onenav_site_added', $post_id);

// Tıklama takip
do_action('onenav_click_tracked', $post_id);

// Haber senkronize
do_action('onenav_news_synced');
```

### Filter'lar

```php
// Trenm verilerini filtele
apply_filters('onenav_trending_data', $trends);

// Arama sonuçlarını filtele
apply_filters('onenav_search_results', $results);
```

### Özel Sorgu Fonksiyonları

```php
// Popüler siteler
onenav_get_popular_sites($limit);

// Kategoriye göre siteler
onenav_get_posts_by_category($category, $limit);

// Trendler
onenav_get_trending();
```

## 📊 Cron Jobs

### Trend Güncellemesi
- Sıklık: Saatlik
- Hook: `onenav_update_trends`

### Haber Senkronizasyonu
- Sıklık: Saatlik
- Hook: `onenav_sync_news`
- Gerekli: NewsAPI anahtarı

## 🔒 Güvenlik

- NONCE doğrulaması tüm form'larda
- Input sanitization
- Output escaping
- Cap kontrolleri (yetki kontrolleri)
- SQL injection koruması (prepared statements)
- XSS koruması

## 📱 Mobil Uyum

- 100% responsive tasarım
- Touch-friendly butonlar
- Mobil menüsü
- Fast loading

## ⚡ Performans

- Lazy loading görüntüler
- CSS/JS minification
- Caching (Transients)
- Database indexing
- API response caching (1 saat)

## 🐛 Sorun Giderme

### API'ler çalışmıyor
- API endpoint'lerine `/wp-json/onenav/v1/` adresinden ulaşın
- WordPress REST API aktif olduğundan emin olun
- NONCE anahtarını kontrol edin

### QR Kodlar oluşturulmuyor
- QRServer API accessible mi kontrol edin (https://api.qrserver.com)

### Haberler senkronize olmuyor
- NewsAPI anahtarını kontrol edin
- Cron jobs çalışıyor mu kontrol edin

### Trendler güncellenmiyorKüstü
- Trend kaynağını kontrol edin
- Custom trends'i boş bırakmadığınızdan emin olun

## 📚 Kullanılan Teknolojiler

- WordPress REST API
- jQuery (AJAX)
- PHP 7.4+
- MySQL 5.7+
- QRServer API
- NewsAPI.org
- CSS3 Grid & Flexbox

## 📝 Dosya Yapısı

```
onenav/
├── style.css                 # Tema tanımı
├── functions.php            # Ana fonksiyonlar
├── index.php               # Fallback template
├── home.php               # Ana sayfa
├── header.php            # Üst bölüm
├── footer.php           # Alt bölüm
├── includes/
│   ├── post-types.php      # Custom post types
│   ├── customizer.php      # Özelleştirme paneli
│   ├── api-endpoints.php   # REST API
│   ├── trend-sync.php      # Trend güncelleme
│   └── widgets.php         # Widget'lar
├── assets/
│   ├── css/
│   │   ├── main.css
│   │   ├── responsive.css
│   │   └── admin.css
│   ├── js/
│   │   ├── main.js
│   │   ├── search.js
│   │   └── trends.js
│   └── images/
├── README.md
└── screenshot.png
```

## 🤝 Destek

Sorularınız veya önerileri var mı? İletişim sayfası üzerinden bize ulaşabilirsiniz.

## 📄 Lisans

GPL v2 or later

---

**OneNav Teması** - Türkiye için tasarlanmış modern navigasyon portalı
