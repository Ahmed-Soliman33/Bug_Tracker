<?php
require_once '../../Models/Project.php';
require_once '../../Controllers/ProjectController.php';
$errMsg = "";

if (
    isset($_POST['project_title']) && isset($_POST['project_type'])
    && isset($_POST['project_description'])
) {
    $project = new Project($_POST['project_title'], $_POST['project_type'], $_POST['project_description']);
    $projectController = new ProjectController;

    $result = $projectController->addProject($project);
    if (!$result) {
        $errMsg = "Error in Adding Project";
    }

}

?>


<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Add Project</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / Add Project</a></li>
                </ol>
            </div>
            <?php
            if ($errMsg !== "") {
                echo "<h4 class='alert alert-danger'>$errMsg</h4>";
            }
            ?>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card card-info card-outline mb-4">
            <form class="needs-validation" action="index.php?page=addProject" method="post" novalidate>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Project Title</label>
                            <input type="text" name="project_title" class="form-control" id="validationCustom01"
                                required />
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Project Description</label>
                            <textarea name="project_description" class="form-control" id="validationCustom02" rows="4"
                                required></textarea>
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom04" class="form-label">Project type</label>
                            <select class="form-select" name="project_type" id="validationCustom04" required>
                                <option selected disabled value="">Choose...</option>
                                <option value="web">Web Application</option>
                                <option value="mobile">mobile Application</option>
                                <option value="desktop">desktop Application</option>
                            </select>

                            <div class="invalid-feedback">Please select a valid Type.</div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-success" type="submit">Submit form</button>
                        </div>
            </form>

            <script>
                (() => {
                    'use strict';
                    const forms = document.querySelectorAll('.needs-validation');
                    Array.from(forms).forEach((form) => {
                        form.addEventListener(
                            'submit',
                            (event) => {
                                if (!form.checkValidity()) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }

                                form.classList.add('was-validated');
                            },
                            false,
                        );
                    });
                })();
            </script>
        </div>
    </div>
</div>