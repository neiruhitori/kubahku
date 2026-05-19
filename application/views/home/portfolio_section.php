<style>
.portfolio-image-container {
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
}
.portfolio-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
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

// Get published portfolios, ordered by order_number
$result = $db_conn->query(
    "SELECT id, title, description, image, image_alt FROM portfolios WHERE published = 1 ORDER BY order_number ASC"
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
    
    <?php
    // Display portfolio rows (3 per row)
    foreach ($portfolio_chunks as $chunk_index => $chunk):
    ?>
    <section class="elementor-section elementor-top-section elementor-element elementor-element-portfolio-row-<?php echo $chunk_index; ?> elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-id="portfolio-row-<?php echo $chunk_index; ?>" data-element_type="section">
        <div class="elementor-container elementor-column-gap-default">
            <div class="elementor-row">
    <?php
    foreach ($chunk as $portfolio):
        $alt_text = $portfolio['image_alt'] ?: $portfolio['title'];
    ?>
        <div class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-<?php echo 'portfolio' . $portfolio['id']; ?>" data-id="<?php echo 'portfolio' . $portfolio['id']; ?>" data-element_type="column">
            <div class="elementor-column-wrap elementor-element-populated">
                <div class="elementor-widget-wrap">
                    <!-- Image Widget -->
                    <div class="elementor-element elementor-element-<?php echo 'image' . $portfolio['id']; ?> elementor-widget elementor-widget-image" data-id="<?php echo 'image' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="image.default">
                        <div class="elementor-widget-container">
                            <div class="portfolio-image-container">
                                <img loading="lazy" decoding="async" src="<?php echo htmlspecialchars($portfolio['image']); ?>" alt="<?php echo htmlspecialchars($alt_text); ?>" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title Widget -->
                    <div class="elementor-element elementor-element-<?php echo 'title' . $portfolio['id']; ?> elementor-widget elementor-widget-heading" data-id="<?php echo 'title' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="heading.default">
                        <div class="elementor-widget-container">
                            <p class="elementor-heading-title elementor-size-default" style="color: #0066cc; font-weight: 600; margin-top: 15px; margin-bottom: 10px;">
                                <?php echo htmlspecialchars($portfolio['title']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Description Widget -->
                    <div class="elementor-element elementor-element-<?php echo 'desc' . $portfolio['id']; ?> elementor-widget elementor-widget-text-editor" data-id="<?php echo 'desc' . $portfolio['id']; ?>" data-element_type="widget" data-widget_type="text-editor.default">
                        <div class="elementor-widget-container">
                            <div class="elementor-text-editor elementor-clearfix" style="color: #666; font-size: 14px; line-height: 1.6;">
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
endif;
?>
