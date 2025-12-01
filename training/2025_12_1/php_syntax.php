<?php require_once '../../dau.php'; ?>

<h3>Các PHP syntax</h3>


<?php echo markdown('
1. Viết code PHP
- Viết code PHP thì phải bắt đầu bằng thẻ mở <?php
- Có thể không cần thẻ đóng ?> nếu file chỉ có code PHP
- Lúc nào viết cả kẹp cả HTML thì nên dùng thẻ đóng
'); ?>

<?php echo markdown('
2. echo
- Sử dụng để in ra như `sout` trong Java, `print` trong Python
- Cú pháp:
```php
echo "<hr>";
echo "Nội dung cần in";
echo "<hr>";
```
- Output:
'); 
echo "<hr>";
echo "Nội dung cần in";
echo "<hr>";
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
echo "<hr>";
echo "Nội dung cần in";
echo "<hr>";
&&&
'); 

?>





<?php require_once '../../dit.php'; ?>