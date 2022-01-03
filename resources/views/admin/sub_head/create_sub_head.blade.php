@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('sub_head.index')}}">All Sub Head</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Create Sub Head</h4>
                    <form class="forms-sample">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select Main Account</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="main_account" required>
                                    <option>Select Main Account</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_account_code" class="col-sm-3 col-form-label">Sub Account Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sub_account_code" name="sub_account_code" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_account_name" class="col-sm-3 col-form-label">Sub Account Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sub_account_name" name="sub_account_name" placeholder="Type Sub Account Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Has Sub Sub Account</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="has_sub_sub_account" required>
                                    <option>Select Sub Sub Account</option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="create_button mr-2 text-center">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
@endsection

