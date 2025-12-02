# Cài đặt PHP trên máy server

```php
$cmd = "php -v";
$output = [];
$returnCode = 0;

exec($cmd, $output, $returnCode);
echo "<h3>Phiên bản PHP đã được cài đặt trên máy server</h3>";
echo "<pre>";
print_r($output[0]);
echo "</pre>";
echo "<h3>Đường dẫn tới bin PHP trên máy server</h3>";

if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
    $cmd = 'where php';
} else {
    $cmd = 'which php';
}

$pathOutput = [];
$pathReturn = 0;
exec($cmd, $pathOutput, $pathReturn);

echo "<pre>";
if (!empty($pathOutput)) {
    echo htmlspecialchars($pathOutput[0], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
} else {
    echo "Không thể tìm thấy đường dẫn PHP (cmd: {$cmd})";
}
echo "</pre>";
```


