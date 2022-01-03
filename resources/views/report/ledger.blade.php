@extends('master')
@section('account','active') @section('account-show','show') @section('account-ledger','active')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['route' => 'report.ledger_search','method' => 'GET']) !!}
                            <div class="row text-center">
                                <div class="col-sm-6" id="siscon_field">
                                    <div class="form-group">
                                        <label for="sister_concern_id">Sister Concern</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id" required>
                                            <option selected disabled value="">choose an option</option>
                                            @foreach($sister_concerns as $sister_concern)
                                                <option value="{{ $sister_concern->id}}"  @if( $sister_concern->id == \Illuminate\Support\Facades\Auth::user()->sister_concern_id) selected @endif>{{$sister_concern->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @foreach($sister_concerns as $sister_concern)
                                    <div class="col-sm-3 chart_field" id="{{$sister_concern->id}}" style="display: none">
                                        <div class="form-group">
                                            <label for="chart_id">Chart</label>
                                            <select class="form-control selectpicker" data-live-search="true" name="chart_id" id="chart_id_{{$sister_concern->id}}" >
                                                <option value="" selected disabled>Choose An option</option>
                                                @for($i = 0 ; $i<count($data[$sister_concern->id]) ; $i++)
                                                    <option value="{{$data[$sister_concern->id][$i]['id']}}">{{$data[$sister_concern->id][$i]['name']}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-sm-2" id="date_from_field" style="display: none">
                                    <div class="form-group">
                                        <label for="age">Date From</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from">
                                    </div>
                                </div>
                                <div class="col-sm-2" id="date_to_field" style="display: none">
                                    <div class="form-group">
                                        <label for="age">Date To</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="search_field">
                                    <div class="form-group">
                                        <label for="none"></label>
                                        <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-12">
                            <div id="printCollection">
                                <br/><br/><br/>
                                @if(!empty($chart))
                                    <div class="row">
                                        <div class="col-sm-3">@if(!empty($from))From &nbsp;: {{date('d-m-Y', strtotime($from))}} <br/> To &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('d-m-Y', strtotime($to))}} @endif</div>
                                        <div class="col-sm-6"><h4 class="project_info_tag text-center">{{!empty($company) ? $company->name : ''}}<hr/></h4></div>
                                        <div class="col-sm-3">Date :: {{date('Y-m-d')}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h5 class="text-center">Ledger of {{($chart->sub_head_id != 0) ? $chart->sub_head_name : $chart->head_name}}, @if(count($results) > 0) DT-{{date('d-m-Y', strtotime($results[0]['date']))}}, upto {{date('d-m-Y', strtotime($results[count($results) - 1]['date']))}} @endif<hr/></h5>
                                        </div>
                                    </div>
                                    <br/>
                                @else
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6"><h4 class="project_info_tag text-center">{{!empty($company) ? $company->name : ''}}</h4></div>
                                        <div class="col-sm-3">Date :: {{date('d-m-Y')}}</div>
                                    </div>
                                    <br/>
                                @endif
                                <table class="custom">
                                    <thead>
                                    <tr class="text-center">
                                        <td>Date</td>
                                        <td>Particular</td>
                                        <td>Voucher</td>
                                        <td>DR</td>
                                        <td>CR</td>
                                        <td>Balance</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($results))
                                        @for($i = 0 ;$i<count($results) ; $i++)
                                            <tr class="text-center">
                                                <td>{{date('d-m-Y', strtotime($results[$i]['date']))}} <br/> {{date("g:i a", strtotime($results[$i]['time']))}}</td>
                                                <td>{{!empty($results[$i]['transfer_amount_to']) ? $results[$i]['transfer_amount_to'] : $results[$i]['transfer_amount_from']}} <br/> {{$results[$i]['naration']}}</td>
                                                <td>{{$results[$i]['voucher_no']}}</td>
                                                <td>{{!empty($results[$i]['debit_amount']) ? $results[$i]['debit_amount'] : 0}}</td>
                                                <td>{{!empty($results[$i]['credit_amount']) ? $results[$i]['credit_amount'] : 0}}</td>
                                                <td>
                                                    @php
                                                        if($chart->category == 'Non-Current Asset' || $chart->category == 'Current Asset' || $chart->category == 'Expense'){
                                                                $balance += (!empty($results[$i]['debit_amount']) ? $results[$i]['debit_amount'] : 0) - (!empty($results[$i]['credit_amount']) ? $results[$i]['credit_amount'] : 0);
                                                            }

                                                           if($chart->category == 'Non-Current Liabilities' || $chart->category == 'Current Liabilities' || $chart->category == 'Income' || $chart->category == 'Equity'){
                                                               $balance += (!empty($results[$i]['credit_amount']) ? $results[$i]['credit_amount'] : 0) - (!empty($results[$i]['debit_amount']) ? $results[$i]['debit_amount'] : 0);
                                                           }

                                                    @endphp
                                                    {{($balance < 0) ? '('. ($balance * -1) . ')' : $balance}}
                                                </td>
                                            </tr>
                                        @endfor
                                        <tr class="text-center">
                                            <td colspan="3"></td>
                                            <td colspan="3">Closing Balance : {{($balance < 0) ? '('. ($balance * -1) . ')' : $balance}}</td>
                                        </tr>
                                    @else
                                        <tr class="text-center">
                                            <td colspan="6" class="text-danger">{{'No Data Found !!'}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <br/>
                            <br/>
                            <div class="row text-center">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <br/>
                                        <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('printCollection')" value="Print" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function _(x){
            return document.getElementById(x);
        }
        function preLoadData(){
            let string = _('sister_concern_id').value;
            if(string != ''){
                $( "#siscon_field" ).removeClass( "col-sm-6" ).addClass( "col-sm-3" );
                $( "#search_field" ).removeClass( "col-sm-6" ).addClass( "col-sm-2" );
                $('#date_from_field, #date_to_field').show();
                $('.chart_field').each(function(){
                    let id = $(this).attr('id');
                    if(id == string){
                        $(this).show();
                        $('#chart_id_' + id).prop('required', true);
                    }
                    else{
                        $('#chart_id_' + id).prop('required', false);
                        $(this).hide();
                    }
                });
            }
        }
        $(document).on('change', '#sister_concern_id', function(){
           let string = $(this).val();
            $( "#siscon_field" ).removeClass( "col-sm-6" ).addClass( "col-sm-3" );
            $( "#search_field" ).removeClass( "col-sm-6" ).addClass( "col-sm-2" );
            $('#date_from_field, #date_to_field').show();
            $('.chart_field').each(function(){
                let id = $(this).attr('id');
                if(id == string){
                    $(this).show();
                    $('#chart_id_' + id).prop('required', true);
                }
                else{
                    $('#chart_id_' + id).prop('required', false);
                    $(this).hide();
                }
            });
        });
        function printDiv(divName)
        {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
