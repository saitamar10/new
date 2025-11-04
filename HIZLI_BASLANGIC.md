# 🚀 OneNav Teması - Hızlı Başlangıç (Quick Start)

## ⚡ 5 Dakikalık Kurulum

### 1️⃣ Dosyaları Yükleyin (2 min)
```
FTP/File Manager üzerinden:
/wp-content/themes/onenav/ klasörüne tüm dosyaları yükleyin
```

### 2️⃣ Temayı Aktif Edin (1 min)
```
WordPress Admin > Görünüm > Temalar > OneNav > Aktif Et
```

### 3️⃣ Kategoriler Oluşturun (1 min)
```
Admin > Siteler > Kategoriler
Ekleyin: Sosyal Ağlar, Habercilik, E-Ticaret, Tasarım, Yazılımcı Araçları
```

### 4️⃣ İlk Site Ekleyin (1 min)
```
Admin > Siteler > Yeni Ekle
- Başlık: "Google"
- Site URL: https://google.com
- Icon URL: https://www.google.com/favicon.ico
- Kategori: Seçin
- Yayınla
```

## ✅ Tamamlandı!

Site artık çalışıyor. Daha fazla site, haber ve uygulama ekleyebilirsiniz.

---

## 📱 Ana Bölümler

| Bölüm | Nereye | Ne İçin |
|-------|--------|---------|
| **Siteler** | Siteler > Yeni Ekle | Web siteleri linki ekle |
| **Haberler** | Haberler > Yeni Ekle | Blog yazıları |
| **Uygulamalar** | Mobil Uygulamalar > Yeni Ekle | iOS/Android app linki |
| **E-Kitaplar** | E-Kitaplar > Yeni Ekle | PDF/EPUB dosyaları |
| **Galeriler** | Galeriler > Yeni Ekle | Fotoğraf koleksiyonları |
| **AI Araçları** | AI Araçları > Yeni Ekle | ChatGPT, Claude, vb |

---

## 🎨 Temanızı Özelleştirin

**Görünüm > Özelleştir**

```
Renk Değiştir:
- Ana Renk: #a855f7 (Purple)
- İkincil Renk: #ec4899 (Pink)

Trend Bar:
- Açık/Kapalı
- Kaynak: Google/Yandex/Özel

Footer:
- Arkaplan rengi
- Metin ekle
```

---

## 🔌 Önemli API'ler

| API | Amaç | Ücretsiz |
|-----|------|---------|
| **QRServer** | QR kod | ✅ Evet (Sınırsız) |
| **NewsAPI** | Haberler | ✅ Evet (100/gün) |
| **Google Trends** | Trendler | ⚠️ Resmi API yok |

---

## 📊 REST API

Siteyi harici uygulamalardan kullanmak için:

```javascript
// Arama
GET /wp-json/onenav/v1/search?q=wordpress

// Kategoriye göre siteler
GET /wp-json/onenav/v1/sites/category/sosyal-aglar

// Popüler siteler
GET /wp-json/onenav/v1/sites/popular

// QR kod
GET /wp-json/onenav/v1/qrcode?text=https://example.com

// Trendler
GET /wp-json/onenav/v1/trending

// Haberler
GET /wp-json/onenav/v1/news
```

---

## 🆘 Yaygın Sorular

**S: Arama çalışmıyor?**
- A: jQuery yüklü mü? REST API aktif mi?

**S: Haberler otomatik gelmiyor?**
- A: NewsAPI anahtarını Customizer'a eklemeyi unuttunuz

**S: Trend Bar boş?**
- A: Özel trend girişi yapın veya Google Trends seçin

**S: QR kod görünmüyor?**
- A: QRServer API erişilebilir mi kontrol edin

---

## 📞 Destek Dosyaları

- **README.md** - Tam dokümantasyon
- **KURULUM.md** - Adım adım rehber
- **TEMA_YAPISI.txt** - Teknik detaylar

---

## 🎯 Sonraki Adımlar

1. ✅ Kategoriler oluştur
2. ✅ 5-10 site ekle
3. ✅ Haberler ekle
4. ✅ Uygulamalar ekle
5. ✅ E-Kitaplar ekle
6. ✅ Renk özelleştir
7. ✅ API anahtarları ekle
8. ✅ Sosyal medya linki ekle

---

**Hepsi bu kadar! 🎉 Başlamış olduğunuz için teşekkürler!**
