<div class="container" style="display: flex; justify-content: center; padding: 60px 0;">
    <div class="auth-card" style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px;">
        <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">Tạo tài khoản mới</h2>
        
        <?php if(isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
            <div class="alert alert-danger" style="background: #ffebee; color: #d32f2f; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                Username hoặc Email đã tồn tại!
            </div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=store" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Họ và tên:</label>
                <input type="text" name="fullname" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Tên đăng nhập:</label>
                <input type="text" name="username" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Email:</label>
                <input type="email" name="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label>Mật khẩu:</label>
                <input type="password" name="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background: var(--primary-color); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
                Đăng ký thành viên
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            Đã có tài khoản? <a href="index.php?controller=auth&action=login" style="color: var(--primary-color); font-weight: bold;">Đăng nhập</a>
        </div>
    </div>
</div>