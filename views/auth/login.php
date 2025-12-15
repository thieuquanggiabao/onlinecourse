<div class="container" style="display: flex; justify-content: center; padding: 60px 0;">
    <div class="auth-card" style="background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px;">
        <h2 style="text-align: center; color: var(--primary-color); margin-bottom: 30px;">Đăng nhập EduPro</h2>
        
        <?php if(isset($_GET['error']) && $_GET['error'] == 'failed'): ?>
            <div class="alert alert-danger" style="background: #ffebee; color: #d32f2f; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                Email hoặc mật khẩu không chính xác!
            </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success" style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                Đăng ký thành công! Vui lòng đăng nhập.
            </div>
        <?php endif; ?>

        <form action="index.php?controller=auth&action=authenticate" method="POST">
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Email:</label>
                <input type="email" name="email" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" placeholder="Email của bạn" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Mật khẩu:</label>
                <input type="password" name="password" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" style="width: 100%; padding: 12px; background: var(--primary-color); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
                Đăng nhập
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px;">
            Chưa có tài khoản? <a href="index.php?controller=auth&action=register" style="color: var(--primary-color); font-weight: bold;">Đăng ký ngay</a>
        </div>
    </div>
</div>