@extends('master')
@section('account','active') @section('account-show','show') @section('vouchar','active') @section('vouchar-show','show') @section('debit_voucher','active') @section('debit_voucher-show','show') @section('debit_voucher-create','active')
@section('content')
    {!! Form::open(['class' =>'form-sample','route' => 'debit_voucher.store','method' => 'POST']) !!}
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="page-header" id="bannerClose"><h3 class="page-title"><span class="page-title-icon bg-gradient-success text-white mr-2"><i class="mdi mdi-plus"></i></span> Add New Debit Voucher</h3></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4"><div class="form-group">
                                        <label for="sister_concern_id">Sister Concern</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id" required>
                                            <option selected disabled value="">choose an option</option>
                                            @foreach($sister_concerns as $sister_concern)
                                                <option value="{{ $sister_concern->id}}"  @if( $sister_concern->id == \Illuminate\Support\Facades\Auth::user()->sister_concern_id) selected @endif>{{$sister_concern->name}}</option>
                                            @endforeach
                                        </select>
                                    </div></div>
                                <div class="col-md-4"><div class="form-group">
                                        <label for="voucher_no"> Voucher No </label>
                                        <input type="text" class="form-control" id="voucher_no" name="voucher_no" value="DV {{$debit_vouchers->count() + 1}}" readonly required>
                                    </div></div>
                                <div class="col-md-4"><div class="form-group">
                                        <label for="date"> Date </label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{date('Y-m-d')}}" required>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-center">Debit<hr/></h5>
                                    <div class="row default_debit">
                                        <div class="col-sm-10"><div class="debit_field" id="0">
                                                <div class="form-group">
                                                    <label for="debit">Debit</label>
                                                    <select class="form-control selectpicker debit_test" data-live-search="true" name="debit" id="debit" >
                                                        <option value="" selected disabled>Choose An option</option>
                                                    </select>

                                                </div>
                                            </div></div>
                                        <div class="col-sm-2 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_debit" id="add_debit_-1"></i></div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="debit_amount"> Debit Amount </label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row custom_debit" style="display: none">
                                        <div class="col-sm-10">
                                            @foreach($sister_concerns as $sister_concern)
                                                <div class="debit_field" id="{{$sister_concern->id}}" style="display: none">
                                                    <div class="form-group">
                                                        <label for="debit">Debit</label>
                                                        <select class="form-control selectpicker debit" data-live-search="true" name="debit[]" id="debit_0" >
                                                            <option value="" selected disabled>Choose An option</option>
                                                            @for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)
                                                                <option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}">{{$data[$sister_concern->id][$i]['name']}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-sm-2 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_debit" id="add_debit_0"></i></div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="debit_amount"> Debit Amount </label>
                                                <input type="text" class="form-control debit_amount" id="debit_amount_0" name="debit_amount[]" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="append_debit">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="text-center">Credit<hr/></h5>
                                    <div class="row default_credit">
                                        <div class="col-sm-10"><div class="credit_field" id="0">
                                                <div class="form-group">
                                                    <label for="credit">Credit</label>
                                                    <select class="form-control selectpicker credit_test" data-live-search="true" name="credit" id="credit" >
                                                        <option value="" selected disabled>Choose An option</option>
                                                    </select>

                                                </div>
                                            </div></div>
                                        <div class="col-sm-2 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_credit" id="add_credit_-1"></i></div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="credit_amount"> Credit Amount </label>
                                                <input type="text" class="form-control credit_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row custom_credit" style="display: none">
                                        <div class="col-sm-10">
                                            @foreach($sister_concerns as $sister_concern)
                                                <div class="credit_field" id="{{$sister_concern->id}}" style="display: none">
                                                    <div class="form-group">
                                                        <label for="credit">Credit</label>
                                                        <select class="form-control selectpicker credit" data-live-search="true" name="credit[]" id="credit_0" >
                                                            <option value="" selected disabled>Choose An option</option>
                                                            @for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)
                                                                <option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}">{{$data[$sister_concern->id][$i]['name']}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="col-sm-2 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_credit" id="add_credit_0"></i></div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="credit_amount"> Credit Amount </label>
                                                <input type="text" class="form-control credit_amount" id="credit_amount_0" name="credit_amount[]" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="append_credit">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="naration"> Naration </label>
                                        <textarea class="form-control" id="naration" name="naration" rows="5" placeholder="Enter Naration Here"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <input type="text" class="form-control" id="transfer_amount_to_0" name="transfer_amount_to[]" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="debit">Debit</label>
                                <input type="text" class="form-control" id="debit_overview_0" name="debit_overview[]" value="DR" readonly>
                                <input type="hidden" class="form-control" id="debit_id_0" name="debit_id[]" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="debit_amount">Debit Amount</label>
                                <input type="text" class="form-control" id="debit_amount_overview_0" name="debit_amount_overview[]" readonly>
                            </div>
                        </div>
                        <div class="col-md-3"></div>

                        <div class="col-md-12" id="append_debit_overview">

                        </div>


                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="transfer_amount_to">Transfer Amount From</label>
                                <input type="text" class="form-control" id="transfer_amount_from_0" name="transfer_amount_from[]" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="credit">Credit</label>
                                <input type="text" class="form-control" id="credit_overview_0" name="credit_overview[]" value="CR" readonly>
                                <input type="hidden" class="form-control" id="credit_id_0" name="credit_id[]" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="credit_amount">Credit Amount</label>
                                <input type="text" class="form-control" id="credit_amount_overview_0" name="credit_amount_overview[]" readonly>
                            </div>
                        </div>

                        <div class="col-md-12" id="append_credit_overview">

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
            <button type="submit" class="custom_button"><i class="mdi mdi-plus"></i> Create </button>
        </div>
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        function _(x){
            return document.getElementById(x);
        }
        function preLoadData(){
            let string = _('sister_concern_id').value;
            if(string != ''){
                $('.default_debit').hide();
                $('.default_credit').hide();
                $('.custom_debit').show();
                $('.custom_credit').show();
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
            }
        }
        $(document).on('change', '#sister_concern_id', function(){
            let string = $(this).val();
            $('.default_debit').hide();
            $('.default_credit').hide();
            $('.custom_debit').show();
            $('.custom_credit').show();
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
        let i = 1;
        let j = 1;
        $(document).on('click', '.add_debit', function (){
            _('credit_amount_0').value = '';
            _('credit_amount_overview_0').value = '';

            $('.add_credit').each(function(){
                let id = $(this).attr('id');
                let split = id.split('_');
                if(split[2] != 0){
                    $("#credit_list_" + split[2]).remove();
                    $("#overview_credit_" + split[2]).remove();
                }
            });
            let string = $('#sister_concern_id').val();
            if(string == null){
                toastr.error('Sister Concern is not selected !!!')
            }
            else{
                let html = '';
                i++;
                html += '<div class="row" id="debit_list_'+ i +'"><div class="col-sm-10">@foreach($sister_concerns as $sister_concern)<div class="debit_field_custom" id="{{$sister_concern->id}}_' + i + '" style="display: none"><div class="form-group"><label for="debit">Debit</label><select class="form-control selectpicker debit" data-live-search="true" name="debit[]" id="debit_'+i+'" ><option value="" selected disabled>Choose An option</option>@for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)<option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}">{{$data[$sister_concern->id][$i]['name']}}</option>@endfor</select></div></div> @endforeach</div>' +
                    '<div class="col-sm-1 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_debit" id="add_debit_' + i + '"></i></div>' +
                    '<div class="col-sm-1 icon_design_col"> <i class="mdi mdi-minus-circle icon_minus_design minus_debit" id="minus_debit_' + i + '"></i></div>' +
                    '<div class="col-sm-12"><div class="form-group"><label for="debit_amount"> Debit Amount </label><input type="text" class="form-control debit_amount" id="debit_amount_' + i + '" name="debit_amount[]" required></div></div></div><hr/>';

                $('#append_debit').append(html);
                $('.selectpicker').selectpicker('refresh');
                $('.debit_field_custom').each(function(){
                    let id = $(this).attr('id');
                    let split = id.split('_');
                    if(split[0] == string){
                        $(this).show();
                        $(this).required = true;
                    }
                    else{
                        $(this).hide();
                        $(this).required = false;
                    }
                });

                html = '';

                html += '<div class="row" id="overview_debit_'+i+'"><div class="col-md-3"><div class="form-group"><label for="transfer_amount_to">Transfer Amount To</label><input type="text" class="form-control" id="transfer_amount_to_'+i+'" name="transfer_amount_to[]" readonly></div></div><div class="col-md-3"><div class="form-group"><label for="debit">Debit</label><input type="text" class="form-control" id="debit_overview_'+i+'" name="debit_overview[]" value="DR" readonly><input type="hidden" class="form-control" id="debit_id_'+i+'" name="debit_id[]" readonly></div></div><div class="col-md-3"><div class="form-group"><label for="debit_amount">Debit Amount</label><input type="text" class="form-control" id="debit_amount_overview_'+i+'" name="debit_amount_overview[]" readonly></div></div><div class="col-md-3"></div></div>';
                $('#append_debit_overview').append(html);
            }
        });
        $(document).on('click','.minus_debit',function(){
            let id = $(this).attr('id');
            let split = id.split('_');
            $("#debit_list_" + split[2]).remove();
            $("#overview_debit_" + split[2]).remove();
        });


        $(document).on('click', '.add_credit', function (){
            _('debit_amount_overview_0').value = '';
            _('debit_amount_0').value = '';

            $('.add_debit').each(function(){
                let id = $(this).attr('id');
                let split = id.split('_');
                if(split[2] != 0){
                    $("#debit_list_" + split[2]).remove();
                    $("#overview_debit_" + split[2]).remove();
                }
            });
            let string = $('#sister_concern_id').val();
            if(string == null){
                toastr.error('Sister Concern is not selected !!!')
            }
            else{
                let html = '';
                j++;
                html += '<div class="row" id="credit_list_'+j+'"><div class="col-sm-10">@foreach($sister_concerns as $sister_concern)<div class="credit_field_custom" id="{{$sister_concern->id}}_' + j + '" style="display: none"><div class="form-group"><label for="credit">Credit</label><select class="form-control selectpicker credit" data-live-search="true" name="credit[]" id="credit_'+j+'" ><option value="" selected disabled>Choose An option</option>@for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)<option value="{{$data[$sister_concern->id][$i]['id'].'_'.$data[$sister_concern->id][$i]['name']}}">{{$data[$sister_concern->id][$i]['name']}}</option>@endfor</select></div></div> @endforeach</div>' +
                    '<div class="col-sm-1 icon_design_col"> <i class="mdi mdi-plus-circle icon_plus_design add_credit" id="add_credit_' + j + '"></i></div>' +
                    '<div class="col-sm-1 icon_design_col"> <i class="mdi mdi-minus-circle icon_minus_design minus_credit" id="minus_credit_' + j + '"></i></div>' +
                    '<div class="col-sm-12"><div class="form-group"><label for="credit_amount"> Credit Amount </label><input type="text" class="form-control credit_amount" id="credit_amount_' + j + '" name="credit_amount[]" required></div></div></div><hr/>';

                $('#append_credit').append(html);
                $('.selectpicker').selectpicker('refresh');
                $('.credit_field_custom').each(function(){
                    let id = $(this).attr('id');
                    let split = id.split('_');
                    if(split[0] == string){
                        $(this).show();
                        $(this).required = true;
                    }
                    else{
                        $(this).hide();
                        $(this).required = false;
                    }
                });

                html = '';

                html += '<div class="row" id="overview_credit_'+j+'"><div class="col-md-3"></div><div class="col-md-3"><div class="form-group"><label for="transfer_amount_from">Transfer Amount From</label><input type="text" class="form-control" id="transfer_amount_from_'+j+'" name="transfer_amount_from[]" readonly></div></div><div class="col-md-3"><div class="form-group"><label for="credit">Credit</label><input type="text" class="form-control" id="credit_overview_'+j+'" name="credit_overview[]" value="DR" readonly><input type="hidden" class="form-control" id="credit_id_'+j+'" name="credit_id[]" readonly></div></div><div class="col-md-3"><div class="form-group"><label for="credit_amount">Credit Amount</label><input type="text" class="form-control" id="credit_amount_overview_'+j+'" name="credit_amount_overview[]" readonly></div></div></div>';
                $('#append_credit_overview').append(html);
            }
        });
        $(document).on('click','.minus_credit',function(){
            let id = $(this).attr('id');
            let split = id.split('_');
            $("#credit_list_" + split[2]).remove();
            $("#overview_credit_" + split[2]).remove();
        });


        $(document).on('change', '.debit', function (){
            let id = $(this).attr('id');
            let split = id.split('_');
            let string = $(this).val();
            let name = string.split('_');
            $('#transfer_amount_to_' + split[1]).val(name[1]);
            $('#debit_id_' + split[1]).val(name[0]);
        });
        $(document).on('change', '.credit', function (){
            let id = $(this).attr('id');
            let split = id.split('_');
            let string = $(this).val();
            let name = string.split('_');
            $('#transfer_amount_from_' + split[1]).val(name[1]);
            $('#credit_id_' + split[1]).val(name[0]);
        });

        $(document).on('input','.debit_amount', function (){
            let id = $(this).attr('id');
            let split = id.split('_');
            let string = $(this).val();
            let sum = 0;
            $('#debit_amount_overview_' + split[2]).val(string);

            $('.debit_amount').each(function(){
                sum += +$(this).val();
            });
            $('#credit_amount_0').val(sum);
            $('#credit_amount_overview_0').val(sum);
        });
        $(document).on('input','.credit_amount', function (){
            let id = $(this).attr('id');
            let split = id.split('_');
            let string = $(this).val();
            let sum = 0;

            $('#credit_amount_overview_' + split[2]).val(string);

            $('.credit_amount').each(function(){
                sum += +$(this).val();
            });
            $('#debit_amount_overview_0').val(sum);
            $('#debit_amount_0').val(sum);
        });
        $(document).on('change', '.debit_test', function (){
            toastr.error('Sister Concern is not selected');
        });
        $(document).on('change', '.credit_test', function (){
            toastr.error('Sister Concern is selected');
        });
    </script>
@endsection
