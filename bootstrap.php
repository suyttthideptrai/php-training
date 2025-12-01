<?php
/**
 * Code được viết bởi claude. Mục đích để đơn giản hoá việc import
 */

// bootstrap.php
// Centralized project bootstrap for simple, predictable imports.
// Usage:
//  - In entry scripts: require_once __DIR__ . '/bootstrap.php';
//  - In nested scripts: require_once dirname(__DIR__, N) . '/bootstrap.php';
// Then use base_require('path/from/project/root.php') to require files.
// @Tìm hiểu: Định nghĩa đường dẫn gốc của project
if (!defined('BASE_DIR')) {
    define('BASE_DIR', __DIR__);
}

/**
 * Return an absolute path inside the project from a path relative to project root.
 * @Tìm hiểu: Chèn BASE_DIR vào đường dẫn relative
 */
function base_path(string $relative = ''): string
{
    return BASE_DIR . '/' . ltrim($relative, '/');
}

/**
 * Require a file relative to project root.
 * Throws a RuntimeException if the file does not exist to make errors obvious.
 * @Tìm hiểu: Import code sử dụng Absolute path, check file tồn tại trước khi require
 */
function base_require(string $relative)
{
    $file = base_path($relative);
    if (!file_exists($file)) {
        // Kí tự \ : là global namespace, khi dùng thì code hiểu là dùng RuntimeException
        // @Tìm hiểu: của php chứ không phải class RuntimeException nào khác trong namespace hiện tại
        throw new \RuntimeException("Required file not found: $file");
    }
    require_once $file;
}

// Add project root to include_path so plain `include 'something.php'` can work
// while still preferring explicit base_require usage.
// @Tìm hiểu: Giống set site-package như trong python
set_include_path(get_include_path() . PATH_SEPARATOR . BASE_DIR);

// Small, optional class autoloader that maps class names to files under project root.
// Useful if you later start adding namespaced classes as simple files.
// TODO: tìm hiểu ý nghĩa hàm này, tạm thời chưa sử dụng
spl_autoload_register(function ($class) {
    $file = BASE_DIR . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});
