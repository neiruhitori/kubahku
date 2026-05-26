<?php
// Form markup only, no layout wrapper - used in AJAX modals
$article = isset($data['article']) ? $data['article'] : [];
$action = isset($data['action']) ? $data['action'] : 'create';
$is_ajax = isset($data['is_ajax']) && $data['is_ajax'];
?>

<form id="articleForm" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($action); ?>">
    <?php if ($action === 'edit' && isset($article['id'])): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">
    <?php endif; ?>

    <!-- Judul -->
    <div class="mb-3">
        <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="title" name="title" required 
               value="<?php echo isset($article['title']) ? htmlspecialchars($article['title']) : ''; ?>"
               placeholder="Masukkan judul artikel">
    </div>

    <!-- Slug -->
    <div class="mb-3">
        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="slug" name="slug" required 
               value="<?php echo isset($article['slug']) ? htmlspecialchars($article['slug']) : ''; ?>"
               placeholder="slug-artikel-otomatis">
        <small class="form-text text-muted">URL-friendly version dari judul (otomatis di-generate)</small>
    </div>

    <!-- Thumbnail -->
    <div class="mb-3">
        <label for="featured_image" class="form-label">Thumbnail <?php echo $action === 'create' ? '<span class="text-danger">*</span>' : '(Opsional untuk update)'; ?></label>
        <input type="file" class="form-control" id="featured_image" name="featured_image" 
               accept="image/jpeg,image/png,image/gif,image/webp,image/bmp"
               <?php echo $action === 'create' ? 'required' : ''; ?>>
        <small class="form-text text-muted">Format: JPG, PNG, GIF, WebP, BMP | Max 5MB</small>
    </div>

    <!-- Image Preview -->
    <?php if ($action === 'edit' && isset($article['featured_image']) && !empty($article['featured_image'])): ?>
    <div class="mb-3">
        <label class="form-label">Thumbnail Saat Ini</label>
        <div>
            <?php 
                // Clean path - remove ./ prefix if exists
                $clean_path = str_replace('./', '', $article['featured_image']);
                $img_src = 'https://produsenkubahmasjid.id/' . $clean_path;
            ?>
            <img id="currentImage" src="<?php echo htmlspecialchars($img_src); ?>" 
                 alt="<?php echo htmlspecialchars($article['title']); ?>"
                 style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                 onerror="console.error('Image load error:', this.src); this.style.display='none'; this.nextElementSibling.style.display='block';">
            <div style="display:none; padding: 10px; background: #f0f0f0; border-radius: 4px; margin-top: 10px;">
                <small>Gambar tidak dapat dimuat. Path: <?php echo htmlspecialchars($article['featured_image']); ?></small>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Image Preview for new upload -->
    <div class="mb-3" id="previewContainer" style="display: none;">
        <label class="form-label">Preview Thumbnail Baru</label>
        <div>
            <img id="imagePreview" src="" alt="Preview" 
                 style="max-width: 200px; max-height: 200px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
        </div>
    </div>

    <!-- Isi Artikel (CKEditor) -->
    <div class="mb-3">
        <label for="content" class="form-label">Isi Artikel <span class="text-danger">*</span></label>
        <textarea class="form-control" id="content" name="content" rows="10" required><?php echo isset($article['content']) ? $article['content'] : ''; ?></textarea>
        <small class="form-text text-muted">Gunakan editor untuk memformat artikel Anda</small>
    </div>

    <!-- Status -->
    <div class="mb-3">
        <label for="published" class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" id="published" name="published" required>
            <option value="1" <?php echo (isset($article['published']) && $article['published'] == 1) ? 'selected' : ''; ?>>Publish</option>
            <option value="0" <?php echo (isset($article['published']) && $article['published'] == 0) ? 'selected' : ''; ?>>Draft</option>
        </select>
        <small class="form-text text-muted">Pilih "Publish" untuk menampilkan artikel di blog</small>
    </div>

    <!-- Form Actions -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> 
            <?php echo $action === 'create' ? 'Tambah Artikel' : 'Update Artikel'; ?>
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>

<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-')      // Replace spaces with -
            .replace(/-+/g, '-')       // Replace multiple - with single -
            .replace(/^-+|-+$/g, '');  // Remove leading/trailing -
        document.getElementById('slug').value = slug;
    });

    // Handle file preview
    document.getElementById('featured_image').addEventListener('change', function() {
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
    document.getElementById('articleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Get CKEditor data
        const editorData = CKEDITOR.instances.content.getData();
        
        // Validate content
        if (!editorData.trim()) {
            alert('Isi artikel tidak boleh kosong!');
            return;
        }

        const formData = new FormData(this);
        // Update content with CKEditor data
        formData.set('content', editorData);

        $.ajax({
            url: '/articles/save_ajax',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    bootstrap.Modal.getInstance(document.getElementById('articleModal')).hide();
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Gagal menyimpan artikel'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error: Gagal menghubungi server');
            }
        });
    });
</script>
