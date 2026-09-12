<?php
// استدعاء ملف الاتصال بقاعدة البيانات منفصلاً
require_once 'config/database.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال البيانات وتنظيفها
    $title   = trim($_POST['title'] ?? '');
    $price   = trim($_POST['price'] ?? '');
    $details = trim($_POST['details'] ?? '');

    // التحقق من صحة البيانات (Validation)
    if (empty($title) || empty($price)) {
        $message = 'الرجاء إدخال اسم الكورس والسعر على الأقل.';
        $message_type = 'error';
    } elseif (!is_numeric($price) || $price < 0) {
        $message = 'يرجى إدخال سعر صحيح.';
        $message_type = 'error';
    } else {
        try {
            // استخدام $pdo المعرّف في ملف db.php
            $stmt = $pdo->prepare("INSERT INTO courses (title, price, details) VALUES (:title, :price, :details)");
            $stmt->execute([
                ':title'   => $title,
                ':price'   => $price,
                ':details' => $details
            ]);

            $message = 'تم إضافة الكورس بنجاح!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'خطأ عند إضافة البيانات: ' . $e->getMessage();
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة كورس جديد</title>
    <!-- ربط ملف التنسيق الخارجي -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>إضافة كورس جديد</h1>
        <p>.POST + Validation + Prepared Statement + INSERT</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
    <a href="index.php" class="nav-btn">الرئيسية</a>
    <a href="test.php" class="nav-btn">اختبار الاتصال</a>
    <a href="show_courses.php" class="nav-btn">عرض الكورسات</a>
    <a href="add_course.php" class="nav-btn active">إضافة كورس</a>
    <a href="search_courses.php" class="nav-btn">بحث الكورسات</a>
</div>
    <!-- كارت النموذج الرئيسي -->
    <div class="form-card">
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            
            <div class="form-group">
                <label>اسم الكورس</label>
                <input type="text" name="title" class="form-control" placeholder="مثال: تطوير تطبيقات الويب بـ PHP" required>
            </div>

            <div class="form-group">
                <label>السعر ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>التفاصيل (الوصف)</label>
                <textarea name="details" class="form-control" placeholder="وصف مختصر للكورس وما سيتم دراسته..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">حفظ الكورس</button>
            </div>

        </form>
    </div>

</body>
</html>