@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('account.index')}}">All Account</a>
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
                <h4 class="card-title text-center">Update Account</h4>
            </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['class' => 'forms-sample','route' => ['account.update',$edit->id],'method' => 'PATCH']) !!}
                    <div class="form-group row">
                        <label for="account_type" class="col-sm-3 col-form-label">Account Type</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="account_type" name="account_type" value="{{$edit->account_type}}" placeholder="Type Your Account Type" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Account Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status" required>
                                <option value="Yes"  @if($edit->status == 'Yes') selected="selected" @endif >Yes</option>
                                <option value="No" @if($edit->status == 'No') selected="selected" @endif>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="create_button mr-2 text-center">Update</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection

