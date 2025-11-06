<?php
/**
 * Single eBook Template - PDF Reader System
 *
 * @package OneNav
 */

get_header();
?>

<main class="single-ebook-page">
    <?php while (have_posts()) : the_post(); ?>

        <?php
        // Get ebook meta data
        $ebook_file = get_post_meta(get_the_ID(), 'ebook_file', true);
        $ebook_type = get_post_meta(get_the_ID(), 'ebook_type', true);
        $reader_style = get_theme_mod('onenav_ebook_reader_style', 'both');
        $enable_pdfjs = get_theme_mod('onenav_enable_pdfjs', 1);
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('ebook-detail'); ?>>

            <!-- eBook Header -->
            <div class="ebook-header">
                <div class="ebook-header-content">

                    <!-- Book Cover -->
                    <div class="ebook-cover-large">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php else : ?>
                            <div class="ebook-cover-placeholder">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Book Info -->
                    <div class="ebook-info">
                        <h1 class="ebook-title"><?php the_title(); ?></h1>

                        <div class="ebook-author">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                            </svg>
                            <?php the_author(); ?>
                        </div>

                        <div class="ebook-meta">
                            <div class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                                <span><?php echo strtoupper($ebook_type ?: 'PDF'); ?> Format</span>
                            </div>
                            <div class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <span><?php echo onenav_reading_time(); ?></span>
                            </div>
                            <div class="meta-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="ebook-actions">
                            <?php if ($ebook_file && in_array($reader_style, array('inline', 'both'))) : ?>
                                <button class="ebook-btn ebook-btn-primary" id="open-reader">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                    </svg>
                                    Okumaya Başla
                                </button>
                            <?php endif; ?>

                            <?php if ($ebook_file && in_array($reader_style, array('download', 'both'))) : ?>
                                <a href="<?php echo esc_url($ebook_file); ?>" download class="ebook-btn ebook-btn-secondary">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    İndir (<?php echo strtoupper($ebook_type ?: 'PDF'); ?>)
                                </a>
                            <?php endif; ?>

                            <button class="ebook-btn ebook-btn-outline" id="add-to-library">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Kütüphaneme Ekle
                            </button>
                        </div>

                        <!-- Rating -->
                        <div class="ebook-rating">
                            <div class="rating-stars">
                                ★★★★☆ <span class="rating-value">4.5</span>
                            </div>
                            <span class="rating-count">(128 değerlendirme)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Reader Container -->
            <?php if ($ebook_file && $enable_pdfjs && in_array($reader_style, array('inline', 'both'))) : ?>
                <div id="pdf-reader-container" class="pdf-reader-container" style="display: none;">
                    <div class="pdf-reader-toolbar">
                        <button id="close-reader" class="toolbar-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Kapat
                        </button>
                        <div class="pdf-controls">
                            <button id="prev-page" class="toolbar-btn">◄ Önceki</button>
                            <span id="page-info">
                                Sayfa <span id="page-num">1</span> / <span id="page-count">-</span>
                            </span>
                            <button id="next-page" class="toolbar-btn">Sonraki ►</button>
                        </div>
                        <div class="zoom-controls">
                            <button id="zoom-out" class="toolbar-btn">-</button>
                            <span id="zoom-level">100%</span>
                            <button id="zoom-in" class="toolbar-btn">+</button>
                        </div>
                    </div>
                    <div class="pdf-viewer">
                        <canvas id="pdf-canvas"></canvas>
                    </div>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                <script>
                    const pdfUrl = <?php echo json_encode($ebook_file); ?>;
                    let pdfDoc = null;
                    let pageNum = 1;
                    let pageRendering = false;
                    let pageNumPending = null;
                    let scale = 1.5;
                    const canvas = document.getElementById('pdf-canvas');
                    const ctx = canvas.getContext('2d');

                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                    // Load PDF
                    function loadPDF() {
                        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
                            pdfDoc = pdfDoc_;
                            document.getElementById('page-count').textContent = pdfDoc.numPages;
                            renderPage(pageNum);
                        });
                    }

                    // Render page
                    function renderPage(num) {
                        pageRendering = true;
                        pdfDoc.getPage(num).then(function(page) {
                            const viewport = page.getViewport({scale: scale});
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            const renderContext = {
                                canvasContext: ctx,
                                viewport: viewport
                            };

                            const renderTask = page.render(renderContext);
                            renderTask.promise.then(function() {
                                pageRendering = false;
                                if (pageNumPending !== null) {
                                    renderPage(pageNumPending);
                                    pageNumPending = null;
                                }
                            });
                        });
                        document.getElementById('page-num').textContent = num;
                    }

                    // Queue rendering
                    function queueRenderPage(num) {
                        if (pageRendering) {
                            pageNumPending = num;
                        } else {
                            renderPage(num);
                        }
                    }

                    // Previous page
                    document.getElementById('prev-page').addEventListener('click', function() {
                        if (pageNum <= 1) return;
                        pageNum--;
                        queueRenderPage(pageNum);
                    });

                    // Next page
                    document.getElementById('next-page').addEventListener('click', function() {
                        if (pageNum >= pdfDoc.numPages) return;
                        pageNum++;
                        queueRenderPage(pageNum);
                    });

                    // Zoom controls
                    document.getElementById('zoom-in').addEventListener('click', function() {
                        scale += 0.25;
                        document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
                        queueRenderPage(pageNum);
                    });

                    document.getElementById('zoom-out').addEventListener('click', function() {
                        if (scale <= 0.5) return;
                        scale -= 0.25;
                        document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
                        queueRenderPage(pageNum);
                    });

                    // Open/Close reader
                    document.getElementById('open-reader').addEventListener('click', function() {
                        document.getElementById('pdf-reader-container').style.display = 'block';
                        if (!pdfDoc) loadPDF();
                    });

                    document.getElementById('close-reader').addEventListener('click', function() {
                        document.getElementById('pdf-reader-container').style.display = 'none';
                    });
                </script>
            <?php endif; ?>

            <!-- Book Description -->
            <div class="ebook-description">
                <h2>Kitap Hakkında</h2>
                <div class="ebook-reader-content">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Book Details -->
            <div class="ebook-details">
                <h3>Detaylar</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Yayınlanma</span>
                        <span class="detail-value"><?php echo get_the_date('d M Y'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Dil</span>
                        <span class="detail-value">Türkçe</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Format</span>
                        <span class="detail-value"><?php echo strtoupper($ebook_type ?: 'PDF'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">İndirme</span>
                        <span class="detail-value">Ücretsiz</span>
                    </div>
                </div>
            </div>

        </article>

    <?php endwhile; ?>
</main>

<style>
/* eBook Detail Styles */
.single-ebook-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
}

.ebook-detail {
    background: var(--content-bg, #ffffff);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.ebook-header {
    padding: 40px;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.05) 0%, rgba(217, 119, 6, 0.05) 100%);
    border-bottom: 1px solid var(--border-color, #e2e8f0);
}

.ebook-header-content {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.ebook-cover-large {
    flex-shrink: 0;
    width: 200px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.ebook-cover-large img {
    width: 100%;
    height: auto;
    display: block;
}

.ebook-cover-placeholder {
    width: 200px;
    height: 300px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.ebook-info {
    flex: 1;
}

.ebook-title {
    font-size: 2.2rem;
    margin-bottom: 10px;
    color: var(--text-dark, #1e293b);
    line-height: 1.2;
}

.ebook-author {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-light, #64748b);
    font-size: 16px;
    margin-bottom: 20px;
}

.ebook-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: var(--text-light, #64748b);
}

.ebook-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.ebook-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.ebook-btn-primary {
    background: var(--warning, #f59e0b);
    color: white;
}

.ebook-btn-primary:hover {
    background: #d97706;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
}

.ebook-btn-secondary {
    background: var(--success, #10b981);
    color: white;
}

.ebook-btn-secondary:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.ebook-btn-outline {
    background: transparent;
    color: var(--text-dark, #1e293b);
    border: 2px solid var(--border-color, #e2e8f0);
}

.ebook-btn-outline:hover {
    border-color: var(--primary-color, #a855f7);
    color: var(--primary-color, #a855f7);
}

.ebook-rating {
    display: flex;
    align-items: center;
    gap: 15px;
}

.rating-stars {
    color: #fbbf24;
    font-size: 18px;
}

.rating-value {
    color: var(--text-dark, #1e293b);
    font-weight: 600;
    margin-left: 5px;
}

.rating-count {
    color: var(--text-light, #64748b);
    font-size: 14px;
}

/* PDF Reader */
.pdf-reader-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--reading-bg, #fef3e0);
    z-index: 9999;
    overflow: auto;
}

.pdf-reader-toolbar {
    position: sticky;
    top: 0;
    background: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    z-index: 10;
}

.toolbar-btn {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.toolbar-btn:hover {
    background: rgba(255, 255, 255, 0.2);
}

.pdf-controls {
    display: flex;
    align-items: center;
    gap: 15px;
}

.zoom-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pdf-viewer {
    padding: 40px 20px;
    display: flex;
    justify-content: center;
    min-height: calc(100vh - 60px);
}

#pdf-canvas {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

/* Book Description */
.ebook-description {
    padding: 40px;
}

.ebook-description h2 {
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.ebook-details {
    padding: 30px 40px 40px;
    background: var(--light-bg, #f8fafc);
}

.ebook-details h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-label {
    font-size: 12px;
    color: var(--text-light, #64748b);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark, #1e293b);
}

@media (max-width: 768px) {
    .ebook-header-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .ebook-cover-large,
    .ebook-cover-placeholder {
        width: 150px;
    }

    .ebook-cover-placeholder {
        height: 225px;
    }

    .ebook-title {
        font-size: 1.6rem;
    }

    .ebook-actions {
        flex-direction: column;
        width: 100%;
    }

    .ebook-btn {
        justify-content: center;
    }

    .pdf-reader-toolbar {
        flex-wrap: wrap;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>
