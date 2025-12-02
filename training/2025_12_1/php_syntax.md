
# Các PHP syntax

1. Viết code PHP
- Viết code PHP thì phải bắt đầu bằng thẻ mở <?php
- Có thể không cần thẻ đóng ?> nếu file chỉ có code PHP
- Lúc nào viết cả kẹp cả HTML thì nên dùng thẻ đóng

2. Từ khoá `echo`
- Sử dụng để in ra như `sout` trong Java, `print` trong Python
- Cú pháp:
```php
echo "<hr>";
echo "Nội dung cần in";
echo "<hr>";
```

3. Các Keyword - Case Insensitive
- Các keyword trong PHP không phân biệt chữ hoa chữ thường (case insensitive)
- ví dụ: `echo`, `Echo`, `ECHO` đều hợp lệ
- Cú pháp:
```php
echo "<hr>";
echo "echo";
Echo "Echo";
ECHO "ECHO";
echO "echO";
echo "<hr>";
```

4. Các tên biến - Case sensitive
- Các tên biến trong PHP sẽ phân biệt chữ hoa chữ thường (case sensitive)
- Ví dụ code sau đây:
```php
$car = "Toyota";
echo $car;   // In ra Toyota
echo $Car;   // Warning: Undefined variable
echo $CAR;   // Warning: Undefined variable
```