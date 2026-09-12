<?php
$status_message = '';
$status_type = '';
$db_details = [];

try {
    // استدعاء ملف الاتصال المنفصل
    require_once 'config/database.php';

    // إذا تم الاتصال بنجاح وتوفر كائن $pdo
    if (isset($pdo)) {
        $status_message = 'تم الاتصال بقاعدة البيانات بنجاح! ✅';
        $status_type = 'success';

        // جلب تفاصيل السيرفر وقاعدة البيانات للتأكد الفعلي
        $server_version = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        $driver_name    = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        $db_name        = $pdo->query("SELECT DATABASE()")->fetchColumn();

        $db_details = [
            'حالة الاتصال'      => 'متصل (Connected)',
            'اسم قاعدة البيانات' => $db_name,
            'نوع المحرك'        => strtoupper($driver_name),
            'إصدار السيرفر'     => $server_version
        ];
    }
} catch (Exception $e) {
    $status_message = 'فشل الاتصال بقاعدة البيانات: ' . $e->getMessage();
    $status_type = 'error';
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار الاتصال بقاعدة البيانات</title>
    <!-- ربط ملف CSS المنفصل -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>اختبار الاتصال بقاعدة البيانات</h1>
        <p>PDO Connection Test + Status Check</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
    <a href="index.php" class="nav-btn">الرئيسية</a>
    <a href="test.php" class="nav-btn active">اختبار الاتصال</a>
    <a href="show_courses.php" class="nav-btn">عرض الكورسات</a>
    <a href="add_course.php" class="nav-btn">إضافة كورس</a>
    <a href="search_courses.php" class="nav-btn">بحث الكورسات</a>
</div>
    <!-- كارت النتيجة -->
    <div class="form-card">
        
        <div class="alert <?= $status_type ?>">
            <?= htmlspecialchars($status_message) ?>
        </div>

        <?php if (!empty($db_details)): ?>
            <h3 class="section-title">تفاصيل الاتصال:</h3>
            <table class="details-table">
                <tbody>
                    <?php foreach ($db_details as $key => $value): ?>
                        <tr>
                            <td class="table-label"><?= $key ?></td>
                            <td class="table-value"><?= htmlspecialchars($value) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

</body>
</html>