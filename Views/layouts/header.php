
<header>
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="../<?php echo $currentPage ?>/index.php?page=chat">
                        <i class="bi bi-chat-text"></i>
                        <span class="navbar-badge badge text-bg-danger">3</span>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="../assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow"
                            alt="User Image" />
                        <span class="d-none d-md-inline"><?php echo $userName ?></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>