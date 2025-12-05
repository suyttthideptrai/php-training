# If, Else, ElseIf trong PHP

### DEMO
```php
$a = 10;
$b = 20;
$c = 30;

if (($a + $b) > $c) {
    echo "Tổng của a và b lớn hơn c";
} elseif (($a + $b) == $c) {
    echo "Tổng của a và b bằng c";
} else {
    echo "Tổng của a và b nhỏ hơn c";
}
```


### If Operators

- If opperators được sử dụng để kiểm tra một điều kiện cụ thể. Nếu điều kiện đúng (true), khối mã bên trong if sẽ được thực thi.
- Sử dụng các toán tử so sánh như: `==`, `===`, `!=`, `!==`, `>`, `<`, `>=`, `<=` để so sánh các giá trị và trả về kết quả `boolean`.
```php
$age = 16;
if ($age < 18) {
    echo "Nhóc";
}
```

### `If` / `if else` shorts
- Cú pháp rút gọn của `If` / `if else`
```php
// If short
$age = 16;
if ($age < 18) echo "Nhóc"; echo "<br>";

// if else short
$age = 20;
if ($age < 18) echo "Nhóc"; echo "<br>";

// else if short
($age < 18) ? print "Nhóc" : print "500K một nháy";
```