<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset("public/images/favicon.png")}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Admin Portal</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="<?= env('APP_URL').'/v1/dashboard'?>">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

               <li class="menu-label">Projects Section</li>

        <li>
            <a href="<?= env('APP_URL').'/v1/projects' ?>">
                <div class="parent-icon"><i class='bx bx-building'></i>
                </div>
                <div class="menu-title">Projects</div>
            </a>
        </li>

        <li>
            <a href="<?= env('APP_URL').'/v1/tasks' ?>">
                <div class="parent-icon"><i class='bx bx-user-circle'></i>
                </div>
                <div class="menu-title">Tasks</div>
            </a>
        </li>

        <li class="menu-label">Others</li>
        <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <div class="parent-icon"><i class='bx bx-pause'></i>
                </div>
                <div class="menu-title">Logout</div>
            </a>
        </li>
        
        <li>
            <a href="mailto:mugovechemistmudavanhu@gmail.com" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
{{-- logout modal start --}}

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample">
                    <p>You are about to logout</p>
                    <div class="form-group">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <a href="<?= env('APP_URL').'/v1/logout' ?>" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--logout modal end-->
