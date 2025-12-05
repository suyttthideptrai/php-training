# Function trong PHP

### Định nghĩa và gọi hàm
```php
function greet($name) {
    return "Xin chào, " . $name . "!<br>";
}
echo greet("ThanhNT");
echo greet("Quylaptrinh");
```


### Hàm với tham số mặc định
```php
function greet($name = "Khách") {
    return "Xin chào, " . $name . "!<br>";
echo greet();
echo greet("ThanhNT");
}
```


### Hàm với số lượng tham số không xác định
#### Đối với hàm có một tham số
```php
function sum(...$numbers) {
    $total = 0;
    foreach ($numbers as $number) {
        $total += $number;
    }
    return $total;
}
echo "Tổng: " . sum(1, 2, 3, 4, 5) . "<br>";
```
#### Đối với hàm có nhiều tham số (Tham số với số lượng không xác định phải là tham số cuối cùng)
```php
function introduce($greeting, ...$names) {
    $introduction = $greeting . " ";
    foreach ($names as $name) {
        $introduction .= $name . " ";
    }
    return trim($introduction) . "<br>";
}
echo introduce("Xin chào", "ThanhNT", "Quylaptrinh", "Suytthideptrai");
```


### Tham chiếu và tham trị

#### Tham trị
- Mặc định, các biến được truyền vào hàm theo kiểu tham trị, nghĩa là hàm sẽ copy giá trị của tham số vào trong hàm để xử lý
```php
function increment($value) {
    $value++;
}
$num = 5;
increment($num);
echo $num;
echo "<br>";
echo "$num không bị thay đổi vì tham trị.";
```

#### Tham chiếu
- Sử dụng ký tự `&` để truyền biến theo tham chiếu.
```php
function increment(&$value) {
    $value++;
}
$num = 5;
increment($num);
echo $num;
echo "<br>";
echo "$num bị thay đổi vì tham chiếu.";
```