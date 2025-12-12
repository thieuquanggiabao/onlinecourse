<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Online Course'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.php" class="logo"><i class="fas fa-graduation-cap"></i> EDUPRO</a>
                <div class="nav-links">
                    <a href="index.php">Trang chủ</a>
                    <a href="index.php?controller=course&action=index">Khóa học</a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="index.php?controller=auth&action=logout">Đăng xuất (<?php echo $_SESSION['fullname']; ?>)</a>
                    <?php else: ?>
                        <a href="index.php?controller=auth&action=login">Đăng nhập</a>
                        <a href="index.php?controller=auth&action=register" class="btn-login">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>