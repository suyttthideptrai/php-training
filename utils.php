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

    public static function filename_to_sentence(string $str): str
    {
        // Loại bỏ phần mở rộng file
        $str = preg_replace('/\.[^.]+$/', '', $str);

        // Thay dấu gạch ngang và gạch dưới bằng dấu cách
        $str = str_replace(['-', '_'], ' ', $str);


        return $str;
    }

}


final class ContentUtils {


    public static function get_navigation_data(string $base_dir, $supported_ext): array
    {
        // 1. Find all markdown files inside the folder (including subfolders)
        // $files = [];
        // $iterator = new RecursiveIteratorIterator(
        //     new RecursiveDirectoryIterator($base_dir, RecursiveDirectoryIterator::SKIP_DOTS)
        // );
        // foreach ($iterator as $file) {
        //     if ($file->isFile()) {
        //         $ext = strtolower($file->getExtension());
        //         if (in_array($ext, $supported_ext, true)) {
        //             $files[] = $file->getPathname();
        //         }
        //     }
        // }
        // sort($files, SORT_STRING | SORT_FLAG_CASE);
        $files = [];
        foreach ($supported_ext as $ext) {
            // TODO: Not optimized, can be improved later
            $pattern = $base_dir . '/**/*.' . $ext;
            $found_files = glob($pattern, GLOB_BRACE);
            $files = array_merge($files, $found_files);
        }

        // Custom sort function for file and folder sorting
        usort($files, function($a, $b) {
            // Extract folder numbers: "1_basic", "2_test" → 1, 2
            preg_match('#/contents/(\d+)_#', $a, $ma);
            preg_match('#/contents/(\d+)_#', $b, $mb);
            $folderA = intval($ma[1] ?? 0);
            $folderB = intval($mb[1] ?? 0);

            // First: compare folder numbers
            if ($folderA !== $folderB) {
                return $folderA <=> $folderB;
            }

            // Same folder → extract the leading number from the basename
            $basenameA = basename($a);
            $basenameB = basename($b);

            preg_match('#^(\d+)_#', $basenameA, $fa);
            preg_match('#^(\d+)_#', $basenameB, $fb);
            
            $fileA = intval($fa[1] ?? PHP_INT_MAX); // Use large number if no match
            $fileB = intval($fb[1] ?? PHP_INT_MAX);
            
            return $fileA <=> $fileB;
        });

        // 2. This array will store the final nested navigation
        $tree = [];

        // 3. Process each file that was found
        foreach ($files as $filePath) {

            // -------------------------------
            // Step A: Convert the full path into a clean relative path
            // Example: "docs/guide/install.md" → "guide/install"
            // -------------------------------

            // Remove the base directory part (example: "docs/")
            $relativePath = str_replace($base_dir . '/', '', $filePath);

            // // Remove ".md" file extension
            // $relativePath = str_replace('.md', '', $relativePath);

            // -------------------------------
            // Step B: Split path into folder names and file name
            // Example: "guide/install" → ["guide", "install"]
            // -------------------------------
            $parts = explode('/', $relativePath);

            // Take the last part as the filename
            // Example: "install"
            $fileName = array_pop($parts);

            // -------------------------------
            // Step C: Walk through the folders and build nested arrays
            // -------------------------------

            // Start at the root of the tree
            $currentFolder = &$tree;

            // Loop through all folders in the path
            foreach ($parts as $folderName) {

                // If this folder does NOT exist yet, create it
                if (!isset($currentFolder[$folderName])) {
                    $currentFolder[$folderName] = [];
                }

                // Move deeper into that folder
                $currentFolder = &$currentFolder[$folderName];
            }

            // -------------------------------
            // Step D: Add the file name into the last folder
            // Example: $currentFolder[] = "install";
            // -------------------------------
            $nav_map = [
                'label' => $fileName,
                'path' => $relativePath
            ];
            $currentFolder[] = $nav_map;
        }

        // 4. Return the final structured navigation
        return $tree;
    }


}

function print_debug($var)
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}