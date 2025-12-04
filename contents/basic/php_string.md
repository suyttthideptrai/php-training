# Chuỗi trong PHP

### Khai báo
- Sử dụng dấu nháy đơn `'` hoặc dấu nháy kép `"` để khai báo chuỗi
```php
$string1 = 'Đây là chuỗi sử dụng dấu nháy đơn';
$string2 = "Đây là chuỗi sử dụng dấu nháy kép";
```

### Check độ dài
- Sử dụng hàm `strlen()` để kiểm tra độ dài của chuỗi
```php
$string = "Hello, World!";
$length = strlen($string);
echo "Độ dài của chuỗi là: " . $length; // outputs 13
```

### Check số từ
- Sử dụng hàm `str_word_count()` để kiểm tra số từ trong chuỗi
```php
$string = "Hello, World! Welcome to PHP.";
$wordCount = str_word_count($string);
echo "Số từ trong chuỗi là: " . $wordCount;
```

### Tìm kiếm text trong chuỗi
- Sử dụng hàm `strpos()` để tìm vị trí của một chuỗi con trong chuỗi
```php
$string = "Hello, World!";
$position = strpos($string, "World");
echo "Vị trí của \'World\' trong chuỗi là: " . $position;
```

# Modify chuỗi

### Convert case
- Sử dụng hàm `strtolower()` và `strtoupper()` để chuyển đổi chuỗi thành chữ thường hoặc chữ hoa
```php
$string = "Hello, World!";
$lower = strtolower($string);
$upper = strtoupper($string);
echo "Chữ thường: " . $lower;
echo "Chữ hoa: " . $upper;
```

### Replace
- Sử dụng hàm `str_replace()` để thay thế một chuỗi con trong chuỗi
```php
$string = "Hello, World!";
$newString = str_replace("World", "PHP", $string);
echo $newString;
```

### Reverse chuỗi
- Sử dụng hàm `strrev()` để đảo ngược chuỗi
```php
$string = "Hello, World!";
$reversed = strrev($string);
echo $reversed;
```

### Chuyển đổi str thành array
- Sử dụng hàm `str_split()` để chuyển đổi chuỗi thành mảng ký tự
- Sử dụng hàm `explode()` để chuyển đổi chuỗi thành mảng dựa trên ký tự phân tách
```php
$string = "Hello, World!";
$array1 = str_split($string);
$array2 = explode(", ", $string);
print_r($array1);
print_r($array2);
```

### trim
- Sử dụng hàm `trim()` để loại bỏ khoảng trắng thừa ở đầu và cuối chuỗi
```php
$string = "   Hello, World!   ";
$trimmed = trim($string);
echo "[" . $trimmed . "]";
```

### Ghép chuỗi
- Sử dụng toán tử `.` để ghép chuỗi
```php
$string1 = "Hello, ";
$string2 = "World!";
$combined = $string1 . $string2;
echo $combined;
```

- Ghép chuỗi với `.=`
```php
$message = "Hello";
$message .= ", World!";
echo $message;
```

### Slice
- Sử dụng hàm `substr()` để cắt một phần của chuỗi
```php
$string = "Hello, World!";
$part = substr($string, 7, 5); // Bắt đầu từ vị trí 7, lấy 5 ký tự
echo $part; // outputs World
```

- Cắt đến cuối chuỗi
```php
$string = "Hello, World!";
$part = substr($string, 7); // Bắt đầu từ vị trí 7 đến cuối chuỗi
echo $part; // outputs World!
```

- Cắt từ đầu chuỗi
```php
$string = "Hello, World!";
$part = substr($string, 0, 5); // Bắt đầu từ vị trí 0, lấy 5 ký tự
echo $part; // outputs Hello
```