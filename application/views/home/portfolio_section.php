<style>
    .portfolio-section-wrapper {
        overflow-y: auto;
        max-height: 510px;
        padding-right: 8px;
        width: 100%;
        max-width: 1140px;
        margin: 0 auto;
    }

    .portfolio-section-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .portfolio-section-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .portfolio-section-wrapper::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .portfolio-section-wrapper::-webkit-scrollbar-thumb:hover {
        background: #5568d3;
    }

    .portfolio-image-container {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        border-radius: 6px;
    }

    .portfolio-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Portfolio item box styling */
    .portfolio-item-box {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px;
        background-color: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .portfolio-item-box:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }
</style>

<?php
// application/views/home/portfolio_section.php
// Fetch portfolios from database and render them

// Simple database connection
$db_conn = new mysqli('localhost', 'root', '', 'db_sikubah');
if ($db_conn->connect_error) {
    echo '<p>Error: Gagal terhubung ke database</p>';
    exit;
}
$db_conn->set_charset('utf8mb4');

// Get all portfolios, ordered by newest first
$result = $db_conn->query(
    "SELECT id, title, description, image FROM portfolios ORDER BY created_at DESC"
);

$portfolios = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $portfolios[] = $row;
    }
}

if (empty($portfolios)):
    // If no portfolios, show a message
    echo '<p>Tidak ada portfolio yang tersedia saat ini.</p>';
else:
    // Split portfolios into chunks of 3 for multiple rows
    $portfolio_chunks = array_chunk($portfolios, 3);

    // Display heading section
?>
    <section class="elementor-section elementor-top-section elementor-element elementor-element-portfolio-heading elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="portfolio-heading" data-element_type="section">
        <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-row">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-portfolio-title-col" data-id="portfolio-title-col" data-element_type="column">
                    <div class="elementor-column-wrap elementor-element-populated">
                        <div class="elementor-widget-wrap">
                            <!-- Main Title -->
                            <div class="elementor-element elementor-element-portfolio-main-title elementor-widget elementor-widget-heading" data-id="portfolio-main-title" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h2 class="elementor-heading-title elementor-size-xl" style="text-align: center; font-weight: bold; font-size: 36px; margin-bottom: 15px; color: #333;">PORTOFOLIO KAMI</h2>
                                </div>
                            </div>

                            <!-- Subtitle -->
                            <div class="elementor-element elementor-element-portfolio-subtitle elementor-widget elementor-widget-text-editor" data-id="portfolio-subtitle" data-element_type="widget" data-widget_type="text-editor.default">
                                <div class="elementor-widget-container">
                                    <div class="elementor-text-editor elementor-clearfix" style="text-align: center; color: #999; font-size: 16px; margin-bottom: 30px;">
                                        <p>Lihat Portofolio Penjualan Kubah Masjid Kami di Seluruh Indonesia Sehingga Anda Tidak Ragu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scrollable Portfolio Items Wrapper -->
    <div class="portfolio-section-wrapper">
        <?php
        // Display portfolio rows (3 per row)
        foreach ($portfolio_chunks as $chunk_index => $chunk):
        ?>
            <section class="elementor-section elementor-top-section elementor-element elementor-element-portfolio-row-<?php echo $chunk_index; ?> elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="portfolio-row-<?php echo $chunk_index; ?>" data-element_type="section">
                <div class="elementor-container elementor-column-gap-default">
                    <div class="elementor-row">
                        <?php
                        foreach ($chunk as $portfolio):
                            $alt_text = $portfolio['title'];
                            $clean_path = str_replace('./', '', $portfolio['image']);
                            $image_path = 'https://produsenkubahmasjid.id/' . $clean_path;
                        ?>
                            <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-<?php echo 'portfolio' . $portfolio['id']; ?>" data-id="<?php echo 'portfolio' . $portfolio['id']; ?>" data-element_type="column">
                                <div class="elementor-column-wrap elementor-element-populated">
                                    <div class="elementor-widget-wrap portfolio-item-box">
                                        <!-- Image Widget -->
                                        <div class="elementor-element elementor-element-<?php echo 'image' . $portfolio['id']; ?> elementor-widget elementor-widget-image" data-id="<?php echo 'image' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="image.default">
                                            <div class="elementor-widget-container">
                                                <div class="portfolio-image-container">
                                                    <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($alt_text); ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Title Widget -->
                                        <div class="elementor-element elementor-element-<?php echo 'title' . $portfolio['id']; ?> elementor-widget elementor-widget-heading" data-id="<?php echo 'title' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="heading.default">
                                            <div class="elementor-widget-container">
                                                <p class="elementor-heading-title elementor-size-default" style="color: #0066cc; font-weight: 700; margin-top: 8px; margin-bottom: 4px; font-size: 16px;">
                                                    <?php echo htmlspecialchars($portfolio['title']); ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Description Widget -->
                                        <div class="elementor-element elementor-element-<?php echo 'desc' . $portfolio['id']; ?> elementor-widget elementor-widget-text-editor" data-id="<?php echo 'desc' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="text-editor.default">
                                            <div class="elementor-widget-container">
                                                <div class="elementor-text-editor elementor-clearfix" style="color: #666; font-size: 12px; line-height: 1.4;">
                                                    <p><?php echo nl2br(htmlspecialchars($portfolio['description'])); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </section>
        <?php
        endforeach;
        ?>
    </div><!-- Close portfolio-section-wrapper -->
<?php
endif;
?>