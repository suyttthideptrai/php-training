# Các hàm math common trong PHP

- Sử dụng hàm `abs()` để lấy giá trị tuyệt đối
- Sử dụng hàm `ceil()` để làm tròn lên
- Sử dụng hàm `floor()` để làm tròn xuống
- Sử dụng hàm `round()` để làm tròn số
- Sử dụng hàm `max()` để lấy giá trị lớn nhất trong một tập hợp
- Sử dụng hàm `min()` để lấy giá trị nhỏ nhất trong một tập hợp
- Sử dụng hàm `pow()` để tính lũy thừa
- Sử dụng hàm `sqrt()` để tính căn bậc hai
- Sử dụng hàm `rand()` để tạo số ngẫu nhiên

```php
$number = -4.7;
var_dump(abs($number));    // outputs 4.7
var_dump(ceil($number));   // outputs -4
var_dump(floor($number));  // outputs -5
var_dump(round($number));  // outputs -5
var_dump(max(1, 3, 2));    // outputs 3
var_dump(min(1, 3, 2));    // outputs 1
var_dump(pow(2, 3));       // outputs 8
var_dump(sqrt(16));        // outputs 4
var_dump(rand(1, 100));    // outputs a random number between 1 and 100
```