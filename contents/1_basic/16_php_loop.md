# Loooop

### While
```php
$i = 1;
while ($i <= 5) {
    echo "Giá trị của i là: " . $i . "<br>";
    $i++;
}
```


### Do While
```php
$i = 1;
do {
    echo "Giá trị của i là: " . $i . "<br>";
    $i++;
} while ($i <= 5);
```

### For
```php
for ($i = 1; $i <= 5; $i++) {
    echo "Giá trị của i là: " . $i . "<br>";
}
```

### Foreach
```php
$fruits = array("Táo", "Chuối", "Cam");
foreach ($fruits as $fruit) {
    echo "Trái cây: " . $fruit . "<br>";
}
```

### Break và Continue
```php
$inventory = array("Trà sữa", "Methanphetamine", "Cà phê", "Nước sướng", "Trà mạn", "Tem lưỡi", "Thuốc lá", "Rượu", "Codeine", "Thuốc lào");
$black_list_items = array("Methanphetamine", "Tem lưỡi", "Codeine");
$query_item = "Nước sướng";
echo "Kiểm tra " . $query_item . " trong kho hàng...<br>";
foreach ($inventory as $item) {
    if (in_array($item, $black_list_items)) {
        echo "Á à: " . $item . "<br>";
        continue;
    }
    if ($item === $query_item) {
        echo "Đã tìm thấy " . $query_item . ", dừng kiểm tra thêm.<br>";
        break;
    }
}
```