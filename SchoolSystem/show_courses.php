<?php
require_once 'config/database.php';

$sql = "SELECT id, title, price, details FROM courses ORDER BY id DESC";
$stmt = $pdo->query($sql);
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الكورسات</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>عرض جميع الكورسات</h1>
        <p>SELECT Query + Fetch All</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
        <a href="index.php" class="nav-btn">الرئيسية</a>
        <a href="test.php" class="nav-btn">اختبار الاتصال</a>
        <a href="show_courses.php" class="nav-btn active">عرض الكورسات</a>
        <a href="add_course.php" class="nav-btn">إضافة كورس</a>
        <a href="search_courses.php" class="nav-btn">بحث الكورسات</a>
    </div>

    <!-- كارت المحتوى الرئيسي -->
    <div class="form-card">
        
        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="alert success">تم حذف الكورس بنجاح.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'not_found'): ?>
            <div class="alert error">الكورس غير موجود أو تم حذفه مسبقاً.</div>
        <?php endif; ?>

        <h2 class="card-title">قائمة الكورسات المتاحة</h2>
        <div class="divider"></div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الكورس</th>
                        <th>السعر</th>
                        <th>التفاصيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">لا توجد كورسات مضافة حالياً.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?= htmlspecialchars($course['id']) ?></td>
                                <td><strong><?= htmlspecialchars($course['title']) ?></strong></td>
                                <td>$ <?= htmlspecialchars(number_format((float)$course['price'], 2)) ?></td>
                                <td><?= htmlspecialchars($course['details']) ?></td>
                                <td>
                                    <a href="edit_course.php?id=<?= htmlspecialchars($course['id']) ?>" class="action-link edit">تعديل</a>
                                    <a href="delete_course.php?id=<?= htmlspecialchars($course['id']) ?>" class="action-link delete" onclick="return confirm('هل أنت متأكد من حذف هذا الكورس؟');">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>