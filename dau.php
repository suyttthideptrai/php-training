<?php
require_once 'utils.php';
$base_dir = __DIR__;
$files = glob($base_dir . '/' . 'training' . '/**/*.php');
foreach ($files as $key => $file) {
    $files[$key] = str_replace($base_dir . '/', '', $file);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" class="dark"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    }
  </style>
</head>
<body>
<div class="sidebar d-flex flex-column p-3">
    <a href="/">
        <h3>Training PHP Navigation</h3>
    </a>
    <ul>
        <? foreach ($files as $file): ?>
            <li>
                <a href="<?php echo '/' . $file; ?>">
                <?php echo str_replace('training/', '', $file); ?>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
</div>
<!-- BEGIN CONTENT -->
<div id="page-content">
