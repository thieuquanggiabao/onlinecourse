<div class="search-section">
    <div class="container">
        <h1>Khám phá tri thức mới</h1>
        <p>Hàng trăm khóa học từ cơ bản đến nâng cao đang chờ bạn</p>
        
        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="controller" value="course">
            <input type="hidden" name="action" value="search">
            
            <input type="text" name="q" placeholder="Bạn muốn học gì hôm nay?" required>
            <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
        </form>
    </div>
</div>

<div class="container">
    <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
        <h2 style="color: var(--primary-color);">Danh sách khóa học</h2>
    </div>

    <?php if (empty($courses)): ?>
        <div style="text-align: center; padding: 50px; color: #666;">
            <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 10px;"></i>
            <p>Hiện chưa có khóa học nào trong hệ thống.</p>
        </div>
    <?php else: ?>
        <div class="course-grid">
            <?php foreach($courses as $course): ?>
                <div class="course-card">
                    <div style="position: relative;">
                        <img src="<?php echo !empty($course['image']) ? 'assets/uploads/courses/'.$course['image'] : 'https://via.placeholder.com/300x200?text=Course+Image'; ?>" 
                             alt="<?php echo htmlspecialchars($course['title']); ?>" 
                             class="course-img">
                    </div>
                    
                    <div class="course-content">
                        <div class="course-cat"><?php echo htmlspecialchars($course['category_name'] ?? 'Chung'); ?></div>
                        
                        <h3 class="course-title">
                            <a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>
                        
                        <div class="course-meta">
                            <span><i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($course['instructor_name']); ?></span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                            <span class="price">
                                <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price'], 0, ',', '.') . ' đ'; ?>
                            </span>
                            <a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>" class="btn-detail" style="border:none; background:none; color:var(--primary-color); padding:0;">
                                Xem ngay <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>