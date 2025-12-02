# Biến trong PHP

### Khai báo biến
- Biến trong PHP được khai báo bằng ký tự `$` theo sau là tên biến
```php
$ten_bien = "Gia tri bien";
$name = "ThanhNT";
$age = 22;
```

### In ra giá trị biến
- Sử dụng `echo` để in ra giá trị biến
```php
$name = "ThanhNT";
$age = 22;
echo "Tên là: " . $name . ", " . $age . " tuổi.";
```

### Kiểu dữ liệu PHP
- Trong PHP không cần thiết phải khai báo kiểu dữ liệu cho biến
- PHP sẽ tự động xác định kiểu dữ liệu dựa trên giá trị được gán cho
- Ở PHP 7 đã cập nhật khai báo kiểu dữ liệu, có một option mới là `declare(strict_types=1);` để bắt buộc kiểu dữ liệu



### PHP hỗ trợ các kiểu dữ liệu sau:
- String
- Integer
- Float (hay còn gọi là double)
- Boolean
- Array
- Object
- NULL
- Resource

### Có thể sử dụng `var_dump()` để kiểm tra kiểu dữ liệu và giá trị của biến
- Ví dụ:
```php
$age = 22;
$name = "ThanhNT";
$score = 8.5;
$hobby = ['Games', 'Coding'];
$mariage_status = null;
$is_super_man = false;
var_dump($age);
var_dump($name);
var_dump($score);
var_dump($hobby);
var_dump($mariage_status);
var_dump($is_super_man);
```

### Assign nhiều biến cùng một giá trị
- Có thể gán cùng một giá trị cho nhiều biến trong một câu lệnh
- Ví dụ:
```php
$a = $b = $c = 'hello';
echo $a; // hello
echo $b; // hello
echo $c; // hello
```


# Phạm vi biến trong PHP

### Các loại phạm vi Biến
- Biến cục bộ (Local Variable)
- Biến toàn cục (Global Variable)
- Biến tĩnh (Static Variable)


### Biến cục bộ và Biến toàn cục

```php
$x = 5;

function myTest() {
  // Không tham chiếu được
  echo "<p>Variable x inside function is: " . $x . "</p>";
}
myTest();

echo "<p>Variable x outside function is: " . $x . "</p>";
```

- Để tham chiếu được phải sử dụng từ khoá `global`
```php
$x = 5;
$y = 10;
function myTest() {
    // Tham chiếu qua từ khóa global
    global $x, $y;
    $y = $x + $y;
}
myTest();
echo $y; // outputs 15
```

- Còn có cách khác để tham chiếu biến global sử dụng `$GLOBALS` array
```php
$x = 5;
$y = 10;
function myTest() {
  $GLOBALS['y'] = $GLOBALS['x'] + $GLOBALS['y'];
}
myTest();
echo $y; // outputs 15
```

### Từ khóa `static`

- Từ khóa `static` được sử dụng để khai báo biến tĩnh trong một hàm
- Biến tĩnh giữ giá trị của nó giữa các lần gọi hàm
```php
function myTest() {
  static $count = 0;
  $count++;
  echo "<p>Function called " . $count . " times</p>";
}
myTest();
myTest();
myTest();
myTest();
myTest();
```