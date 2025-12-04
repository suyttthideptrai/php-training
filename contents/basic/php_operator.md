# Các toán tử trong PHP

- Tương tự các ngôn ngữ lập trình khác, PHP hỗ trợ nhiều loại toán tử khác nhau như:
    - `+` : Phép cộng
    - `-` : Phép trừ
    - `*` : Phép nhân
    - `/` : Phép chia
    - `%` : Phép chia lấy dư
    - `**` : Phép lũy thừa
```php
$a = 10;
$b = 3;
var_dump($a + $b);  // int(13)
var_dump($a - $b);  // int(7)
var_dump($a * $b);  // int(30)
var_dump($a / $b);  // float(3.3333333333333)
var_dump($a % $b);  // int(1)
var_dump($a ** $b); // int(1000)
```
- Ngoài ra còn có các toán tử so sánh, toán tử logic, toán tử gán, v.v.
    - `=` : Toán tử gán
    - `==` : Toán tử so sánh bằng (Kiểm tra giá trị bằng nhau sau khi ép kiểu nếu cần)
    - `===` : Toán tử so sánh bằng tuyệt đối (Kiểm tra cả giá trị và kiểu dữ liệu)
    - `!=` / `<>` : Toán tử khác
    - `!==` : Toán tử khác tuyệt đối
    - `>` : Toán tử lớn hơn
    - `<` : Toán tử nhỏ hơn
    - `>=` : Toán tử lớn hơn hoặc bằng
    - `<=` : Toán tử nhỏ hơn hoặc bằng
```php
$x = 5;
$y = 10;
var_dump($x == $y);   // false
var_dump($x != $y);   // true
var_dump($x < $y);    // true
var_dump($x <= $y);   // true
var_dump($x > $y);    // false
var_dump($x >= $y);   // false
```
- Toán tử logic:
    - `&&` : Toán tử AND
    - `||` : Toán tử OR
    - `!` : Toán tử NOT
```php
$a = true;
$b = false;
var_dump($a && $b); // false
var_dump($a || $b); // true
var_dump(!$a);      // false
```
