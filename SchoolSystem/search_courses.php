<?php
require_once 'config/database.php';

$keyword = trim($_GET['keyword'] ?? '');

$sql = "SELECT * FROM courses WHERE 1=1";
$params = [];

if ($keyword !== '') {
    $sql .= " AND title LIKE :keyword";
    $params[':keyword'] = '%' . $keyword . '%';
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$courses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بحث الكورسات</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- الهيدر العلوي -->
    <div class="header-banner">
        <h1>البحث في الكورسات</h1>
        <p>GET + LIKE Search + Prepared Statement</p>
    </div>

    <!-- شريط التنقل -->
    <div class="nav-container">
        <a href="index.php" class="nav-btn">الرئيسية</a>
        <a href="test.php" class="nav-btn">اختبار الاتصال</a>
        <a href="show_courses.php" class="nav-btn">عرض الكورسات</a>
        <a href="add_course.php" class="nav-btn">إضافة كورس</a>
        <a href="search_courses.php" class="nav-btn active">بحث الكورسات</a>
    </div>

    <!-- كارت نموذج البحث والنتائج -->
    <div class="form-card">
        
        <form method="GET" action="">
            <div class="form-group">
                <label>ابحث باسم الكورس:</label>
                <input type="text" name="keyword" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="اكتب كلمة البحث...">
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">بحث</button>
            </div>
        </form>

        <div class="divider"></div>
        <h2 class="card-title">نتائج البحث</h2>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الكورس</th>
                        <th>السعر</th>
                        <th>التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">لا توجد نتائج مطابقة للبحث.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?= htmlspecialchars($course['id']) ?></td>
                                <td><strong><?= htmlspecialchars($course['title']) ?></strong></td>
                                <td>$ <?= htmlspecialchars(number_format((float)$course['price'], 2)) ?></td>
                                <td><?= htmlspecialchars($course['details']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>