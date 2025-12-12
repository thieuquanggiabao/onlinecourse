<div class="container" style="margin-top: 30px;">
    <h2>Quản lý khóa học của tôi</h2>
    <a href="index.php?controller=instructor&action=createCourse" class="btn-create" style="background: var(--primary-color); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">+ Thêm khóa học mới</a>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr style="background: #f1f1f1;">
                <th>ID</th>
                <th>Hình ảnh</th>
                <th>Tên khóa học</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($courses as $course): ?>
            <tr>
                <td><?php echo $course['id']; ?></td>
                <td>
                    <?php if($course['image']): ?>
                        <img src="assets/uploads/courses/<?php echo $course['image']; ?>" width="50">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo htmlspecialchars($course['category_name']); ?></td>
                <td><?php echo number_format($course['price']); ?> đ</td>
                <td>
                    <a href="index.php?controller=instructor&action=editCourse&id=<?php echo $course['id']; ?>">Sửa</a> | 
                    <a href="index.php?controller=instructor&action=deleteCourse&id=<?php echo $course['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>