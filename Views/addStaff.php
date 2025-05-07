<?php
require_once '../../Models/Staff.php';
require_once '../../Controllers/StaffController.php';
$errMsg = "";

if (
    isset($_POST['staff_name']) && isset($_POST['staff_email'])
) {
    if (
        !empty($_POST['staff_name']) && !empty($_POST['staff_email'])
    ) {
        $staff = new Staff($_POST['staff_name'], $_POST['staff_email'], $_POST['staff_email'], "staff");
        $staffController = new StaffController;

        $result = $staffController->addStaff($staff);
        if (!$result) {
            $errMsg = "Error in Adding Staff";
        }
    }

}

?>


<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Add Staff</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / Add Staff</a></li>
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
            <form class="needs-validation" action="index.php?page=addStaff" method="post" novalidate>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Staff Name</label>
                            <input type="text" name="staff_name" class="form-control" id="validationCustom01"
                                required />
                            <div class="valid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Staff Email</label>
                            <input type="email" name="staff_email" class="form-control" id="validationCustom01"
                                required />
                            <div class="valid-feedback"></div>
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