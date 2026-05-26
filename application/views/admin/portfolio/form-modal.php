<?php
// Form markup only, no layout wrapper - used in AJAX modals
$portfolio = isset($portfolio) ? $portfolio : [];
$action = isset($action) ? $action : 'create';
$is_ajax = isset($is_ajax) && $is_ajax;
?>

<form id="portfolioForm" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
    <?php if ($action === 'edit' && isset($portfolio['id'])): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($portfolio['id']); ?>">
    <?php endif; ?>

    <!-- Judul -->
    <div class="mb-3">
        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="title" name="title" required
            value="<?php echo isset($portfolio['title']) ? htmlspecialchars($portfolio['title']) : ''; ?>"
            placeholder="Contoh: Kubah Masjid Al-Ikhlas Surabaya">
    </div>

    <!-- Deskripsi -->
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="description" name="description" rows="4"
            placeholder="Deskripsi lokasi dan spesifikasi kubah..."><?php echo isset($portfolio['description']) ? htmlspecialchars($portfolio['description']) : ''; ?></textarea>
        <small class="form-text text-muted">Deskripsi singkat tentang project kubah ini</small>
    </div>

    <!-- Gambar Portfolio -->
    <div class="mb-3">
        <label for="portfolio_image" class="form-label">Gambar Portfolio <?php echo $action === 'create' ? '<span class="text-danger">*</span>' : '(Opsional untuk update)'; ?></label>
        <input type="file" class="form-control" id="portfolio_image" name="portfolio_image"
            accept="image/jpeg,image/png,image/gif,image/webp,image/bmp"
            <?php echo $action === 'create' ? 'required' : ''; ?>>
        <small class="form-text text-muted">Format: JPG, PNG, GIF, WebP, BMP | Max 5MB | Akan otomatis dikonversi ke WebP</small>
    </div>

    <!-- Image Preview Current -->
    <?php if ($action === 'edit' && isset($portfolio['image']) && !empty($portfolio['image'])): ?>
        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label>
            <div>
                <?php
                $clean_path = str_replace('./', '', $portfolio['image']);
                $img_src = 'https://produsenkubahmasjid.id/' . $clean_path;
                ?>
                <img id="currentImage" src="<?php echo htmlspecialchars($img_src); ?>"
                    alt="<?php echo htmlspecialchars($portfolio['title']); ?>"
                    style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div style="display:none; padding: 10px; background: #f0f0f0; border-radius: 4px; margin-top: 10px;">
                    <small>Gambar tidak dapat dimuat. Path: <?php echo htmlspecialchars($portfolio['image']); ?></small>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Image Preview for new upload -->
    <div class="mb-3" id="previewContainer" style="display: none;">
        <label class="form-label">Preview Gambar Baru</label>
        <div>
            <img id="imagePreview" src="" alt="Preview"
                style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
        </div>
    </div>

    <!-- Form Actions -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i>
            <?php echo $action === 'create' ? 'Tambah Portfolio' : 'Update Portfolio'; ?>
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>

<script>
    // Handle file preview
    document.getElementById('portfolio_image').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('previewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle form submission
    document.getElementById('portfolioForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: '/portfolio/save_ajax',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', {
                    xhr: xhr,
                    status: status,
                    error: error
                });
                alert('Gagal menyimpan portfolio!\nError: ' + error);
            }
        });
    });
</script>