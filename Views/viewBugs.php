<?php

require_once '../../Controllers/BugController.php';
require_once '../../Controllers/AuthController.php';
require_once '../../Controllers/StaffController.php';
$bugs = [];
$BugController = new BugController;
$errMsg = '';
$viewMsg = '';



if (isset($_SESSION["userRole"])) {
    if ($_SESSION["userRole"] == "admin") {
        $viewMsg = "All Bugs";
        $result = $BugController->getAllBugs();
        if (!$result) {
            $errMsg = "Error in fetching Bugs";
        } else {
            $bugs = $result;
        }
    } else if ($_SESSION["userRole"] == "staff") {
        $viewMsg = "Your Bugs";
        $authController = new AuthController;
        $user = $authController->getUserById($_SESSION["userId"]);
        if ($user) {
            $staffController = new StaffController;
            $staff = $staffController->getStaffByEmail($user[0]["email"]);
            if ($staff) {
                $result = $BugController->getBugsForStaff($staff[0]["staff_id"]);
                if (!$result) {
                    $errMsg = "Error in fetching Bugs";
                } else {
                    $bugs = $result;
                }
            }
        }
    }
}
?>



<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0"><?php echo $viewMsg ?></h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / Bugs</a></li>
                </ol>
            </div>
        </div>
        <div class="">
            <div class="card mb-4">
                <!-- /.card-header -->
                <div class="card-body">



                    <?php

                    if (count($bugs) > 0) {

                        ?>
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Bug</th>
                                    <th>Project</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <?php
                                    if ($_SESSION["userRole"] == "admin") {

                                        ?>
                                        <th>Assigned To</th>
                                        <?php
                                    } ?>
                                    <th>Priority</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($bugs as $bug) {
                                    ?>
                                    <tr class="align-middle">
                                        <td><?php echo $bug['id']; ?></td>
                                        <td class="text-capitalize fs-5 text-danger fw-bold"><?php echo $bug['bug_name']; ?>
                                        </td>
                                        <td style="color: #444;"><?php echo $bug['project_title']; ?></td>
                                        <td><?php echo $bug['category']; ?></td>
                                        <td>
                                            <p <?php
                                            if ($bug['status'] == "waiting") {
                                                echo "class='text-bg-warning text-center' style='margin-top: 10px; border-radius: 50px;'";
                                            } else if ($bug["status"] == "in_progress") {
                                                echo "class='text-bg-info text-center'  style='margin-top: 10px; border-radius: 50px;'";
                                            } else {
                                                echo "class='text-bg-success text-center'  style='margin-top: 10px; border-radius: 50px;'";
                                            }
                                            ?>>
                                                <?php echo $bug['status']; ?>
                                            </p>
                                        </td>
                                        <?php
                                        if ($_SESSION["userRole"] == "admin") {

                                            ?>
                                            <td><?php echo $bug['staffName']; ?></td>
                                            <?php
                                        }
                                        ?>
                                        <td><?php echo $bug['priority']; ?></td>
                                        <td><?php echo $bug['created_at']; ?> </td>
                                        <td>
                                            <?php
                                            $bug_id = $bug['id'];
                                            require '../layouts/buttons.php';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <h4 class='alert alert-danger'>No Bugs Found</h4>
                        <?php
                    }
                    ?>


                </div>

            </div>
        </div>
        <!-- <div class="timeline-footer">
            <a class="btn btn-danger btn-sm">Delete</a>
        </div> -->


    </div>
</div>