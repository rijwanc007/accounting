@extends('master')
@section('report','active') @section('report-show','show') @section('report','active') @section('report-show','show') @section('balance_sheet-report','active')
@section('content')
    @php
     $head_sum = 0;
     $total_asset = 0;
    $asset_sum = 0;
    $total_liabilities = 0;
    $liabilities_sum = 0;
    @endphp
    <div class="col-lg-12 text-center"><h3>Statement of Financial Position</h3><hr/></div>
    <br/><br/>
    <div class="col-lg-12">
        {!! Form::open(['route' => 'report.balance_date_search','method' => 'GET']) !!}
        <div class="row text-center">
            <div class="col-sm-3">
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
    </div>
    <br/><br/>
    <div class="card">
        <div class="card-body">
            <div id="print_balance_sheet">
                <br/><br/><br/>
                <div class="container-fluid">
                    <div class="row text-center">
                        <div class="col-sm-12"><h3> {{($sis_con != null) ? \App\SisterConcern::find($sis_con)->name : 'Nahid Group'}} Statement Of Financial Position</h3><hr/></div>
                        <br/>
                        @if(empty($from))
                            <div class="col-sm-12 text-center text-primary"><h3>as 31 Dec' {{date('Y')}}</h3></div>
                        @else
                            <div class="col-sm-12 text-center text-primary"><h4>{{date('F-d-Y', strtotime($from))}} &nbsp; - &nbsp;{{date('F-d-Y', strtotime($to))}}</h4></div>
                        @endif
                    </div>
                    <br/><br/><br/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12 text-center"><h3>Assets</h3><hr/></div>
                                <div class="col-sm-6"><h4 class="text-center">Particular<hr/></h4></div>
                                <div class="col-sm-3"><h4 class="text-center">Amount<hr/></h4></div>
                                <div class="col-sm-3"><h4 class="text-center">Amount<hr/></h4></div>

                                <br/><br/>
                                    <div class="col-sm-6 text-left"><h4>{{'Current Asset'}}</h4></div>
                                    <div class="col-sm-6 text-right"><h4>{{number_format($current_assets->sum('amount'))}}</h4></div>
                                    @foreach($current_assets as $current_asset)
                                        <div class="col-sm-6 text-center"><h4>{{$current_asset->particular}}</h4></div>
                                        <div class="col-sm-3 text-center"><h4>{{number_format($current_asset->amount)}}</h4></div>
                                        <div class="col-sm-3 text-center"></div>
                                    @endforeach
                                    <div class="col-sm-6 text-left"><h4>{{'Non-Current Asset'}}</h4></div>
                                    <div class="col-sm-6 text-right"><h4>{{number_format($non_current_assets->sum('amount'))}}</h4></div>
                                    @foreach($non_current_assets as $non_current_asset)
                                        <div class="col-sm-6 text-center"><h4>{{$non_current_asset->particular}}</h4></div>
                                        <div class="col-sm-3 text-center"><h4>{{number_format($non_current_asset->amount)}}</h4></div>
                                        <div class="col-sm-3 text-center"></div>
                                    @endforeach
                                <br/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12 text-center"><h3>Liabilities</h3><hr/></div>
                                <div class="col-sm-6"><h4 class="text-center">Particular<hr/></h4></div>
                                <div class="col-sm-3"><h4 class="text-center">Amount<hr/></h4></div>
                                <div class="col-sm-3"><h4 class="text-center">Amount<hr/></h4></div>

                                <br/><br/>
                                    <div class="col-sm-6 text-left"><h4>{{'Current Liabilities'}}</h4></div>
                                    <div class="col-sm-6 text-right"><h4>{{number_format($current_liabilities->sum('amount'))}}</h4></div>
                                    @foreach($current_liabilities as $current_liabilitie)
                                        <div class="col-sm-6 text-center"><h4>{{$current_liabilitie->particular}}</h4></div>
                                        <div class="col-sm-3 text-center"><h4>{{number_format($current_liabilitie->amount)}}</h4></div>
                                        <div class="col-sm-3 text-center"></div>
                                    @endforeach
                                    <div class="col-sm-6 text-left"><h4>{{'Non-Current Liabilities'}}</h4></div>
                                    <div class="col-sm-6 text-right"><h4>{{number_format($non_current_liabilities->sum('amount'))}}</h4></div>
                                    @foreach($non_current_liabilities as $non_current_liabilitie)
                                        <div class="col-sm-6 text-center"><h4>{{$current_liabilitie->particular}}</h4></div>
                                        <div class="col-sm-3 text-center"><h4>{{number_format($current_liabilitie->amount)}}</h4></div>
                                        <div class="col-sm-3 text-center"></div>
                                    @endforeach
                                <div class="col-sm-6 text-left"><h4>{{'Equity'}}</h4></div>
                                <div class="col-sm-6 text-right"><h4>{{number_format($equities->sum('amount'))}}</h4></div>
                                @foreach($equities as $equity)
                                    <div class="col-sm-6 text-center"><h4>{{$equity->particular}}</h4></div>
                                    <div class="col-sm-3 text-center"><h4>{{number_format($equity->amount)}}</h4></div>
                                    <div class="col-sm-3 text-center"></div>
                                @endforeach
                                <div class="col-sm-6 text-left"><h4>{{'Retained Earnings'}}</h4></div>
                                <div class="col-sm-6 text-right"><h4>{{number_format($retained_earnings)}}</h4></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12"><hr/></div>
                                <div class="col-sm-6"><h3 class="text-info text-center">Total</h3></div>
                                <div class="col-sm-6"><h3 class="text-info text-right">{{number_format($current_assets->sum('amount') + $non_current_assets->sum('amount'))}}</h3></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12"><hr/></div>
                                <div class="col-sm-6"><h3 class="text-info text-center">Total</h3></div>
                                <div class="col-sm-6"><h3 class="text-info text-right">{{number_format($current_liabilities->sum('amount') + $non_current_liabilities->sum('amount') + $equities->sum('amount') + $retained_earnings)}}</h3></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br/><br/>
            <div class="row text-center">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <br/>
                        <input type="button" class="print_button custom_button btn-block form-control" onclick="printDiv('print_balance_sheet')" value="Print" />
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
