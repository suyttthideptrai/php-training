<?php
require_once dirname(__DIR__, 2) . '/bootstrap.php';
base_require('dau.php');
?>

<?php echo markdown('
3. Case Sensitive
- Sử dụng để in ra như `sout` trong Java, `print` trong Python
- Cú pháp:
```php
echo "<hr>";
echo "Nội dung cần in";
echo "<hr>";
```
- Output:
&&&+
echo "Nội dung cần in \n";
for ($i = 0; $i < 3; $i++) {
    echo "This is line " . $i . "\n";
};
&&&
', true);
?>

<?php base_require('dit.php'); ?>
