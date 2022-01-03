@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('announcement.index')}}">All Announcement</a>
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
                <h4 class="card-title text-center">Create Announcement</h4>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['class' => 'forms-sample','route' => 'announcement.store']) !!}
                    <div class="form-group row">
                        <label for="announcement_name" class="col-sm-3 col-form-label">Announcement Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="announcement_name" name="announcement_name" placeholder="Type Your Announcement Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label">Announcement Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="about" name="announcement_description" rows="8" placeholder="Type Details About The Announcement" required></textarea>
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
@endsection
