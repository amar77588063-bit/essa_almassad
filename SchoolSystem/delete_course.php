<?php
require_once 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('رقم الكورس غير صحيح.');
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM courses WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

if ($stmt->rowCount() > 0) {
    header('Location: show_courses.php?success=deleted');
} else {
    header('Location: show_courses.php?error=not_found');
}
exit;