<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bank";

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS bank");
    $pdo->exec("USE bank");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS accounts (
            id INT PRIMARY KEY,
            balance DECIMAL(10,2)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS transactions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            from_account INT,
            to_account INT,
            amount DECIMAL(10,2),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $count = $pdo->query("SELECT COUNT(*) FROM accounts")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO accounts VALUES (1,1000),(2,500)");
    }

} catch (PDOException $e) {
    header("Location: result.php?status=error");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $from = (int)$_POST["from_account"];
    $to   = (int)$_POST["to_account"];
    $amt  = (float)$_POST["amount"];

    try {
        if ($amt <= 0) throw new Exception();

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT balance FROM accounts WHERE id=?");
        $stmt->execute([$from]);
        $balance = $stmt->fetchColumn();

        if ($balance === false || $balance < $amt) {
            throw new Exception();
        }

        $pdo->prepare(
            "UPDATE accounts SET balance = balance - ? WHERE id = ?"
        )->execute([$amt, $from]);

        $pdo->prepare(
            "UPDATE accounts SET balance = balance + ? WHERE id = ?"
        )->execute([$amt, $to]);

        $pdo->prepare(
            "INSERT INTO transactions (from_account, to_account, amount)
             VALUES (?, ?, ?)"
        )->execute([$from, $to, $amt]);

        $pdo->commit();

        header("Location: result.php?status=success");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        header("Location: result.php?status=error");
        exit;
    }
}
