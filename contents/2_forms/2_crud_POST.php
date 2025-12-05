<?php
require_once dirname(__DIR__, 2) . '/libs/CsvUtils.php';

$csv_file = BASE_DIR . '/persistence/form-data.csv';
$csv = new CsvUtils($csv_file);

// Ensure CSV file exists and has header
if (!file_exists($csv_file)) {
    file_put_contents($csv_file, "id,name,email,phone,age\n");
}

$action = $_POST['action'] ?? 'view';
$message = '';
$message_type = '';

// ==================== CREATE ====================
if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $age = trim($_POST['age'] ?? '');

    if ($name && $email) {
        $allRows = $csv->readAll();
        $nextId = (empty($allRows) ? 1 : max(array_column($allRows, 0)) + 1);
        
        $csv->appendRow([$nextId, $name, $email, $phone, $age]);
        $message = "✓ Record created successfully!";
        $message_type = 'success';
    } else {
        $message = "✗ Name and Email are required!";
        $message_type = 'danger';
    }
}

// ==================== UPDATE ====================
elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $age = trim($_POST['age'] ?? '');

    if ($id && $name && $email) {
        $updated = $csv->updateRow(['id' => $id], [$id, $name, $email, $phone, $age]);
        if ($updated > 0) {
            $message = "✓ Record updated successfully!";
            $message_type = 'success';
        } else {
            $message = "✗ Record not found!";
            $message_type = 'danger';
        }
    } else {
        $message = "✗ ID, Name and Email are required!";
        $message_type = 'danger';
    }
}

// ==================== DELETE ====================
elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['id'] ?? '');
    if ($id) {
        $deleted = $csv->deleteRow(['id' => $id]);
        if ($deleted > 0) {
            $message = "✓ Record deleted successfully!";
            $message_type = 'success';
        } else {
            $message = "✗ Record not found!";
            $message_type = 'danger';
        }
    } else {
        $message = "✗ ID is required!";
        $message_type = 'danger';
    }
}

// ==================== DELETE ALL ====================
elseif ($action === 'truncate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirm = $_POST['confirm'] ?? '';
    if ($confirm === 'yes') {
        $csv->deleteAll();
        $message = "✓ All records deleted successfully!";
        $message_type = 'success';
    } else {
        $message = "✗ Truncate cancelled!";
        $message_type = 'warning';
    }
}

// Fetch all rows for display
$allRows = $csv->readAll();
$header = $csv->readHeader();
?>

<style>
    .container-fluid {
        max-width: 1200px;
        margin: 0 auto;
    }
    .form-section {
        background-color: #f8f9fa;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    .table-section {
        background-color: #fff;
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .btn-group-action {
        display: flex;
        gap: 0.5rem;
    }
    .message-alert {
        margin-bottom: 1.5rem;
    }
    .table {
        margin-bottom: 0;
    }
    .table thead {
        background-color: #2674c2;
        color: white;
    }
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
</style>

<div class="container-fluid">
    <h1>📋 CRUD Demo - Form Data Management</h1>
    <p class="text-muted">Manipulating <code><?php echo htmlspecialchars($csv_file); ?></code></p>

    <!-- Message Alert -->
    <?php if ($message): ?>
        <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> message-alert" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Create Form -->
        <div class="col-lg-6">
            <div class="form-section">
                <h3>➕ Create New Record</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    
                    <div class="form-group">
                        <label for="create_name">Name *</label>
                        <input type="text" class="form-control" id="create_name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="create_email">Email *</label>
                        <input type="email" class="form-control" id="create_email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="create_phone">Phone</label>
                        <input type="tel" class="form-control" id="create_phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="create_age">Age</label>
                        <input type="number" class="form-control" id="create_age" name="age" min="0">
                    </div>
                    
                    <button type="submit" class="btn btn-success">Create Record</button>
                </form>
            </div>
        </div>

        <!-- Update Form -->
        <div class="col-lg-6">
            <div class="form-section">
                <h3>✏️ Update Record</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="update">
                    
                    <div class="form-group">
                        <label for="update_id">Record ID *</label>
                        <input type="number" class="form-control" id="update_id" name="id" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_name">Name *</label>
                        <input type="text" class="form-control" id="update_name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_email">Email *</label>
                        <input type="email" class="form-control" id="update_email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="update_phone">Phone</label>
                        <input type="tel" class="form-control" id="update_phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="update_age">Age</label>
                        <input type="number" class="form-control" id="update_age" name="age" min="0">
                    </div>
                    
                    <button type="submit" class="btn btn-warning">Update Record</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Delete Form -->
        <div class="col-lg-6">
            <div class="form-section">
                <h3>🗑️ Delete Record</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="delete">
                    
                    <div class="form-group">
                        <label for="delete_id">Record ID *</label>
                        <input type="number" class="form-control" id="delete_id" name="id" required>
                    </div>
                    
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">
                        Delete Record
                    </button>
                </form>
            </div>
        </div>

        <!-- Truncate Form -->
        <div class="col-lg-6">
            <div class="form-section">
                <h3>⚠️ Truncate All Records</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="truncate">
                    
                    <div class="form-group">
                        <label for="confirm">Confirm Action *</label>
                        <select class="form-control" id="confirm" name="confirm" required>
                            <option value="">-- Select --</option>
                            <option value="yes">Yes, delete all records</option>
                            <option value="no">No, cancel</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-danger" onclick="return confirm('⚠️ This will delete ALL records! Are you absolutely sure?');">
                        Truncate All
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-section mt-4">
        <h3>📊 All Records (<?php echo count($allRows); ?> total)</h3>
        
        <?php if (empty($allRows)): ?>
            <div class="alert alert-info">No records found. Create a new record to get started!</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <?php foreach ($header as $col): ?>
                                <th><?php echo htmlspecialchars($col); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allRows as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td><?php echo htmlspecialchars($cell); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Usage Guide -->
    <div class="form-section mt-4">
        <h3>📖 Usage Guide</h3>
        <pre><code class="language-php"><?php echo htmlspecialchars(
'// Initialize CsvUtils
$csv = new CsvUtils("form-data.csv");

// READ: Get all rows
$rows = $csv->readAll();

// READ: Get header
$header = $csv->readHeader();

// READ: Get specific row by index
$row = $csv->readRow(0);

// CREATE: Append new row
$csv->appendRow([1, "John Doe", "john@example.com", "123456", "25"]);

// UPDATE: By index
$csv->updateRow(0, [1, "Jane Doe", "jane@example.com", "654321", "26"]);

// UPDATE: By query (match criteria)
$csv->updateRow(
    ["id" => "1"],
    [1, "Updated Name", "updated@example.com", "999999", "30"]
);

// DELETE: By query criteria
$csv->deleteRow(["id" => "1"]);

// DELETE: By index
$csv->deleteRow(1);

// TRUNCATE: Delete all rows (keeps header)
$csv->deleteAll();
'
        ); ?></code></pre>
    </div>
</div>
