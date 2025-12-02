# Ép kiểu

```php
$a = 5;       // Integer
$b = 5.34;    // Float
$c = "hello"; // String
$d = true;    // Boolean
$e = NULL;    // NULL

$a = (string) $a;
$b = (string) $b;
$c = (string) $c;
$d = (string) $d;
$e = (string) $e;

var_dump($a);
var_dump($b);
var_dump($c);
var_dump($d);
var_dump($e);
```

## Các kiểu ép
- `(int)` hoặc `(integer)` : Ép kiểu sang số nguyên
- `(float)` hoặc `(double)` hoặc `(real)` : Ép kiểu sang số thực
- `(string)` : Ép kiểu sang chuỗi
- `(bool)` hoặc `(boolean)` : Ép kiểu sang boolean
- `(array)` : Ép kiểu sang mảng
- `(object)` : Ép kiểu sang đối tượng
- `(unset)` : Hủy biến (biến sẽ có giá trị NULL)
