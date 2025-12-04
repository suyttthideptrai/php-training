<?php
require_once 'utils.php';
require_once 'bootstrap.php';

$SUPPORTED_CONTENT_EXTENSIONS = ['md', 'php'];

// List all markdown files under /content

$base_dir = base_path('contents');
$nav_data = ContentUtils::get_navigation_data($base_dir, $SUPPORTED_CONTENT_EXTENSIONS);
// print_debug($nav_data); die;
// $files = glob($base_dir . '/**/*.md');
// foreach ($files as $key => $file) {
//     $normalized = str_replace($base_dir, '', $file);
//     $normalized = str_replace('.md', '', $normalized);
//     $files[$key] = $normalized;
// }


// Content resolve
$CONTENT_TYPE = '';
$page = $_GET['f'] ?? '';
if (empty($page)) {
    $page = '/home.md'; // default page
}
if (StringUtils::get_file_extension($page) === 'php') {
    $CONTENT_TYPE = 'php';
} else {
    $CONTENT_TYPE = 'md';
}

$page_dir = $base_dir . '/' . $page;
$source = '';
try {
  $source = file_get_contents($page_dir);
} catch (Exception $e) {
  echo "<script>allert('" . "Error loading content: . $e->getMessage() " . "');</script>";
}
$html_source = htmlspecialchars($source, ENT_QUOTES, 'UTF-8');

?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="dark"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/assets/css/bootstrap5.0.2.min.css">
  <link rel="stylesheet" href="/public/assets/css/hightlightjs.default.min.css">
  <title>Training PHP</title>
    <style>
    body {
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 26vw;
      background-color: #2674c2ff;
      color: #fff;
      flex-shrink: 0;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
      text-decoration: none;
    }
    #page-content {
      flex-grow: 1;
      padding: 2.5rem;
      overflow-y: scroll;
    }
    #page-content-source {
      flex-grow: 1;
      padding: 2.5rem;
      overflow-y: scroll;
    }
    pre code.no-lint {
      background-color: #01101fff;
      color: #37d108ff;
      display: block;
      padding: 1rem;
      border-radius: 0.25rem;
    }
    pre code.language-php {
      display: block;
      padding: 1rem;
      border-radius: 0.25rem;
      border: 2px solid #2f619dff;
    }
  </style>
</head>
<body>
  <!-- BEGIN RENDER NAV SIDEBAR -->
  <div class="sidebar d-flex flex-column p-3">
      <a href="/">
          <h3>PHP Training Notebook</h3>
      </a>
      <ul class="list-unstyled">
      <?php foreach ($nav_data as $folder => $items): ?>
          <li>
              <div class="d-flex align-items-center gap-2">
                <img src="/public/assets/icon/folder-icon.png" alt="Folder" width="18" height="18" />
                <p class="mb-0">
                  <?php echo htmlspecialchars($folder); ?>
                </p>
              </div>
              <ul>
                  <?php foreach ($items as $file): ?>
                      <li class="d-flex align-items-center gap-2">
                          <!-- BEGIN ICON -->
                          <?php if (str_ends_with($file['path'], '.md')): ?>
                            <img src="/public/assets/icon/md-icon.png" alt="Markdown" width="24" height="24" />
                          <?php elseif (str_ends_with($file['path'], '.php')): ?>
                            <img src="/public/assets/icon/php-icon.png" alt="PHP" width="24" height="24" />
                          <?php else: ?>
                            <img src="/public/assets/icon/fallback-icon.png" alt="Fallback" width="24" height="24" />
                          <?php endif; ?>
                          <!-- END ICON -->
                          <a href="<?php echo '/index.php?f=' . $file['path']; ?>">
                              <?php echo htmlspecialchars($file['label']); ?>
                          </a>
                      </li>
                  <?php endforeach; ?>
              </ul>
          </li>
      <?php endforeach; ?>
      </ul>
  </div>
  <!-- END RENDER NAV SIDEBAR -->

  <!-- TOGGLE SHOW SOURCE BUTTON FOR MD -->
    <div  id="toggle-show-source"
          class="btn btn-secondary"
          style="position: fixed; top: 1rem; right: 1rem; z-index: 1000;"
          onclick="{
            const content = document.getElementById('page-content');
            const source = document.getElementById('page-content-source');
            if (source.style.display === 'none') {
                source.style.display = 'block';
                content.style.display = 'none';
            } else {
                source.style.display = 'none';
                content.style.display = 'block';
            }
          }"
    >
        Ẩn hiện source code
    </div>
  <!-- TOGGLE SHOW SOURCE BUTTON FOR MD -->

  <!-- BEGIN SOURCE -->
  <div id="page-content-source" style="display: none;"><?php echo HtmlUtils::wrapCode($html_source, true); ?></div>
  <!-- END SOURCE -->

  <!-- BEGIN CONTENT -->
  <div id="page-content" class="h-100">
    <!-- CONTENT TYPE MARKDOWN -->
    <?php if ($CONTENT_TYPE === 'md'): ?>
      <?php if (str_contains($page, 'test_markdown_html_parser')) {
          echo "<h2>Debug Markdown Parser</h2>";
          echo markdown($source, true);
      } else {
          echo markdown($source);
      }
      ?>
    <!-- CONTENT TYPE PHP -->
    <?php elseif ($CONTENT_TYPE === 'php'): ?>
      <?php
      // Thực thi file PHP và hiển thị kết quả
      $page_dir = base_path('contents/' . $page);
      include $page_dir;
      ?>
    <!-- CONTENT TYPE UNKNOWN -->
    <?php else: ?>
      <p>Unsupported content type.</p>
    <?php endif; ?>

  <!-- END CONTENT -->
  </div>
  <script src="/public/assets/js/highlightjs.min.js"></script>
  <script>
      document.addEventListener('DOMContentLoaded', (event) => {
          // Chỉ highlight thẻ có class language-php
          document.querySelectorAll('pre code.language-php').forEach((block) => {
          hljs.highlightElement(block);
          });
      });
  </script>
</body>
</html>