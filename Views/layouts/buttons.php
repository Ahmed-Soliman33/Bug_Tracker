<?php
require_once("../../Controllers/BugController.php");
require_once("../../Controllers/ProjectController.php");
require_once("../../Controllers/StaffController.php");






if (
    isset($_POST['action']) && isset($_POST['id'])
    && $_POST['action'] === "delete" && !empty($_POST['id'])
) {
    $action = $_POST['action'];
    $id = $_POST['id'];
    switch ($currentComponent) {
        case "viewBugs":
            $bugController = new BugController();
            $result = $bugController->deleteBug($id);
            if ($result) {
                echo "<script>window.location.href = 'index.php?page=viewBugs';</script>";
                exit();
            }
            break;
        case "viewProjects":
            $projectController = new ProjectController();
            $result = $projectController->deleteProject($id);
            if ($result) {
                echo "<script>window.location.href = 'index.php?page=viewProjects';</script>";
                exit();
            }
            break;
        case "viewStaff":
            $email = $_POST['email'];
            $staffController = new StaffController();
            $result = $staffController->deleteStaff($id, $email);
            if ($result) {
                echo "<script>window.location.href = 'index.php?page=viewStaff';</script>";
                exit();
            }
            break;
        default:
            break;
    }
} else if (
    isset($_POST['action']) && isset($_POST['id'])
    && $_POST['action'] === "edit" && !empty($_POST['id'])
) {
    $id = $_POST['id'];
    switch ($currentComponent) {
        case "viewBugs":
            $_SESSION["editId"] = $id;
            if ($_SESSION["editId"]) {
                echo "<script>window.location.href = 'index.php?page=editBug';</script>";
                exit();
            }
            break;
        default:
            break;
    }
}

?>

<div style="display: flex; justify-content: center; gap: 5px;">
    <form method="post">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button style="border: none; padding: 0; margin: 0;" type="submit">
            <i class="bi bi-pencil-square text-info" style="cursor: pointer; margin-right: 2px; font-size: 18px;"></i>
        </button>
    </form>

    <form method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php
        if ($currentComponent === "viewStaff") {
            ?>
            <input type="hidden" name="email" value="<?php echo $email ?>">
            <?php
        }
        ?>
        <button style="border: none; padding: 0; margin: 0;" type="submit">
            <i class="bi bi-archive-fill" style="cursor: pointer; font-size: 18px; color: #e01123;"></i>
        </button>
    </form>
</div>