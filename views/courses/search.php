<div class="search-section">
    <div class="container">
        <h1>Tìm kiếm khóa học</h1>
        <p>Nhập từ khóa để tìm khóa học bạn quan tâm</p>
        
        <form action="index.php" method="GET" class="search-box">
            <input type="hidden" name="controller" value="course">
            <input type="hidden" name="action" value="search">
            
            <input type="text" name="q" value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>" placeholder="Ví dụ: Lập trình PHP..." required>
            <button type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
        </form>
    </div>
</div>

<div class="container" style="min-height: 400px;">
    <div style="margin-bottom: 20px;">
        <a href="index.php?controller=course&action=index" style="color: #666;">
            <i class="fas fa-arrow-left"></i> Quay lại tất cả khóa học
        </a>
    </div>

    <div style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
        <h2 style="color: var(--primary-color);">
            Kết quả tìm kiếm cho: "<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>"
        </h2>
        <span style="color: #666; font-weight: bold;">
            Tìm thấy <?php echo count($courses); ?> khóa học
        </span>
    </div>

    <?php if (empty($courses)): ?>
        <div style="text-align: center; padding: 50px; background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <i class="fas fa-search-minus" style="font-size: 50px; color: #ccc; margin-bottom: 20px;"></i>
            <h3 style="color: #333;">Không tìm thấy kết quả nào!</h3>
            <p style="color: #666; margin-bottom: 20px;">Rất tiếc, chúng tôi không tìm thấy khóa học nào phù hợp với từ khóa <strong>"<?php echo htmlspecialchars($keyword); ?>"</strong>.</p>
            
            <p>Gợi ý:</p>
            <ul style="list-style: none; color: #666;">
                <li>- Kiểm tra lỗi chính tả của từ khóa.</li>
                <li>- Thử tìm bằng từ khóa khác hoặc chung chung hơn.</li>
                <li>- <a href="index.php?controller=course&action=index" style="color: var(--primary-color); font-weight: bold;">Xem tất cả khóa học</a></li>
            </ul>
        </div>
    <?php else: ?>
        
        <div class="course-grid">
            <?php foreach($courses as $course): ?>
                <div class="course-card">
                    <div style="position: relative;">
                        <img src="<?php echo !empty($course['image']) ? 'assets/uploads/courses/'.$course['image'] : 'https://via.placeholder.com/300x200?text=Course'; ?>" 
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