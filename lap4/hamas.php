
#تكليف طرق التعامل مع الملفات ودوال الوقت و التاريخ و المنطقة الزمنية 

#. قراءة وكتابة الملفات الأسا0سية
php
// قراءة ملف كامل
$content = file_get_contents('example.txt');

// كتابة في ملف
file_put_contents('example.txt', 'Hello World!');

// قراءة سطر بسطر
$lines = file('example.txt');
foreach ($lines as $line) {
    echo trim($line) . "\n";
}

#2. التحقق من وجود الملفات والمجلدات
php

if (file_exists('example.txt')) {
    echo 'الملف موجود';
}

if (is_dir('uploads/')) {
    echo 'المجلد موجود';
}

if (is_readable('example.txt')) {
    echo 'الملف قابل للقراءة';
}

#3. إنشاء وحذف الملفات والمجلدات
php

// إنشاء مجلد
mkdir('uploads', 0777, true); // true لإنشاء مجلدات متداخلة

// حذف ملف
unlink('temp.txt');

// حذف مجلد فارغ
rmdir('empty_folder');

// حذف مجلد مع كل محتوياته
function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}

#4. قراءة محتويات المجلد
php

// قراءة جميع الملفات
$files = scandir('uploads/');

// فلترة حسب الامتداد
$images = glob('uploads/*.jpg');

// iterator للملفات الكبيرة
$iterator = new DirectoryIterator('uploads/');
foreach ($iterator as $file) {
    if ($file->isFile()) {
        echo $file->getFilename() . ' - ' . $file->getSize() . ' bytes';
    }
}

#5. رفع الملفات (File Upload)
php
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['file']['name']);
    $targetPath = $uploadDir . time() . '_' . $fileName;
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        echo 'تم رفع الملف بنجاح';
    }
}

#======================================================
#دوال الوقت والتاريخ في PHP
#1. الدوال التقليدية (date/time functions)
php
// التاريخ الحالي
echo date('Y-m-d H:i:s'); // 2026-01-21 14:30:25

// تنسيقات شائعة
echo date('d/m/Y');     // 21/01/2026
echo date('l, F j');    // Wednesday, January 21

// Timestamp الحالي
$timestamp = time();
echo date('Y-m-d', $timestamp);

// تحويل timestamp إلى تاريخ
$future = strtotime('+1 month');
echo date('Y-m-d', $future); // الشهر القادم

#2. DateTime Class (الطريقة الحديثة والموصى بها)
php
$date = new DateTime();
echo $date->format('Y-m-d H:i:s');

// إنشاء تاريخ محدد
$date = new DateTime('2026-01-21 14:30:00');
echo $date->format('l, d F Y');

// إضافة/طرح وقت
$date->add(new DateInterval('P1M')); // شهر واحد
$date->sub(new DateInterval('PT2H')); // ساعتين

// مقارنة التواريخ
$date1 = new DateTime('2026-01-21');
$date2 = new DateTime('2026-01-22');
$diff = $date1->diff($date2);
echo $diff->days; // 1

#التعامل مع المناطق الزمنية (Timezones)
#1. إعداد المنطقة الزمنية
php 
// في بداية الصفحة أو php.ini
date_default_timezone_set('Africa/Cairo');  // لمصر
date_default_timezone_set('Europe/London'); // لندن
date_default_timezone_set('America/New_York'); // نيويورك

// التحقق من المنطقة الحالية
echo date_default_timezone_get();

#========================================================
#2. استخدام DateTime مع Timezone
php
// تاريخ مع منطقة زمنية محددة
$date = new DateTime('now', new DateTimeZone('Asia/Riyadh'));
echo $date->format('Y-m-d H:i:s T'); // T تعرض الاختصار

// تحويل بين المناطق الزمنية
$cairoTime = new DateTime('now', new DateTimeZone('Africa/Cairo'));
$cairoTime->setTimezone(new DateTimeZone('UTC'));
echo $cairoTime->format('Y-m-d H:i:s');

#=============================================================
#3. قائمة المناطق الزمنية المدعومة
php
// عرض جميع المناطق المدعومة
$timezones = DateTimeZone::listIdentifiers();
print_r($timezones);

// أو فلترة حسب القارة
$africa = DateTimeZone::listIdentifiers(DateTimeZone::AFRICA);

#4. مثال عملي: تسجيل الوقت المحلي للمستخدم
php
function getUserLocalTime($userTimezone = 'UTC') {
    $date = new DateTime('now', new DateTimeZone($userTimezone));
    return $date->format('Y-m-d H:i:s T');
}

// استخدام
$user_tz = $_POST['timezone'] ?? 'Africa/Cairo';
echo getUserLocalTime($user_tz);

#5. التعامل مع التوقيت الصيفي (DST)
php

$date = new DateTime('2026-06-15', new DateTimeZone('Europe/Paris'));
echo $date->format('Y-m-d H:i:s T'); // سيأخذ بعين الاعتبار التوقيت الصيفي تلقائياً

#نصائح أمان مهمة للملفات:
php
// تجنب directory traversal
$filename = basename($_GET['file']); // basename للأمان
$file = 'uploads/' . $filename;

// التحقق من الامتدادات المسموحة
$allowed = ['jpg', 'png', 'pdf'];
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    die('نوع الملف غير مسموح');
}
