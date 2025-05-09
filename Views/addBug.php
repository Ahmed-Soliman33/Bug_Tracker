<?php
require_once '../../Controllers/BugController.php';
require_once '../../Controllers/ProjectController.php';
require_once '../../Controllers/StaffController.php';
require_once '../../controllers/CustomerController.php';
$errMsg = "";
$projects;
$allStaff;

if (
    isset($_POST['bug_name'])
    && isset($_POST['project_id'])
    && isset($_POST['category'])
    && isset($_POST['details'])
) {
    if (
        !empty($_POST['bug_name'])
        && !empty($_POST['project_id'])
        && !empty($_POST['category'])
        && !empty($_POST['details'])

    ) {
        $assinged_to = isset($_POST['assigned_to']) ? $_POST['assigned_to'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : 'waiting';
        $priority = isset($_POST['priority']) ? $_POST['priority'] : 'medium';
        $bug = new Bug(
            $_POST['bug_name'],
            $_POST['project_id'],
            $_POST['category'],
            $_POST['details'],
            $assinged_to,
            $status,
            $priority
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
                <h3 class="mb-0">Add Bug</h3>
                <?php if (!empty($errMsg))
                    echo "<div class='alert alert-danger'>$errMsg</div>"
                        ?>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="">Home / Add Bug</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-info card-outline mb-4">
                <form class="needs-validation" class="mb-3" action="index.php?page=addBug" method="POST">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="bug_name" class="form-label">Bug Name</label>
                                <input type="text" name="bug_name" class="form-control" id="bug_name" required />
                            </div>
                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Project</label>
                                <select class="form-select" name="project_id" id="project_id" required>
                                    <option selected disabled value="">Choose Project</option>
                                    <?php
                foreach ($projects as $project) {
                    ?>
                                    <option value="<?php echo $project['project_id']; ?>">
                                        <?php echo $project['project_title']; ?>
                                    </option>
                                    <?php
                }
                ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category" id="category" required>
                                <option selected disabled value="">Choose category</option>
                                <option value="web">Web Application</option>
                                <option value="mobile">mobile Application</option>
                                <option value="desktop">desktop Application</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="details" class="form-label">Details</label>
                            <textarea type="text" name="details" class="form-control" id="details" required></textarea>
                        </div>


                        <!--  add all staff in this    -->


                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assigned To</label>
                            <select <?php if ($_SESSION['userRole'] != 'admin')
                                echo "disabled"; ?> class="form-select"
                                name="assigned_to" id="assigned_to" required>
                                <option selected disabled value="">Choose Project</option>
                                <?php
                                foreach ($allStaff as $staff) {
                                    ?>
                                    <option value="<?php echo $staff['staff_id']; ?>">
                                        <?php echo $staff['staff_name']; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!-- ///////////////////// -->
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select <?php if ($_SESSION['userRole'] == 'customer')
                                echo "disabled"; ?> class="form-select"
                                name="status" id="status" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="waiting">Waiting</option>
                                <option value="in_progress">In_progress</option>
                                <option value="solved">Solved</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priority</label>
                            <select <?php if ($_SESSION['userRole'] == 'customer')
                                echo "disabled"; ?> class="form-select"
                                name="priority" id="priority" required>
                                <option selected disabled value="">Choose Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
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