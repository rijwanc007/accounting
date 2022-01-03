@extends('master')
@section('management','active') @section('management-show','show') @section('sister-concern','active') @section('sister-concern-show','show') @section('sister-concern-create','active')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => 'sister_concern.store','method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-plus"></i></span> Add New Sister Concern</h3></div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Sister Concern Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter New Sister Concern Name" required>
                    </div>
                    <div class="form-group">
                        <label for="hid">Status</label>
                        <select class="form-control" name="status" required>
                            <option selected disabled value="">Choose An Option</option>
                            <option value="Active">Active</option>
                            <option value="Deactivate">Deactivate</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="custom_button"><i class="mdi mdi-plus"></i> Create </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
