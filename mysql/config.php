
<?php
//الاتصال بقاعدة البيانات  باستخدام طريقة  mysqli في PHP
$server = "localhost";  
$username = "hamasT29";        
$passw= " ";             
$dbname = "ggsxh256";       

//إنشاء الأتصال
$conn = new mysqli($server, $username, $passw, $dbname);

//التحقق من الأتصال
if ($conn->connect_error) {
    die("Connection Configuration Failed: " . $conn->connect_error);
}
echo"Connection Configured Successfully"; 
?>


