@extends('master')
 @section('bank','active') @section('bank-show','show') @section('bank-cash-status','active') @section('bank-cash-status-show','show') @section('cash-status','active')
@section('content')
    @php
    $dr_sum = 0;
    $cr_sum = 0;
    @endphp
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row table-responsive">
                        <div class="col-lg-12">
                            {!! Form::open(['route' => 'bank.cash_balance_search','method' => 'GET']) !!}
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sister_concern_id">Sister Concern</label>
                                        <select class="form-control selectpicker" data-live-search="true" name="sister_concern_id" id="sister_concern_id">
                                            <option selected disabled value="">choose an option</option>
                                            @foreach($sister_concerns as $sister_concern)
                                                <option value="{{ $sister_concern->id}}">{{$sister_concern->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="age">Date From</label>
                                        <input type="date" class="form-control" id="date_from" name="date_from">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="age">Date To</label>
                                        <input type="date" class="form-control" id="date_to" name="date_to">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="none"></label>
                                        <button class="btn custom_button btn-lg btn-block form-control" id="search_balance">Search</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div id="printBalance">
                                <div class="row"><div class="col-md-12"><h2 class="text-center project_info_tag">Cash Status<hr/></h2><br/></div></div>
                                @for($i =0 ;$i<count($results) ; $i++)
                                    @php
                                        !empty($results[$i]['debit_amount']) ? $dr_sum += $results[$i]['debit_amount'] : $cr_sum += $results[$i]['credit_amount'];
                                    @endphp
                                @endfor
                                <div class="row"><div class="col-md-12"><h3 class="text-center project_info_tag">Cash Balance : {{number_format($cr_sum - $dr_sum)}} .00<hr/></h3><br/></div></div>
                                @if(!empty($from))
                                    <div class="row">
                                        <div class="col-md-3">From : {{$from}} <br/> To&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$to}}</div>
                                        <div class="col-sm-6"><h4 class="project_info_tag text-center">Debit & Credit History</h4></div>
                                        <div class="col-sm-3">Date :: {{date('Y-m-d')}}</div>
                                    </div>
                                    <br/>
                                @else
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-6"><h4 class="project_info_tag text-center">Debit & Credit History</h4></div>
                                        <div class="col-sm-3">Date :: {{date('Y-m-d')}}</div>
                                    </div>
                                    <br/>
                                @endif
                                <table class="custom">
                                    <thead>
                                    <tr>
                                        <td class="text-center"> Date </td>
                                        <td class="text-center"> DR</td>
                                        <td class="text-center"> CR</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($results) != 0)
                                    @for($i =0 ;$i<count($results) ; $i++)
                                        <tr class="text-center">
                                            <td>{{date('d-m-Y', strtotime($results[$i]['date']))}}</td>
                                            <td>{{!empty($results[$i]['debit_amount']) ? number_format($results[$i]['debit_amount']).'.00' : '0.00'}} </td>
                                            <td>{{!empty($results[$i]['credit_amount']) ? number_format($results[$i]['credit_amount']).'.00' : '0.00'}} </td>
                                        </tr>
                                    @endfor
                                    @else
                                        <tr class="text-center">
                                            <td colspan="3" class="text-info">{{'No Data Found !!'}}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <br/>
                                        <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('printBalance')" value="print" />
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
