-- إنشاء قاعدة البيانات إذا لم تكن موجودة
-- CREATE DATABASE IF NOT EXISTS training_institute;
USE training_institute;

-- إنشاء جدول الشركات
CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- إدخال بيانات افتراضية للشركات
INSERT INTO companies (name) VALUES 
('شركة ABC'),
('شركة XYZ'),
('شركة الابتكار'),
('شركة النجاح'),
('شركة الرواد');

-- إنشاء جدول المتدربين
CREATE TABLE IF NOT EXISTS trainees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    company_id INT,
    status ENUM('غير معتمد', 'معتمد', 'مستبعد', 'مستقيل') DEFAULT 'غير معتمد',
    reason_for_exclusion VARCHAR(255),
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

-- إدخال بيانات افتراضية للمتدربين
INSERT INTO trainees (name, email, company_id, status,reason_for_exclusion) VALUES 
('أحمد علي', 'ahmed@example.com', 1, 'معتمد',''),
('سارة محمد', 'sarah@example.com', 2, 'غير معتمد',''),
('خالد إبراهيم', 'khaled@example.com', 3, 'معتمد',''),
('منى حسين', 'mona@example.com', 4, 'مستبعد', 'غياب متكرر'),
('يوسف عادل', 'yousef@example.com', 5, 'مستقيل', 'ظروف خاصة');

-- إنشاء جدول الحضور والانصراف
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trainee_id INT,
    date DATE,
    status ENUM('حاضر', 'غائب') NOT NULL,
    FOREIGN KEY (trainee_id) REFERENCES trainees(id)
);

-- إضافة بعض بيانات الحضور الافتراضية
INSERT INTO attendance (trainee_id, date, status) VALUES 
(1, '2024-10-01', 'حاضر'),
(1, '2024-10-02', 'غائب'),
(2, '2024-10-01', 'حاضر'),
(3, '2024-10-01', 'حاضر'),
(3, '2024-10-02', 'حاضر');

-- استعلام للتحقق من البيانات المدرجة
SELECT * FROM companies;
SELECT * FROM trainees;
SELECT * FROM attendance;
