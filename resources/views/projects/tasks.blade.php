@extends('layouts.view')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="card-header">
                        <h4 class="card-title"><?=$title?></h4>
                        <div class="text-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#projectModal">Add Task</button>
                        </div>
                    </div>
                    <br>
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable">
                            <?php
                                $i = 1;
                                foreach ($tasks as $list):
                                $id = base64_encode($list->projectID);
                            ?>
                            <tr id="task_<?=$list->taskID?>">
                                <td class="order"><?=$i++;?></td>
                                <td><?=$list->taskName;?></td>
                                <td><?=$list->createdBy;?></td>
                                <td><?=$list->createdAt;?></td>
                                <td>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleEditModal<?=$list->taskID?>">Edit</button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleDeleteModal<?=$list->taskID?>">Delete</button>
                                </td>
                            </tr>
                            {{-- Edit modal Start  --}}
                            <div class="modal fade" id="exampleEditModal<?= $list->taskID ?>" tabindex="-1" aria-labelledby="exampleEditModal<?= $list->taskID ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleEditModal<?= $list->taskID ?>">Update Project Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="forms-sample"  action="<?= env('APP_URL')."/v1/projects/tasks/update/$id" ?>" method="POST">
                                                <!-- CSRF Token -->
                                                <?= csrf_field() ?>
                                                <div id="alert-msg"></div>
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Task Name</label>
                                                    <input type="text" class="form-control" value="<?= $list->taskName ?>" name="name">
                                                </div>

                                                <input type="hidden" class="form-control" value="<?= $list->taskID ?>" name="task_id">
                                                <div class="form-group">
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Edit modal End  --}}
                            {{-- Delete modal Start  --}}
                            <div class="modal fade" id="exampleDeleteModal<?= $list->taskID ?>" tabindex="-1" aria-labelledby="exampleDeleteModal<?= $list->taskID ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleDeleteModal<?= $list->taskID ?>">Delete Project Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="forms-sample"  action="<?= env('APP_URL')."/v1/projects/tasks/delete/$id" ?>" method="POST">
                                                <!-- CSRF Token -->
                                                <?= csrf_field() ?>
                                                <div id="alert-msg"></div>
                                                <div class="form-group">
                                                    <p>You are about to delete task for project <?= $project->name ?></p>
                                                </div>

                                                <input type="hidden" class="form-control" value="<?= $list->taskID ?>" name="task_id">
                                                <div class="form-group">
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Delete modal End  --}}

                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Create Project Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="AddForm">
                    <div id="alert-msg"></div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Task Name</label>
                        <input type="text" class="form-control" placeholder="Task Name" name="name">
                    </div>

                    <input type="hidden" class="form-control" value="<?= $project->id ?>" name="project_id">
                    <div class="form-group">
                        <div class="modal-footer">
                            <button type="submit" id="taskadd" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
    $("#sortable").sortable({
        update: function(event, ui) {
        var order = $(this).sortable('toArray').toString();
        var taskUrl = "<?php echo env('APP_URL') . '/v1/tasks/reorder'; ?>";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: taskUrl,
                method: 'GET',
                data: { order: order },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                console.log(response);
                // Get the current page URL
                var currentUrl = window.location.href;
                // Redirect to a new URL
                window.location.href = currentUrl;
                }
            });
        }
    });
});


    $('#taskadd').click(function() {
        var form_data = $('#AddForm').serialize();
        var posturl = "<?php echo env('APP_URL') . '/v1/tasks/add'; ?>";
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: posturl,
            type: 'POST',
            data: form_data,
            headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            dataType: "json",
            beforeSend: function() {
                $("#loader").show();
            },
            success: function(data) {
                if (data.msg == 'YES') {
                    console.log(data);
                    $('#alert-msg').html(
                        '<div class="alert alert-success text-center">Project successfully added!</div>');
                    window.location.href = data.url;
                } else if (data.msg == 'NO') {
                    $('#alert-msg').html(
                        '<div class="alert alert-danger text-center">' + data.msgYacho + '</div>'
                    );
                    $("#loader").hide();
                } else {
                    var errors = data.msg; // Assuming data.msg contains the error object
                    var errorHtml = '<div class="alert alert-danger"><ul>';
                    for (var field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorHtml += '<li>' + errors[field][0] + '</li>'; // Assuming each field has an array of errors
                        }
                    }
                    errorHtml += '</ul></div>';
                    $('#alert-msg').html(errorHtml);
                    $("#loader").hide();
                }
            },
            complete: function(data) {
                $("#loader").hide();
            }
        });

        return false;
    });
    </script>

@endsection
