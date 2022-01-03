@extends('master')
@section('report','active') @section('report-show','show') @section('cash_flow_statement-report','active')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-12">
                            {!! Form::open(['route' => 'report.cash_flow_statement_search','method' => 'GET']) !!}
                            <div class="row text-center">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sister_concern_id">Sister Concern</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id" required>
                                            <option selected disabled value="">choose an option</option>
                                            @foreach($sister_concerns as $sister_concern)
                                                <option value="{{ $sister_concern->id}}">{{$sister_concern->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Date From</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Date To</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="none"></label>
                                        <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div id="printCollection">
                                <br/><br/><br/>
                                @if(!empty($company))
                                    <div class="row">
                                        <div class="col-sm-12 text-center"><h4 class="project_info_tag text-center">{{!empty($company) ? $company->name : ''}}</h4>
                                            <p>Received & Payment Accounts</p>
                                            <p>For the date ended @if(!empty($from))From &nbsp;: {{date('d-m-Y', strtotime($from))}} <br/> To &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{date('d-m-Y', strtotime($to))}} @else {{date('d-m-Y')}} @endif</p>
                                        </div>
                                    </div>
                                    <br/>
                                @else
                                    <div class="row">
                                        <div class="col-sm-12 text-center"><h4 class="project_info_tag text-center">{{'Nahid Enterprise'}}</h4>
                                            <p>Received & Payment Accounts</p>
                                            <p>For the date ended {{date('d-m-Y')}}</p></div>
                                    </div>
                                    <br/>
                                @endif
                                <div class="row">
                                    <div class="col-sm-6" style="padding-right: 0px !important;">
                                        <table class="table cash_flow_table customer">
                                            <thead>
                                            <tr class="text-center">
                                                <td>Particular</td>
                                                <td>Amount</td>
                                                <td>Amount</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="2"><b>Opening Balance : </b><hr class="normal_hr"/>Cash in Hand</td>
                                                <td class="text-center">{{number_format($cash_in_hand)}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><b class="text-center">Received:</b><hr class="normal_hr"/>Sales A/C</td>
                                                <td class="text-center">{{number_format($cash_receiveds->sum('amount'))}}</td>
                                            </tr>
                                            @foreach($cash_receiveds as $received)
                                                <tr>
                                                    <td>{{$received->particular}}</td>
                                                    <td class="text-center">{{number_format($received->amount)}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2">Bank A/C</td>
                                                <td class="text-center">{{number_format($bank_receiveds->sum('amount'))}}</td>
                                            </tr>
                                            @foreach($bank_receiveds as $received)
                                                <tr>
                                                    <td>{{$received->particular}}</td>
                                                    <td class="text-center">{{number_format($received->amount)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-6"  style="padding-left: 0px !important;">
                                        <table class="table cash_flow_table customer">
                                            <thead>
                                            <tr class="text-center">
                                                <td>Particular</td>
                                                <td>Amount</td>
                                                <td>Amount</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr><td colspan="3" class="table_column_height"></td></tr>
                                            <tr>
                                                <td colspan="2"><b class="text-center">Paid:</b><hr class="normal_hr"/>Cash</td>
                                                <td class="text-center">{{number_format($cash_paids->sum('amount'))}}</td>
                                            </tr>
                                            @foreach($cash_paids as $paid)
                                                <tr>
                                                    <td>{{$paid->particular}}</td>
                                                    <td class="text-center">{{number_format($paid->amount)}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2">Bank A/C</td>
                                                <td class="text-center">{{number_format($bank_paids->sum('amount'))}}</td>
                                            </tr>
                                            @foreach($bank_paids as $paid)
                                                <tr>
                                                    <td>{{$paid->particular}}</td>
                                                    <td class="text-center">{{number_format($paid->amount)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
