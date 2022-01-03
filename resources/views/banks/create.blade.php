@extends('master')
@section('bank','active') @section('bank-show','show') @section('bank-create','active')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => 'bank.store','method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-bank"></i></span>Bank</h3></div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="sister_concern_id"> Sister Concern </label>
                        <select class="form-control" name="sister_concern_id" id="sister_concern_id" data-live-search="true" required>
                            <option selected disabled value="">Choose an option</option>
                            @foreach($sister_concern_s as $sister_concern)
                                <option value="{{$sister_concern->id}}" data-tokens="{{$sister_concern->name}}">{{Str::upper($sister_concern->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_name"> Bank Name </label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" required>
                    </div>
                    <div class="form-group">
                        <label for="branch"> Branch </label>
                        <input type="text" class="form-control" id="branch" name="branch" placeholder="Branch" required>
                    </div>
                    <div class="form-group">
                        <label for="account"> Account Number </label>
                        <input type="text" class="form-control" id="account" name="account" placeholder="Account Number" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="custom_button" id="btn"><i class="mdi mdi-bank"></i> Create </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
