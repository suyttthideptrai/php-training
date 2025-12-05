# Các kiểu dữ liệu trong PHP


## PHP hỗ trợ các kiểu dữ liệu chính sau đây:
- String
- Integer
- Float (floating point numbers - also called double)
- Boolean
- Array
- Object
- NULL
- Resource

### String
- Chuỗi là một dãy các ký tự được bao quanh bởi dấu nháy đơn (' ') hoặc nháy kép (" ")
- Ví dụ:
```php
$name1 = 'ThanhNT'; // Sử dụng nháy đơn
$name2 = "ThanhNT"; // Sử dụng nháy kép
```

### Integer
- Số nguyên là các số không có phần thập phân
- Ví dụ:
```php
$age = 22;
$year = 2025;
```

### Float
- Số thực là các số có phần thập phân
- Ví dụ:
```php
$score = 8.5;
$price = 199.99;
```

### Boolean
- Kiểu boolean chỉ có hai giá trị: true (đúng) và false (sai)
- Ví dụ:
```php
$is_student = true;
$is_graduated = false;
```

### Sử dụng `var_dump()` để kiểm tra kiểu dữ liệu và giá trị của biến
- Ví dụ:
```php
$age = 22;
$name = "ThanhNT";
$score = 8.5;
$hobby = ['Games', 'Coding'];
$mariage_status = null;
$is_super_man = false;
```
```php
var_dump($age);
var_dump($name);
var_dump($score);
var_dump($hobby);
var_dump($mariage_status);
var_dump($is_super_man);
```

### Object
```php
class Person {
    public $name;
    public $age;
    function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
}
$person = new Person("ThanhNT", 22);
var_dump($person);
```

### NULL
- Kiểu NULL chỉ có một giá trị duy nhất là NULL, biểu thị rằng biến không
- Ví dụ:
```php
$mariage_status = null;
var_dump($mariage_status);
```

### Array
- Mảng là một tập hợp các giá trị được lưu trữ dưới một tên biến duy nhất
- Ví dụ:
```php
$hobby = ['Games', 'Coding', 'Reading'];
var_dump($hobby);
$data = array(1, 'aa', 3.5, true, null);
var_dump($data);
```