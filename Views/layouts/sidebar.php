<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../<?php echo $currentPage ?>/index.php" class="brand-link">
            <!--begin::Brand Image-->
            <img src="../assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">Bug Tracker</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            Bugs
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../<?php echo $currentPage ?>/index.php?page=viewBugs" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>View Bugs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../<?php echo $currentPage ?>/index.php?page=addBug" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Bug</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            Projects
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../<?php echo $currentPage ?>/index.php?page=viewProjects" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>View Projects</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../<?php echo $currentPage ?>/index.php?page=addProject" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Project</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php 
                
                if ((isset($_SESSION["userRole"]) && $_SESSION["userRole"] == "admin")) {

                    ?>


                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    Staff
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../<?php echo $currentPage ?>/index.php?page=viewStaff" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>View Staff</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../<?php echo $currentPage ?>/index.php?page=addStaff" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Add Staff</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php
                }
                
                ?>
                <li class="nav-item">
                    <a href="../../Views/auth/login.php?logout" class="nav-link text-danger">
                        <p>
                            Logout
                        </p>
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>