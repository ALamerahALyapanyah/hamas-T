<?php
// Array Functions With Short Explanations

// 1. count — يحسب عدد عناصر المصفوفة
$a = [1, 2, 3];
$count = count($a);

// 2. array_push — إضافة عناصر لنهاية المصفوفة
$b = [1, 2];
array_push($b, 3);

// 3. array_pop — حذف آخر عنصر من المصفوفة
$c = [1, 2, 3];
array_pop($c);

// 4. array_merge — دمج مصفوفتين
$d1 = [1, 2];
$d2 = [3, 4];
$merged = array_merge($d1, $d2);

// 5. in_array — التحقق من وجود قيمة في مصفوفة
$exists = in_array(2, [1, 2, 3]);

// 6. array_search — البحث عن قيمة وإرجاع مفتاحها
$search = array_search("b", ["a", "b", "c"]);

// 7. array_reverse — عكس ترتيب عناصر المصفوفة
$rev = array_reverse([1, 2, 3]);

// 8. sort — ترتيب المصفوفة تصاعدياً
$e = [3, 1, 2];
sort($e);

// 9. rsort — ترتيب المصفوفة تنازلياً
$f = [3, 1, 2];
rsort($f);

// 10. array_unique — إزالة العناصر المكررة
$unique = array_unique([1, 1, 2, 3]);

// 11. array_filter — تصفية المصفوفة باستخدام شرط
$filtered = array_filter([1,2,3,4], fn($n) => $n % 2 == 0);

// 12. array_map — تطبيق دالة على كل عنصر
$mapped = array_map(fn($n) => $n * 2, [1,2,3]);

// 13. array_reduce — دمج عناصر المصفوفة في قيمة واحدة (مثل الجمع)
$sum = array_reduce([1,2,3], fn($carry, $item) => $carry + $item, 0);

// 14. array_keys — إرجاع جميع المفاتيح
$keys = array_keys(["name" => "Ali", "age" => 20]);

// 15. array_values — إرجاع كل القيم بدون المفاتيح
$values = array_values(["name" => "Ali", "age" => 20]);

// 16. array_slice — أخذ جزء من المصفوفة
$slice = array_slice([10,20,30,40], 1, 2);

// 17. array_chunk — تقسيم المصفوفة إلى أجزاء صغيرة
$chunks = array_chunk([1,2,3,4], 2);
?>
