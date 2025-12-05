# So sánh `echo` và `print` trong PHP


| Đặc điểm                | `echo`             | `print`        |
| ----------------------- | ------------------ | -------------- |
| Kiểu                    | Từ khóa ngôn ngữ   | Hàm có giá trị |
| Số tham số              | Nhiều              | 1              |
| Trả về giá trị          | Không              | 1              |
| Hiệu năng               | Nhanh hơn          | Chậm hơn       |
| Sử dụng trong biểu thức | No                 | Yes            |

--------------------

- Ví dụ sử dụng `echo`
```php
echo "Hello, World!";
echo "<br>";
$result = echo "Hello again!"; // Lỗi cú pháp
```


- Ví dụ sử dụng `print`
```php
print "Hello, World!";
print "<br>";
$result = print "Hello again!";
echo "<br>";
echo "Giá trị trả về của print là: " . $result;
```