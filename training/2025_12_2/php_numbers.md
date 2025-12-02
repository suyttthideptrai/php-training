# Số trong PHP

## Các kiểu số trong PHP
- Kiểu số nguyên (Integer)
- Kiểu số thực (Float)
- Số dạng chuỗi (String)

## Ngoài ra còn có 2 dạng giá trị của số
- Infinity (vô cực)
- NaN (Not a Number - không phải số)


## Các hàm check
- `is_float($var)` : Kiểm tra biến có phải kiểu số thực hay không
- `is_infinite($var)` : Kiểm tra biến có phải vô cực hay không
- `is_nan($var)` : Kiểm tra biến có phải NaN hay không
- `is_numeric($var)` : Kiểm tra biến có phải kiểu số hay không (bao gồm cả số dạng chuỗi)
- Ví dụ minh họa
```php
$int_num = 42; // Số nguyên
$float_num = 3.14; // Số thực
$string_num = "12345"; // Số dạng chuỗi
$infinity_num = INF; // Vô cực
$nan_num = NAN; // Not a Number
var_dump(is_float($float_num)); // true
var_dump(is_infinite($infinity_num)); // true
var_dump(is_nan($nan_num)); // true
var_dump(is_numeric($string_num)); // true
var_dump(is_numeric($int_num)); // true
var_dump(is_numeric($float_num)); // true
var_dump(is_float($int_num)); // false
```


## Ép kiểu từ string sang số
- Sử dụng `(int)` hoặc `(float)` để ép kiểu
- Ví dụ:
```php
$string_num1 = "100";
$string_num2 = "3.14abc";
$int_num = (int)$string_num1; // Kết quả: 100 (kiểu int)
$float_num = (float)$string_num2; // Kết quả: 3.
echo $int_num;
echo "<br>";
echo $float_num;
```