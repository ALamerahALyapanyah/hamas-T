<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "تم إنشاء الجدول بنجاح أو كان موجود مسبقًا.<br>";
} else {
    echo "خطأ في إنشاء الجدول: " . $conn->error;
}


$sql = "INSERT INTO students (name, email) VALUES ('أحمد', 'ahmed@example.com')";
if ($conn->query($sql) === TRUE) {
    echo "تم إضافة بيانات بنجاح.<br>";
} else {
    echo "خطأ في الإضافة: " . $conn->error;
}


$sql = "SELECT id, name, email FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>قائمة الطلاب:</h3>";
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - الاسم: " . $row["name"]. " - البريد: " . $row["email"]. "<br>";
    }
} else {
    echo "لا توجد بيانات.";
}

$conn->close();
?>
