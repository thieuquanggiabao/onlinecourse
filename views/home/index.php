<div class="hero-section" style="background: linear-gradient(135deg, var(--primary-color), #a29bfe); padding: 80px 0; color: white; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 20px;">Học kỹ năng mới, mở tương lai mới</h1>
        <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.9;">Hệ thống khóa học trực tuyến hàng đầu với các giảng viên uy tín.</p>
        
        <form action="index.php" method="GET" style="display: inline-block; background: white; padding: 10px; border-radius: 50px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            <input type="hidden" name="controller" value="course">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Bạn muốn học gì?" style="border: none; outline: none; padding: 10px 20px; width: 300px; font-size: 16px;">
            <button type="submit" style="background: #fdcb6e; border: none; padding: 10px 30px; border-radius: 40px; cursor: pointer; font-weight: bold; color: #2d3436;">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </form>
    </div>
</div>

<div class="container" style="margin-top: 60px; margin-bottom: 60px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
        <div>
            <h2 style="color: var(--primary-color); font-size: 28px;">Khóa học nổi bật</h2>
            <p style="color: #666;">Những khóa học được quan tâm nhất tuần qua</p>
        </div>
        <a href="index.php?controller=course&action=index" style="color: var(--primary-color); font-weight: bold;">Xem tất cả <i class="fas fa-arrow-right"></i></a>
    </div>

    <?php if (empty($courses)): ?>
        <div style="text-align: center; padding: 40px; background: #eee; border-radius: 10px;">
            <p>Hiện chưa có khóa học nào nổi bật. Hãy quay lại sau nhé!</p>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
                <p><i>(Admin: Hãy thêm khóa học vào database để kiểm tra)</i></p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="course-grid">
            <?php foreach($courses as $course): ?>
                <div class="course-card">
                    <div style="position: relative;">
                         <img src="<?php echo !empty($course['image']) ? 'assets/uploads/courses/'.$course['image'] : 'https://via.placeholder.com/300x200?text=Course'; ?>" 
                              alt="<?php echo htmlspecialchars($course['title']); ?>" 
                              class="course-img">
                         <span style="position: absolute; top: 10px; right: 10px; background: #fdcb6e; color: #333; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                             <?php echo htmlspecialchars($course['level'] ?? 'New'); ?>
                         </span>
                    </div>
                    
                    <div class="course-content">
                        <div class="course-cat"><?php echo htmlspecialchars($course['category_name'] ?? 'General'); ?></div>
                        <h3 class="course-title">
                            <a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </a>
                        </h3>
                        
                        <div class="course-meta">
                            <span><i class="fas fa-chalkboard-teacher"></i> <?php echo htmlspecialchars($course['instructor_name']); ?></span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                            <span class="price">
                                <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price'], 0, ',', '.') . ' đ'; ?>
                            </span>
                            <a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>" style="color: var(--primary-color); font-size: 14px;">Chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div style="background: #f1f2f6; padding: 60px 0;">
    <div