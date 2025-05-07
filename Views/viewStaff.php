<?php

require_once '../../Controllers/StaffController.php';
$staffs = [];

$staffController = new StaffController;

$result = $staffController->getAllStaff();
if (!$result) {
    $errMsg = "Error in fetching Staff";
} else {
    $staffs = $result;
}
?>



<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">View Staff</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="">Home / Staff</a></li>
                </ol>
            </div>
        </div>
        <div class="">
            <div class="card mb-4">
                <!-- /.card-header -->
                <div class="card-body">

                    <?php

                    if (count($staffs) > 0) {

                        ?>
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Staff Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($staffs as $staff) {
                                    ?>
                                    <tr class="align-middle">
                                        <td style="color: #444;"><?php echo $staff['staff_id']; ?></td>
                                        <td class="text-capitalize text-danger fw-bold fs-5">
                                            <?php echo $staff['staff_name']; ?>
                                        </td>
                                        <td style="color: #444;"><?php echo $staff['staff_email']; ?></td>
                                        <td style="color: #444;"><?php echo $staff['staff_created_at']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <h4 class='alert alert-danger'>No Staffs Found</h4>
                        <?php
                    }
                    ?>

                </div>

            </div>
        </div>
    </div>
</div>