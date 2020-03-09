@extends('master')
@section('content')
    <div class="row">
        <div class="col-md-12 text-right">
            <a class="main_head_button" href="{{route('main_head.index')}}">All Main Head</a>
            <br/><br/><br/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Create Main Head</h4>
                    <form class="forms-sample">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Account Type</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="account_type" required>
                                    @foreach($accounts as $account)
                                    <option value="{{$account->id}}">{{$account->account_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account_code" class="col-sm-3 col-form-label">Account Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="account_code" name="account_code" readonly="readonly" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account_name" class="col-sm-3 col-form-label">Account Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control account_name" id="account_name" name="account_name" placeholder="Type Account Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Has Sub Account</label>
                            <div class="col-sm-9">
                                 <select class="form-control" name="has_sub_account" required>
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
    <script>
        $(document).on('input','.account_name',function(){
          console.log('there is something')
        })
    </script>
@endsection

