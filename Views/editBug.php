<?php
require_once '../../Controllers/BugController.php';
require_once '../../Controllers/ProjectController.php';
require_once '../../Controllers/StaffController.php';
require_once '../../Models/Bug.php';


$errMsg = "";
$projects = [];
$allStaff = [];
$bugData = [];

// Load all necessary data
$projectController = new ProjectController;
$staffController = new StaffController;

$projects = $projectController->getAllProjects();
$allStaff = $staffController->getAllStaff();

// Check if editId is set
if (isset($_SESSION["editId"]) && !empty($_SESSION["editId"])) {
    $bugController = new BugController;
    $bugData = $bugController->getBugById($_SESSION["editId"]);
}

// Handle update form submission
if (
    isset($_POST['bug_name']) &&
    isset($_POST['details']) &&
    isset($_POST['status']) &&
    isset($_POST['priority']) &&
    isset($_SESSION["editId"])
) {
    if (
        !empty($_POST['bug_name']) &&
        !empty($_POST['details']) &&
        !empty($_POST['status']) &&
        !empty($_POST['priority'])
    ) {
        $bug = new Bug(
            $_POST['bug_name'],
            $bugData[0]['project_id'],
            $bugData[0]['category'],
            $_POST['details'],
            $_POST['assigned_to'],
            $_POST['status'],
            $_POST['priority']
        );

        $bugController = new BugController;
        $success = $bugController->updateBug($_SESSION["editId"], $bug);

        if ($success) {
            echo "<script>window.location.href = 'index.php?page=viewBugs';</script>";
            exit();
        }
    } else {
        $errMsg = "Please fill all required fields.";
    }
}
?>

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Bug</h3>
                <?php if (!empty($errMsg))
                    echo "<div class='alert alert-danger'>$errMsg</div>"; ?>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / Edit Bug</a></li>
                </ol>
            </div>
        </div>
    </div>

    <?php if ($bugData): ?>
        <div class="app-content">
            <div class="container-fluid">
                <div class="card card-info card-outline mb-4">
                    <form class="needs-validation" method="POST" action="index.php?page=editBug">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="bug_name" class="form-label">Bug Name</label>
                                    <input type="text" name="bug_name" class="form-control" id="bug_name"
                                        value="<?php echo $bugData[0]['bug_name'] ?>" required />
                                </div>

                                <div class="col-md-6">
                                    <label for="project_id" class="form-label">Project</label>
                                    <select disabled class="form-select" name="project_id" id="project_id">
                                        <?php foreach ($projects as $project): ?>
                                            <option value="<?= $project['project_id']; ?>"
                                                <?= $bugData[0]['project_id'] == $project['project_id'] ? 'selected' : ''; ?>>
                                                <?= $project['project_title']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select disabled class="form-select" name="category" id="category">
                                        <option value="web" <?= $bugData[0]['category'] == 'web' ? 'selected' : ''; ?>>Web
                                            Application</option>
                                        <option value="mobile" <?= $bugData[0]['category'] == 'mobile' ? 'selected' : ''; ?>>
                                            Mobile Application</option>
                                        <option value="desktop" <?= $bugData[0]['category'] == 'desktop' ? 'selected' : ''; ?>>
                                            Desktop Application</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="details" class="form-label">Details</label>
                                    <textarea name="details" class="form-control" id="details"
                                        required><?php echo $bugData[0]['details']; ?></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="assigned_to" class="form-label">Assigned To</label>
                                    <select <?php
                                    if ($_SESSION['userRole'] != 'admin') {
                                        echo 'disabled';
                                    }
                                    ?> class="form-select" name="assigned_to" id="assigned_to">
                                        <?php foreach ($allStaff as $staff): ?>
                                            <option value="<?= $staff['staff_id']; ?>"
                                                <?= $bugData[0]['assigned_to'] == $staff['staff_id'] ? 'selected' : ''; ?>>
                                                <?= $staff['staff_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status" required>
                                        <option disabled value="">Choose...</option>
                                        <option value="waiting" <?= $bugData[0]['status'] == 'waiting' ? 'selected' : ''; ?>>
                                            Waiting</option>
                                        <option value="in_progress" <?= $bugData[0]['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="solved" <?= $bugData[0]['status'] == 'solved' ? 'selected' : ''; ?>>
                                            Solved
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" name="priority" id="priority" required>
                                        <option disabled value="">Choose Priority</option>
                                        <option value="low" <?= $bugData[0]['priority'] == 'low' ? 'selected' : ''; ?>>Low
                                        </option>
                                        <option value="medium" <?= $bugData[0]['priority'] == 'medium' ? 'selected' : ''; ?>>
                                            Medium</option>
                                        <option value="high" <?= $bugData[0]['priority'] == 'high' ? 'selected' : ''; ?>>High
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-success" type="submit">Update Bug</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container">
            <div class="alert alert-danger">No bug data found.</div>
        </div>
    <?php endif; ?>
</div>