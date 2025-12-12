<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php 
// Kiểm tra xem file sidebar có tồn tại không trước khi require để tránh lỗi
if (file_exists(__DIR__ . '/../../layouts/sidebar.php')) {
    require_once __DIR__ . '/../../layouts/sidebar.php';
}
?>

<div class="main-content" style="padding: 20px;">
    <div class="container" style="max-width: 900px; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: var(--primary-color);">Chỉnh sửa khóa học</h2>
            <a href="index.php?controller=instructor&action=manageCourse" style="text-decoration: none; color: #666;">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <form action="index.php?controller=instructor&action=updateCourse&id=<?php echo $course['id']; ?>" method="POST" enctype="multipart/form-data">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Tên khóa học:</label>
                <input type="text" name="title" 
                       value="<?php echo htmlspecialchars($course['title']); ?>" 
                       required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Danh mục:</label>
                    <select name="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <?php foreach($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                <?php echo ($cat['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Giá (VNĐ):</label>
                    <input type="number" name="price" 
                           value="<?php echo $course['price']; ?>" 
                           required min="0" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>

            <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Trình độ:</label>
                    <select name="level" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>Cơ bản</option>
                        <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>Trung bình</option>
                        <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>Nâng cao</option>
                    </select>
                </div>

                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 20px;">
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Thời lượng (tuần):</label>
                    <input type="number" name="duration_weeks" 
                           value="<?php echo $course['duration_weeks']; ?>" 
                           required min="1" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px; border: 1px dashed #ccc; padding: 15px; border-radius: 4px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Ảnh đại diện:</label>
                
                <?php if(!empty($course['image'])): ?>
                    <div style="margin-bottom: 10px;">
                        <p style="font-size: 13px; color: #666;">Ảnh hiện tại:</p>
                        <img src="assets/uploads/courses/<?php echo $course['image']; ?>" alt="Current Image" style="height: 100px; object-fit: cover; border-radius: 4px;">
                    </div>
                <?php endif; ?>

                <input type="hidden" name="current_image" value="<?php echo $course['image']; ?>">

                <p style="font-size: 13px; margin-bottom: 5px;">Chọn ảnh mới (nếu muốn thay đổi):</p>
                <input type="file" name="image" accept="image/*">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Mô tả chi tiết:</label>
                <textarea name="description" rows="8" required 
                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;"><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div style="text-align: right;">
                <button type="submit" style="background: var(--primary-color); color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;">
                    <i class="fas fa-save"></i> Cập nhật khóa học
                </button>
            </div>

        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>