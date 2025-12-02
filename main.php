<?php
require_once 'utils.php';
require_once 'bootstrap.php';

// List all markdown files under /training

$base_dir = base_path('training');
$files = glob($base_dir . '/**/*.md');
foreach ($files as $key => $file) {
    $normalized = str_replace($base_dir, '', $file);
    $normalized = str_replace('.md', '', $normalized);
    $files[$key] = $normalized;
}

// Get markdown resource to render

$page = $_GET['f'] ?? '';
if (empty($page)) {
    $page = '/home'; // default page
}
$page_dir = $base_dir . $page . '.md';

$source = file_get_contents($page_dir);
$html_source = htmlspecialchars($source, ENT_QUOTES, 'UTF-8');

?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="dark"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
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
<div class="sidebar d-flex flex-column p-3">
    <a href="/">
        <h3>Training PHP Navigation</h3>
    </a>
    <ul>
      <?php foreach ($files as $file): ?>
          <li>
              <a href="<?php echo '/index.php?f=' . $file; ?>">
                  <?php echo $file; ?>
              </a>
          </li>
      <?php endforeach; ?>
    </ul>
</div>
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

    <!-- BEGIN SOURCE -->
    <div id="page-content-source" style="display: none;"><?php echo HtmlUtils::wrapCode($html_source, true); ?></div>
    <!-- END SOURCE -->

    <!-- BEGIN CONTENT -->
    <div id="page-content" class="h-100">

    <?php if (str_contains($page, 'test_markdown_html_parser')) {
        echo "<h2>Debug Markdown Parser</h2>";
        echo markdown($source, true);
    } else {
        echo markdown($source);
    }
    ?>

    <!-- END CONTENT -->
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
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