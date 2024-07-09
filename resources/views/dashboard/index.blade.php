@extends('layouts.dashboard')
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">

            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Projects</p>
                                <h4 class="my-1 text-primary" id="totalProjects"></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-primary text-primary ms-auto"><i
                                    class='bx bx-comment-detail'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Tasks</p>
                                <h4 class="my-1 text-info" id="totalTasks"></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                    class='bx bx-laptop'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="card radius-10">


        </div>
    </div>
</div>
<!--end page wrapper -->
<script>
function fetchData() {
    const xhr = new XMLHttpRequest();
    var posturl = "<?php echo env('APP_URL')."/v1/dashboard/details"; ?>";
    xhr.open('GET', posturl, true);
    console.log(xhr);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            var totalProjects = response.projects;
            var totalTasks = response.tasks;

            document.getElementById('totalProjects').innerText = totalProjects;
            document.getElementById('totalTasks').innerText = totalTasks;
        }
    };
    xhr.send();
}

// setInterval(fetchData, 1000000);
setInterval(fetchData, 5000);
</script>

@endsection
