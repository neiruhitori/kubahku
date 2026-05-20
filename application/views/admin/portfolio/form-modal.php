<form id="portfolio-form" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" id="form-action" value="<?php echo $action; ?>">
    <?php if ($action === 'edit' && !empty($portfolio['id'])): ?>
        <input type="hidden" name="id" value="<?php echo $portfolio['id']; ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Judul Portfolio *</label>
        <input type="text" class="form-control" name="title" required value="<?php echo htmlspecialchars($portfolio['title'] ?? ''); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($portfolio['description'] ?? ''); ?></textarea>
        <small class="form-text text-muted">Deskripsi lokasi dan spesifikasi kubah</small>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Gambar <?php echo $action === 'create' ? '*' : ''; ?></label>
        <input type="file" class="form-control" name="portfolio_image" id="portfolio_image" accept="image/*" <?php echo $action === 'create' ? 'required' : ''; ?>>
        <small class="form-text text-muted">Gambar akan otomatis dikonversi ke format WebP. Ukuran maksimal: 5MB</small>
        
        <?php if (!empty($portfolio['image']) && $action === 'edit'): ?>
            <div style="margin-top: 10px;">
                <p style="font-weight: 600; margin-bottom: 5px;">Gambar Saat Ini:</p>
                <img src="<?php echo htmlspecialchars(str_replace('./images/', '/images/', $portfolio['image'])); ?>" style="max-width: 100px; max-height: 100px; border-radius: 5px;" onerror="this.src='/images/placeholder.png'">
            </div>
        <?php endif; ?>
        
        <img id="preview-image" style="max-width: 100px; max-height: 100px; margin-top: 10px; border-radius: 5px; display: none;" alt="Preview">
    </div>

    <div style="display: flex; gap: 10px; margin-top: 30px;">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> <?php echo $action === 'create' ? 'Tambah' : 'Update'; ?>
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Batal
        </button>
    </div>
</form>

<script>
    // Preview gambar saat file dipilih
    document.getElementById('portfolio_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('preview-image');
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle form submission via AJAX
    document.getElementById('portfolio-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/SIKUBAH/portfolio/save_ajax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message and close modal
                const modalEl = document.getElementById('portfolioModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                
                // Show toast/alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.querySelector('.content-card').insertBefore(alertDiv, document.querySelector('.content-card').firstChild);
                
                // Close modal and reload table
                modal.hide();
                
                // Reload page after 1 second
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal mengirim form!');
        });
    });
</script>
