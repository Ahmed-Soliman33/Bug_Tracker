<?php
require_once '../../Controllers/BugController.php';
require_once '../../Controllers/ProjectController.php';
require_once '../../Controllers/StaffController.php';
$errMsg = "";
$projects;
$allStaff;



echo $_SESSION["editId"];
if (isset($_SESSION["editId"]) && !empty($_SESSION["editId"])) {
    $bugController = new BugController;
    $result = $bugController->getBugById($_SESSION["editId"]);
    if ($result) {
        $bug_name = $result['bug_name'];
        $project_id = $result['project_id'];
        $category = $result['category'];
        $details = $result['details'];
        $assigned_to = $result['assigned_to'];
        $status = $result['status'];
        $priority = $result['priority'];

    }
}

if (
    isset($_POST['bug_name'])
    && isset($_POST['project_id'])
    && isset($_POST['category'])
    && isset($_POST['details'])
    && isset($_POST['assigned_to'])
    && isset($_POST['status'])
    && isset($_POST['priority'])
) {
    if (
        !empty($_POST['bug_name'])
        && !empty($_POST['project_id'])
        && !empty($_POST['category'])
        && !empty($_POST['details'])
        && !empty($_POST['assigned_to'])
        && !empty($_POST['status'])
        && !empty($_POST['priority'])

    ) {
        $bug = new Bug(
            $_POST['bug_name'],
            $_POST['project_id'],
            $_POST['category'],
            $_POST['details'],
            $_POST['assigned_to'],
            $_POST['status'],
            $_POST['priority']
        );
        $bugController = new BugController;
        $bugController->addBug($bug);
    }

}


$projectController = new ProjectController;
$staffController = new StaffController;

$ProjectsResult = $projectController->getAllProjects();
$staffResult = $staffController->getAllStaff();
if (!$ProjectsResult) {
    $errMsg = "Error in fetching Projects";
} else {
    $projects = $ProjectsResult;
}
if (!$staffResult) {
    $errMsg = "Error in fetching Staff";
} else {
    $allStaff = $staffResult;
}




?>





<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Bug</h3>
                <?php if (!empty($errMsg))
                    echo "<div class='alert alert-danger'>$errMsg</div>"
                        ?>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="">Home / edit Bug</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-info card-outline mb-4">
                <form class="needs-validation" class="mb-3" action="index.php?page=editBug" method="POST">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="bug_name" class="form-label">Bug Name</label>
                                <input type="text" name="bug_name" class="form-control" id="bug_name"
                                    value="<?php echo $bug_name; ?>" required />
                        </div>
                        <div class="col-md-6">
                            <label for="project_id" class="form-label">Project</label>
                            <select disabled class="form-select" name="project_id" id="project_id" required>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= $project['project_id']; ?>" <?= $project['project_id'] == $project_id ? 'selected' : ''; ?>>
                                        <?= $project['project_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category" disabled required>
                                <option value="web" <?= $category == "web" ? 'selected' : ''; ?>>Web Application</option>
                                <option value="mobile" <?= $category == "mobile" ? 'selected' : ''; ?>>Mobile Application
                                </option>
                                <option value="desktop" <?= $category == "desktop" ? 'selected' : ''; ?>>Desktop
                                    Application</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="details" class="form-label">Details</label>
                            <textarea name="details" class="form-control" id="details"
                                required><?php echo $details; ?></textarea>
                        </div>


                        <!--  add all staff in this    -->
                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <select class="form-select" name="assigned_to" id="assigned_to" disabled required>
                                <?php foreach ($allStaff as $staff): ?>
                                    <option value="<?= $staff['staff_id']; ?>" <?= $staff['staff_id'] == $assigned_to ? 'selected' : ''; ?>>
                                        <?= $staff['staff_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- ///////////////////// -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="waiting" <?= $status == "waiting" ? 'selected' : ''; ?>>Waiting</option>
                                <option value="in_progress" <?= $status == "in_progress" ? 'selected' : ''; ?>>In Progress
                                </option>
                                <option value="solved" <?= $status == "solved" ? 'selected' : ''; ?>>Solved</option>
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" name="priority" id="priority" required>
                                <option value="low" <?= $priority == "low" ? 'selected' : ''; ?>>Low</option>
                                <option value="medium" <?= $priority == "medium" ? 'selected' : ''; ?>>Medium</option>
                                <option value="high" <?= $priority == "high" ? 'selected' : ''; ?>>High</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" type="submit">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>