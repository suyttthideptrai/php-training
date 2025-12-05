<?php
require_once __DIR__ . '/bootstrap.php';
base_require('/libs/Parsedown.php');  // Thư viện chuyển markdown sang HTML

/**
 * Utility class sử dụng để kiểm tra nền tảng OS hiện tại
 * Phát hiện bằng cách so sánh hằng DIRECTORY_SEPARATOR và PHP_OS_FAMILY
 */
final class PlatformUtils
{
    public static function isWindows(): bool
    {
        // khai báo kí tự \ trong string sử dụng \\
        return \DIRECTORY_SEPARATOR === '\\';
    }

    public static function isUnix(): bool
    {
        // Bao gồm Linux, macOS, BSD…
        return \DIRECTORY_SEPARATOR === '/';
    }

    public static function isMac(): bool
    {
        return \PHP_OS_FAMILY === 'Darwin';
    }

    public static function isLinux(): bool
    {
        return \PHP_OS_FAMILY === 'Linux';
    }

    public static function getFamily(): string
    {
        return \PHP_OS_FAMILY; // Windows, Linux, Darwin, BSD, Solaris
    }
}

/**
 * Utility class cho HTML Element
 */
final class HtmlUtils
{
    /**
     * Bọc code trong thẻ <pre><code no-lint>...</code></pre>
     */
    public static function wrapCode($elm, $isLint=false): string
    {
        if ($isLint)
        {
            return '<pre><code class="language-php">' . $elm . '</code></pre>';
        }
        else
        {
            return '<pre><code class="no-lint">' . $elm . '</code></pre>';
        }
    }

}

/**
 * Chuyển đổi markdown sang HTML, với khả năng thực thi code PHP nhúng
 */
function markdown($text, $isDebug = false)
{

    $CODE_DEL = '```';
    $EXECUTABLE = 'php';

    $Parsedown = new Parsedown();

    if (!str_contains($text, $CODE_DEL))
    {
        return $Parsedown->text($text);
    }

    $parts = explode($CODE_DEL, $text);
    if ($isDebug)
    {
        echo "<p>Debug: Found " . count($parts) . " parts split by '" . $CODE_DEL . "'</p>";
        echo "<pre>" . print_r($parts) . "</pre>";
    }
    $result = '';
    foreach ($parts as $index => $part)
    {

        // Execute code if it's executable PHP
        if (str_starts_with($parts[$index], $EXECUTABLE))
        {
            // Parse html
            $result .= $Parsedown->text($CODE_DEL . $parts[$index] . $CODE_DEL);

            // Execute PHP code
            $trimmed = trim($parts[$index]);
            $code = ltrim($trimmed, $EXECUTABLE);
            $code = trim($code);
            if (empty($code)) {
                continue;
            }
            $output = exec_use_current_php($code, $isDebug);
            $result .= HtmlUtils::wrapCode(implode('<br>', $output));
        } else
        {
            $result .= $Parsedown->text($parts[$index]);
        }
    }
    return $result;
}

/**
 * Thực thi đoạn code PHP sử dụng bin PHP hiện tại, giống subprocess trong Python
 */
function exec_use_current_php($cmd, $isDebug = false)
{
    $output = [];
    $returnCode = 0;
    $cmd = trim($cmd);

    // Loại bỏ comment dòng
    $cmd = preg_replace('/\/\/.*$/m', '', $cmd);

    if (PlatformUtils::isWindows())
    {
        // Windows: command wrapper sử dụng "
        // Escape " -> '
        $cmd = str_replace("\"", "'", $cmd);
        // Loại bỏ khoảng trống để exec code 1 line
        $cmd = preg_replace('/\r\n|\r|\n/', '', $cmd);
        $mergeCmd = "php -r \"$cmd\"";

    }
    if (PlatformUtils::isUnix())
    {
        // Unix: command wrapper sử dụng '
        // Escape ' -> "
        $cmd = str_replace("'", "\"", $cmd);
        $cmd = preg_replace('/\r\n|\r|\n/', '', $cmd);
        $mergeCmd = "php -r '$cmd'";
    }

    if ($isDebug)
    {
        echo "<p>Debug: Full command to execute: " . "<pre><code>" . htmlspecialchars($mergeCmd) . "</code></pre>" . "</p>";
    }
    exec($mergeCmd, $output, $returnCode);
    if ($isDebug)
    {
        echo "<p>Debug: Out: " . "<pre><code>" . implode('<br>', $output) . "</code></pre>" . "</p>";
    }

    if ($returnCode !== 0) {
        return ["Error executing code. Return code: $returnCode"];
    }
    return $output;
}


final class StringUtils {

    public static function get_file_extension(string $str): string
    {
        $parts = explode('.', $str);
        if (count($parts) < 2) {
            return ''; // Không có phần mở rộng
        }
        return end($parts);
    }

}

function print_debug($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}