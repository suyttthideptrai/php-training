## Mảng đa chiều

### 2 Chiều
```php
function printData($data) {
    $format = "| %3d | %-15s | %-6s | %-3d |<br>";
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
]
printData($csv_value);
```