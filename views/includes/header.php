
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - LearnHub' : 'LearnHub - Nền tảng học trực tuyến'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<header class="header">
    <div class="header-container">

        <!-- Left Section -->
        <div class="flex items-center gap-4">
            <button id="menu-btn" class="icon-btn" style="display: none;">
                <i class="fas fa-bars"></i>
            </button>
            <a href="index.php" class="logo">
                <i class="fas fa-book-open" style="color: var(--primary-color); font-size: 2rem;"></i>
                <span>LearnHub</span>
            </a>
        </div>

        <!-- Search -->
        <div class="search-bar">
            <i class="fas fa-search" style="color: #9ca3af;"></i>
            <input type="text" id="search-input" placeholder="Tìm kiếm khóa học...">
        </div>

        <!-- Right Section -->
        <div class="nav-right">

            <?php if (!isset($user)): ?>
                <!-- Chưa đăng nhập -->
                <?php if (!isset($hideCategories) || !$hideCategories): ?>
                <button class="btn-link" style="display: none;font-size: 1rem;">Khóa học</button>
                <?php endif; ?>
                <a href="#" class="btn-link" style="display: none;">Giảng dạy</a>

                <a href="login.php" class="btn btn-secondary" style="padding: 0.5rem 1rem; display: none;">Đăng nhập</a>
                <a href="register.php" class="btn btn-primary" style="padding: 0.5rem 1rem;">Đăng ký</a>

            <?php else: ?>
                <!-- Đã đăng nhập -->

                <div class="relative" id="user-menu-container">
                    <button
                        onclick="toggleUserMenu()"
                        class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-lg transition-colors"
                    >
                        <!-- Avatar -->
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 
                            flex items-center justify-center text-white shadow-md">
                            <?= strtoupper($user['name'][0]); ?>
                        </div>

                        <!-- User Info -->
                        <div class="text-left hidden lg:block">
                            <div class="text-gray-900"><?= $user['name']; ?></div>
                            <div class="text-xs text-gray-500">
                                <?= 
                                    $user['role'] === 2 ? "Quản trị viên" : 
                                    ($user['role'] === 1 ? "Giảng viên" : "Học viên")
                                ?>
                            </div>
                        </div>

                        <!-- Arrow -->
                        <i id="arrow-icon" class="fa-solid fa-chevron-down w-4 h-4 text-gray-400 transition-transform"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="user-dropdown" 
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 hidden">

                        <!-- Info -->
                        <div class="px-4 py-3 border-b border-gray-200">
                            <div class="text-gray-900"><?= $user['name']; ?></div>
                            <div class="text-sm text-gray-500"><?= $user['email']; ?></div>

                            <div class="mt-1">
                                <span class="
                                    inline-block px-2 py-1 rounded-full text-xs
                                    <?= $user['role'] === 2 ? 'bg-purple-100 text-purple-700' : '' ?>
                                    <?= $user['role'] === 1 ? 'bg-blue-100 text-blue-700' : '' ?>
                                    <?= $user['role'] === 0 ? 'bg-green-100 text-green-700' : '' ?>
                                ">
                                    <?= 
                                        $user['role'] === 2 ? "Quản trị viên" : 
                                        ($user['role'] === 1 ? "Giảng viên" : "Học viên")
                                    ?>
                                </span>
                            </div>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="dashboard.php" 
                            class="w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors flex items-center gap-3 text-gray-700">
                                <i class="fa-solid fa-table-columns w-5 h-5"></i>
                                <span>Bảng điều khiển</span>
                            </a>

                            <a href="settings.php" 
                            class="w-full px-4 py-2 text-left hover:bg-gray-50 transition-colors flex items-center gap-3 text-gray-700">
                                <i class="fa-solid fa-gear w-5 h-5"></i>
                                <span>Cài đặt</span>
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="border-t border-gray-200 pt-2">
                            <a href="logout.php" 
                            class="w-full px-4 py-2 text-left hover:bg-red-50 transition-colors flex items-center gap-3 text-red-600">
                                <i class="fa-solid fa-right-from-bracket w-5 h-5"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
</header>

<style>
    @media (min-width: 1024px) {
        .btn-link { display: inline-block !important; }
    }
    @media (min-width: 640px) {
        .nav-right .btn { display: inline-block !important; }
    }
    .btn-link {
        background: transparent;
        border: none;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        color: var(--text-primary);
        text-decoration: none;
    }
    .btn-link:hover {
        color: var(--primary-color);
    }
</style>

<!-- JS Toggle Dropdown -->
<script>
function toggleUserMenu() {
    const menu = document.getElementById("user-dropdown");
    const arrow = document.getElementById("arrow-icon");

    menu.classList.toggle("hidden");
    arrow.classList.toggle("rotate-180");
}

document.addEventListener("click", function(event) {
    const container = document.getElementById("user-menu-container");
    if (container && !container.contains(event.target)) {
        document.getElementById("user-dropdown").classList.add("hidden");
        document.getElementById("arrow-icon").classList.remove("rotate-180");
    }
});
</script>

</body>
</html>
