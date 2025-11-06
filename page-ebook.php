<?php
/**
 * Template Name: E-Kitaplar
 * Template for displaying e-books
 *
 * @package OneNav
 */

get_header();

$buy_text = onenav_get_option('ebook_buy_text', 'Basılı Kitabı Satın Al');
$download_text = onenav_get_option('ebook_download_text', 'E-Kitabı İndir');
$related_title = onenav_get_option('ebook_related_title', 'İlgili Kitaplar');
$excerpt_length = onenav_get_option('ebook_excerpt_length', '150');
?>

<div class="container" style="margin-top: 40px;">
    <!-- Page Header -->
    <div style="text-align: center; margin-bottom: 50px;">
        <h1 style="font-size: 3rem; margin-bottom: 15px;"><i class="fas fa-book"></i> <?php the_title(); ?></h1>
        <p style="font-size: 1.2rem; color: #64748b; max-width: 800px; margin: 0 auto;">
            <?php echo get_the_content(); ?>
        </p>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs" style="margin-bottom: 40px;">
        <button class="filter-tab active" data-filter="all">Tümü</button>
        <button class="filter-tab" data-filter="pdf">PDF</button>
        <button class="filter-tab" data-filter="epub">EPUB</button>
        <button class="filter-tab" data-filter="mobi">MOBI</button>
        <button class="filter-tab" data-filter="azw3">AZW3</button>
    </div>

    <!-- E-Books Grid -->
    <div class="ebooks-container">
        <div class="apps-grid" id="ebooks-grid">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $ebooks_query = new WP_Query(array(
                'post_type' => 'ebook',
                'posts_per_page' => 24,
                'paged' => $paged,
            ));

            if ($ebooks_query->have_posts()) {
                while ($ebooks_query->have_posts()) {
                    $ebooks_query->the_post();
                    $file_url = get_post_meta(get_the_ID(), 'ebook_file', true);
                    $file_type = get_post_meta(get_the_ID(), 'ebook_type', true);
                    $buy_link = get_post_meta(get_the_ID(), 'ebook_buy_link', true);
                    $author = get_post_meta(get_the_ID(), 'ebook_author', true);
                    $pages = get_post_meta(get_the_ID(), 'ebook_pages', true);
                    ?>
                    <div class="ebook-card" data-type="<?php echo esc_attr(strtolower($file_type)); ?>" data-post-id="<?php the_ID(); ?>" style="cursor: pointer;" onclick="window.location.href='<?php the_permalink(); ?>'">
                        <!-- Book Cover -->
                        <div class="ebook-cover" style="position: relative;">
                            <?php if (has_post_thumbnail()) { ?>
                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                            <?php } else { ?>
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; font-size: 3rem;">
                                    <i class="fas fa-book"></i>
                                </div>
                            <?php } ?>
                            <?php if ($file_type) { ?>
                                <span style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 5px; font-size: 11px; font-weight: bold;">
                                    <?php echo strtoupper($file_type); ?>
                                </span>
                            <?php } ?>
                        </div>

                        <!-- Book Info -->
                        <div style="padding: 15px;">
                            <h3 class="ebook-title" style="font-size: 15px; margin-bottom: 8px; line-height: 1.4; min-height: 42px;">
                                <?php the_title(); ?>
                            </h3>

                            <?php if ($author) { ?>
                                <p class="ebook-author" style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
                                    <i class="fas fa-user"></i> <?php echo esc_html($author); ?>
                                </p>
                            <?php } ?>

                            <?php if ($pages) { ?>
                                <p style="font-size: 12px; color: #999; margin-bottom: 10px;">
                                    <i class="fas fa-file-alt"></i> <?php echo esc_html($pages); ?> sayfa
                                </p>
                            <?php } ?>

                            <!-- Action Buttons -->
                            <div class="ebook-actions" style="display: flex; gap: 8px; margin-top: 15px;">
                                <?php if ($file_url) { ?>
                                    <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="ebook-btn" onclick="event.stopPropagation();" style="flex: 1; text-align: center; padding: 10px; background: var(--primary-color); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                        <i class="fas fa-download"></i> <?php echo esc_html($download_text); ?>
                                    </a>
                                <?php } ?>
                                <?php if ($buy_link) { ?>
                                    <a href="<?php echo esc_url($buy_link); ?>" target="_blank" class="ebook-btn" onclick="event.stopPropagation();" style="flex: 1; text-align: center; padding: 10px; background: var(--success); color: white; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                        <i class="fas fa-shopping-cart"></i> Satın Al
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            } else {
                echo '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px;"><p style="font-size: 1.2rem; color: #64748b;"><i class="fas fa-info-circle"></i> Henüz e-kitap eklenmemiş.</p></div>';
            }
            ?>
        </div>

        <!-- Pagination -->
        <?php if ($ebooks_query->max_num_pages > 1) { ?>
            <div class="pagination" style="margin-top: 50px; text-align: center;">
                <?php
                echo paginate_links(array(
                    'total' => $ebooks_query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => '<i class="fas fa-arrow-left"></i> Önceki',
                    'next_text' => 'Sonraki <i class="fas fa-arrow-right"></i>',
                ));
                ?>
            </div>
        <?php } ?>
    </div>

    <!-- Featured E-Books Section -->
    <div class="section" style="margin-top: 80px;">
        <div class="section-title">
            <h2><i class="fas fa-star"></i> Öne Çıkan E-Kitaplar</h2>
        </div>
        <div class="apps-grid">
            <?php
            $featured_query = new WP_Query(array(
                'post_type' => 'ebook',
                'posts_per_page' => 6,
                'meta_key' => 'featured',
                'meta_value' => '1',
            ));

            if ($featured_query->have_posts()) {
                while ($featured_query->have_posts()) {
                    $featured_query->the_post();
                    $file_url = get_post_meta(get_the_ID(), 'ebook_file', true);
                    $file_type = get_post_meta(get_the_ID(), 'ebook_type', true);
                    $author = get_post_meta(get_the_ID(), 'ebook_author', true);
                    ?>
                    <div class="ebook-card" data-post-id="<?php the_ID(); ?>">
                        <div class="ebook-cover">
                            <?php if (has_post_thumbnail()) { ?>
                                <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                            <?php } else { ?>
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white; font-size: 3rem;">
                                    <i class="fas fa-book"></i>
                                </div>
                            <?php } ?>
                        </div>
                        <h3 class="ebook-title"><?php the_title(); ?></h3>
                        <?php if ($author) { ?>
                            <p class="ebook-author"><i class="fas fa-user"></i> <?php echo esc_html($author); ?></p>
                        <?php } ?>
                        <div class="ebook-actions">
                            <?php if ($file_url) { ?>
                                <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="ebook-btn"><i class="fas fa-download"></i> İndir</a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const ebookCards = document.querySelectorAll('.ebook-card');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            ebookCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-type') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
