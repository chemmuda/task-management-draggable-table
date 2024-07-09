@extends('layouts.view')
@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="card-header">
                        <h4 class="card-title"><?=$title?> List</h4>
                        <div class="text-end">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#projectModal">Add Projects</button>
                        </div>
                    </div>
                    <br>
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Project Details</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($projects as $list):
                                $id = base64_encode($list->projectID)

                            ?>
                            <tr>
                                <td><?=$i++;?></td>
                                <td><?=$list->projectName;?></td>
                                <td><?=$list->projectDescription ?></td>
                                <td><?=$list->createdBy;?></td>
                                <td><?=$list->createdAt;?></td>
                                <td>
                                    <a href="<?=env('APP_URL')."/v1/projects/tasks/$id"?>" type="button"  class="btn btn-primary px-3">View Tasks</a>
                                </td>
                            </tr>
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
                <h5 class="modal-title" id="projectModalLabel">Create New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="AddForm">
                    <div id="alert-msg"></div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Project Name</label>
                        <input type="text" class="form-control" placeholder="Project Name" name="title">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Project Description</label>
                        <input type="text" class="form-control" placeholder="Project Description" name="description">
                    </div>
                    <div class="form-group">
                        <div class="modal-footer">
                            <button type="submit" id="projectadd" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#projectadd').click(function() {
        var form_data = $('#AddForm').serialize();
        var posturl = "<?php echo env('APP_URL') . '/v1/projects/add'; ?>";
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
