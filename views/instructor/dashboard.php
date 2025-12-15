<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php if (file_exists(__DIR__ . '/../layouts/sidebar.php')) require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<style>
    /* CSS Riêng cho Dashboard */
    .dashboard-container {
        padding: 30px;
        background: #f8f9fa;
        min-height: 100vh;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s;
        border: 1px solid #eee;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .icon-purple { background: #efeefe; color: var(--primary-color); }
    .icon-green { background: #e1fcf2; color: #00b894; }
    .icon-blue { background: #e3f2fd; color: #0984e3; }
    .icon-orange { background: #fff3cd; color: #f1c40f; }

    .stat-info h3 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #2d3436;
    }

    .stat-info p {
        margin: 5px 0 0;
        color: #636e72;
        font-size: 14px;
    }

    /* Section Styles */
    .dashboard-section {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #eee;
        margin-bottom: 30px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid #f1f1f1;
        padding-bottom: 15px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3436;
        margin: 0;
    }

    /* Table Styles (Mini version) */
    .mini-table {
        width: 100%;
        border-collapse: collapse;
    }
    .mini-table th, .mini-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #f1f1f1;
    }
    .mini-table th {
        font-size: 13px;
        color: #b2bec3;
        text-transform: uppercase;
    }
    .mini-table tr:last-child td { border-bottom: none; }
    
    .status-active {
        color: #00b894;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-sm-view {
        padding: 5px 15px;
        background: #f1f2f6;
        color: #636e72;
        border-radius: 20px;
        font-size: 12px;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-sm-view:hover {
        background: var(--primary-color);
        color: #fff;
    }
</style>

<div class="main-content">
    <div class="dashboard-container">
        
        <div style="margin-bottom: 25px;">
            <h2 style="color: var(--primary-color); margin-bottom: 5px;">
                Dashboard Tổng quan
            </h2>
            <p style="color: #636e72;">Chào mừng trở lại, <strong><?php echo $_SESSION['fullname'] ?? 'Giảng viên'; ?></strong>!</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo number_format($totalCourses); ?></h3>
                    <p>Khóa học của tôi</p>
                </div>
                <div class="stat-icon icon-purple">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo number_format($totalStudents); ?></h3>
                    <p>Tổng học viên</p>
                </div>
                <div class="stat-icon icon-blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3 style="font-size: 24px;"><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</h3>
                    <p>Tổng doanh thu</p>
                </div>
                <div class="stat-icon icon-green">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3>4.8 <span style="font-size: 14px; color: #fdcb6e;"><i class="fas fa-star"></i></span></h3>
                    <p>Đánh giá trung bình</p>
                </div>
                <div class="stat-icon icon-orange">
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            
            <div class="dashboard-section">
                <div class="section-header">
                    <h3 class="section-title">Khóa học gần đây</h3>
                    <a href="index.php?controller=instructor&action=manageCourse" style="font-size: 13px; color: var(--primary-color); font-weight: 600;">Xem tất cả</a>
                </div>
                
                <?php if(empty($courses)): ?>
                    <p style="text-align: center; color: #999; padding: 20px;">Chưa có dữ liệu.</p>
                <?php else: ?>
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Khóa học</th>
                                <th>Giá</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $limit = 0;
                                foreach($courses as $course): 
                                    if($limit >= 5) break; 
                                    $limit++;
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: #2d3436;"><?php echo htmlspecialchars($course['title']); ?></div>
                                    <div style="font-size: 12px; color: #b2bec3;"><?php echo $course['category_name'] ?? 'Chung'; ?></div>
                                </td>
                                <td><?php echo number_format($course['price']); ?>đ</td>
                                <td><?php echo date('d/m/Y', strtotime($course['created_at'])); ?></td>
                                <td><span class="status-active">Hoạt động</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="dashboard-section">
                <div class="section-header">
                    <h3 class="section-title">Thao tác nhanh</h3>
                </div>
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <a href="index.php?controller=instructor&action=createCourse" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; text-decoration: none; color: #2d3436; transition: 0.2s;">
                        <div style="width: 40px; height: 40px; background: #e3f2fd; color: #0984e3; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600;">Tạo khóa học mới</div>
                            <div style="font-size: 12px; color: #636e72;">Bắt đầu soạn giáo án mới</div>
                        </div>
                    </a>

                    <a href="index.php?controller=instructor&action=manageCourse" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; text-decoration: none; color: #2d3436; transition: 0.2s;">
                        <div style="width: 40px; height: 40px; background: #e1fcf2; color: #00b894; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600;">Quản lý nội dung</div>
                            <div style="font-size: 12px; color: #636e72;">Chỉnh sửa, xóa khóa học</div>
                        </div>
                    </a>
                    
                    <a href="#" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #fdfdfd; border: 1px solid #eee; border-radius: 8px; text-decoration: none; color: #2d3436; transition: 0.2s;">
                        <div style="width: 40px; height: 40px; background: #fff3cd; color: #f1c40f; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-comment-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600;">Hỏi đáp sinh viên</div>
                            <div style="font-size: 12px; color: #636e72;">Xem các câu hỏi mới</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>