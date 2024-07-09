@extends('layouts.default')
@section('content')
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="p-4">
                                <div class="mb-3 text-center">
                                    <img src="{{ asset("public/images/logo-icon.png") }}" width="60" alt="" />
                                </div>
                                <div class="text-center mb-4">
                                    <h5 class="">Task Management System</h5>
                                    <p class="mb-0">Please log in to your account</p>
                                </div>
                                <div class="form-body">
                                    <form id="LoginForm">
                                        <div id="alert-msg"></div>

                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">Username</label>
                                            <input type="text" name="email" class="form-control"
                                                id="inputEmailAddress" placeholder="Admin Portal">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password" class="form-control border-end-0"
                                                    id="inputChoosePassword"
                                                    placeholder="Enter Password"> <a href="javascript:;"
                                                    class="input-group-text bg-transparent"><i
                                                        class='bx bx-hide'></i></a>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button id="login" class="btn btn-primary">Log In</button>
                                                <br>
                                        <div class="text-right">
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->

<script>
    $('#login').click(function() {
        var form_data = $('#LoginForm').serialize();
        var posturl = "<?php echo env('APP_URL') . '/v1/login'; ?>";
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
                        '<div class="alert alert-success text-center">Login successful!</div>');
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
