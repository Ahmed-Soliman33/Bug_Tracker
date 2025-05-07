<?php
require_once '../../Controllers/ProjectController.php';
$errMsg = "";
$projects = [];


$projectController = new ProjectController;

$result = $projectController->getAllProjects();
if (!$result) {
    $errMsg = "Error in fetching Projects";
} else {
    $projects = $result;
}


?>


<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">View Projects</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / View Projects</a></li>
                </ol>
            </div>
        </div>
        <div class="">
            <div class="card mb-4">
                <!-- /.card-header -->
                <div class="card-body">



                    <?php

                    if (count($projects) > 0) {

                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Project</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project) {

                                    ?>
                                    <tr class="align-middle">
                                        <td><?php echo $project['project_id']; ?></td>
                                        <td class="text-danger fw-bold fs-5" style="font-size: 18px; font-weight: semibold">
                                            <?php echo $project['project_title']; ?>
                                        </td>
                                        <td>
                                            <div <?php
                                            if ($project['project_type'] == "web") {
                                                echo "class='text-bg-success p-1 text-center' style='margin-top: 10px; border-radius: 50px;'";
                                            } else if ($project["project_type"] == "mobile") {
                                                echo "class='text-bg-warning text-center p-1'  style='margin-top: 10px; border-radius: 50px;'";
                                            } else {
                                                echo "class='text-bg-info text-center p-1'  style='margin-top: 10px; border-radius: 50px;'";
                                            }
                                            ?>>
                                                <?php echo $project['project_type']; ?>
                                            </div>
                                        </td>
                                        <td><span
                                                style="font-size: 15px; color: #444;"><?php echo $project['project_description']; ?></span>
                                        </td>
                                    </tr>
                                    <?php
                                } ?>

                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <h4 class='alert alert-danger'>No Projects Found</h4>
                        <?php
                    }
                    ?>



                </div>
            </div>
        </div>
    </div>
</div>