-- Cơ sở dữ liệu của dự án
--
-- 1. Bảng USERS
-- Chứa thông tin người dùng: học viên, giảng viên, quản trị viên
--
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(255) DEFAULT NULL,
    role INT(1) NOT NULL DEFAULT 0 COMMENT '0: student, 1: instructor, 2: admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 2. Bảng CATEGORIES
-- Chứa danh mục của các khóa học
--
CREATE TABLE categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 3. Bảng COURSES
-- Chứa thông tin chi tiết về các khóa học
-- Thiết lập Khóa ngoại liên kết đến users (giảng viên) và categories
--
CREATE TABLE courses (
    id INT(11) NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    instructor_id INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    duration_weeks INT(5) DEFAULT 0,
    level VARCHAR(50) DEFAULT 'Beginner', -- Beginner, Intermediate, Advanced
    image VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (instructor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 4. Bảng ENROLLMENTS
-- Ghi lại việc học viên đăng ký vào khóa học nào
-- Thiết lập Khóa ngoại liên kết đến courses và users (học viên)
--
CREATE TABLE enrollments (
    id INT(11) NOT NULL AUTO_INCREMENT,
    course_id INT(11) NOT NULL,
    student_id INT(11) NOT NULL,
    enrolled_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) NOT NULL DEFAULT 'active', -- active, completed, dropped
    progress INT(3) DEFAULT 0, -- Phần trăm hoàn thành (0-100)
    PRIMARY KEY (id),
    UNIQUE KEY (course_id, student_id), -- Đảm bảo một học viên chỉ đăng ký một khóa học một lần
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 5. Bảng LESSONS
-- Chứa các bài học trong từng khóa học
-- Thiết lập Khóa ngoại liên kết đến courses
--
CREATE TABLE lessons (
    id INT(11) NOT NULL AUTO_INCREMENT,
    course_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    video_url VARCHAR(255) DEFAULT NULL,
    order INT(5) NOT NULL, -- "order" là từ khóa trong SQL, nên đặt trong dấu ` ` hoặc đổi tên.
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 6. Bảng MATERIALS
-- Chứa tài liệu đính kèm cho từng bài học
-- Thiết lập Khóa ngoại liên kết đến lessons
--
CREATE TABLE materials (
    id INT(11) NOT NULL AUTO_INCREMENT,
    lesson_id INT(11) NOT NULL,
    filename VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) DEFAULT NULL, -- pdf, doc, ppt, v.v.
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

