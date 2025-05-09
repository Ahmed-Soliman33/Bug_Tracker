<?php
require_once '../Controllers/DBController.php';

// Existing code to fetch bug flow data...
$bug_id = $_GET['bug_id'] ?? null;
// ... (fetch bug details)

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Flow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Bug Flow for Bug #<?php echo htmlspecialchars($bug_id); ?></h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Error Category</th>
                    <th>Details</th>
                    <th>Print Screen</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Populate with bug data -->
            </tbody>
        </table>
        <?php include 'chat.php'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/chat.js"></script>
</body>

</html>