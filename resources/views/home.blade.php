@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- {{ __('You are logged in!') }} -->
                <div class="card-body">
                  
                    <div class="form-group mb-3">
                        <label for="exampleInputEmail1">Profile Image</label>
                        <input type="file" class="profile_img form-control"  name="profile_img" aria-describedby="" placeholder="Enter email">
                        <span class="text-danger profile_error"></span>
                  
                    </div>
                    <div class="form-group  mb-3">  
                        <label for="">First Name</label>
                        <input type="text" class="first_name form-control" name="first_name"  aria-describedby="" placeholder="Enter First Name">
                        <span class="text-danger first_error"></span>
                    <div class="form-group  mb-3">
                        <label for="">Last Name</label>
                        <input type="text" class="last_name form-control" name="last_name"  aria-describedby="" placeholder="Enter Last Name">
                        <span class="text-danger last_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="email form-control"  name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <span class="text-danger email_error"></span> </div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="">User Name</label>
                        <input type="text" class="user_name form-control" name="user_name" aria-describedby="" placeholder="Enter User Name">
                        <span class="text-danger user_error"></span>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="">Date of birth</label>
                        <input type="date" class="birth_date form-control" name="birth_date"  aria-describedby="" >
                        <span class="text-danger birth_date_error"></span>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="">Gender</label><br>
                        <input type="radio" class="female"  name="gender" value="female" aria-describedby=""> Female
                        <input type="radio" class="mail" name="gender" value="male" aria-describedby=""> Male
                        <span class="text-danger gender_error"></span>
                    </div>
                   
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="password form-control" id="exampleInputPassword1" placeholder="Password">
                        <span class="text-danger password_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" class="confirm_password form-control"  placeholder="Confirm Password">
                        <span class="text-danger confirm_error"></span>
                    </div>
                    <button type="button" class="submit btn btn-primary mt-4">Submit</button>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>First Name</th>
                    <th>Email</th>
                    <th>Date Of Birth</th>
                    <th>Gender</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div>
    </div>
</div>
@push('script')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
   $(".submit").on("click",function(e){
    e.preventDefault();
    var profile_img = $(".profile_img").prop('files')[0];
    var birth_date= $(".birth_date").val();
    var user_name = $('.user_name').val();
    var first_name = $(".first_name").val();
    var email = $(".email").val();
    var last_name = $(".last_name").val();
    var gender = $("input[name='gender']:checked").val();
    var password = $('.password').val();
    var confirm_password = $('.confirm_password').val();

    let formData = new FormData();
    formData.append('profile_img',profile_img);
    formData.append('birth_date',birth_date);
    formData.append('user_name',user_name);
    formData.append('first_name',first_name);
    formData.append('last_name',last_name);
    formData.append('gender',gender);
    formData.append('password',password);
    formData.append('email',email);
    formData.append('confirm_password',confirm_password);

    $.ajax({
        type: "POST",
        url: "{{route('employee.store')}}",
        data: formData,
        contentType:'multipart/form-data',
        cache:false,
        contentType:false,
        processData:false,
        dataType: "json",
        
        success: function (response) {
            if(response.data == "true")
            {
                Data();
            }
            else{
                printErrorMsg(response.error);
                Data();
            }
        }
    });

    function printErrorMsg(msg) {
        $.each(msg, function(key, value) {
            if (key == "first_name") {
                $(".first_error").html(value);
            }
            if (key == "last_name") {
                $(".last_error").html(value);
            }
            if (key == "gender") {
                $(".gender_error").html(value);
            }
            if (key == "password") {
                $(".password_error").html(value);
            }
            if (key == "user_name") {
                $(".user_error").html(value);
            }
            if (key == "confirm_password") {
                $(".confirm_error").html(value);
            }
            if (key == "profile_img") {
                $(".profile_error").html(value);
            }
            if (key == "email") {
                $(".email_error").html(value);
            }
            if (key == "birth_date") {
                $(".birth_date_error").html(value);
            }
        });
    }

   });
   Data();
   function Data(){

   var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        destroy:true,
        dataSrc:"",
        ajax: "{{ route('employee.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'email', name: 'email'},
            {data: 'birth_data', name: 'birth_data'},
            {data: 'gender', name: 'gender'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

  
});
</script>
@endpush
@endsection
