<?php
base_require('config.php');
base_require('utils.php');


class PageContent {

    private $content;
    private $content_source;
    private $content_type;

    public function __construct($content, $content_source, $content_type) {
        $this->content = $content;
        $this->content_source = $content_source;
        $this->content_type = $content_type;
    }

    public function get_content() {
        return $this->content;
    }

    public function get_content_source() {
        return $this->content_source;
    }

    public function get_content_type() {
        return $this->content_type;
    }

    public function has_content_source() {
        return !empty($this->content_source);
    }

}

class ContentBuilder
{

    private static $instance = null;
    private static $base_content_path = 'contents';
    /** page_uri -> PageContent */
    private $cache_map = [];
    /** page_uri -> md5 */
    private $hash_map = [];

    private function __construct()
    {
        $this->clear_cache();
    }

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function clear_cache()
    {
        $this->cache_map = [];
        $this->hash_map  = [];
    }

    public static function get_ext($path) {
        return StringUtils::get_file_extension($path);
    }

    public static function get_relative_path($full_path) {
        $base_content_path = base_path(self::$base_content_path);
        $relative_path = str_replace($base_content_path . DIRECTORY_SEPARATOR, '', $full_path);
        $relative_path = str_replace(DIRECTORY_SEPARATOR, '/', $relative_path);
        return $relative_path;
    }

    public function get_content($path): ?PageContent{
        if (!is_file($path)) {
            return null;
        }
        $Config = new Config();
        $ext = self::get_ext($path);
        if (in_array($ext, $Config->SUPPORTED_CONTENT_TYPES) === false) {
            return null;
        }
        switch ($ext) {
            case 'md':
                if (str_contains($path, 'test_markdown_html_parser')) {
                    return $this->get_markdown_content($path, true);
                }
                return $this->get_markdown_content($path, false);
            case 'php':
                return $this->get_php_content($path);
            default:
                return null;
        }
    }

    private function get_markdown_content($path, $isDebug): PageContent
    {
        $source = file_get_contents($path);
        if ($source === false) {
            return new PageContent("Error loading content from $path", '', 'md');
        }
        $content = self::render_markdown($source, $isDebug);
        return new PageContent($content, $source, 'md');
    }

    private function get_php_content($path): PageContent
    {
        $source = file_get_contents($path);
        if ($source === false) {
            return new PageContent("Error loading content from $path", '', 'md');
        }
        $relative_path = self::get_relative_path($path);
        return new PageContent($relative_path, $source, 'md');
    }



    /**
     * Chuyển đổi markdown sang HTML, với khả năng thực thi code PHP nhúng
     */
    public static function render_markdown($text, $isDebug = false): string
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
}