@extends('master')
@section('user_create','active')
@section('user_show','show')
@section('all_user','active')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('user.index')}}">All User</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="item">
                <h4 class="card-title text-center">Create User</h4>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['class' => 'forms-sample','route' => 'user.store','enctype'=>'multipart/form-data']) !!}
                        <div class="form-group row">
                            <label for="first_name" class="col-sm-3 col-form-label">First Name </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Type First Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Type Last Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Image Upload</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" name="image" placeholder="Upload User Image" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Type Validate Email Address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Type Phone Number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Type Your Full Address" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nid" class="col-sm-3 col-form-label">National ID Number</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nid" name="nid" placeholder="Type Your National ID Number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="position" class="col-sm-3 col-form-label">Position</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="position" name="position" placeholder="Type Your Position" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="about" class="col-sm-3 col-form-label">About Him/Her</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="about" name="about" rows="8" placeholder="Type Something About Him Or Her" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="role" required>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Type Your Password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Type Your Password Again" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="create_button mr-2 text-center">Submit</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <script>
        var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");
        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
    @endsection
