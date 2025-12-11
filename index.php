<?php
require 'config.php';

// CREATE
if ($_POST['action'] == 'create') {
    $stmt = $pdo->prepare("INSERT INTO employees (name, email, position, salary) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['position'], $_POST['salary']]);
}

// READ
$employees = $pdo->query("SELECT * FROM employees ORDER BY created_at DESC")->fetchAll();

// UPDATE/DELETE via GET
if ($_GET['delete']) {
    $stmt = $pdo->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee CRUD Demo - PHP Heroku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h1 class="text-primary mb-4">👥 Employee Management System</h1>
        
        <!-- ADD FORM -->
        <div class="card mb-4">
            <div class="card-body">
                <h5>Add Employee</h5>
                <form method="POST">
                    <input type="hidden" name="action" value="create">
                    <div class="row">
                        <div class="col-md-3"><input name="name" class="form-control" placeholder="Name" required></div>
                        <div class="col-md-3"><input name="email" type="email" class="form-control" placeholder="Email" required></div>
                        <div class="col-md-2"><input name="position" class="form-control" placeholder="Position" required></div>
                        <div class="col-md-2"><input name="salary" type="number" class="form-control" placeholder="Salary" required></div>
                        <div class="col-md-2"><button class="btn btn-success w-100">Add</button></div>
                    </div>
                </form>
            </div>
        </div>

        <!-- LIST -->
        <div class="card">
            <div class="card-header">
                <h5>📋 Employees (<?=count($employees)?>)</h5>
            </div>
            <div class="card-body">
                <?php if (empty($employees)): ?>
                    <p class="text-muted">No employees yet. Add one above!</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th><th>Name</th><th>Email</th><th>Position</th><th>Salary</th><th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employees as $emp): ?>
                                <tr>
                                    <td><?=$emp['id']?></td>
                                    <td><strong><?=$emp['name']?></strong></td>
                                    <td><?=$emp['email']?></td>
                                    <td><span class="badge bg-primary"><?=$emp['position']?></span></td>
                                    <td>Rp <?=number_format($emp['salary'],0,',','.')?></td>
                                    <td>
                                        <a href="?delete=<?=$emp['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
</html>
