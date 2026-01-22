
#1. PDO Bind Parameters (الأكثر شيوعاً)
#يُستخدم لربط القيم الآمنة مع الاستعلامات SQL لمنع SQL Injection.

#مثال:
php

$pdo = new PDO("mysql:host=localhost;dbname=bank", $user, $pass);

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND status = ?");
$stmt->bindParam(1, $userId, PDO::PARAM_INT);    // البارامتر الأول رقم
$stmt->bindParam(2, $status, PDO::PARAM_STR);    // البارامتر الثاني نص

$userId = 123;
$status = 'active';
$stmt->execute();

$user = $stmt->fetch();
#أنواع BindParam:
php

$stmt->bindParam(1, $value, PDO::PARAM_INT);    // integer
$stmt->bindParam(1, $value, PDO::PARAM_STR);    // string  
$stmt->bindParam(1, $value, PDO::PARAM_BOOL);   // boolean
$stmt->bindParam(1, $value, PDO::PARAM_NULL);   // NULL

#الفرق بين bindParam و bindValue:
php

// bindParam:
# يمرر المتغير بالمرجع (يتغير القيمة)
$value = 123;
$stmt->bindParam(1, $value);
$value = 456; // هذا سيؤثر على الاستعلام

// bindValue: يمرر قيمة ثابتة
$stmt->bindValue(1, $value); // 123 فقط
2. MySQLi Bind Parameters
php

$stmt = $mysqli->prepare("INSERT INTO accounts (user_id, amount) VALUES (?, ?)");
$stmt->bind_param("ii", $userId, $amount); // "ii" = integer, integer

$userId = 1;
$amount = 1000;
$stmt->execute();

#أنواع MySQLi bind_param:

i = integer
d = double/float  
s = string
b = blob

#3. Bind في الـ Callbacks والـ Closures
php

class Bank {
    private $rate = 1.5;
    
    public function calculateInterest($amount) {
        return $amount * $this->rate;
    }
}

// ربط $this مع الدالة
$bank = new Bank();
$calculate = [$bank, 'calculateInterest'];
$interest = call_user_func($calculate, 1000); // 1500

#استخدام Closure مع use (bind variables):
php

$taxRate = 0.14;
$vatCalculator = function($price) use ($taxRate) {
    return $price * (1 + $taxRate);
};

echo $vatCalculator(100); // 114
4. Reflection Bind (المتقدم)
php



class User {
    private $name;
    
    public function setName($name) {
        $this->name = $name;
    }
}

$reflection = new ReflectionClass('User');
$method = $reflection->getMethod('setName');
$instance = new User();

$method->invoke($instance, 'Ahmed'); // ربط الدالة بالكائن
مثال عملي لبنكك (من الذاكرة السابقة):
php



class BankDatabase {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // إيداع آمن بـ bind
    public function deposit($accountId, $amount) {
        $stmt = $this->pdo->prepare("
            UPDATE accounts 
            SET balance = balance + ?, 
                updated_at = NOW()
            WHERE account_id = ? 
            AND balance >= 0
        ");
        
        $stmt->bindParam(1, $amount, PDO::PARAM_INT);
        $stmt->bindParam(2, $accountId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // سحب آمن
    public function withdraw($accountId, $amount) {
        $stmt = $this->pdo->prepare("
            UPDATE accounts 
            SET balance = balance - ?
            WHERE account_id = ? 
            AND balance >= ?
        ");
        
        $stmt->bindParam(1, $amount, PDO::PARAM_INT);
        $stmt->bindParam(2, $accountId, PDO::PARAM_INT);
        $stmt->bindParam(3, $amount, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}

// الاستخدام
$db = new BankDatabase($pdo);
$db->deposit(123, 500);  // آمن 100%
لماذا Bind مهم؟



❌ غير آمن (SQL Injection):
$result = $pdo->query("SELECT * FROM users WHERE id = $userId");

✅ آمن مع Bind:
$stmt->bindParam(1, $userId, PDO::PARAM_INT);
الـ Bind هو الطريقة الوحيدة الآمنة لتمرير البيانات لقواعد البيانات في PHP!