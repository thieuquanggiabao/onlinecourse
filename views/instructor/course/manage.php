<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php if (file_exists(__DIR__ . '/../../layouts/sidebar.php')) require_once __DIR__ . '/../../layouts/sidebar.php'; ?>

<style>
    .manage-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #eee;
    }

    .manage-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid #f1f1f1;
        background: #fff;
    }

    .btn-add-new {
        background: linear-gradient(135deg, var(--primary-color), #a29bfe);
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(108, 92, 231, 0.3);
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(108, 92, 231, 0.4);
        color: white;
    }

    /* Table Styles */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead {
        background: #f8f9fa;
        color: #636e72;
    }

    .custom-table th {
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f1;
        color: #2d3436;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tr:hover {
        background-color: #fcfcfc;
    }

    /* Thumbnail Image */
    .course-thumb-box {
        width: 80px;
        height: 50px;
        border-radius: 6px;
        overflow: hidden;
        background: #eee;
        border: 1px solid #eee;
    }

    .course-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Badge Styles */
    .badge-price {
        background: #e1fcf2;
        color: #00b894;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 13px;
        font-weight: bold;
    }

    .badge-cat {
        background: #dfe6e9;
        color: #636e72;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
        transition: 0.2s;
        border: 1px solid transparent;
    }

    .btn-lessons { background: #e3f2fd; color: #0984e3; }
    .btn-lessons:hover { background: #0984e3; color: white; }

    .btn-edit { background: #fff3cd; color: #f1c40f; }
    .btn-edit:hover { background: #f1c40f; color: white; }

    .btn-delete { background: #ffebee; color: #d63031; }
    .btn-delete:hover { background: #d63031; color: white; }

</style>

<div class="main-content" style="padding: 40px 20px; background: #f9f9f9; min-height: 100vh;">
    <div class="container" style="max-width: 1100px; margin: 0 auto;">
        
        <div style="margin-bottom: 30px;">
            <h2 style="color: #2d3436; margin-bottom: 5px;">Xin chào, Giảng viên!</h2>
            <p style="color: #636e72;">Quản lý các khóa học và nội dung giảng dạy của bạn tại đây.</p>
        </div>

        <div class="manage-card">
            <div class="manage-header">
                <div>
                    <h3 style="margin: 0; color: var(--primary-color);">Danh sách khóa học</h3>
                    <span style="font-size: 13px; color: #888;">Tổng số: <?php echo count($courses); ?> khóa học</span>
                </div>
                <a href="index.php?controller=instructor&action=createCourse" class="btn-add-new">
                    <i class="fas fa-plus-circle"></i> Tạo khóa học mới
                </a>
            </div>

            <div class="table-responsive">
                <?php if (empty($courses)): ?>
                    <div style="text-align: center; padding: 60px 20px;">
                        <i class="fas fa-folder-open" style="font-size: 60px; color: #dfe6e9; margin-bottom: 20px;"></i>
                        <h4 style="color: #636e72;">Bạn chưa tạo khóa học nào</h4>
                        <p style="color: #b2bec3; margin-bottom: 25px;">Hãy bắt đầu chia sẻ kiến thức của bạn ngay hôm nay.</p>
                        <a href="index.php?controller=instructor&action=createCourse" class="btn-add-new">
                            + Tạo ngay
                        </a>
                    </div>
                <?php else: ?>
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#ID</th>
                                <th style="width: 100px;">Ảnh</th>
                                <th>Thông tin khóa học</th>
                                <th>Giá bán</th>
                                
                                <th style="text-align: right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><span style="font-weight: bold; color: #aaa;">#<?php echo $course['id']; ?></span></td>
                                
                                <td>
                                    <div class="course-thumb-box">
                                        <img src="<?php echo !empty($course['image']) ? 'assets/uploads/courses/'.$course['image'] : 'https://via.placeholder.com/150x100?text=No+Img'; ?>" 
                                             class="course-thumb-img" alt="Thumbnail">
                                    </div>
                                </td>

                                <td>
                                    <div style="font-weight: 700; font-size: 16px; margin-bottom: 5px; color: #2d3436;">
                                        <?php echo htmlspecialchars($course['title']); ?>
                                    </div>
                                    <span class="badge-cat"><?php echo htmlspecialchars($course['category_name']); ?></span>
                                    <span style="font-size: 12px; color: #888; margin-left: 10px;">
                                        <i class="far fa-clock"></i> <?php echo $course['duration_weeks']; ?> tuần
                                    </span>
                                </td>

                                <td>
                                    <?php if($course['price'] == 0): ?>
                                        <span class="badge-price" style="background: #dfe6e9; color: #636e72;">Miễn phí</span>
                                    <?php else: ?>
                                        <span class="badge-price">
                                            <?php echo number_format($course['price'], 0, ',', '.'); ?> đ
                                        </span>
                                    <?php endif; ?>
                                </td>

                                

                                <td style="text-align: right;">
                                    <div class="action-group" style="justify-content: flex-end;">
                                        

                                        <a href="index.php?controller=instructor&action=editCourse&id=<?php echo $course['id']; ?>" 
                                           class="btn-icon btn-edit" title="Chỉnh sửa thông tin">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <a href="index.php?controller=instructor&action=deleteCourse&id=<?php echo $course['id']; ?>" 
                                           class="btn-icon btn-delete" 
                                           title="Xóa khóa học"
                                           onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn xóa khóa học này?\nTất cả bài học trong khóa này cũng sẽ bị xóa!');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>