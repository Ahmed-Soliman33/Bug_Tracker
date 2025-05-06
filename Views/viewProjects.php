<?php
require_once '../../Controllers/ProjectController.php';
$errMsg = "";
$projects;


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
                <div class="card-header">
                    <h3 class="card-title">Projects Table</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
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
                                    <td style="font-size: 18px; font-weight: semibold">
                                        <?php echo $project['project_title']; ?>
                                    </td>
                                    <td>
                                        <div class="bg-primary text-center rounded text-white"
                                            style="width: 55% ; font-size: 18px; font-weight: semibold">
                                            <?php echo $project['project_type']; ?>
                                        </div>
                                    </td>
                                    <td><span class="badge text-bg-danger"
                                            style="font-size: 14px;"><?php echo $project['project_description']; ?></span>
                                    </td>
                                </tr>
                                <?php

                            } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>