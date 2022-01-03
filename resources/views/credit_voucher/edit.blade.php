@extends('master')
@section('account','active') @section('account-show','show') @section('vouchar','active') @section('vouchar-show','show') @section('credit_voucher','active') @section('credit_voucher-show','show') @section('credit_voucher-create','active')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => ['credit_voucher.update', $edit->id],'method' => 'PATCH']) !!}
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-pencil"></i></span>Credit Voucher</h3></div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4"><div class="form-group">
                                <label for="sister_concern_id">Sister Concern</label>
                                <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id" required>
                                    <option selected disabled value="">choose an option</option>
                                    @foreach($sister_concerns as $sister_concern)
                                        <option value="{{ $sister_concern->id}}" @if($edit->sister_concern_id == $sister_concern->id) selected @endif>{{$sister_concern->name}}</option>
                                    @endforeach
                                </select>
                            </div></div>
                        <div class="col-md-4"><div class="form-group">
                                <label for="voucher_no"> Voucher No </label>
                                <input type="text" class="form-control" id="voucher_no" name="voucher_no" value="{{$edit->voucher_no}}" readonly required>
                            </div></div>
                        <div class="col-md-4"><div class="form-group">
                                <label for="date"> Date </label>
                                <input type="date" class="form-control" id="date" name="date" value="{{$edit->date}}" required>
                            </div></div>
                        <div class="col-md-6">
                            <h5 class="text-center">Debit<hr/></h5>
                            <div class="debit_field" id="0" @if($edit->sister_concern_id != 0) style="display: none" @endif>
                                <div class="form-group">
                                    <label for="debit">Debit</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="debit" id="debit" >
                                        <option value="" selected disabled>Choose An option</option>
                                    </select>

                                </div>
                            </div>
                            @foreach($sister_concerns as $sister_concern)
                                <div class="debit_field" id="{{$sister_concern->id}}" @if($edit->sister_concern_id != $sister_concern->id) style="display: none" @endif>
                                    <div class="form-group">
                                        <label for="debit">Debit</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="debit" id="debit">
                                            <option value="" selected disabled>Choose An option</option>
                                            @for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)
                                                <option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}" @if($edit->debit_id == $data[$sister_concern->id][$i]['id']) selected @endif>{{$data[$sister_concern->id][$i]['name']}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="debit_amount"> Debit Amount </label>
                                <input type="text" class="form-control" id="debit_amount" name="debit_amount" value="{{$edit->debit_amount}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center">Credit<hr/></h5>
                            <div class="credit_field" @if($edit->sister_concern_id != 0) style="display: none" @endif>
                                <div class="form-group">
                                    <label for="credit">Credit</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="credit" id="credit" >
                                        <option value="" selected disabled>Choose An option</option>
                                    </select>

                                </div>
                            </div>
                            @foreach($sister_concerns as $sister_concern)
                                <div class="debit_field" id="{{$sister_concern->id}}" @if($edit->sister_concern_id != $sister_concern->id) style="display: none" @endif>
                                    <div class="form-group">
                                        <label for="credit">Credit</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="credit" id="credit">
                                            <option value="" selected disabled>Choose An option</option>
                                            @for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)
                                                <option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}" @if($edit->credit_id == $data[$sister_concern->id][$i]['id']) selected @endif>{{$data[$sister_concern->id][$i]['name']}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="credit_amount"> Credit Amount </label>
                                <input type="text" class="form-control" id="credit_amount" name="credit_amount" value="{{$edit->credit_amount}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="naration"> Naration </label>
                        <textarea class="form-control" id="naration" name="naration" rows="5" placeholder="Enter Naration Here">{{$edit->naration}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12"><h3>Overview<hr/></h3></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="transfer_amount_to">Transfer Amount To</label>
                                <input type="text" class="form-control" id="transfer_amount_to" name="transfer_amount_to" value="{{$edit->transfer_amount_to}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="debit">Debit</label>
                                <input type="text" class="form-control" id="debit_overview" name="debit_overview" value="DR" readonly>
                                <input type="hidden" class="form-control" id="debit_id" name="debit_id" value="{{$edit->debit_id}}" readonly required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="debit_amount">Debit Amount</label>
                                <input type="text" class="form-control" id="debit_amount_overview" name="debit_amount_overview" value="{{$edit->debit_amount_overview}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="transfer_amount_from">Transfer Amount From</label>
                                <input type="text" class="form-control" id="transfer_amount_from" name="transfer_amount_from" value="{{$edit->transfer_amount_from}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="credit">Credit</label>
                                <input type="text" class="form-control" id="credit_overview" name="credit_overview" value="CR" readonly>
                                <input type="hidden" class="form-control" id="credit_id" name="credit_id" value="{{$edit->credit_id}}" readonly required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="credit_amount">Credit Amount</label>
                                <input type="text" class="form-control" id="credit_amount_overview" name="credit_amount_overview" value="{{$edit->credit_amount_overview}}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/><br/>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <button type="submit" class="custom_button"><i class="mdi mdi-pencil"></i> Update </button>
        </div>
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">

        $(document).on('change', '#sister_concern_id', function(){
            let string = $(this).val();
            $('.debit_field').each(function(){
                let id = $(this).attr('id');
                if(id == string){
                    $(this).show();
                    $(this).required = true;
                }
                else{
                    $(this).hide();
                    $(this).required = false;
                }
            });
            $('.credit_field').each(function(){
                let id = $(this).attr('id');
                if(id == string){
                    $(this).show();
                    $(this).required = true;
                }
                else{
                    $(this).hide();
                    $(this).required = false;
                }
            });
        });
        $(document).on('change', '#debit', function (){
            let string = $(this).val();
            let name = string.split('_');
            $('#transfer_amount_to').val(name[1]);
            $('#debit_id').val(name[0]);
        });
        $(document).on('change', '#credit', function (){
            let string = $(this).val();
            let name = string.split('_');
            $('#transfer_amount_from').val(name[1]);
            $('#credit_id').val(name[0]);
        });

        $(document).on('input','#debit_amount', function (){
            let string = $(this).val();
            $('#debit_amount_overview, #credit_amount, #credit_amount_overview').val(string);
        });
        $(document).on('input','#credit_amount', function (){
            let string = $(this).val();
            $('#credit_amount_overview, #debit_amount, #debit_amount_overview').val(string);
        });
    </script>
@endsection
