@extends('layouts.app')

<div id="app">

    <main class="py-4">
        {{-- Add Modal --}}


        <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="AddStudentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddStudentModalLabel">Add Student Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <ul id="save_msgList"></ul>

                        <div class="form-group mb-3">
                            <label for="">Full Name</label>
                            <input type="text" required class="name form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Course</label>
                            <input type="text" required class="course form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" required class="email form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Phone No</label>
                            <input type="text" required class="phone form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Profile Image</label>
                            <input type="file" required class="image form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary add_student">Save</button>
                    </div>

                </div>
            </div>
        </div>









        {{-- Edit Modal --}}
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit & Update Student Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <ul id="update_msgList"></ul>

                        <input type="hidden" id="stud_id" />

                        <div class="form-group mb-3">
                            <label for="">Full Name</label>
                            <input type="text" id="name" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Course</label>
                            <input type="text" id="course" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" id="email" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Phone No</label>
                            <input type="text" id="phone" required class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Profile Image</label>
                            <input type="file" id="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update_student">Update</button>
                    </div>

                </div>
            </div>
        </div>
        {{-- Edn- Edit Modal --}}


        {{-- Delete Modal --}}
        <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Student Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4>Confirm to Delete Data ?</h4>
                        <input type="hidden" id="deleteing_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary delete_student">Yes Delete</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End - Delete Modal --}}

        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">

                    <div id="success_message"></div>

                    <div class="card">
                        <div class="card-header">
                            <h4>
                                Student Data
                                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                                    data-bs-target="#AddStudentModal">Add Student</button>
                            </h4>
                            <input type="text" id="search" class="form-control mt-2"
                                placeholder="Search students...">
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {

        fetchstudent();

        function fetchstudent(query = '') {
            $.ajax({
                type: "GET",
                url: "/fetch-students",
                data: {
                    query: query
                },
                dataType: "json",
                success: function(response) {
                    $('tbody').html("");
                    $.each(response.students, function(key, item) {
                        var statusButton = item.status == 1 ?
                            '<td><button type="button" class="btn btn-success editbtn btn-sm">Complete</button></td>' :
                            '<td><button type="button" class="btn btn-primary warning btn-sm">Incomplete</button></td>';

                        var statusButton2 = item.status == 1 ?
                            '<td><button type="button" value="' + item.id +
                            '" class="btn btn-warning statusbtn btn-sm">Incomplete</button></td>' :
                            '<td><button type="button" value="' + item.id +
                            '" class="btn btn-info statusbtn btn-sm">Complete</button></td>';

                        $('tbody').append('<tr>\
                        <td>' + item.id + '</td>\
                        <td>' + item.name + '</td>\
                        <td>' + item.course + '</td>\
                        <td>' + item.email + '</td>\
                        <td>' + item.phone + '</td>\
                        <td><img src="storage/' + item.image + '" alt="' + item.name + '" width="50"></td>\
                        ' + statusButton + '\
                        <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
                        <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
                        ' + statusButton2 + '\
                    </tr>');
                    });
                }
            });
        }

        $('#search').on('keyup', function() {
            var query = $(this).val();
            fetchstudent(query);
        });


        // ........................  Student Add............................................


        $(document).on('click', '.add_student', function(e) {
            e.preventDefault();

            $(this).text('Sending..');

            var formData = new FormData();
            formData.append('name', $('.name').val());
            formData.append('course', $('.course').val());
            formData.append('email', $('.email').val());
            formData.append('phone', $('.phone').val());
            formData.append('image', $('.image')[0].files[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/students",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_student').text('Save');
                    } else {
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#AddStudentModal').find('input').val('');
                        $('.add_student').text('Save');
                        $('#AddStudentModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });



        //...................edit..............................

        $(document).on('click', '.editbtn', function(e) {
            e.preventDefault();
            var stud_id = $(this).val();
            // alert(stud_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-student/" + stud_id,
                success: function(response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#name').val(response.student.name);
                        $('#course').val(response.student.course);
                        $('#email').val(response.student.email);
                        $('#phone').val(response.student.phone);
                        $('#stud_id').val(stud_id);
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });


        //........................update....................

        $(document).on('click', '.update_student', function(e) {
            e.preventDefault();

            $(this).text('Updating..');
            var id = $('#stud_id').val();

            var formData = new FormData();
            formData.append('name', $('#name').val());
            formData.append('course', $('#course').val());
            formData.append('email', $('#email').val());
            formData.append('phone', $('#phone').val());
            if ($('#image')[0].files[0]) {
                formData.append('image', $('#image')[0].files[0]);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/update-student/" + id,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function(key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_student').text('Update');
                    } else {
                        $('#update_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_student').text('Update');
                        $('#editModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });






        //.................. statusbtn......................

        $(document).on('click', '.statusbtn', function(e) {
            e.preventDefault();

            $(this).text('changing..');
            var id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "GET",
                url: "/status-change/" + id,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').text(response.message);
                        fetchstudent();
                    }
                }
            });
        });


        //.................. delete model show.........

        $(document).on('click', '.deletebtn', function() {
            var stud_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(stud_id);
        });


        //................... delete student...................

        $(document).on('click', '.delete_student', function(e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-student/" + id,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_student').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchstudent();
                    }
                }
            });
        });

    });
</script>
