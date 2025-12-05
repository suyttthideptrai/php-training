<?php

/**
 * ContentManager quản lý nội dung của ứng dụng
 */
class ContentManager {

    // Singleton instance
    private static $instance = null;

    private $base_content_path;
    private $relative_content_path;
    private $supported_content_types;
    private $navigation_data;
    private $is_navigation_initialized = false;


    private function __construct($base_content_path, $supported_content_types) {
        if (!is_array($supported_content_types) || count($supported_content_types) === 0) {
            throw new InvalidArgumentException("Supported content types must be a non-empty array");
        }
        $this->supported_content_types = $supported_content_types;
        if ($base_content_path === null || $base_content_path === '') {
            throw new InvalidArgumentException("Base content path cannot be null or empty");
        }
        $this->base_content_path = $base_content_path;
        if (is_dir($base_content_path)) {
            $this->relative_content_path = str_replace(base_path(), '', $base_content_path);
        } else {
            throw new InvalidArgumentException("Base content path is not a valid directory: $base_content_path");
        }
        // print_debug(base_path());
        // print_debug($this->base_content_path);
        // print_debug($this->relative_content_path);
        // print_debug($this->supported_content_types);
        // print_debug('---');
        $this->init_navigation_data();
        // print_debug($this->get_navigation_data());
    }

    // Method lấy instance duy nhất
    public static function get_instance($base_content_path, $supported_content_types) {
        if (self::$instance === null) {
            self::$instance = new self($base_content_path, $supported_content_types);
        }
        return self::$instance;
    }

    public function get_base_content_path() {
        return $this->base_content_path;
    }

    public function get_supported_content_types() {
        return $this->supported_content_types;
    }

    private function init_navigation_data() {
        // 1. Find all markdown files inside the folder (including subfolders)
        $files = [];
        foreach ($this->supported_content_types as $ext) {
            // TODO: Not optimized, can be improved later
            $pattern = $this->relative_content_path . '/**/*.' . $ext;
            $found_files = glob($pattern, GLOB_BRACE);
            $files = array_merge($files, $found_files);
        }

        // Custom sort function for file and folder sorting
        usort($files, function($a, $b) {
            // Extract folder numbers: "1_basic", "2_test" → 1, 2
            preg_match('#/' . $this->relative_content_path . '/(\d+)_#', $a, $ma);
            preg_match('#/' . $this->relative_content_path . '/(\d+)_#', $b, $mb);
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
            $relativePath = str_replace($this->relative_content_path . '/', '', $filePath);

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

        // 4. Store the final structured navigation
        $this->navigation_data = $tree;
        $this->is_navigation_initialized = true;
        
        return $tree;
    }


    public function get_navigation_data() {
        if (!$this->is_navigation_initialized) {
            $this->init_navigation_data();
        }
        return $this->navigation_data;
    }


}