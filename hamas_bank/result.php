<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="result-box">
<?php
$status = $_GET['status'] ?? '';

if ($status === 'success') {
    echo "<h2 class='success'>✅ Transfer Successful</h2>";
    echo "<p>The transaction was completed successfully.</p>";
} else {
    echo "<h2 class='error'>❌ Transfer Failed</h2>";
    echo "<p>Please check the data and try again.</p>";
}
?>
    <a href="index.html" class="btn">Back to Transfer</a>
</div>

</body>
</html>
