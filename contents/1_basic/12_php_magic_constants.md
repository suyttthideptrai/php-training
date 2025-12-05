# Magic Constants trong PHP

- PHP có một số magic constants đặc biệt cung cấp thông tin về vị trí mã nguồn hiện tại.
### Các Magic Constants phổ biến
- `__LINE__`: Trả về số dòng hiện tại trong tập tin mã nguồn.
- `__DIR__`: Trả về thư mục chứa tập tin mã nguồn hiện tại.
- `__FILE__`: Trả về đường dẫn đầy đủ và tên tập tin của tập tin mã nguồn hiện tại.
- `__FUNCTION__`: Trả về tên của hàm hiện tại.
- `__CLASS__`: Trả về tên của lớp hiện tại.
- `__METHOD__`: Trả về tên của phương thức hiện tại.
- `__NAMESPACE__`: Trả về tên của namespace hiện tại.
- `__TRAIT__`: Trả về tên của trait hiện tại.

### Ví dụ sử dụng Magic Constants
```php
function testFunction() {
    echo "This is line number: " . __LINE__ . "<br>";
    echo "This function is called: " . __FUNCTION__ . "<br>";
}
testFunction();
```