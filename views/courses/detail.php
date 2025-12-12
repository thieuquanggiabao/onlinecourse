<div class="course-header" style="background: linear-gradient(135deg, var(--primary-color), #6c5ce7); padding: 60px 0; color: white;">
    <div class="container">
        <?php if (isset($course) && is_array($course)): ?>
            <span class="badge-cat" style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 20px; font-size: 14px; text-transform: uppercase;">
                <?php echo htmlspecialchars($course['category_name'] ?? 'Tổng hợp'); ?>
            </span>
            
            <h1 style="font-size: 36px; margin: 20px 0; font-weight: 700;">
                <?php echo htmlspecialchars($course['title']); ?>
            </h1>
            
            <div style="font-size: 16px; opacity: 0.9; display: flex; gap: 20px;">
                <span><i class="fas fa-user-tie"></i> Giảng viên: <strong><?php echo htmlspecialchars($course['instructor_name'] ?? 'Admin'); ?></strong></span>
                <span><i class="fas fa-calendar-alt"></i> Cập nhật: <?php echo date('d/m/Y', strtotime($course['updated_at'] ?? $course['created_at'])); ?></span>
            </div>
        <?php else: ?>
            <h1>Không tìm thấy thông tin khóa học</h1>
        <?php endif; ?>
    </div>
</div>

<div class="container" style="margin-top: 40px; margin-bottom: 60px;">
    <?php if (isset($course) && is_array($course)): ?>
    <div class="course-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        
        <div class="course-main">
            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
                <h3 style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; color: var(--primary-color);">Giới thiệu khóa học</h3>
                <div style="line-height: 1.8; color: #444;">
                    <?php echo nl2br(htmlspecialchars($course['description'])); ?>
                </div>
            </div>

            <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <h3 style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 20px; color: var(--primary-color);">
                    Nội dung bài học (<?php echo isset($lessons) ? count($lessons) : 0; ?> bài)
                </h3>
                
                <?php if (empty($lessons)): ?>
                    <p style="color: #666; font-style: italic;">Nội dung đang được cập nhật...</p>
                <?php else: ?>
                    <div class="lesson-list" style="display: flex; flex-direction: column; gap: 15px;">
                        <?php foreach($lessons as $lesson): ?>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 1px solid #eee;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <?php if(isset($is_enrolled) && $is_enrolled): ?>
                                        <i class="fas fa-play-circle" style="color: var(--primary-color); font-size: 20px;"></i>
                                    <?php else: ?>
                                        <i class="fas fa-lock" style="color: #999; font-size: 20px;"></i>
                                    <?php endif; ?>
                                    
                                    <span style="font-weight: 500; color: #333;">
                                        Bài <?php echo $lesson['order']; ?>: <?php echo htmlspecialchars($lesson['title']); ?>
                                    </span>
                                </div>
                                
                                <?php if(isset($is_enrolled) && $is_enrolled): ?>
                                    <a href="index.php?controller=lesson&action=show&id=<?php echo $lesson['id']; ?>" 
                                       style="font-size: 12px; padding: 5px 15px; border: 1px solid var(--primary-color); color: var(--primary-color); border-radius: 20px; text-decoration: none;">
                                       Học ngay
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="course-sidebar">
            <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                <img src="<?php echo !empty($course['image']) ? 'assets/uploads/courses/'.$course['image'] : 'https://via.placeholder.com/600x400?text=Course'; ?>" 
                     style="width: 100%; height: 200px; object-fit: cover;" alt="Thumbnail">
                
                <div style="padding: 25px;">
                    <div style="font-size: 32px; font-weight: bold; color: var(--primary-color); margin-bottom: 20px; text-align: center;">
                        <?php echo ($course['price'] == 0) ? 'Miễn phí' : number_format($course['price'], 0, ',', '.') . ' đ'; ?>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <?php if (isset($is_enrolled) && $is_enrolled): ?>
                            <a href="#" class="btn-full" style="display: block; width: 100%; padding: 15px; text-align: center; background: #00b894; color: white; border-radius: 5px; font-weight: bold;">
                                <i class="fas fa-check-circle"></i> Đã đăng ký
                            </a>
                        <?php else: ?>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="index.php?controller=enrollment&action=enroll&course_id=<?php echo $course['id']; ?>" 
                                   onclick="return confirm('Xác nhận đăng ký khóa học này?');"
                                   style="display: block; width: 100%; padding: 15px; text-align: center; background: var(--primary-color); color: white; border-radius: 5px; font-weight: bold;">
                                    Đăng ký ngay
                                </a>
                            <?php else: ?>
                                <a href="index.php?controller=auth&action=login" 
                                   style="display: block; width: 100%; padding: 15px; text-align: center; background: var(--primary-color); color: white; border-radius: 5px; font-weight: bold;">
                                    Đăng nhập để học
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <ul style="list-style: none; padding-top: 20px; border-top: 1px solid #eee;">
                        <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                            <span><i class="fas fa-signal" style="color:var(--primary-color);"></i> Trình độ:</span>
                            <strong><?php echo htmlspecialchars($course['level'] ?? 'Mọi cấp độ'); ?></strong>
                        </li>
                        <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                            <span><i class="fas fa-clock" style="color:var(--primary-color);"></i> Thời lượng:</span>
                            <strong><?php echo htmlspecialchars($course['duration_weeks']); ?> tuần</strong>
                        </li>
                        <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                            <span><i class="fas fa-book" style="color:var(--primary-color);"></i> Bài học:</span>
                            <strong><?php echo isset($lessons) ? count($lessons) : 0; ?> bài</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>