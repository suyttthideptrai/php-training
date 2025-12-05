# Mảng

## Các kiểu mảng

### Mảng đơn giản
```php
$cars = array("Volvo", "BMW", "Toyota");
print_r($cars);
```

### Mảng nhiều kiểu dữ liệu
```php
$myFunction = function() {
    return "Hello!";
};
$myArr = array("Volvo", 15, ["apples", "bananas"], $myFunction);
print_r($myArr);
```

### Mảng kết hợp (associative array)
```php
$age = array("ThanhNT" => 25, "Quylaptrinh" => 22, "Suytthideptrai" => 30);
print_r($age);
```

-----


## Biển đổi mảng

### Cập nhật phần tử mảng
```php
$cars = array("Volvo", "BMW", "Toyota");
$cars[1] = "Mercedes";
foreach ($cars as $i => $car) {
    $cars[$i] = strtoupper($car);
}
print_r($cars);
```

### Thêm phần tử mảng
```php
$cars = array("Volvo", "BMW", "Toyota");
$cars[] = "Audi"; // Thêm vào cuối mảng
array_push($cars, "Ford"); // Thêm vào cuối mảng
array_unshift($cars, "Chevrolet"); // Thêm vào đầu mảng
print_r($cars);
```

### Xóa phần tử mảng
```php
function print_array_line($arr) {
    echo implode(", ", $arr) . "<br>";
}
$cars = array("Volvo", "BMW", "Toyota", "Audi");

unset($cars[1]); // Xóa phần tử có chỉ số 1
print_array_line($cars);

array_pop($cars); // Xóa phần tử cuối cùng
print_array_line($cars);

array_shift($cars); // Xóa phần tử đầu tiên
print_array_line($cars);
```

-----

## Sắp xếp mảng
```php
$cars = array("Volvo", "BMW", "Toyota", "Audi");

sort($cars); // Sắp xếp tăng dần
print_r($cars);

rsort($cars); // Sắp xếp giảm dần
print_r($cars);
```

#### Sắp xếp mảng assoc

##### Sắp xếp theo `key`
```php
$age = array("2. ThanhNT" => 25, "1. Quylaptrinh" => 22, "3. Suytthideptrai" => 30);

ksort($age); // Sắp xếp theo giá trị tăng dần
print_r($age);

krsort($age); // [Korea Sort :D] Sắp xếp theo giá trị giảm dần
print_r($age);
```

##### Sắp xếp theo `value`
```php
$age = array("2. ThanhNT" => 25, "1. Quylaptrinh" => 22, "3. Suytthideptrai" => 30);

asort($age); // Sắp xếp theo giá trị tăng dần
print_r($age);

arsort($age); // Sắp xếp theo giá trị giảm dần
print_r($age);
```

-----

## Mảng đa chiều

### 2 Chiều
```php
function printData($data) {
    $format = "| %3d | %-15s | %-6s | %-3s |<br>";
    printf($format, '#', 'Name', 'Sex', 'Age');
    foreach ($data as $i => $row) {
        printf($format, $i + 1, $row[0], $row[1], $row[2]);
    }
}
$csv_value = [
    // name          // sex.   // age
    ['ThanhNT'       , 'male'  , 20],  // A person
    ['Quylaptrinh'   , 'male'  , 21],
    ['Suytthideptrai', 'female', 22],
];
printData($csv_value);
```