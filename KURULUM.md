# OneNav Tema - Kurulum Rehberi

## 🎯 Adım Adım Kurulum

### ADIM 1: Tema Dosyalarını Yükleyin

#### Seçenek A: FTP ile Yükleme
1. FTP istemcisini açın (FileZilla, WinSCP vb)
2. WordPress sitenize bağlanın
3. `/wp-content/themes/` klasörüne giden
4. Tüm OneNav dosyalarını buraya yükleyin

#### Seçenek B: Dosya Yöneticisi ile
1. cPanel veya Hosting kontrol paneline giriş yapın
2. File Manager açın
3. `public_html/wp-content/themes/` konumuna gidin
4. Yeni klasör oluşturun: `onenav`
5. Dosyaları buraya yükleyin

### ADIM 2: WordPress Admin Panel

1. **WordPress admin panel**'e giriş yapın: `https://yoursite.com/wp-admin`
2. Sol menüden **Görünüm > Temalar** seçin
3. **OneNav** temasını bulun
4. **Aktif Et** butonuna tıklayın

### ADIM 3: Temel Ayarları Yapın

#### Logo ve Site Bilgileri

1. **Ayarlar > Genel** bölümüne girin
2. Site başlığını yazın (örn: "OneNav - Navigation Portal")
3. Site açıklamasını yazın
4. **Ayarlar > Görünüm** bölümünde:
   - **Logo yükleyin** (SVG/PNG, min 200x60px)
   - **Favicon yükleyin** (ICO/PNG)

#### Theme Customizer Ayarları

1. **Görünüm > Özelleştir** seçin
2. Sol menüde **OneNav** bölümlerini göreceksiniz:

   **a) Genel Ayarlar**
   - Ana Renk: `#a855f7` (Purple)
   - İkincil Renk: `#ec4899` (Pink)

   **b) Header Ayarları**
   - ✅ Trend Bar Göster: Açık
   - Trend Kaynağı: "Google Trends" seçin
   - Custom Trendler (boş bırakabilirsiniz)

   **c) Ana Sayfa Ayarları**
   - Tüm bölümleri açık yapın:
     - ✅ Popüler Siteler
     - ✅ Haberler
     - ✅ Uygulamalar
     - ✅ E-Kitaplar
     - ✅ AI Araçları
     - ✅ Galeriler
   - Her Bölümde Gösterilecek Öğe: 12

   **d) Arama Ayarları**
   - Placeholder: "Ara... (Site, Haber, Uygulama, E-Book, Galeri, AI)"

   **e) Footer Ayarları**
   - Footer Arka Plan Rengi: `#0f172a`
   - Footer Metni: Kendi metninizi yazın
   - ✅ Sosyal Medya İkonları Göster

3. **Yayınla** butonuna tıklayın

### ADIM 4: İçerik Kategorilerini Oluşturun

1. **Siteler > Kategoriler** bölümüne girin
2. Aşağıdaki kategorileri oluşturun:

   ```
   📱 Sosyal Ağlar
   📰 Habercilik
   🛍️ E-Ticaret
   🎨 Tasarım
   💻 Yazılımcı Araçları
   🎮 Oyunlar
   🎓 Eğitim
   🏢 İş Araçları
   💰 Finans
   🚀 Startup'lar
   ```

3. Her kategori için:
   - **İsim** yazın
   - **Slug** (URL): Otomatik doldurulur
   - **Açıklama** (isteğe bağlı)
   - **Renk Seç** (Customizer'dan öğrendikten sonra)

### ADIM 5: Birkaç Örnek Site Ekleyin

1. **Siteler > Yeni Ekle** seçin
2. Başlık: "Google Trends"
3. Açıklama: "Günün gündemi ve popüler aramalar"
4. Sağ tarafta **Site Detayları** kutusu:
   - Site URL: `https://trends.google.com`
   - Icon URL: `https://www.google.com/favicon.ico`
5. Kategori seçin: "Tasarım"
6. **Yayınla** butonu

**Başka örnekler:**
```
- ChatGPT | https://chat.openai.com | Kategori: Yazılımcı Araçları
- Figma | https://figma.com | Kategori: Tasarım
- Canva | https://canva.com | Kategori: Tasarım
- Medium | https://medium.com | Kategori: Habercilik
- Twitter | https://twitter.com | Kategori: Sosyal Ağlar
```

### ADIM 6: İlk Haberi Ekleyin

1. **Haberler > Yeni Ekle** seçin
2. Başlık: "Hoşgeldiniz OneNav'a!"
3. İçerik yazın
4. Öne çıkan resmi yükleyin
5. Kategori: "Genel"
6. **Yayınla**

### ADIM 7: Menü Oluşturun (İsteğe Bağlı)

1. **Görünüm > Menüler** seçin
2. Yeni menü oluşturun: "Ana Menü"
3. Elemanlar ekleyin:
   - Anasayfa (Özel Linkler > Anasayfa)
   - Siteler (Özel Linkler > Siteler Sayfası)
   - Haberler
   - Uygulamalar
   - E-Kitaplar
   - AI Araçları
4. **Menü Ayarlarında:**
   - "Bu menüyü göster" > "Primary Menu" seçin
   - Kaydet

### ADIM 8: Statik Sayfalar Oluşturun

1. **Sayfalar > Yeni Ekle** seçin

Aşağıdaki sayfaları oluşturun:

**Anasayfa:**
- Başlık: "Ana Sayfa"
- **Ayarlar** altında: "Site anasayfa olarak ayarla"

**Siteler Arşivi:**
- Başlık: "Siteler"
- Burada siteler listelenir (otomatik)

**Haberler:**
- Başlık: "Haberler"

**Uygulamalar:**
- Başlık: "Mobil Uygulamalar"

**Hakkımızda:**
- Başlık: "Hakkımızda"
- İçerik yazın

**İletişim:**
- Başlık: "İletişim"
- E-posta adresi ve form bilgileri

**Gizlilik Politikası:**
- Başlık: "Gizlilik Politikası"
- İçerik yazın

### ADIM 9: Statik Sayfa Ayarlarını Yapın

**Ayarlar > Okuma**
1. Anasayfa Göster: "Statik Sayfa" seçin
2. Anasayfa: "Anasayfa" sayfasını seçin
3. Yazı Sayfası: "Haberler" sayfasını seçin
4. Kaydet

### ADIM 10: API Ayarları (İsteğe Bağlı)

**Haberler Otomatik Çekmek İçin:**

1. https://newsapi.org adresine gid
2. Ücretsiz API anahtarı al
3. **Görünüm > Özelleştir > OneNav - API Ayarları**
4. NewsAPI Anahtarı alanına yapıştır
5. QR Kod Boyutu: 200px (varsayılan)
6. Yayınla

### ADIM 11: WordPress Cron Job Ayarlarını Kontrol Edin

**Trending ve Haber Senkronizasyonu İçin:**

`wp-config.php` dosyasında aşağıdaki satırı kontrol edin:

```php
define('DISABLE_WP_CRON', false); // Etkin olduğundan emin olun
```

Eğer `true` ise `false` yapın ve kaydedin.

### ADIM 12: Güvenlik Ayarları

**Ayarlar > Genel**
- WordPress Adresi (URL): `https://` ile başlasın
- Site Adresi (URL): `https://` ile başlasın

**Eklentiler Yükleyin (Önerilen):**
1. Wordfence Security
2. BackUp
3. WP Rocket (Cache)

### ADIM 13: Test Edin

1. **Ana sayfaya gidin:** `https://yoursite.com`
2. Aşağıdakileri test edin:
   - ✅ Trend bar görünüyor mu?
   - ✅ Arama çalışıyor mu?
   - ✅ Kategoriler filtreleniyor mu?
   - ✅ QR butonları çalışıyor mu?
   - ✅ Mobil de uyumlu mu?

## 🔧 Gelişmiş Ayarlar

### WordPress Permalink Ayarları

1. **Ayarlar > Başlıklar (Permalinks)**
2. Özel Yapı seçin: `/%postname%/`
3. Kaydet

### REST API Ayarları

Kontrol etmek için:
```
https://yoursite.com/wp-json/wp/v2/pages
```

Bu sayfayı açabiliyorsanız REST API aktif demektir.

### Tema Güncellemeleri

Manuel olarak dosyaları FTP/File Manager üzerinden güncelleyin.

## ⚠️ Yaygın Sorunlar ve Çözümleri

### Sayfa tamamen boş gözüküyor
- PHP versiyonu 7.4+ mü? Kontrol edin
- Hata logu kontrol edin: `/wp-content/debug.log`

### Arama çalışmıyor
- jQuery yüklenmiş mi? Kontrol edin
- REST API aktif mi? Test edin
- Browser console'da hata var mı? Kontrol edin

### Resimleri gösterilmiyor
- Resim URL'leri doğru mu?
- İmage Proxy aktif mi?

### Trend Bar boş
- Trend kaynağı ayarı kontrol edin
- Custom trends boş mu?

### Haberler senkronize olmuyor
- NewsAPI anahtarı doğru mu?
- Cron jobs çalışıyor mu?
- `wp-config.php`'de `DISABLE_WP_CRON` kontrol edin

## 📞 Destek İletişim

Sorunlar için contact sayfasından bize ulaşabilirsiniz.

---

**Kurulum Tamamlandı! 🎉**

Artık OneNav temanız tamamen hazır. Sitelerinizi, haberlerinizi ve uygulamalarınızı eklemeye başlayabilirsiniz.
