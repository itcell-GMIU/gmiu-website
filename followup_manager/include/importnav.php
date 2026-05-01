<!-- <script src="../include/importjs.php"></script> -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="change_password.php" class="nav-link">
                <i class="nav-icon fa-solid fa-key"></i>
                <span class="d-sm-inline d-none">Change Password</span>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <b data-toggle="modal" data-target="#logout" class="nav-link">
                <i class="nav-icon fa-solid fa-key"></i>
                <span class="d-sm-inline d-none">Logout</span>
            </b>

        </li>
    </ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Logout ???</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3> Do You Want to Logout ???</h3>
            </div>
            <div class="modal-footer">
                <a href="logout.php" class="nav-link"><span class="btn btn-danger">Log out</span></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>