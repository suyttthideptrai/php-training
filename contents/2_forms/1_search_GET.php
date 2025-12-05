<?php
$baseDir = BASE_DIR . DIRECTORY_SEPARATOR . 'contents';
$query = isset($_GET['q']) ? trim($_GET['q']) : ''; // echo $query; die;
$has_query = ($query !== '');

$results = [];

if ($has_query) {

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($it as $file) {
        if (!$file->isFile()) continue;

        $ext = strtolower($file->getExtension());
        if (!in_array($ext, ['md', 'php'])) continue;   // loại file cần tìm

        $path = $file->getPathname();
        $content = file_get_contents($path);

        // match tên file hoặc nội dung file
        if (stripos($path, $query) !== false || stripos($content, $query) !== false) {
            $path = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $path);
            $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
            $results[] = $path;
        }
    }
}
?>

<div class="container">
    <h2>Search Contents</h2>
    <div class="row justify-content-left">
        <div class="col-md-6">
            <form id="search-form" method="GET" class="d-flex">
                <div class="input-group">
                    <button class="btn btn-primary px-4" id="search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <input class="form-control form-control-lg"
                           type="text"
                           name="q"
                           value="<?php echo htmlspecialchars($query); ?>"
                           placeholder="Search file name or content..."
                           required
                           type="search"
                    />
                </div>
            </form>
        </div>
    </div>
    <?php if ($has_query): ?>
        <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
        <?php if (empty($results)): ?>
            <p>No results found.</p>
        <?php else: ?>
            <ul class="list-unstyled">
                <?php foreach ($results as $r): ?>
                    <li class="d-flex align-items-center gap-2">
                        <!-- BEGIN ICON -->
                            <?php if (str_ends_with($r, '.md')): ?>
                            <img src="/public/assets/icon/md-icon.png" alt="Markdown" width="24" height="24" />
                            <?php elseif (str_ends_with($r, '.php')): ?>
                            <img src="/public/assets/icon/php-icon.png" alt="PHP" width="24" height="24" />
                            <?php else: ?>
                            <img src="/public/assets/icon/fallback-icon.png" alt="Fallback" width="24" height="24" />
                            <?php endif; ?>
                        <!-- END ICON -->
                        <a href="<?php echo '/index.php?f=' . htmlspecialchars($r); ?>">
                            <?php echo htmlspecialchars($r); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('search-btn').addEventListener('click', function (event) {
        event.preventDefault();
        query = document.querySelector('input[name="q"]').value;
        query = query.trim();
        if (query === '') {
            alert('Please enter a search query.');
            return;
        }
        nav_url = new URL(window.location.href);
        nav_url.searchParams.delete("q");
        nav_url.searchParams.append("q", query);
        // alert(nav_url);
        window.location.href = nav_url; 
    });
</script>