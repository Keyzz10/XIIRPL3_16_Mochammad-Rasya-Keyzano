<?php /* Printable Users List - use browser Print > Save as PDF */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Export - PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
        body { padding: 24px; }
        h1 { font-size: 1.5rem; margin-bottom: 16px; }
        .meta { color: #6b7280; font-size: .9rem; margin-bottom: 16px; }
        table { font-size: .9rem; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
    </head>
<body>
    <div class="d-flex justify-content-between align-items-center no-print mb-3">
        <div>
            <h1 class="mb-0">Users Export</h1>
            <div class="meta">Generated at <?php echo date('Y-m-d H:i'); ?></div>
        </div>
        <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print me-2"></i>Print / Save as PDF</button>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Phone</th>
                <th>Last Login</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst(str_replace('_',' ', $user['role']))); ?></td>
                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_login']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html>


