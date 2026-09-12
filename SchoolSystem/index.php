<?php
// استدعاء ملف الاتصال بقاعدة البيانات
require_once 'config/database.php';

// جلب إحصائيات سريعة من قاعدة البيانات
try {
    $courses_count       = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    $students_count      = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
    $registrations_count = $pdo->query("SELECT COUNT(*) FROM course_student")->fetchColumn();
} catch (PDOException $e) {
    $courses_count       = 0;
    $students_count      = 0;
    $registrations_count = 0;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية - نظام إدارة الكورسات</title>
    <!-- ربط ملف CSS المنفصل -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>لوحة التحكم الرئيسية</h1>
        <p>School System Management Dashboard</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
        <a href="index.php" class="nav-btn active">الرئيسية</a>
        <a href="test.php" class="nav-btn">اختبار الاتصال</a>
        <a href="show_courses.php" class="nav-btn">عرض الكورسات</a>
        <a href="add_course.php" class="nav-btn">إضافة كورس</a>
        <a href="search_courses.php" class="nav-btn">بحث الكورسات</a>
    </div>

    <!-- كارت المحتوى الرئيسي -->
    <div class="form-card">
        <h2 class="card-title">مرحباً بك في نظام إدارة الكورسات</h2>
        <p class="card-desc">
            يمكنك من خلال هذا النظام إدارة الكورسات، إضافة دورات جديدة، ومتابعة الطلاب المسجلين بكل سهولة.
        </p>

        <div class="divider"></div>

        <!-- إحصائيات النظام -->
        <h3 class="section-title">ملخص النظام:</h3>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>إجمالي الكورسات</h3>
                <div class="number"><?= $courses_count ?></div>
            </div>

            <div class="stat-card">
                <h3>إجمالي الطلاب</h3>
                <div class="number"><?= $students_count ?></div>
            </div>

            <div class="stat-card">
                <h3>عدد التسجيلات</h3>
                <div class="number"><?= $registrations_count ?></div>
            </div>
        </div>

        <!-- روابط سريعة -->
        <div class="quick-links">
            <a href="add_course.php" class="link-btn primary-link">+ إضافة كورس جديد</a>
            <a href="test.php" class="link-btn secondary-link">فحص قاعدة البيانات</a>
        </div>
    </div>

</body>
</html>