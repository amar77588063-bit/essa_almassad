<?php
require_once 'config/database.php';

$message = '';
$message_type = '';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    die('رقم الكورس غير صحيح.');
}

// جلب بيانات الكورس الحالية
$stmt = $pdo->prepare("SELECT * FROM courses WHERE id = :id");
$stmt->execute([':id' => $id]);
$course = $stmt->fetch();

if (!$course) {
    die('الكورس غير موجود.');
}

$title   = $course['title'];
$price   = $course['price'];
$details = $course['details'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $price   = trim($_POST['price'] ?? '');
    $details = trim($_POST['details'] ?? '');

    if (empty($title) || empty($price)) {
        $message = 'الرجاء إدخال اسم الكورس والسعر.';
        $message_type = 'error';
    } elseif (!is_numeric($price) || (float)$price < 0) {
        $message = 'يرجى إدخال سعر صحيح.';
        $message_type = 'error';
    } else {
        try {
            $updateStmt = $pdo->prepare("UPDATE courses SET title = :title, price = :price, details = :details WHERE id = :id");
            $updateStmt->execute([
                ':title'   => $title,
                ':price'   => $price,
                ':details' => $details,
                ':id'      => $id
            ]);

            $message = 'تم حفظ التعديلات بنجاح!';
            $message_type = 'success';
        } catch (PDOException $e) {
            $message = 'خطأ أثناء التعديل: ' . $e->getMessage();
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
    <title>تعديل الكورس</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>تعديل بيانات الكورس</h1>
        <p>POST + Prepared Statement + UPDATE</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
        <a href="index.php" class="nav-btn">الرئيسية</a>
        <a href="show_courses.php" class="nav-btn">عرض الكورسات</a>
        <a href="add_course.php" class="nav-btn">إضافة كورس</a>
    </div>

    <!-- كارت النموذج -->
    <div class="form-card">
        
        <?php if (!empty($message)): ?>
            <div class="alert <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            
            <div class="form-group">
                <label>اسم الكورس</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
            </div>

            <div class="form-group">
                <label>السعر ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($price) ?>" required>
            </div>

            <div class="form-group">
                <label>التفاصيل (الوصف)</label>
                <textarea name="details" class="form-control"><?= htmlspecialchars($details) ?></textarea>
            </div>

            <div class="form-actions" style="display: flex; gap: 10px;">
                <button type="submit" class="submit-btn">حفظ التعديلات</button>
                <a href="show_courses.php" class="nav-btn" style="border-radius: 20px; line-height: 24px;">إلغاء</a>
            </div>

        </form>
    </div>

</body>
</html>