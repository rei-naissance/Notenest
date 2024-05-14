<?php
?>

<nav class="navi navbar navbar-expand-lg bg-body-tertiary sticky-top shadow-lg p-3 bg-body-tertiary rounded">
    <div class="container-fluid">
        <img src="images/temporary-nest.svg" height="50" width="50" alt=""/>
        <a class="logo navbar-brand ms-lg-3" href="index.php">NOTENEST</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" href="notedatabase.php">Home</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" href="aboutus.php">About</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#side" role="button" aria-controls="offcanvasExample">...<Panel></Panel></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-end" tabindex="-1" id="side" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">
            <img src="images/temporary-nest.svg" height="50" width="50" alt=""/>
            <a class="logo navbar-brand ms-lg-3" href="notedatabase.php">NOTENEST</a>
        </h5>

        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

    </div>
    <div class="offcanvas-body">
        <div class="d-flex flex-column align-items-right">
            <a href="adminreport.php" class="btn">Admin report</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</div>

