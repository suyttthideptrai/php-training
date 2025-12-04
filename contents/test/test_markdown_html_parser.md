### Break và Continue
```php
$inventory = ["Trà sữa", "Methanphetamine", "Cà phê", "Nước sướng", "Trà mạn", "Tem lưỡi", "Thuốc lá", "Rượu", "Codeine", "Thuốc lào"];
$black_list_items = ["Methanphetamine", "Tem lưỡi", "Codeine"];
$query_item = "Nước sướng";
echo "Kiểm tra " . $query_item . " trong kho hàng...<br>";
foreach ($inventory as $item) {
    if (in_array($item, $black_list_items)) {
        echo "Á à: " . $item . "<br>";
        continue;
    }
    if ($item === $query_item) {
        echo "Đã tìm thấy" . $query_item ", dừng kiểm tra thêm.<br>";
        break;
    }
}
```