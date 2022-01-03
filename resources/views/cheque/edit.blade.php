@extends('master')
@section('bank','active') @section('bank-show','show') @section('chequebook','active') @section('chequebook-show','show')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => ['cheque.update', $cheque->id],'method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-file-document"></i></span>Cheque Book Entry</h3></div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="pay_to"> Pay To</label>
                        <input type="text" class="form-control" id="pay_to" name="pay_to" placeholder="pay_to" value="{{$cheque->pay_to}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount"> Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" value="{{$cheque->amount}}" required>
                    </div>
                    <div class="form-group">
                        <label for="date"> Date </label>
                        <input type="date" class="form-control" id="date" name="date" value="{{$cheque->date}}" required>
                    </div>
                    <div class="form-group">
                        <label for="ac_payee">AC Payee</label>
                        <select class="form-control" name="ac_payee" id="ac_payee" required>
                            <option selected disabled value="">choose an option</option>
                            <option value="yes" @if($cheque->ac_payee == 'yes') selected @endif>Yes</option>
                            <option value="no" @if($cheque->ac_payee == 'no') selected @endif>No</option>
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
            <button type="submit" class="custom_button" id="btn"><i class="mdi mdi-file-document"></i> Update</button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
