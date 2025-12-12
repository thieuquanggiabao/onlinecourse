<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php if (file_exists(__DIR__ . '/../../layouts/sidebar.php')) require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="main-content" style="padding: 20px;">
    <div class="container" style="max-width: 900px; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <h2 style="color: var(--primary-color); margin-bottom: 20px;">+ Thêm khóa học mới</h2>
        
        <form action="index.php?controller=instructor&action=storeCourse" method="POST" enctype="multipart/form-data">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold;">Tên khóa học:</label>
                <input type="text" name="title" required placeholder="Nhập tên khóa học..." 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold;">Danh mục:</label>
                    <select name="category_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                        <option value="">-- Chọn danh mục --</option>
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>">
                                    <?php echo htmlspecialchars($cat['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold;">Giá (VNĐ):</label>
                    <input type="number" name="price" value="0" min="0" required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold;">Trình độ:</label>
                    <select name="level" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                        <option value="Beginner">Cơ bản</option>
                        <option value="Intermediate">Trung bình</option>
                        <option value="Advanced">Nâng cao</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold;">Thời lượng (tuần):</label>
                    <input type="number" name="duration_weeks" value="4" min="1" required 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold;">Ảnh đại diện:</label>
                <input type="file" name="image" accept="image/*" 
                       style="display: block; margin-top: 5px;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold;">Mô tả chi tiết:</label>
                <textarea name="description" rows="5" required placeholder="Nhập mô tả về khóa học..."
                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px; font-family: inherit;"></textarea>
            </div>

            <div style="text-align: right;">
                <a href="index.php?controller=instructor&action=manageCourse" style="margin-right: 15px; text-decoration: none; color: #666;">Hủy bỏ</a>
                <button type="submit" style="background: var(--primary-color); color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                    <i class="fas fa-plus-circle"></i> Tạo khóa học
                </button>
            </div>

        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>