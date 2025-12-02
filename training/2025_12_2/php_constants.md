# Các cách tạo constant trong PHP

### Sử dụng từ khoá `define()`
- Sử dụng hàm `define()` để tạo cconstant, tên constant thường viết hoa
```php
define("PI", 3.14);
echo PI; // 3.14
```

### Sử dụng từ khoá `const`
- Sử dụng từ khoá `const` để tạo constant
```php
const GRAVITY = 9.8;
echo GRAVITY; // 9.8
```

### So sánh `define()` và `const`
- `define()` có thể được sử dụng để tạo constant trong các cấu trúc điều khiển (if, loops)
- `const` chỉ có thể được sử dụng ở cấp độ lớp hoặc phạm vi toàn cục.